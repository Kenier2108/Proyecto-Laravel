<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\MovimientoInventario;


class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Venta::with(['cliente', 'usuario'])
            ->latest('fecha')
            ->paginate(10);
        
        return view('ventas.index', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();

        $productos = Producto::where('cant_producto', '>', 0)->orderBy('nom_producto')->get();

        return view('ventas.create', compact('clientes', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lineas = $request->input('productos', []);

        $lineas = array_filter($lineas, function ($linea) {
            return is_array($linea) &&
                (!empty($linea['id_producto']) ||
                !empty($linea['cantidad']));
        });

        $request->merge(['productos' => array_values($lineas)]);

        $datos = $request->validate([
            'id_cliente' => ['nullable', 'exists:clientes,id'],
            'productos' => ['required', 'array', 'min:1'],
            'productos.*.id_producto' => [
                'required', 'integer', 'distinct', 'exists:productos,id'
            ],
            'productos.*.cantidad' => [
                'required', 'integer', 'min:1'
            ],
        ]);

        $venta = DB::transaction(function () use ($datos) {
            $venta = Venta::create([
            'id_cliente' => $datos['id_cliente'] ?? null,
            'usuario_id' => auth()->id(),
            'fecha' => now(),
            'total' => 0,
            'estado' => 'registrada',
        ]);

        $total = 0;

        foreach ($datos['productos'] as $linea) {
            $producto = Producto::whereKey($linea['id_producto'])
                ->lockForUpdate()
                ->firstOrFail();

            $cantidad = (int) $linea['cantidad'];

            if ($producto->cant_producto < $cantidad) {
                throw ValidationException::withMessages([
                    'productos' => 
                        'No hay stock suficiente de ' . 
                        $producto->nom_producto,
                ]);
            }

            $subtotal = round(
                (float) $producto->valor_producto * $cantidad,
                2
            );

            DetalleVenta::create([
                'id_venta' => $venta->id,
                'id_producto' => $producto->id,
                'cantidad' => $cantidad,
                'precio_unitario' => $producto->valor_producto,
                'subtotal' => $subtotal,
            ]);

            $producto->cant_producto -= $cantidad;
            $producto->save();

            MovimientoInventario::create([
                'id_producto' => $producto->id,
                'usuario_id' => auth()->id(),
                'tipo' => 'salida',
                'cantidad' => $cantidad,
                'observacion' => 'Venta #' . $venta->id,
            ]);

            $total += $subtotal;
        }

        $venta->update(['total' => $total]);

        return $venta;
    });

    return redirect()->route('ventas.index')
        ->with('success', 'Venta registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta)
    {
        //
    }
}
