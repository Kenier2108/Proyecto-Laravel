<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\Producto;
use App\Models\MovimientoInventario;

class MovimientoInventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movimientos = MovimientoInventario::with(['producto', 'usuario'])
            ->latest()->paginate(10);

        return view('movimientos.index', compact('movimientos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::orderBy('nom_producto')->get();
        return view('movimientos.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'id_producto' => ['required', 'exists:productos,id'],
            'tipo' => ['required', 'in:entrada,salida'],
            'cantidad' => ['required', 'integer', 'min:1'],
            'observacion' => ['nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($datos) {
            $producto = Producto::whereKey($datos['id_producto'])->lockForUpdate()->firstOrFail();

        if (
            $datos['tipo'] === 'salida' &&
            $producto->cant_producto < $datos['cantidad']
        )
        {
            throw ValidationException::withMessages([
                'cantidad' => ['No hay existencias suficientes.']
            ]);
        }

        if ($datos['tipo'] === 'entrada') {
            $producto->cant_producto += $datos['cantidad'];
        } else {
            $producto->cant_producto -= $datos['cantidad'];
        }

        $producto->save();

            MovimientoInventario::create([
                'id_producto' => $producto->id,
                'usuario_id' => auth()->id(),
                'tipo' => $datos['tipo'],
                'cantidad' => $datos['cantidad'],
                'observacion' => $datos['observacion'] ?? null,
            ]);

        });

        return redirect()->route('movimientos.index')->with('success', 'Movimiento de inventario registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MovimientoInventario $movimientoInventario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MovimientoInventario $movimientoInventario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MovimientoInventario $movimientoInventario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MovimientoInventario $movimientoInventario)
    {
        //
    }
}
