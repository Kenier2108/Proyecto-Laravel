<h1>{{ $modo }} Producto</h1>
<div class="form-group">
    <label for="nom_producto">Nombre</label>
    <input class="form-control" type="text" name="nom_producto" id="nom_producto" value="{{ old('nom_producto', $producto->nom_producto ?? '') }}" required>
</div>
<div class="form-group">
    <label for="detalle_producto">Detalle</label>
    <input class="form-control" type="text" name="detalle_producto" id="detalle_producto" value="{{ old('detalle_producto', $producto->detalle_producto ?? '') }}" required>
</div>
<div class="form-group">
    <label for="cant_producto">Cantidad</label>
    <input class="form-control" type="text" name="cant_producto" id="cant_producto" value="{{ old('cant_producto', $producto->cant_producto ?? '') }}" required>
</div>
<div class="form-group">
    <label for="valor_producto">Valor</label>
    <input class="form-control" type="text" name="valor_producto" id="valor_producto" value="{{ old('valor_producto', $producto->valor_producto ?? '') }}" required>
</div>
<div class="form-group">
    <label for="estado_producto">Estado</label>
    <input class="form-control" type="text" name="estado_producto" id="estado_producto" value="{{ old('estado_producto', $producto->estado_producto ?? '') }}" required>
</div>
<div class="form-group">
    <label for="id_categoria">Categoría</label>
    <select class="form-control" name="id_categoria" id="id_categoria" required>
        <option value="">Seleccione una categoría</option>
        @foreach ($categorias as $categoria)
            <option value="{{ $categoria->id }}" @selected(old('id_categoria', $producto->id_categoria ?? '') == $categoria->id)>
                {{ $categoria->nom_categoria }}
            </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="foto_producto">Foto</label>
    <input class="form-control" type="file" name="foto_producto" id="foto_producto" accept="image/*" @required(!isset($producto))>
    @if (isset($producto->foto_producto))
        <img src="{{ asset('storage/'.$producto->foto_producto) }}" alt="{{ $producto->nom_producto }}" width="150" class="mt-2">
    @endif
</div>
<br>
<button type="submit" class="btn btn-success">{{ $modo }} registro</button>
<a href="{{ route('producto.index') }}" class="btn btn-secondary">Cancelar</a>
@if ($errors->any())
    <div class="alert alert-danger mt-3" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
