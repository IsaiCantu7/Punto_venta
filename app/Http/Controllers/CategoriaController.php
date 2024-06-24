<?php
namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Mostrar una lista de las categorías.
     */
    public function index()
    {
        $categorias = Categoria::all(); // Obtener todas las categorías
        return view('categorias.index', compact('categorias')); // Retornar la vista con las categorías
    }

    /**
     * Mostrar el formulario para crear una nueva categoría.
     */
    public function create()
    {
        return view('categorias.create'); // Retornar la vista de creación de categorías
    }

    /**
     * Almacenar una nueva categoría en el almacenamiento.
     */
    public function store(Request $request)
    {
        // Validar y almacenar la nueva categoría
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        // Crear una nueva categoría con los datos validados
        Categoria::create($request->all());

        // Redireccionar a la lista de categorías con un mensaje de éxito
        return redirect()->route('categorias.index')
                         ->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Mostrar la categoría especificada.
     */
    public function show(Categoria $categoria)
    {
        return view('categorias.show', compact('categoria')); // Retornar la vista de detalle con la categoría
    }

    /**
     * Mostrar el formulario para editar la categoría especificada.
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria')); // Retornar la vista de edición con la categoría
    }

    /**
     * Actualizar la categoría especificada en el almacenamiento.
     */
    public function update(Request $request, Categoria $categoria)
    {
        // Validar y actualizar la categoría existente
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        // Actualizar la categoría con los datos validados
        $categoria->update($request->all());

        // Redireccionar a la lista de categorías con un mensaje de éxito
        return redirect()->route('categorias.index')
                         ->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Eliminar la categoría especificada del almacenamiento.
     */
    public function destroy(Categoria $categoria)
    {
        // Eliminar la categoría
        $categoria->delete();

        // Redireccionar a la lista de categorías con un mensaje de éxito
        return redirect()->route('categorias.index')
                         ->with('success', 'Categoría eliminada exitosamente.');
    }
}
