<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <span class="font-weight-bold">{{ $componentName}} | {{$pageTitle }}</span>
                </h4>

                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark"
                            data-toggle="modal"
                            data-target="#theModal">Agregar
                        </a>
                    </li>
                </ul>
            </div>

            @include('common.searchBox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm table-striped mt-1">
                        <thead class="text-white" style ="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-white">Descripcion</th>
                                <th class="table-th text-white">Imagen</th>
                                <th class="table-th text-white">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>
                                    <h6>{{ $category->name }}</h6>
                                </td>
                                <td class="text-center">
                                    <span>
                                        <img src="{{Storage::url($category->imagen)}}"
                                            alt="imagen de ejemplo" height="60" width="60" class="rounded">
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" class="btn btn-dark mtmobile" title="Editar"
                                            wire:click="edit({{ $category->id }})">
                                            <i class="fas fa-edit fa-xs"></i>
                                    </a>

                                    {{-- @if( $category->products->count()> 1) --}}
                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile" title="Borrar"
                                            onclick="confirm({{ $category->id }}, {{ $category->products->count() }})">
                                            <i class="fas fa-trash fa-xs"></i>
                                        </a>
                                    {{-- @endif --}}

                                </td>
                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                     {{ $categories->links() }}

                </div>

            </div>

        </div>

    </div>

    @include('livewire.category.form')

</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    // escuchamos el evento que viene del backend
    window.livewire.on('show-modal',msg =>{
        //console.log(msg)
        // de esta forma llamamos a la funcion que esta por afuera
        //test()
        $('#theModal').modal('show')
    });

    window.livewire.on('category-added',msg =>{
        $('#theModal').modal('hide')
    });

    window.livewire.on('category-updated',msg =>{
        $('#theModal').modal('hide')
    });
    window.livewire.on('category-deleted',msg =>{
        console.log('Registro eliminado')
    });

});

function confirm(id, products){

    if(products > 0){
        swal('No se puede eliminar la categoria por que tiene producto relacionado')
        return;
    }

    swal({
        title: 'CONFIRMAR',
        text: 'Confirmas eliminar el registro',
        type: 'warning',
        showCancelButton: 'Cerrar',
        cancelButtonColor:'#fff',
        confirmButtonColor:'#3b3f5c',
        confirmButtonText:'Aceptar'
    }).then(function(result){
        if(result.value){
            // este delete row lo definimos en el componente en un listener
            window.livewire.emit('deleteRow',id)
            swal.close()
        }
    })

}


</script>
