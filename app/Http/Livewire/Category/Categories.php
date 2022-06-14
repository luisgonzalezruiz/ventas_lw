<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;

use App\Models\Category;
use Livewire\WithFileUploads;

use Livewire\WithPagination;

use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Categories extends Component
{
    use WithFileUploads;
    use WithPagination;

    use AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';

    public $name, $selected_id; //?Category $object;
    public $search;
    public $image;
    public $pageTitle;
    public $componentName;

    //escuchamos eventos emitidos desde la vista
    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

    public function mount()
    {
        $this->pageTitle     = 'Listado';
        $this->componentName = 'Categorías';
        $this->pagination    = 5;
        $this->search        = '';
       // $this->object        = null;
    }

    // limpiamos el buscador
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // de esta forma especificamos que queremos usar una paginacion personalizada
    //public function paginationView()
    //{
    //    return 'vendor.livewire.bootstrap';
    //}

    public function render()
    {
        if (strlen($this->search)) {
            $categories = Category::where('name', 'like', '%'.$this->search.'%')
                ->orderBy('id', 'desc')->paginate($this->pagination);
        } else {
            $categories = Category::orderBy('id', 'desc')->paginate($this->pagination);
        }
        // lo que decimos aqui es: va a renderizar en la seccion content que esta en la plantilla
        // loyouts/theme y el archico app.blade.php
        return view('livewire.category.categories', compact('categories'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function edit($id)
    {
        // de esta forma estamos especificando las columnas a recuperar, son buenas practicas
        // al no especificar, devuelve todas las filas
        $record = Category::find($id,['id','name','image']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->image = null;

        //emitimos el evento show-modal
        $this->emit('show-modal','show modal!');
    }

    public function store()
    {
        $rules=[
            'name'=>'required|unique:categories|min:3'
        ];
        $messages = [
            'name.required' => 'Nombre es requerido',
            'name.unique' => 'Nombre ya existe',
            'name.min'=> 'Nombre debe tener minimo 3 digitos'
        ];

        // ejecutamos la validacion
        $this->validate($rules,$messages);

        // aqui insertamos el registro
        $category =Category::create([
                'name'=>$this->name
        ]);

        $customFileName = '';
        if ($this->image) {
            // unique() es una funcion de php que genera un string unico, milisegundos
            // $this->image->extension() image es una variable de tipo image que viene desde el from
            // y tiene un atributo extension
            $customFileName = uniqid() . '_.' . $this->image->extension();

            //$this->image->storeAs('public/categories',$customFileName);
            $url = Storage::put('categories', $this->image);

            // aqui actualizamos el registro con el path de la imagen
            $category->image = $url; //$customFileName;
            $category->save();
        }
        //emitimos el evento show-modal
        //$this->emit('noty','Registro grabado!!!');
        $this->emit('category-added','Categoria Registrada');
        $this->resetUI();

    }

    public function update(){
        // tener en cuenta que al poner las reglas no debe haber espacio en blanco.
        $rules=[
            'name'=>"required|min:3|unique:categories,name,$this->selected_id "
        ];
        $messages = [
            'name.required' => 'Nombre es requerido',
            'name.unique' => 'Nombre ya existe',
            'name.min'=> 'Nombre debe tener minimo 3 digitos'
        ];
        $this->validate($rules,$messages);

        // aqui recuperamos el registro seleccionado
        $category = Category::find($this->selected_id);
        $category->update([
            'name'=> $this->name
        ]);
        // verificamos si se selecciono alguna imagen
        if ($this->image){
            $customFileName = uniqid() . '_.' . $this->image->extension();

            //$this->image->storeAs('public/categories',$customFileName);

            $url =  Storage::put('categories', $this->image);

            //extraemos la imagen anterior por que debemos eliminar fisicamente
            //por que vamos a almacenar uno nuevo
            $imageName = $category->image;
            $category->image = $url; //$customFileName;
            $category->save();

            //vemos si hay imagen anterior
            if($imageName != null){
                // note que consultamos la carpeta storage y no public
                //if(file_exists('storage/categories'. $imageName)){
                //    unlink('storage/categories'. $imageName);
                //}
                //if(file_exists($imageName)){
                    //unlink($imageName);
                    Storage::delete($imageName);
                //}


            }

        }

        $this->emit('category-updated','Categoria Actualizada');
        $this->resetUI();

    }

    public function resetUI(){
        $this->name = '';
        $this->selected_id  = 0;
        $this->image = null;
        $this->search = '';

        $this->emit('hide-modal', 'hide modal');
    }


    //public function destroy($id){
    public function destroy(Category $category){
        //$category = Category::find($id);
        $imageName = $category->image;
        $category->delete();

        //dd($imageName);

        if($imageName != null){
            //unlink('storage/categories/629527ad9dee3_.jpg');
            //Storage::disk('categories')->delete($imageName);
              Storage::delete($imageName);
        }

        $this->resetUI();
        $this->emit('category-deleted','Categoria Eliminada');

    }

}
