<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/empleados', function () {
//     return view('empleados.index');
// });

// Route::get('empleados/create',[EmpleadoController::class, 'create']);

Route::resource('empleado',EmpleadoController::class)->middleware('auth');
Route::resource('producto', ProductoController::class)->except('show')->middleware('auth');
Route::resource('categoria', CategoriaController::class)
    ->except('show')
    ->parameters(['categoria' => 'categoria'])
    ->middleware('auth');

Auth::routes();

Route::get('/home', [EmpleadoController::class, 'index'])->name('home');

Route::group(['middleware'=>'auth'], function(){
    Route::get('/',[EmpleadoController::class, 'index'])->name('home');
});

Route::get('/',function(){
    return view('auth.login');
});