<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::withCount('productos')->orderBy('nom_categoria')->paginate(10);

        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $datosCategoria = $request->validate([
            'nom_categoria' => ['required', 'string', 'max:255'],
        ]);
        Categoria::create($datosCategoria);

        return redirect()->route('categoria.index')->with('mensaje', 'Categoría agregada con éxito');
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.update', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $datosCategoria = $request->validate([
            'nom_categoria' => ['required', 'string', 'max:255'],
        ]);
        $categoria->update($datosCategoria);

        return redirect()->route('categoria.index')->with('mensaje', 'Categoría actualizada con éxito');
    }

    public function destroy(Categoria $categoria)
    {
        if ($categoria->productos()->exists()) {
            return redirect()->route('categoria.index')
                ->with('error', 'No se puede eliminar una categoría que tiene productos asociados.');
        }

        $categoria->delete();

        return redirect()->route('categoria.index')->with('mensaje', 'Categoría eliminada con éxito');
    }
}
