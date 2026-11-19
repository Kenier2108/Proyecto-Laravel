@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h1 class="h4 mb-0">Registrar Movimiento de Inventario</h1>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('movimientos.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="id_producto" class="form-label">Producto</label>
                            <select name="id_producto" id="id_producto" class="form-select" required>
                                <option value="">Seleccione un producto</option>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}" @selected(old('id_producto') == $producto->id)>
                                        {{ $producto->nom_producto }} (stock: {{ $producto->cant_producto }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select name="tipo" id="tipo" class="form-select" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="entrada" @selected(old('tipo') === 'entrada')>Entrada</option>
                                <option value="salida" @selected(old('tipo') === 'salida')>Salida</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" value="{{ old('cantidad') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="observacion" class="form-label">Observación</label>
                            <textarea name="observacion" id="observacion" class="form-control" rows="3">{{ old('observacion') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Registrar movimiento</button>
                        <a href="{{ route('movimientos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection