@extends('layouts.app')
@section('content')
<div class="container">
    @if ($categorias->isEmpty())
        <div class="alert alert-warning">
            Primero debes <a href="{{ route('categoria.create') }}">crear una categoría</a> para registrar productos.
        </div>
    @else
        <form action="{{ route('producto.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('productos.form', ['modo' => 'Guardar'])
        </form>
    @endif
</div>
@endsection
