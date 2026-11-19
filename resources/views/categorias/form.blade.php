<h1 class="h4 mb-3">{{ $modo }} Categoría</h1>
<div class="mb-3">
    <label for="nom_categoria" class="form-label">Nombre de la categoría</label>
    <input class="form-control" type="text" name="nom_categoria" id="nom_categoria" value="{{ old('nom_categoria', $categoria->nom_categoria ?? '') }}" required>
</div>
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
