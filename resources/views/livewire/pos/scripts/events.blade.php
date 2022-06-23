<script>
    document.addEventListener('DOMContentLoaded', function(){
        // escuchamos el evento que viene del backend
        window.livewire.on('scan-ok', msg =>{
            noty(msg)
        });

        window.livewire.on('scan-notfound', msg =>{
            noty(msg,2)
        });

        window.livewire.on('scan-stock', msg =>{
            noty(msg,2)
        });

        window.livewire.on('sale-error', msg =>{
            noty(msg)
        });

        window.livewire.on('print-ticket', saleId =>{
           window.open("print://" + saleId, '_blank')
        });

    });

</script>
