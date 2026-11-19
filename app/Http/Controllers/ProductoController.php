<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $consulta = Producto::query()->with('categoria');

        if ($request->filled('buscar')){
            $consulta->where(
                'nom_producto', 'like', '%' . $request->buscar . '%'
            );
        }

        if ($request->filled('id_categoria')) {
            $consulta->where('id_categoria', $request->input('id_categoria'));
        }

        if ($request->filled('estado_producto')) {
            $consulta->where('estado_producto', $request->input('estado_producto'));
        }

        $productos = $consulta->orderBy('nom_producto')->paginate(5)->withQueryString();

        $categorias =   Categoria::orderBy('nom_categoria')->get();

        return view('productos.index', compact('productos', 'categorias'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nom_categoria')->get();

        return view('productos.create', compact('categorias'));
    }

    public function store(StoreProductoRequest $request)
    {
        $datos = $request->validated();
        
        if ($request->hasFile('foto_producto')) {
            $datos['foto_producto'] = $request->file('foto_producto')->store('productos', 'public');
        }

        Producto::create($datos);

        return redirect()->route('producto.index')->with('mensaje', 'Producto agregado con éxito');
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::orderBy('nom_categoria')->get();

        return view('productos.update', compact('producto', 'categorias'));
    }

    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $datos = $request->validated();
        $fotoAnterior = $producto->foto_producto;

        if ($request->hasFile('foto_producto')) {
            $datos['foto_producto'] = $request->file('foto_producto')->store('productos', 'public');
        }

        $producto->update($datos);
        if (isset($datos['foto_producto'])) {
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

    protected $fillable = [
            'nom_producto',
            'detalle_producto',
            'cant_producto',
            'valor_producto',
            'foto_producto',
            'estado_producto',
            'id_categoria',
        ];
}
