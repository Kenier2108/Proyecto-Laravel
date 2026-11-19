<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovimientoInventarioController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ClienteController;

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/empleados', function () {
//     return view('empleados.index');
// });

// Route::get('empleados/create',[EmpleadoController::class, 'create']);

Route::resource('empleado',EmpleadoController::class)->middleware(['auth', 'consulta.solo_lectura']);
Route::resource('producto', ProductoController::class)->except('show')->middleware(['auth', 'consulta.solo_lectura']);
Route::resource('categoria', CategoriaController::class)
    ->except(['show', 'create', 'store'])
    ->parameters(['categoria' => 'categoria'])
    ->middleware(['auth', 'consulta.solo_lectura']);

Route::middleware(['auth', 'rol:administrador'])->group(function () {
    Route::get('categoria/create', [CategoriaController::class, 'create'])->name('categoria.create');
    Route::post('categoria', [CategoriaController::class, 'store'])->name('categoria.store');
});

Auth::routes();

Route::get('/home', [EmpleadoController::class, 'index'])->name('home');

Route::group(['middleware'=>'auth'], function(){
    Route::get('/',[EmpleadoController::class, 'index'])->name('home');
});

Route::get('/',function(){
    return view('auth.login');
});
Route::get('/indicadores', [DashboardController::class, 'index'])
    // ->middleware('auth')
    ->name('indicadores.index');
Route::middleware(['auth', 'consulta.solo_lectura'])->group(function () {
    Route::resource('movimientos', MovimientoInventarioController::class)
        ->only(['index', 'create', 'store']);
});

Route::middleware(['auth', 'consulta.solo_lectura'])->group(function () {
    Route::get('/productos', [ProductoController::class, 'index'])
        ->middleware('rol:administrador,inventario,consulta')
        ->name('productos.index');
        
    Route::get('/productos/create', [ProductoController::class, 'create'])
        ->middleware('rol:administrador,inventario')
        ->name('productos.create');

    Route::get('/productos', [ProductoController::class, 'store'])
        ->middleware('rol:administrador,inventario')
        ->name('productos.store');

    Route::get('/productos/{producto}/edit', [ProductoController::class, 'edit'])
        ->middleware('rol:administrador,inventario')
        ->name('productos.edit');

    Route::get('/productos/{producto}', [ProductoController::class, 'update'])
        ->middleware('rol:administrador,inventario')
        ->name('productos.update');

    Route::get('/productos/{producto}', [ProductoController::class, 'destroy'])
        ->middleware('rol:administrador,inventario')
        ->name('productos.destroy');
});

Route::middleware(['auth', 'consulta.solo_lectura'])->group(function() {
    Route::resource('clientes', ClienteController::class)->except(['show']);
    Route::resource('ventas', VentaController::class)->only(['index', 'create', 'store']);
});