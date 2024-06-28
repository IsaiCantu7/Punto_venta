<?php
namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Inventario;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Mostrar una lista de los recursos.
     */
    public function index()
    {
        $productos = Producto::all(); // Obtener todos los productos
        return view('productos.index', compact('productos')); // Retornar la vista con los productos
    }

    /**
     * Mostrar el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        $categorias = Categoria::all(); // Obtener todas las categorías
        return view('productos.create', compact('categorias')); // Retornar la vista de creación con las categorías
    }

    /**
     * Almacenar un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'required',
            'PV' => 'required|numeric',
            'PC' => 'required|numeric',
            'Fecha_de_compra' => 'required|date',
            'Color(es)' => 'nullable|string',
            'descripcion_corta' => 'nullable|string',
            'descripcion_larga' => 'nullable|string'
        ]);

        // Crear un nuevo producto con los datos validados
        Producto::create($request->all());

        // Redireccionar a la lista de productos con un mensaje de éxito
        return redirect()->route('productos.index')
                        ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Mostrar el recurso especificado.
     */
    public function show(Producto $producto)
    {
        $categorias = Categoria::all(); // Obtener todas las categorías
        return view('productos.show', compact('producto', 'categorias')); // Retornar la vista de detalle con el producto y las categorías
    }

    /**
     * Mostrar el formulario para editar el recurso especificado.
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all(); // Obtener todas las categorías
        return view('productos.edit', compact('producto', 'categorias')); // Retornar la vista de edición con el producto y las categorías
    }

    /**
     * Actualizar el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, Producto $producto)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'required',
            'PV' => 'required|numeric',
            'PC' => 'required|numeric',
            'Fecha_de_compra' => 'required|date',
            'Color(es)' => 'nullable|string',
            'descripcion_corta' => 'nullable|string',
            'descripcion_larga' => 'nullable|string'
        ]);

        // Actualizar el producto con los datos validados
        $producto->update($request->all());

        // Redireccionar a la lista de productos con un mensaje de éxito
        return redirect()->route('productos.index')
                        ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Eliminar el recurso especificado del almacenamiento.
     */
    public function destroy(Producto $producto)
    {
        // Verificar si hay inventario asociado al producto
        $inventario = Inventario::where('producto_id', $producto->id)->exists();
    
        if ($inventario) {
            // Si hay inventario asociado, redireccionar con un mensaje de error
            return redirect()->route('productos.index')
                             ->with('error', 'No se puede eliminar el producto porque tiene inventario asociado.');
        }
    
        // Si no hay inventario asociado, proceder con la eliminación del producto
        $producto->delete();
    
        // Redireccionar a la lista de productos con un mensaje de éxito
        return redirect()->route('productos.index')
                        ->with('success', 'Producto eliminado exitosamente.');
    }
}
