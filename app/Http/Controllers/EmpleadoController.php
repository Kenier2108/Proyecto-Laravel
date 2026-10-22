<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listado['empleados'] = Empleado::paginate(5);
        return view('empleados.index', $listado);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $msj = [
            'required' => 'El :attribute es requerido.',
            'Foto.required' => 'La foto es requerida.',
        ];

        $datosEmpleado = $request->validate([
            'Nombres' => ['required', 'string', 'max:100'],
            'PrimerApel' => ['required', 'string', 'max:100'],
            'SegundoApel' => ['required', 'string', 'max:100'],
            'Correo' => ['required', 'email', 'max:100'],
            'Foto' => ['required', 'image', 'max:10048'],
        ], $msj);

        $datosEmpleado['Foto'] = $request->file('Foto')->store('empleados', 'public');
        Empleado::create($datosEmpleado);

        return redirect('empleado')->with('mensaje', 'Empleado agregado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $empleado=Empleado::findOrFail($id);
        return view('empleados.update', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $msj = [
            'required' => 'El :attribute es requerido.',
            'Foto.required' => 'La foto es requerida.',
        ];
        $datosEmpleado = $request->validate([
            'Nombres' => ['required', 'string', 'max:100'],
            'PrimerApel' => ['required', 'string', 'max:100'],
            'SegundoApel' => ['required', 'string', 'max:100'],
            'Correo' => ['required', 'email', 'max:100'],
            'Foto' => ['required', 'image', 'max:10048'],
        ], $msj);
        $datos = $request->except(['_token', '_method']);
        if ($request->hasFile('Foto')) {
            $datos['Foto'] = $request->file('Foto')->store('empleados', 'public');
        }

        Empleado::where('id', '=', $id)->update($datos);

        return redirect('empleado')->with('mensaje', 'Empleado actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $empleado = Empleado::findOrFail($id);
        Storage::disk('public')->delete($empleado->Foto);
        $empleado->delete();

        return redirect('empleado')->with('mensaje', 'Empleado eliminado con éxito');
    }

}