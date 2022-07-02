<?php

namespace App\Http\Livewire\Permiso;

use Livewire\Component;

use Spatie\Permission\Models\Permission;

use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Permisos extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';
    public $name, $selected_id;
    public $search;
    public $pageTitle;
    public $componentName;

    //escuchamos eventos emitidos desde la vista
    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

    public function mount()
    {
        $this->pageTitle     = 'Listado';
        $this->componentName = 'Permisos';
        $this->pagination    = 5;
        $this->search        = '';

    }

    // limpiamos el buscador
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        if (strlen($this->search)) {
            $permissions = Permission::where('name', 'like', '%'.$this->search.'%')
                ->orderBy('id', 'desc')->paginate($this->pagination);
        } else {
            $permissions = Permission::orderBy('id', 'desc')->paginate($this->pagination);
        }
        // lo que decimos aqui es: va a renderizar en la seccion content que esta en la plantilla
        // loyouts/theme y el archico app.blade.php
        return view('livewire.permiso.permisos', compact('permissions'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function new()
    {
        $this->emit('show-modal', 'show modal');
    }

    public function store()
    {
        $rules=[
            'name'=>'required|unique:permissions|min:3'
        ];
        $messages = [
            'name.required' => 'Nombre es requerido',
            'name.unique' => 'Nombre ya existe',
            'name.min'=> 'Nombre debe tener minimo 3 digitos'
        ];

        // ejecutamos la validacion
        $this->validate($rules,$messages);

        try {
            DB::beginTransaction();

            // aqui insertamos el registro
            $role =Permission::create([
                'name'=>$this->name
            ]);


            DB::commit();

            $this->emit('noty', "Agregado el permiso {$this->name}");

        } catch(\Exception $exp) {
            DB::rollBack();
            $this->emit('error', $exp->getMessage());
        }

        $this->resetUI();
    }

    public function edit(Permission $permission)
    {
        /* $this->authorize('update', $role, Role::class); */

        $this->name  = $permission->name;
        $this->selected_id = $permission->id;

        $this->emit('show-modal', 'show modal');
    }

    public function update()
    {

        // tener en cuenta que al poner las reglas no debe haber espacio en blanco.
        $rules=[
            'name'=>"required|min:3|unique:permissions,name,$this->selected_id "
        ];
        $messages = [
            'name.required' => 'Nombre es requerido',
            'name.unique' => 'Nombre ya existe',
            'name.min'=> 'Nombre debe tener minimo 3 digitos'
        ];
        $this->validate($rules,$messages);

        // aqui recuperamos el registro seleccionado
        $permission = Permission::find($this->selected_id);

        try {
            DB::beginTransaction();

            $permission->name =$this->name;
            $permission->save();

            DB::commit();

            $this->emit('noty', "El permiso {$this->name} fue actualizado correctamente");

        } catch(\Exception $exp) {
            DB::rollBack();
            $this->emit('error', $exp->getMessage());
        }

        $this->resetUI();
    }

    public function destroy(Permission $permission)
    {
        /* $this->authorize('delete', $role, Role::class); */

        // verificamos de esta manera que
        $rolesCount = $permission->roles->count();
        if($rolesCount > 0){
            $this->emit('noty', "El permiso {$permission->name} tiene roles vinculados");
            return;
        }

        //if ($permission->canDelete()) {
            $permission->delete();
            $this->resetPage();
        //}

        $this->emit('noty', "El permiso {$permission->name} fue eliminado correctamente");
        $this->resetUI();

    }

    public function resetUI()
    {
        /* $this->authorize('viewAny', Role::class); */

        $this->name = "";
        $this->search = "";
        $this->selected_id = 0;
        $this->resetValidation();
        $this->emit('hide-modal', 'hide modal');

    }

}

