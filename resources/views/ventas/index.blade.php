@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <h1 class="h2 mb-1">Ventas</h1>
            <p class="text-muted mb-0">Consulta las ventas registradas.</p>
        </div>
        @if (auth()->user()->rol !== 'consulta')
            <a href="{{ route('ventas.create') }}" class="btn btn-primary">
                Registrar venta
            </a>
        @endif
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Usuario</th>
                            <th scope="col" class="text-end">Total</th>
                            <th scope="col">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ventas as $venta)
                            <tr>
                                <td>{{ $venta->id }}</td>
                                <td>{{ $venta->fecha }}</td>
                                <td>{{ $venta->cliente?->nombre ?? 'Sin cliente registrado' }}</td>
                                <td>{{ $venta->usuario?->name ?? 'Sin usuario' }}</td>
                                <td class="text-end">${{ number_format((float) $venta->total, 2) }}</td>
                                <td>
                                    <span class="badge {{ $venta->estado === 'registrada' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($venta->estado) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No hay ventas registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if ($ventas->hasPages())
        <div class="mt-3">
            {{ $ventas->links() }}
        </div>
    @endif
</div>
@endsection
