<script src="{{ asset('theme/js/loader.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js" crossorigin="anonymous" defer></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous" defer></script>

<script src="{{ asset('theme/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}" defer></script>
<script src="{{ asset('theme/js/app.js') }}" defer></script>
<script src="{{ asset('theme/js/custom.js') }}" defer></script>


<script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}" defer></script>
<script src="{{ asset('theme/plugins/notification/snackbar/snackbar.min.js') }}" defer></script>

<script src="{{ asset('theme/plugins/nicescroll/jquery.nicescroll.js') }}" defer></script>

<script src="{{ asset('theme/plugins/currency/currency.js') }}" defer></script>

<script src="{{ asset('vendor/dmauro-Keypress/keypress-2.1.5.min.js') }}" defer></script>
<script src="{{ asset('vendor/onscan/onscan.min.js') }}" defer></script>


<script src="https://cdn.jsdelivr.net/npm/flatpickr" defer></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>


{{-- este es del mixin --}}
<script src="{{ asset('js/app.js') }}" defer></script>



<script>
window.onload = function() {

    App.init();

    initNiceScroll();
    initFlatpickr();

    initPosKeypress();
    initOnScan();


};
</script>

<script>


    function initNiceScroll() {

        $('.tblscroll').niceScroll({
            cursorcolor: "#515365",
            cursorwidth: "15px",
            background: "rgba(20,20,20,0.3)",
            cursorborder: "0px",
            cursorborderradius: 7
        });
    }


    function initOnScan() {
        try {
            onScan.attachTo(document, {
                suffixKeyCodes: [13],
                onScan: function(barcode) {
                    window.livewire.emit('scanCode', barcode);
                },
                onScanError: function(e){
                    console.log(e);
                }
            });

            console.log('Scaner ready!');
        } catch(e) {
            console.log(e);
        }
    }

    function initPosKeypress() {

        console.log('llegue al metodo initPosKeypress 1')

        var listener = new window.keypress.Listener();

        listener.simple_combo("f9", function() {
            window.livewire.emit('saveSale');
        });

        listener.simple_combo("f8", function() {
            var input = document.getElementById('cash');
            input.value = '';
            input.focus();
        });

        listener.simple_combo("f4", function() {
            var value = parseInt(document.getElementById('hiddenTotal').value, 10);
            if (value > 0) {
                Confirm('clearCart', '', '¿CONFIRMAS CANCELAR LA COMPRA?');
            } else {
                noty('AGREGA PRODUCTOS A LA VENTA.', 2);
            }
        });

    }

    function initFlatpickr() {
        flatpickr(document.getElementsByClassName('flatpickr'), {
            enableTime: false,
            dateFormat: 'd-m-Y',
            locale: 'es'
        });
    }

    // este funcion lo usaremos globalmente para mostrar los mensajes
    // es una libreria javascrips que definimos mas arriba
    function noty(msg, option = 1) {
        Snackbar.show({
            text: msg.toUpperCase(),
            actionText: 'Cerrar',
            actionTextColor: '#fff',
            backgroundColor: option == 1 ? '#3b3f5c' : '#e7515a',
            pos: 'top-right'
        });
    }

    function Confirm(event, id, text = '¿CONFIRMAS ELIMINAR EL REGISTRO?') {
        swal({
            title: 'CONFIRMAR',
            text: text,
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#3b3f5c'
        }).then(
            function (result) {
                if (result.value) {
                    //console.log('elimine');
                    window.livewire.emit(event, id);
                    swal.close();
                }
            }
        );
    }

    document.addEventListener('DOMContentLoaded', function () {
        window.livewire.on('noty', msg => {
            noty(msg)
        });

        window.livewire.on('error', msg => {
            noty(msg, 2)
        });

        window.livewire.on('hide-modal', msg => {
            $('#theModal').modal('hide');
        });

        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });

        window.livewire.on('print-ticket', saleId => {
            window.open('print://' + saleId, '_blank');
        });
    })

</script>


