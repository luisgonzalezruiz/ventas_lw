<?php

namespace App\Http\Livewire\Denomination;

use Livewire\Component;

use App\Models\Denomination;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Storage;


class Denominations extends Component
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

    public $type, $value, $image, $selected_id;


    public function mount()
    {
        // al $object lo defino como un objeto de tipo Product()
        //$this->object = new Product();
        $this->pageTitle     = 'Listado';
        $this->componentName = 'Denominations';
        $this->pagination    = 5;
        $this->search        = '';
        $this->selected_id = 0;

    }

    // limpiamos el buscador
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if (strlen($this->search)) {
            $denominations = Denomination::where('type', 'like', '%'.$this->search.'%')
                ->orderBy('id', 'desc')->paginate($this->pagination);
        } else {
            $denominations = Denomination::orderBy('id', 'desc')->paginate($this->pagination);
        }
        // lo que decimos aqui es: va a renderizar en la seccion content que esta en la plantilla
        // loyouts/theme y el archico app.blade.php
        return view('livewire.denomination.denominations', compact('denominations'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function edit(Denomination $denomination)
    {
        //$record = Product::find($id,['id','name','image']);

        $this->type = $denomination->type;
        $this->value = $denomination->value;
        $this->image = null;
        $this->selected_id = $denomination->id;

        $this->emit('show-modal', 'show modal');

    }

    public function store()
    {
        $uniqueName = 'unique:denominations,type,value';
        if ($this->selected_id > 0) {
            $uniqueName .= ",{$this->selected_id}";
        }

        $rules=[
            'type'        => "required|string|min:3",
            'value'        => "required|numeric|min:0",
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        $messages = [
            'type.required' => 'Tipo es requerido',
            'value.required' => 'Valor es requerido',
        ];

        // ejecutamos la validacion
        $this->validate($rules,$messages);

        // aqui insertamos el registro
        $denomination = new Denomination();
        $denomination->type = $this->type;
        $denomination->value = $this->value;

        if ($this->image) {
            $denomination->image = Storage::put('denominations', $this->image);
        }

        $denomination->save();

        $this->resetUI();
        $this->emit('noty', 'Agregado nuevo producto');

    }

    public function update(){

        $rules=[
            'type'        => "required|string|min:3",
            'value'        => "required|numeric|min:0",
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        $messages = [
            'type.required' => 'Tipo es requerido',
            'value.required' => 'Valor es requerido',
        ];

        // ejecutamos la validacion
        $this->validate($rules,$messages);

        // Actualizamos los datos
        $denomination = Denomination::find($this->selected_id);
        $denomination->type = $this->type;
        $denomination->value = $this->value;

        if ($this->image) {
            // verificamos si el registro actual tiene una imagen asociada para borrarlo
            $imageName = $denomination->image;
            if($imageName != null){
                Storage::delete($imageName);
            }
            // esto resume las tres lineas anteriores
            $denomination->image = Storage::put('denominations', $this->image);
        }

        $denomination->save();

        //$this->emit('category-added','Categoria Registrada');
        //$this->resetUI();

        $this->resetUI();
        $this->emit('noty', 'Registro actualizado!!!');

    }

    public function resetUI(){

        $this->type = "BILLETE";
        $this->value = "";

        $this->image  = null;
        $this->selected_id  = 0;
        $this->search = '';

        //$this->resetValidation();
        $this->emit('modal-hide', 'Oculta el modal');
    }


    //public function destroy($id){
    public function destroy(Denomination $denomination){
        $imageName = $denomination->image;
        $denomination->delete();
        if($imageName != null){
              Storage::delete($imageName);
        }
        $this->emit('noty', "El registro ha sido eliminado");
        $this->resetUI();
    }


}
