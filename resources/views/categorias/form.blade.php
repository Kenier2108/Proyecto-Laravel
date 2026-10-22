<h1>{{ $modo }} Categoría</h1>
<div class="form-group">
    <label for="nom_categoria">Nombre de la categoría</label>
    <input class="form-control" type="text" name="nom_categoria" id="nom_categoria" value="{{ old('nom_categoria', $categoria->nom_categoria ?? '') }}" required>
</div>
<br>
<button type="submit" class="btn btn-success">{{ $modo }} registro</button>
<a href="{{ route('categoria.index') }}" class="btn btn-secondary">Cancelar</a>
@if ($errors->any())
    <div class="alert alert-danger mt-3" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
