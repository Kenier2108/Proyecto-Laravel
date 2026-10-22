@extends('layouts.app')
@section('content')
<div class="container">
    <form action="{{ route('categoria.update', $categoria) }}" method="POST">
        @csrf
        @method('PATCH')
        @include('categorias.form', ['modo' => 'Actualizar'])
    </form>
</div>
@endsection
