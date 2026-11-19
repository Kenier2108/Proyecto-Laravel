@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('movimientos.update', $movimiento) }}" method="POST">
        @csrf
        @method('PATCH')
        @include('movimientos.form', ['modo' => 'Actualizar'])
    </form>
</div>
@endsection