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
                wire:model.lazy="name"
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

    <div class="col-12 mt-3">
        <div class="form-group">
            <label>Permisos</label>
            <select class="form-control" wire:model.lazy="selectedPermissions" multiple>
                @foreach($permissions as $permission)
                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                @endforeach
            </select>
            @error('selectedPermissions.*')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>

@include('common.modalFooter')
