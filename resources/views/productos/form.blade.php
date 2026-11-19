<h1 class="h4 mb-3">{{ $modo }} Producto</h1>
<div class="mb-3">
    <label for="nom_producto" class="form-label">Nombre</label>
    <input class="form-control" type="text" name="nom_producto" id="nom_producto"  value="{{ old('nom_producto', $producto->nom_producto ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="detalle_producto" class="form-label">Detalle</label>
    <input class="form-control" type="text" name="detalle_producto" id="detalle_producto" value="{{ old('detalle_producto', $producto->detalle_producto ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="cant_producto" class="form-label">Cantidad</label>
    <input class="form-control" type="text" name="cant_producto" id="cant_producto" value="{{ old('cant_producto', $producto->cant_producto ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="valor_producto" class="form-label">Valor</label>
    <input class="form-control" type="text" name="valor_producto" id="valor_producto" value="{{ old('valor_producto', $producto->valor_producto ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="estado_producto" class="form-label">Estado</label>
    <select class="form-select" name="estado_producto" id="estado_producto" required>
        <option value="">Seleccione un estado</option>
        <option value="Activo" @selected(old('estado_producto', $producto->estado_producto ?? '') == 'Activo')>Activo</option>
        <option value="Inactivo" @selected(old('estado_producto', $producto->estado_producto ?? '') == 'Inactivo')>Inactivo</option>
    </select>
</div>
<div class="mb-3">
    <label for="id_categoria" class="form-label">Categoría</label>
    <select class="form-select" name="id_categoria" id="id_categoria" required>
        <option value="">Seleccione una categoría</option>
        @foreach ($categorias as $categoria)
            <option value="{{ $categoria->id }}" @selected(old('id_categoria', $producto->id_categoria ?? '') == $categoria->id)>
                {{ $categoria->nom_categoria }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="foto_producto" class="form-label">Foto</label>
    <input class="form-control" type="file" name="foto_producto" id="foto_producto" accept="image/*" @required(!isset($producto))>
    @if (isset($producto->foto_producto))
        <img src="{{ asset('storage/'.$producto->foto_producto) }}" alt="{{ $producto->nom_producto }}" width="150" class="mt-2">
    @endif
</div>
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
