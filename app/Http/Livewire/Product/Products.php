<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Storage;
//use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Products extends Component
{
    use WithFileUploads;
    use WithPagination;

    //use AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';
    //escuchamos eventos emitidos desde la vista
    protected $listeners = [
        'deleteRow' => 'destroy'
    ];
    public $search;
    public $pageTitle;
    public $componentName;

    public $name, $barcode, $cost, $price, $stock, $alerts, $image, $category_id, $selected_id;
    //public $object;
    //public $image;

    public function mount()
    {
        // al $object lo defino como un objeto de tipo Product()
        //$this->object = new Product();

        $this->pageTitle     = 'Listado';
        $this->componentName = 'Productos';
        $this->pagination    = 5;
        $this->search        = '';
        $this->selected_id = 0;
        $this->category_id = "Elegir";

        //$this->object        = null;
    }

    // limpiamos el buscador
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories =  Category::orderBy('name', 'desc')->get();

        if (strlen($this->search)) {
            $products = Product::join('categories as c','c.id','products.category_id')
                    ->select('products.*','c.name as category')
                    ->where('products.name', 'like', '%'.$this->search.'%')
                    ->orWhere('products.barcode', 'like', '%'.$this->search.'%')
                    ->orWhere('c.name', 'like', '%'.$this->search.'%')
                    ->orderBy('id', 'desc')->paginate($this->pagination);

        } else {
            $products = Product::join('categories as c','c.id','products.category_id')
                    ->select('products.*','c.name as category')
                    ->orderBy('id', 'desc')->paginate($this->pagination);
        }

        return view('livewire.product.products', compact('products','categories'))
                ->extends('layouts.theme.app')
                ->section('content');

    }

    protected function rules_old()
    {
        //Unique validation need the id on update.
        $uniqueName = 'unique:products,name';
        $uniqueCode = 'unique:products,barcode';
        if ($this->selected_id > 0) {
            $uniqueName .= ",{$this->selected_id}";
            $uniqueCode .= ",{$this->selected_id}";
        }

        return [
                'name'        => "required|string|$uniqueName|min:3",
                'barcode'     => "required|string|$uniqueCode|min:1",
                'cost'        => "required|numeric|min:0",
                'price'       => "required|numeric|min:0",
                'stock'       => "required|numeric|min:0",
                'alerts'      => "required|numeric|min:0",
                'category_id' => 'required|integer|min:1|exists:categories,id',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];


    }

    public function new()
    {
        $this->object = new Product();
        $this->image  = null;
        $this->emit('show-modal', 'show modal');
    }

    public function edit(Product $product)
    {
        //$record = Product::find($id,['id','name','image']);
        /*
        $this->name = $product->name;
        $this->barcode = $product->barcode;
        $this->cost = $product->cost;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->alerts = $product->alerts;
        $this->image = null;
        $this->category_id = $product->category_id;
        $this->selected_id = $product->id;
        */

        $this->object = $product;
        $this->image  = null;
        $this->emit('show-modal', 'show modal');

    }

    public function store()
    {
        $uniqueName = 'unique:products,name';
        $uniqueCode = 'unique:products,barcode';
        if ($this->selected_id > 0) {
            $uniqueName .= ",{$this->selected_id}";
            $uniqueCode .= ",{$this->selected_id}";
        }

        //'category_id' => 'required|integer|min:1|exists:categories,id|not_in:0',
        $rules=[
            'name'        => "required|string|$uniqueName|min:3",
            'barcode'     => "required|string|$uniqueCode|min:1",
            'cost'        => "required|numeric|min:0",
            'price'       => "required|numeric|min:0",
            'stock'       => "required|numeric|min:0",
            'alerts'      => "required|numeric|min:0",
            'category_id' => 'required|not_in:Elegir',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        $messages = [
            'name.required' => 'Nombre es requerido',
            'name.unique' => 'Nombre ya existe',
            'name.min'=> 'Nombre debe tener minimo 3 digitos',
            'cost.required' => 'Costo es requerido',
            'price.required' => 'Precio es requerido',
            'stock.required' => 'Stock es requerido',
            'alerts.required' => 'Ingresa el valor minimo en stock',
            'category_id.not_in' => 'Elige una categoria valida',
        ];

        // ejecutamos la validacion
        $this->validate($rules,$messages);

        if ($this->image) {
            //$this->object->image = $this->image->store(null, 'products');
            $this->object->image = Storage::put('products', $this->image);
        }

        $this->object->save();
        $this->emit('noty', 'Agregado nuevo producto');
        $this->resetUI();

    }

    public function update(){

        $this->validate();

        if ($this->image) {
            //Remove old file.
            //Storage::disk('products')->delete($this->object->image);
            Storage::delete($this->object->image);
            //$this->object->image = $this->image->store(null, 'products');
            $this->object->image =  Storage::put('products', $this->image);
        }

        $this->object->save();

        $this->emit('noty', "El producto {$this->object->name} fue actualizado correctamente");
        $this->resetUI();

    }

    public function resetUI(){

        $this->object = null;
        $this->image  = null;
        $this->resetValidation();
        $this->emit('hide-modal', 'hide modal');
    }


    //public function destroy($id){
    public function destroy(Product $product){
        //$category = Category::find($id);
        $imageName = $product->image;
        $product->delete();

        //dd($imageName);

        if($imageName != null){
              Storage::delete($imageName);
        }

        $this->emit('noty', "El producto {$this->object->name} fue actualizado correctamente");
        $this->resetUI();

    }

}
