@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if ($categorias->isEmpty())
                        <div class="alert alert-warning mb-0" role="alert">
                            @if (auth()->user()->rol === 'administrador')
                                Primero debes <a href="{{ route('categoria.create') }}">crear una categoría</a> para registrar productos.
                            @else
                                No hay categorías disponibles para registrar productos. Solicita a un administrador que cree una categoría.
                            @endif
                        </div>
                    @else
                        <form action="{{ route('producto.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @include('productos.form', ['modo' => 'Guardar'])
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
