@include('common.modalHead')

<div class="row">
    <div class="col-12 col-md-8">
        <div class="form-group">
            <label>Nombre</label>
            <input
                type="text"
                wire:model.lazy="object.name"
                class="form-control"
                placeholder="Ej: Curso Laravel"
            >
            @error('object.name')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Código</label>
            <input
                type="text"
                wire:model.lazy="object.barcode"
                class="form-control"
                placeholder="Ej: 002932"
            >
            @error('object.barcode')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Costo</label>
            <input
                type="text"
                wire:model.lazy="object.cost"
                class="form-control"
                placeholder="Ej: 1.00"
                data-type="currency"
            >
            @error('object.cost')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Precio</label>
            <input
                type="text"
                wire:model.lazy="object.price"
                class="form-control"
                placeholder="Ej: 1.00"
                data-type="currency"
            >
            @error('object.price')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Stock</label>
            <input
                type="number"
                wire:model.lazy="object.stock"
                class="form-control"
                placeholder="Ej: 100"
            >
            @error('object.stock')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Inv.Minimo</label>
            <input
                type="number"
                wire:model.lazy="object.alerts"
                class="form-control"
                placeholder="Ej: 100"
            >
            @error('object.alerts')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Categoría</label>

            <select class="form-control" wire:model.lazy="object.category_id">
                <option value="">Elejir</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            @error('object.category_id')
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
                Imágen {{ $image ?? ($object->image ?? '') }}
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
