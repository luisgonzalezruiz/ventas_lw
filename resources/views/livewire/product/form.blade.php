@include('common.modalHead')

<div class="row">
    <div class="col-12 col-md-8">
        <div class="form-group">
            <label>Nombre</label>
            <input
                type="text"
                wire:model.lazy="name"
                class="form-control"
                placeholder="Ej: Curso Laravel"
            >
            @error('name')
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
                wire:model.lazy="barcode"
                class="form-control"
                placeholder="Ej: 002932"
            >
            @error('barcode')
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
                wire:model.lazy="cost"
                class="form-control"
                placeholder="Ej: 1.00"
                data-type="currency"
            >
            @error('cost')
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
                wire:model.lazy="price"
                class="form-control"
                placeholder="Ej: 1.00"
                data-type="currency"
            >
            @error('price')
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
                wire:model.lazy="stock"
                class="form-control"
                placeholder="Ej: 100"
            >
            @error('stock')
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
                wire:model.lazy="alerts"
                class="form-control"
                placeholder="Ej: 100"
            >
            @error('alerts')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Categoría</label>

            <select class="form-control" wire:model.lazy="category_id">
                <option value="Elegir" disabled>Elegir</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            @error('category_id')
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
