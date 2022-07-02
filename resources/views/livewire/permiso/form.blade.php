@include('common.modalHead')

<div class="row">
    <div class="col-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa-regular fa-pen-to-square"></i>
                </span>
            </div>
            <input
                type="text"
                wire:model.prevent="name"
                class="form-control"
                placeholder="Ej: Administrador"
            >
        </div>
        @error('name')
            <span class="text-danger er">
                {{ $message }}
            </span>
        @enderror
    </div>


</div>

@include('common.modalFooter')
