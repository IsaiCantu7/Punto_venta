<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    /**
     * Mostrar una lista de los recursos.
     */
    public function index()
    {
        $inventarios = Inventario::all(); // Obtener todos los registros de inventario
        return view('inventarios.index', compact('inventarios')); // Retornar la vista con los inventarios
    }

    /**
     * Mostrar el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        $productos = Producto::all(); // Obtener todos los productos
        $categorias = Categoria::all(); // Obtener todas las categorías
        return view('inventarios.create', compact('productos', 'categorias')); // Retornar la vista de creación con los productos y categorías
    }

    /**
     * Almacenar un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'producto_id' => 'required',
            'categoria_id' => 'required',
            'fecha_de_entrada' => 'nullable|date',
            'fecha_de_salida' => 'nullable|date',
            'motivo' => 'nullable|string',
            'movimiento' => 'required|string',
            'cantidad' => 'required|integer',
        ]);

        // Crear un nuevo registro de inventario con los datos validados
        Inventario::create($request->all());

        // Redireccionar a la lista de inventarios con un mensaje de éxito
        return redirect()->route('inventarios.index')
                         ->with('success', 'Movimiento creado exitosamente.');
    }

    /**
     * Mostrar el recurso especificado.
     */
    public function show($id)
    {
        $inventario = Inventario::findOrFail($id); // Recuperar el inventario por su ID
        return view('inventarios.show', compact('inventario')); // Retornar la vista de detalle con el inventario
    }

    /**
     * Mostrar el formulario para editar el recurso especificado.
     */
    public function edit($id)
    {
        $inventario = Inventario::findOrFail($id); // Recuperar el inventario por su ID
        $productos = Producto::all(); // Obtener todos los productos
        $categorias = Categoria::all(); // Obtener todas las categorías
        return view('inventarios.edit', compact('inventario', 'productos', 'categorias')); // Retornar la vista de edición con el inventario, productos y categorías
    }

    /**
     * Actualizar el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'producto_id' => 'required',
            'categoria_id' => 'required',
            'fecha_de_entrada' => 'nullable|date',
            'fecha_de_salida' => 'nullable|date',
            'motivo' => 'nullable|string',
            'movimiento' => 'required|string',
            'cantidad' => 'required|integer',
        ]);

        // Recuperar el inventario por su ID y actualizarlo con los datos validados
        $inventario = Inventario::findOrFail($id);
        $inventario->update($request->all());

        // Redireccionar a la lista de inventarios con un mensaje de éxito
        return redirect()->route('inventarios.index')
                         ->with('success', 'Movimiento actualizado exitosamente.');
    }

    /**
     * Eliminar el recurso especificado del almacenamiento.
     */
    public function destroy($id)
    {
        // Recuperar el inventario por su ID y eliminarlo
        $inventario = Inventario::findOrFail($id);
        $inventario->delete();

        // Redireccionar a la lista de inventarios con un mensaje de éxito
        return redirect()->route('inventarios.index')
                         ->with('success', 'Movimiento eliminado exitosamente.');
    }
}
