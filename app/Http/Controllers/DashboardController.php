<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProductos = Producto::count();
        $totalCategorias = Categoria::count();

        $productosAgotados = Producto::where('cant_producto', 0)->count();

        $productosBajos = Producto::where('cant_producto', '<=', 5)->orderBy('cant_producto')->get();

        $valorEstimado = Producto::selectRaw('COALESCE(SUM(cant_producto * valor_producto), 0) as total')->value('total');

        return view('indicadores.index', compact(
            'totalProductos',
            'totalCategorias',
            'productosAgotados',
            'productosBajos',
            'valorEstimado'
        ));
    }
}
