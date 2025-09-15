@extends('layouts.app')

@section('title', 'Agregar Cliente')

@section('content')
    <div class="card">
        <h5 class="card-header">Agregar Cliente</h5>
        <div class="card-body">
            <form method="POST" action="{{ route('clients.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="rut_empresa" class="form-label">RUT Empresa</label>
                    <input type="text" name="rut_empresa" id="rut_empresa" class="form-control" value="{{ old('rut_empresa') }}" required>
                    @error('rut_empresa')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="mb-3">
                    <label for="rubro" class="form-label">Rubro</label>
                    <input type="text" name="rubro" id="rubro" class="form-control" value="{{ old('rubro') }}" required>
                    @error('rubro')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="mb-3">
                    <label for="razon_social" class="form-label">Razón Social</label>
                    <input type="text" name="razon_social" id="razon_social" class="form-control" value="{{ old('razon_social') }}" required>
                    @error('razon_social')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}" required>
                    @error('telefono')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion') }}" required>
                    @error('direccion')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="mb-3">
                    <label for="contacto_nombre" class="form-label">Nombre del contacto</label>
                    <input type="text" name="contacto_nombre" id="contacto_nombre" class="form-control" value="{{ old('contacto_nombre') }}" required>
                    @error('contacto_nombre')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="mb-3">
                    <label for="contacto_email" class="form-label">Email del contacto</label>
                    <input type="email" name="contacto_email" id="contacto_email" class="form-control" value="{{ old('contacto_email') }}" required>
                    @error('contacto_email')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection