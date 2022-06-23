<script>

try {

    onScan.attachTo(document,{
        suffixKeyCodes: [13],
        onScan: function(barcode){
            console.log(barcode)
            window.livewire.emit('scanCode',barcode)
        },
        onScanError: function(e){
            console,log(e)
        }
    })
    consolo.log('Scanner ready')

} catch (error) {
    console.log('Error de lectura', error)
}


</script>
