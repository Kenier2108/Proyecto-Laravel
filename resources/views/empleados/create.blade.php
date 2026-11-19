@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('empleado.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('empleados.form', ['modo' => 'Guardar'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
