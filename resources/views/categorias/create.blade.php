@extends('layouts.app')
@section('content')
<div class="container">
    <form action="{{ route('categoria.store') }}" method="POST">
        @csrf
        @include('categorias.form', ['modo' => 'Guardar'])
    </form>
</div>
@endsection
