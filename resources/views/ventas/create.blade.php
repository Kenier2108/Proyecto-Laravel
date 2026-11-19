@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1 class="h2 mb-1">Registrar venta</h1>
        <p class="text-muted mb-0">Selecciona el cliente y los productos de la venta.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <div class="fw-semibold mb-1">No se pudo registrar la venta:</div>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @include('ventas.form')
            <a href="{{ route('ventas.index') }}" class="btn btn-outline-secondary mt-3">Volver a ventas</a>
        </div>
    </div>
</div>
@endsection
