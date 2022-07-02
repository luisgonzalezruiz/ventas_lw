<div class="row sales layout-top-spacing">
    <div class="col-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <span class="font-weight-bold">
                        {{ $componentName }} | {{ $pageTitle }}
                    </span>
                </h4>

                <ul class="tabs tab-pills">
                    {{-- @can('create_roles') --}}
                        <li>
                            {{-- <a href="javascript:void(0)" class="tabmenu bg-dark" wire:click="new()">Agregar</a> --}}

                            <a href="javascript:void(0)" class="tabmenu bg-dark"
                                data-toggle="modal"
                                data-target="#theModal">Agregar
                            </a>
                        </li>
                    {{-- @endcan --}}
                </ul>
            </div>

            @include('common.searchBox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white">
                            <tr>
                                <th class="table-th text-white">ID</th>
                                <th class="table-th text-white text-center">DESCRIPCION</th>
                                <th class="table-th text-white text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                            <tr>
                                <td>
                                    <h6>{{ $permission->id }}</h6>
                                </td>
                                <td class="text-center h6">
                                    {{ $permission->name }}
                                </td>
                                <td class="text-center">
                                    {{-- @can('update_roles') --}}
                                        <a
                                            href="javascript:void(0)"
                                            class="btn btn-dark mtmobile"
                                            title="Editar"
                                            wire:click="edit({{ $permission->id }})"
                                        >
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                    {{-- @endcan --}}
                                    {{-- @can('delete_roles') --}}
                                        <a
                                            href="javascript:void(0)"
                                            @if ($permission->roles->count() == 0)
                                                class="btn btn-dark"
                                                title="Borrar"
                                                onclick="Confirm('deleteRow', {{ $permission->id }})"
                                            @else
                                                class="btn btn-dark disabled"
                                                title="Este permiso no puede ser borrado"
                                                disabled
                                            @endif
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    {{-- @endcan --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $permissions->links() }}
                </div>
            </div>
        </div>
    </div>

    @include('livewire.role.form')

</div>

<script>

    document.addEventListener('DOMContentLoaded', function(){
        // escuchamos el evento que viene del backend
        window.livewire.on('show-modal',msg =>{
            $('#theModal').modal('show')
        });

        window.livewire.on('permission-added',msg =>{
            $('#theModal').modal('hide')
        });

        window.livewire.on('permission-updated',msg =>{
            $('#theModal').modal('hide')
        });
        window.livewire.on('permission-deleted',msg =>{
            console.log('Registro eliminado')
        });

    });
</script>

