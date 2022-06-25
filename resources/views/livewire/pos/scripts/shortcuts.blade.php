<script>
     window.onload = function() {

         console.log('funciona tecla rapida')

         var listener = new window.keypress.Listener();


         listener.simple_combo("f9", function(){
             window.livewire.emit('saveSale')
         })

         listener.simple_combo("f8", function(){
             document.getElementById('cash').value = ''
             document.getElementById('hiddenTotal').value = ''
             document.getElementById('cash').focus()
         })

         listener.simple_combo("f4", function(){
             console.log('funciona el f4')
             //hiddenTotal es un input oculto que esta en pos/partials/total.blade.php
            var total = parseFloat(document.getElementById('hiddenTotal').value)
            if (total>0){
                 Confirm(0,'clearCart','Seguro de elimar el carrito')
            }else{
                 noty('Agrega productos a la venta')
            }

         })
     }


</script>
