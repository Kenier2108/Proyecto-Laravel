<h1 class="h4 mb-3">{{ $modo }} Empleado</h1>

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label for="Nombres" class="form-label">Nombre</label>
    <input class="form-control" type="text" value="{{ old('Nombres', $empleado->Nombres ?? '') }}" name="Nombres" id="Nombres" placeholder="Introduzca nombre" required>
</div>
<div class="mb-3">
    <label for="PrimerApel" class="form-label">Primer apellido</label>
    <input class="form-control" type="text" value="{{ old('PrimerApel', $empleado->PrimerApel ?? '') }}" name="PrimerApel" id="PrimerApel" placeholder="Introduzca primer apellido" required>
</div>
<div class="mb-3">
    <label for="SegundoApel" class="form-label">Segundo apellido</label>
    <input class="form-control" type="text" value="{{ old('SegundoApel', $empleado->SegundoApel ?? '') }}" name="SegundoApel" id="SegundoApel" placeholder="Introduzca segundo apellido" required>
</div>
<div class="mb-3">
    <label for="Correo" class="form-label">Correo electrónico</label>
    <input class="form-control" type="email" value="{{ old('Correo', $empleado->Correo ?? '') }}" name="Correo" id="Correo" placeholder="Introduzca correo electrónico" required>
</div>
<div class="mb-3">
    <label for="Foto" class="form-label">Foto</label>
    <input class="form-control" type="file" name="Foto" id="Foto" accept="image/*" required>
</div>
@if (isset($empleado->Foto))
    <img src="{{ asset('storage/'.$empleado->Foto) }}" alt="Foto de {{ $empleado->Nombres }}" width="220" height="220" class="img-thumbnail mb-3">
@endif

<button type="submit" class="btn btn-success">{{ $modo }} registro</button>
<a href="{{ route('empleado.index') }}" class="btn btn-secondary">Cancelar</a>