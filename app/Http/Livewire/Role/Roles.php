<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;

use App\Models\Role;
use Spatie\Permission\Models\Permission;

use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Roles extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';
    public $name, $selected_id;
    public $search;
    public $pageTitle;
    public $componentName;
    public $selectedPermissions;

    public $selected;

    //escuchamos eventos emitidos desde la vista
    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

    public function mount()
    {
        $this->pageTitle     = 'Listado';
        $this->componentName = 'Roles';
        $this->pagination    = 5;
        $this->search        = '';
        $this->selectedPermissions=[];

        $this->selected=[];

    }

    // limpiamos el buscador
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $permissions = Permission::all();

        if (strlen($this->search)) {
            $roles = Role::where('name', 'like', '%'.$this->search.'%')
                ->orderBy('id', 'desc')->paginate($this->pagination);
        } else {
            $roles = Role::orderBy('id', 'desc')->paginate($this->pagination);
        }
        // lo que decimos aqui es: va a renderizar en la seccion content que esta en la plantilla
        // loyouts/theme y el archico app.blade.php
        return view('livewire.role.roles', compact('roles','permissions'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function new()
    {
        /* $this->authorize('create', Role::class); */

        /* $this->object              = new Role(); */
        $this->selectedPermissions = [];
        $this->emit('show-modal', 'show modal');
    }

    public function store()
    {
        $rules=[
            'name'=>'required|unique:roles|min:3'
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
            $role =Role::create([
                'name'=>$this->name
            ]);

            // registramos todos los permisos que viene del formulario
            //es un array de permisos seleccionados
            $role->givePermissionTo($this->selectedPermissions);

            DB::commit();

            $this->emit('noty', "Agregado el rol {$this->name}");

        } catch(\Exception $exp) {
            DB::rollBack();
            $this->emit('error', $exp->getMessage());
        }

        $this->resetUI();
    }

    public function edit(Role $role)
    {
        /* $this->authorize('update', $role, Role::class); */

        $this->name  = $role->name;
        $this->selected_id = $role->id;

        //$this->selectedPermissions = $role->permissions->pluck('name','id');  //$role->getPermissionNames();

        /* $this->selectedPermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role->id)
                    ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                    ->all(); */

        // de esta forma llenamos una array con valores especificando el key
        $this->selected = array_fill_keys($role->permissions->pluck('id')->toArray(),true);


/*         $permissions = Permission::all()->pluck('name', 'id');
        $role->load('permissions'); */

        //dd($this->selectedPermissions );

        $this->emit('show-modal', 'show modal');
    }

    public function update()
    {

        //dd($this->selected);
        // tener en cuenta que al poner las reglas no debe haber espacio en blanco.
        $rules=[
            'name'=>"required|min:3|unique:roles,name,$this->selected_id "
        ];
        $messages = [
            'name.required' => 'Nombre es requerido',
            'name.unique' => 'Nombre ya existe',
            'name.min'=> 'Nombre debe tener minimo 3 digitos'
        ];
        $this->validate($rules,$messages);

        // aqui recuperamos el registro seleccionado
        $role = Role::find($this->selected_id);

        try {
            DB::beginTransaction();

            $role->name =$this->name;
            $role->save();

            // de esta forma convertimos a areglo simple los checks seleccionado y lo guardamos
            $xx=array_keys(array_filter($this->selected));
            $role->syncPermissions($xx);

            //$role->syncPermissions($this->selectedPermissions);

            DB::commit();

            $this->emit('noty', "El rol {$this->name} fue actualizado correctamente");

        } catch(\Exception $exp) {
            DB::rollBack();
            $this->emit('error', $exp->getMessage());
        }

        $this->resetUI();
    }

    public function destroy(Role $role)
    {
        /* $this->authorize('delete', $role, Role::class); */

        // verificamos de esta manera que
        $permissionsCount = $role->permissions->count();
        if($permissionsCount > 0){
            $this->emit('noty', "El rol {$role->name} tiene permisos asociados");
            return;
        }

        if ($role->canDelete()) {
            $role->delete();
            $this->resetPage();
        }

        $this->emit('noty', "El rol {$role->name} fue eliminado correctamente");
        $this->resetUI();

    }

    public function resetUI()
    {
        /* $this->authorize('viewAny', Role::class); */

        $this->name = "";
        $this->selectedPermissions = [];
        $this->resetValidation();
        $this->emit('hide-modal', 'hide modal');
    }

}
