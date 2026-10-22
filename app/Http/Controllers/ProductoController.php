<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')->paginate(5);

        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nom_categoria')->get();

        return view('productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $datosProducto = $request->validate($this->reglasValidacion());
        $datosProducto['foto_producto'] = $request->file('foto_producto')->store('productos', 'public');
        Producto::create($datosProducto);

        return redirect()->route('producto.index')->with('mensaje', 'Producto agregado con éxito');
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::orderBy('nom_categoria')->get();

        return view('productos.update', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $datosProducto = $request->validate($this->reglasValidacion(false));
        $fotoAnterior = $producto->foto_producto;

        if ($request->hasFile('foto_producto')) {
            $datosProducto['foto_producto'] = $request->file('foto_producto')->store('productos', 'public');
        }

        $producto->update($datosProducto);
        if (isset($datosProducto['foto_producto'])) {
            Storage::disk('public')->delete($fotoAnterior);
        }

        return redirect()->route('producto.index')->with('mensaje', 'Producto actualizado con éxito');
    }

    public function destroy(Producto $producto)
    {
        Storage::disk('public')->delete($producto->foto_producto);
        $producto->delete();

        return redirect()->route('producto.index')->with('mensaje', 'Producto eliminado con éxito');
    }

    private function reglasValidacion(bool $requiereFoto = true): array
    {
        return [
            'nom_producto' => ['required', 'string', 'max:255'],
            'detalle_producto' => ['required', 'string', 'max:255'],
            'cant_producto' => ['required', 'string', 'max:255'],
            'valor_producto' => ['required', 'string', 'max:255'],
            'foto_producto' => $requiereFoto
                ? ['required', 'image', 'max:10048']
                : ['nullable', 'image', 'max:10048'],
            'estado_producto' => ['required', 'string', 'max:255'],
            'id_categoria' => ['required', 'exists:categoria,id'],
        ];
    }
}
