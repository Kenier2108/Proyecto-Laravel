@extends('layouts.app')
@section('content')
<div class="container">
    @if(Session::has('mensaje'))
        <div class="alert alert-success" role="alert">{{ Session::get('mensaje') }}</div>
    @endif

    <a href="{{ route('producto.create') }}" class="btn btn-success">Registrar nuevo producto</a>
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
                <th>Acción</th>
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
                    <td>{{ $producto->categoria->nom_categoria }}</td>
                    <td>
                        <a href="{{ route('producto.edit', $producto) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('producto.destroy', $producto) }}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Quieres borrar este producto?')" class="btn btn-danger">Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $productos->links() }}
</div>
@endsection
