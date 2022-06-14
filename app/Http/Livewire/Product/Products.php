<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Products extends Component
{
    use WithFileUploads;
    use WithPagination;

    use AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';
    //escuchamos eventos emitidos desde la vista
    protected $listeners = [
        'deleteRow' => 'destroy'
    ];
    public $search;
    public $pageTitle;
    public $componentName;

    //public $name, $barcode, $cost, $price, $stock, $alerts, $image, $category_id, $selected_id;
    public ?Product $object;
    public $image;

    public function mount()
    {
        $this->pageTitle     = 'Listado';
        $this->componentName = 'Productos';
        $this->pagination    = 5;
        $this->search        = '';
        $this->object        = null;
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
            $products = Product::where('name', 'like', '%'.$this->search.'%')
                ->orderBy('id', 'desc')->paginate($this->pagination);
        } else {
            $products = Product::orderBy('id', 'desc')->paginate($this->pagination);
        }

        return view('livewire.product.products', compact('products','categories'))
                ->extends('layouts.theme.app')
                ->section('content');

    }

     //Livewire need to defined rules for binding object.
     protected function rules()
     {
         //Unique validation need the id on update.
         $uniqueName = 'unique:products,name';
         $uniqueCode = 'unique:products,barcode';
         if ($this->object->exists ?? false) {
             $uniqueName .= ",{$this->object->id}";
             $uniqueCode .= ",{$this->object->id}";
         }

         return [
             'object.name'        => "required|string|$uniqueName|min:3",
             'object.barcode'     => "required|string|$uniqueCode|min:1",
             'object.cost'        => "required|numeric|min:0",
             'object.price'       => "required|numeric|min:0",
             'object.stock'       => "required|numeric|min:0",
             'object.alerts'      => "required|numeric|min:0",
             'object.category_id' => 'required|integer|min:1|exists:categories,id',
             'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
         ];
     }

    public function edit(Product $product)
    {
        //$record = Category::find($id,['id','name','image']);
        $this->object = $product;
        $this->image = null;

        //emitimos el evento show-modal
        $this->emit('show-modal','show modal!');

    }

    public function store()
    {
        // ejecutamos la validacion
        $this->validate();

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
