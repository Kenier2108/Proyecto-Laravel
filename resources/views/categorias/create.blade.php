@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('categoria.store') }}" method="POST">
                        @csrf
                        @include('categorias.form', ['modo' => 'Guardar'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
