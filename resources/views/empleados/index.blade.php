@extends('layouts.app')
@section('content')
<div class="container">

@if(Session::has('mensaje'))
    <div class="alert alert-success" role="alert">
        {{Session::get('mensaje')}}
    </div>
@endif
<br><br>

<a href="{{url('empleado/create')}}" class="btn btn-success">Registrar Nuevo Empleado</a>
<br><br>
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>P. Apellido</th>
            <th>S. Apellido</th>
            <th>Correo</th>
            <th>Accion</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($empleados as $datos)
        <tr>
            <td>{{$datos->id}}</td>
            <td>
                <img src="{{asset('storage').'/'.$datos->Foto}}" alt="" width="220" height="220">
            </td>
            <td>{{$datos->Nombres}}</td>
            <td>{{$datos->PrimerApel}}</td>
            <td>{{$datos->SegundoApel}}</td>
            <td>{{$datos->Correo}}</td>
            <td>
                <a href="{{url('/empleado/'.$datos->id.'/edit')}}" class="btn btn-warning">
                    Editar
                </a> |
                <form action="{{url('/empleado/'.$datos->id)}}" method="post" class="d-inline">
                    @csrf
                    {{method_field('DELETE')}}
                    <input type="submit" onclick="return confirm('¿Quieres borrar?')" value="Borrar" class="btn btn-danger">
                </form>

            </td>

        </tr>

        @endforeach
    </tbody>
</table>
{!! $empleados->links() !!}
</div>
@endsection