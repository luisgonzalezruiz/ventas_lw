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
                                <th class="table-th text-white">Code Bar</th>
                                <th class="table-th text-white">Nombre</th>
                                <th class="table-th text-white">Categoria</th>
                                <th class="table-th text-white text-right">Precio</th>
                                <th class="table-th text-white text-right">Stock</th>
                                <th class="table-th text-white text-center">Imagen</th>
                                <th class="table-th text-white text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td><h6>{{ $product->barcode }}</h6></td>
                                <td><h6>{{ $product->name }}</h6></td>
                                <td><h6>{{ $product->category }}</h6> </td>
                                <td class="text-right"><h6>{{ $product->price }}</h6></td>
                                <td class="text-right"><h6>{{ $product->stock }}</h6></td>
                                <td class="text-center">
                                    <span>
                                        <img src="{{Storage::url($product->imagen)}}"
                                            alt="imagen de ejemplo" height="60" width="60" class="rounded">
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" class="btn btn-dark mtmobile" title="Editar"
                                            wire:click="edit({{ $product->id }})">
                                            <i class="fas fa-edit fa-xs"></i>
                                    </a>

                                    {{-- @if( $product->products->count()> 1) --}}
                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile" title="Borrar"
                                            onclick="confirm({{ $product->id }}, {{ 0 }})">
                                            <i class="fas fa-trash fa-xs"></i>
                                        </a>
                                    {{-- @endif --}}

                                </td>
                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                    <div  class="pagination-no_spacing">
                        {{ $products->links() }}
                    </div>

                </div>

            </div>

        </div>

    </div>

    @include('livewire.product.form')

</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    // escuchamos el evento que viene del backend
    window.livewire.on('show-modal',msg =>{
        $('#theModal').modal('show')
    });

    window.livewire.on('product-added',msg =>{
        $('#theModal').modal('hide')
    });

    window.livewire.on('product-updated',msg =>{
        $('#theModal').modal('hide')
    });
    window.livewire.on('product-deleted',msg =>{
        console.log('Registro eliminado')
    });

    window.livewire.on('modal-hide',msg =>{
        $('#theModal').modal('hide')
        console.log('entra aqui')
    });
    window.livewire.on('hidden.bs.modal',msg =>{
        // de esta forma ocultamos todos los elementos que tengan la clase "er", fijarse en la parte donde mostrarmos errores
        // en el modal
        $('.er').css('display','none')
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


function test(){
    console.log('Se ejecuto esta funcion')
}

</script>
