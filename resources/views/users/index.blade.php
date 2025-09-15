@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Usuarios</span>
            <a href="{{ route('users.create') }}" class="btn btn-primary">Agregar Usuario</a>
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
                <th>RUT</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->rut }}</td>
                    <td>{{ $user->nombre }}</td>
                    <td>{{ $user->apellido }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
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
                @if ($users->hasPages())
                    <nav aria-label="Paginación de usuarios">
                        <ul class="pagination justify-content-end mb-0">
                            {{-- Previous Page Link --}}
                            @if ($users->onFirstPage())
                                <li class="page-item disabled" aria-disabled="true" aria-label="Anterior">
                                    <span class="page-link">&laquo; Anterior</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev" aria-label="Anterior">&laquo; Anterior</a>
                                </li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($users->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next" aria-label="Siguiente">Siguiente &raquo;</a>
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