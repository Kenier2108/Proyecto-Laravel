@extends('layouts.app')
@section('content')
<div class="container">
    @if (Session::has('mensaje'))
        <div class="alert alert-success" role="alert">{{ Session::get('mensaje') }}</div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger" role="alert">{{ Session::get('error') }}</div>
    @endif

    @if (auth()->user()->rol === 'administrador')
        <a href="{{ route('categoria.create') }}" class="btn btn-success">Registrar nueva categoría</a>
        <br><br>
    @endif
    <table class="table table-light">
        <thead>
            <tr>
                <th>#</th>
                <th>Categoría</th>
                <th>Productos</th>
                @if (auth()->user()->rol !== 'consulta')
                    <th>Acción</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($categorias as $categoria)
                <tr>
                    <td>{{ $categoria->id }}</td>
                    <td>{{ $categoria->nom_categoria }}</td>
                    <td>{{ $categoria->productos_count }}</td>
                    @if (auth()->user()->rol !== 'consulta')
                        <td>
                            <a href="{{ route('categoria.edit', $categoria) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('categoria.destroy', $categoria) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Quieres borrar esta categoría?')" class="btn btn-danger">Borrar</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $categorias->links() }}
</div>
@endsection
