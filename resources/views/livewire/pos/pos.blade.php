<div>
    <style></style>
    <div class="row layout-top-spacing">
        <div class="col-sm-12 col-md-8">
            {{-- detalles --}}
            @include('livewire.pos.partials.detail')

        </div>

        <div class="col-sm-12 col-md-4">
            {{-- total --}}
            @include('livewire.pos.partials.total')
            {{-- denominaciones --}}
            @include('livewire.pos.partials.denominations')

        </div>


    </div>
</div>

<script>
 window.onload = function() {
        initPosKeypress();
        initOnScan();
    };
</script>
