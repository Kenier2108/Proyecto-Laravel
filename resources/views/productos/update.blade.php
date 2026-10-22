@extends('layouts.app')
@section('content')
<div class="container">
    <form action="{{ route('producto.update', $producto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        @include('productos.form', ['modo' => 'Actualizar'])
    </form>
</div>
@endsection
