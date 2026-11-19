@extends('layouts.app')

@section('content')
<div class="container">
    @if (Session::has('mensaje'))
        <div class="alert alert-success" role="alert">{{ Session::get('mensaje') }}</div>
    @endif

    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger" role="alert">{{ Session::get('error') }}</div>
    @endif

    @if (auth()->user()->rol !== 'consulta')
        <a href="{{ route('movimientos.create') }}" class="btn btn-success">Registrar nuevo movimiento</a>
        <br><br>
    @endif

    <table class="table table-light">
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Observación</th>
                <th>Usuario</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($movimientos as $movimiento)
                <tr>
                    <td>{{ $movimiento->id }}</td>
                    <td>{{ $movimiento->producto?->nom_producto ?? 'Sin producto' }}</td>
                    <td>
                        @if ($movimiento->tipo === 'entrada')
                            <span class="badge bg-success">Entrada</span>
                        @else
                            <span class="badge bg-danger">Salida</span>
                        @endif
                    </td>
                    <td>{{ $movimiento->cantidad }}</td>
                    <td>{{ $movimiento->observacion ?? 'Sin observación' }}</td>
                    <td>{{ $movimiento->usuario?->name ?? 'Sistema' }}</td>
                    <td>{{ $movimiento->created_at ? $movimiento->created_at->format('d/m/Y H:i') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No hay movimientos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $movimientos->links() }}
</div>
@endsection
