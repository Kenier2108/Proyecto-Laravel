<h1>{{ $modo }} Movimiento</h1>

<div class="form-group">
    <label for="id_producto">Producto</label>
    <select class="form-control" name="id_producto" id="id_producto" required>
        <option value="">Seleccione un producto</option>
        @foreach ($productos as $producto)
            <option value="{{ $producto->id }}" @selected(old('id_producto', $movimiento->id_producto ?? '') == $producto->id)>
                {{ $producto->nom_producto }} (stock: {{ $producto->cant_producto }})
            </option>
        @endforeach
    </select>
</div>

<div class="form-group mt-3">
    <label for="tipo">Tipo</label>
    <select class="form-control" name="tipo" id="tipo" required>
        <option value="">Seleccione un tipo</option>
        <option value="entrada" @selected(old('tipo', $movimiento->tipo ?? '') == 'entrada')>Entrada</option>
        <option value="salida" @selected(old('tipo', $movimiento->tipo ?? '') == 'salida')>Salida</option>
    </select>
</div>

<div class="form-group mt-3">
    <label for="cantidad">Cantidad</label>
    <input class="form-control" type="number" name="cantidad" id="cantidad" min="1" value="{{ old('cantidad', $movimiento->cantidad ?? '') }}" required>
</div>

<div class="form-group mt-3">
    <label for="observacion">Observación</label>
    <textarea class="form-control" name="observacion" id="observacion" rows="3">{{ old('observacion', $movimiento->observacion ?? '') }}</textarea>
</div>

<br>
<button type="submit" class="btn btn-success">{{ $modo }} registro</button>
<a href="{{ route('movimientos.index') }}" class="btn btn-secondary">Cancelar</a>

@if ($errors->any())
    <div class="alert alert-danger mt-3" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif