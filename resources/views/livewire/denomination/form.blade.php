@include('common.modalHead')

<div class="row">
    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Categoría</label>

            <select class="form-control" wire:model.lazy="type">
                <option value="BILLETE">Billete</option>
                <option value="MONEDA">Moneda</option>
                <option value="OTRO">Otro</option>

            </select>

            @error('type')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Valor</label>
            <input
                type="text"
                wire:model.defer="value"
                class="form-control"
                placeholder="Ej: 1000"
            >
            @error('value')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>




    <div class="col-12 col-md-8">
        <div class="form-group custom-file">
            <input
                type="file"
                class="custom-file-input form-control"
                wire:model="image"
                accept="image/x-png, image/gif, image/jpeg"
            >
            <label class="custom-file-label">
                Imágen {{ $image }}
            </label>

            @error('image')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

</div>

@include('common.modalFooter')
