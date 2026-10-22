<h1>{{$modo}} Empleado</h1>
    <div class="form-group">
        <input class="form-control" type="text" value="{{isset($empleado->Nombres)?$empleado->Nombres:old('Nombres')}}" name="Nombres" id="Nombres" placeholder="Introduzca Nombre"><br>
    </div>
    <div class="form-group">
        <input class="form-control" type="text" value="{{isset($empleado->PrimerApel)?$empleado->PrimerApel:old('PrimerApel')}}" name="PrimerApel" id="PrimerApel" placeholder="Introduzca Primer Apellido"><br>
    </div>
    <div class="form-group">
        <input class="form-control" type="text" value="{{isset($empleado->SegundoApel)?$empleado->SegundoApel:old('SegundoApel')}}" name="SegundoApel" id="SegundoApel" placeholder="Introduzca Segundo Apellido"><br>
    </div>
    <div class="form-group">
        <input class="form-control" type="email" value="{{isset($empleado->Correo)?$empleado->Correo:old('Correo')}}" name="Correo" id="Correo" placeholder="Introduzca Email"><br>
    </div>
    <div class="form-group">
        <input class="form-control" type="file" name="Foto" id="Foto"><br>
    </div>
        @if(isset($empleado->Foto))
            <img src="{{asset('storage').'/'.$empleado->Foto}}" alt="" width="220" height="220"><br>
        @endif
        <br><br>
    <input type="submit" value="{{$modo}} Registro" class="btn btn-success">
    @if(count($errors)>0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif
    