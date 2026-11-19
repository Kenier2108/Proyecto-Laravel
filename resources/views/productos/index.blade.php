@extends('layouts.app')
@section('content')
<div class="container">
    @if(Session::has('mensaje'))
        <div class="alert alert-success" role="alert">{{ Session::get('mensaje') }}</div>
    @endif

    <form method="GET" action="{{ route('producto.index') }}" class="row g-3 align-items-end mb-4">
        <div class="col-md-4">
            <label for="buscar" class="form-label">Nombre del producto:</label>
            <input class="form-control" type="text" name="buscar" id="buscar" value="{{ request('buscar') }}">
        </div>

        <div class="col-md-3">
            <label for="id_categoria" class="form-label">Categoría:</label>
            <select class="form-select" name="id_categoria" id="id_categoria">
                <option value="">Todas las categorías</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" @selected(request('id_categoria') == $categoria->id)>{{ $categoria->nom_categoria }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label for="estado_producto" class="form-label">Estado:</label>
            <select class="form-select" name="estado_producto" id="estado_producto">
                <option value="">Todos</option>
                <option value="Activo" @selected(request('estado_producto') === '1')>Activos</option>
                <option value="Inactivo" @selected(request('estado_producto') === '0')>Inactivos</option>
            </select>
        </div>

        <div class="col-md-auto">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="{{ route('producto.index') }}" class="btn btn-outline-secondary">Limpiar</a>
        </div>
    </form>
        
    @if (in_array(auth()->user()->rol, ['administrador', 'inventario']))
    <a href="{{ route('producto.create') }}" class="btn btn-success">Registrar nuevo producto</a>
    @endif
    <br><br>
    <table class="table table-light">
        <thead>
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Producto</th>
                <th>Detalle</th>
                <th>Cantidad</th>
                <th>Valor</th>
                <th>Estado</th>
                <th>Categoría</th>
                @if (in_array(auth()->user()->rol, ['administrador', 'inventario']))
                    <th>Acción</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td><img src="{{ asset('storage/'.$producto->foto_producto) }}" alt="{{ $producto->nom_producto }}" width="100"></td>
                    <td>{{ $producto->nom_producto }}</td>
                    <td>{{ $producto->detalle_producto }}</td>
                    <td>{{ $producto->cant_producto }}</td>
                    <td>{{ $producto->valor_producto }}</td>
                    <td>{{ $producto->estado_producto }}</td>
                    <td>{{ $producto->categoria?->nom_categoria ?? 'Sin categoría' }}</td>
                    @if (in_array(auth()->user()->rol, ['administrador', 'inventario']))
                        <td>
                            <a href="{{ route('producto.edit', $producto) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('producto.destroy', $producto) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Quieres borrar este producto?')" class="btn btn-danger">Borrar</button>
                            </form>
                        </td>
                    @endif
                    {{ $productos->links() }}
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $productos->links() }}
</div>
@endsection
