@extends('layouts.app')

@section('title', 'Productos')

@section('content')
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Productos</span>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Agregar Producto</a>
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
                <th>SKU</th>
                <th>Nombre</th>
                <th>Precio Neto</th>
                <th>Precio Venta</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->sku }}</td>
                    <td class="d-flex align-items-center">
                        @php
                            // Determine image URL: if imagen_url starts with http use it, otherwise treat as asset path
                            $imgUrl = $product->imagen_url;
                            if ($imgUrl && !preg_match('#^https?://#i', $imgUrl)) {
                                $imgUrl = asset($imgUrl);
                            }
                        @endphp
                        @if(!empty($imgUrl))
                            <img src="{{ $imgUrl }}" alt="{{ $product->nombre }}" style="width:48px;height:48px;object-fit:cover;border-radius:4px;margin-right:8px;" />
                        @else
                            <div style="width:48px;height:48px;background:#f0f0f0;border-radius:4px;margin-right:8px;display:inline-block"></div>
                        @endif
                        <div>{{ $product->nombre }}</div>
                    </td>
                    <td>{{ number_format($product->precio_neto, 0, ',', '.') }}</td>
                    <td>{{ number_format($product->precio_venta, 0, ',', '.') }}</td>
                    @php
                        $stockClass = '';
                        if (isset($product->stock_bajo) && isset($product->stock_alto)) {
                            if ($product->stock_actual <= $product->stock_bajo) {
                                $stockClass = 'text-danger fw-bold';
                            } elseif ($product->stock_actual >= $product->stock_alto) {
                                $stockClass = 'text-success fw-bold';
                            }
                        }
                    @endphp
                    <td class="{{ $stockClass }}">{{ $product->stock_actual }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display: inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
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
                @if ($products->hasPages())
                    <nav aria-label="Paginación de productos">
                        <ul class="pagination justify-content-end mb-0">
                            @if ($products->onFirstPage())
                                <li class="page-item disabled" aria-disabled="true" aria-label="Anterior">
                                    <span class="page-link">&laquo; Anterior</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev" aria-label="Anterior">&laquo; Anterior</a>
                                </li>
                            @endif

                            @if ($products->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next" aria-label="Siguiente">Siguiente &raquo;</a>
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