<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Muestra una lista de proveedores.
     */
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedores.index', compact('proveedores'));
    }

    /**
     * Muestra el formulario para crear un nuevo proveedor.
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Almacena un proveedor recién creado en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'nombre_contacto' => 'required|string|max:255',
            'correo' => 'required|email|unique:proveedores,correo',
            'telefono' => 'required|string|max:20',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedores.index')
                         ->with('success', 'Proveedor creado exitosamente.');
    }

    /**
     * Muestra los detalles de un proveedor específico.
     */
    public function show($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.show', compact('proveedor'));
    }

    /**
     * Muestra el formulario para editar un proveedor específico.
     */
    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.edit', compact('proveedor'));
    }

    /**
     * Actualiza el proveedor especificado en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'nombre_contacto' => 'required|string|max:255',
            'correo' => 'required|email|unique:proveedores,correo,'.$id,
            'telefono' => 'required|string|max:20',
        ]);

        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')
                         ->with('success', 'Proveedor actualizado exitosamente.');
    }

    /**
     * Elimina un proveedor específico de la base de datos.
     */
    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('proveedores.index')
                         ->with('success', 'Proveedor eliminado exitosamente.');
    }
}

