@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Clientes</span>
            <a href="{{ route('clients.create') }}" class="btn btn-primary">Agregar Cliente</a>
        </h5>
        <div class="card-body">
            <form method="GET" class="mb-3 d-flex" action="{{ url()->current() }}">
                <div class="me-2">
                    <input type="text" name="id" value="{{ request('id') }}" class="form-control" placeholder="Filtrar por ID" />
                </div>
                <div>
                    <button class="btn btn-outline-primary" type="submit">Filtrar</button>
                </div>
            </form>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>RUT Empresa</th>
                <th>Razón Social</th>
                <th>Contacto</th>
                <th>Email Contacto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->rut_empresa }}</td>
                    <td>{{ $client->razon_social }}</td>
                    <td>{{ $client->contacto_nombre }}</td>
                    <td>{{ $client->contacto_email }}</td>
                    <td>
                        <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display: inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este cliente?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
                </table>
            </div>
            <div class="mt-3">
                @if ($clients->hasPages())
                    <nav aria-label="Paginación de clientes">
                        <ul class="pagination justify-content-end mb-0">
                            @if ($clients->onFirstPage())
                                <li class="page-item disabled" aria-disabled="true" aria-label="Anterior">
                                    <span class="page-link">&laquo; Anterior</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $clients->previousPageUrl() }}" rel="prev" aria-label="Anterior">&laquo; Anterior</a>
                                </li>
                            @endif

                            @if ($clients->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $clients->nextPageUrl() }}" rel="next" aria-label="Siguiente">Siguiente &raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled" aria-disabled="true" aria-label="Siguiente">
                                    <span class="page-link">Siguiente &raquo;</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif
            </div>
        </div>
    </div>
@endsection