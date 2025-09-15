@extends('layouts.app')

@section('title', 'Agregar Producto')

@section('content')
    <div class="card">
        <h5 class="card-header">Agregar Producto</h5>
        <div class="card-body">
            <form method="POST" action="{{ route('products.store') }}">
        @csrf
        <div class="mb-3">
            <label for="sku" class="form-label">SKU</label>
            <input type="text" name="sku" id="sku" class="form-control" value="{{ old('sku') }}" required>
            @error('sku')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
            @error('nombre')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="mb-3">
            <label for="descripcion_corta" class="form-label">Descripción corta</label>
            <textarea name="descripcion_corta" id="descripcion_corta" class="form-control" required>{{ old('descripcion_corta') }}</textarea>
            @error('descripcion_corta')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="mb-3">
            <label for="descripcion_larga" class="form-label">Descripción larga</label>
            <textarea name="descripcion_larga" id="descripcion_larga" class="form-control" required>{{ old('descripcion_larga') }}</textarea>
            @error('descripcion_larga')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="mb-3">
            <label for="imagen_url" class="form-label">URL de la imagen</label>
            <input type="url" name="imagen_url" id="imagen_url" class="form-control" value="{{ old('imagen_url') }}" required>
            @error('imagen_url')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="mb-3">
            <label for="precio_neto" class="form-label">Precio Neto</label>
            <input type="number" step="0.01" name="precio_neto" id="precio_neto" class="form-control" value="{{ old('precio_neto') }}" required>
            @error('precio_neto')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="mb-3">
            <label for="stock_actual" class="form-label">Stock Actual</label>
            <input type="number" name="stock_actual" id="stock_actual" class="form-control" value="{{ old('stock_actual') }}" required>
            @error('stock_actual')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="mb-3">
            <label for="stock_minimo" class="form-label">Stock Mínimo</label>
            <input type="number" name="stock_minimo" id="stock_minimo" class="form-control" value="{{ old('stock_minimo') }}" required>
            @error('stock_minimo')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="mb-3">
            <label for="stock_bajo" class="form-label">Stock Bajo</label>
            <input type="number" name="stock_bajo" id="stock_bajo" class="form-control" value="{{ old('stock_bajo') }}" required>
            @error('stock_bajo')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="mb-3">
            <label for="stock_alto" class="form-label">Stock Alto</label>
            <input type="number" name="stock_alto" id="stock_alto" class="form-control" value="{{ old('stock_alto') }}" required>
            @error('stock_alto')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection