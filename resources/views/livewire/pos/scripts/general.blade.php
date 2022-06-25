<script>
window.onload = function() {

    $('.tblscroll').nicescroll({
        cursorcolor:"#515365",
        cursorwidth:"30px",
        backgrouond: "rgba(20,20,20,0.3)",
        cursorborder: "0px",
        cursorborderradius:3
    })

    // esta funcion lo hacemos generico para poder reutilizarlo desde cualquier componente
    function Confirm(id, eventName, text){
        swal({
            title: 'CONFIRMAR',
            text: text,
            type: 'warning',
            showCancelButton: 'Cerrar',
            cancelButtonColor:'#fff',
            confirmButtonColor:'#3b3f5c',
            confirmButtonText:'Aceptar'
        }).then(function(result){
            if(result.value){
                // este delete row lo definimos en el componente en un listener
                window.livewire.emit(eventName,id)
                swal.close()
            }
        })

    }

}


</script>
