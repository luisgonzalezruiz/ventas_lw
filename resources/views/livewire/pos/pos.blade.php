<div class="row sales layout-top-spacing">
    <div class="col-sm-12 col-md-8">
        @include('livewire.pos.partials.detail')
    </div>
    <div class="col-12 col-md-4">
        @include('livewire.pos.partials.total')
        @include('livewire.pos.partials.denominations')
    </div>
</div>


{{-- <script src="{{ asset('vendor/dmauro-Keypress/keypress-2.1.5.min.js') }}" defer></script>
<script src="{{ asset('vendor/onscan/onscan.min.js') }}" defer></script> --}}

{{-- <script>
      window.onload = function() {
        initPosKeypress();
        initOnScan();
    };
</script> --}}

{{-- @include('livewire.pos.scripts.general')
@include('livewire.pos.scripts.shortcuts')
@include('livewire.pos.scripts.events')
@include('livewire.pos.scripts.scan') --}}
