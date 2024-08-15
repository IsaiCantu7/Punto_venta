<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $producto = Producto::findOrFail($request->input('producto_id'));
        $categoriaId = $producto->categoria_id;
    
        // Adjuntar la categoría a la solicitud antes de la validación
        $request->merge(['categoria_id' => $categoriaId]);

        // Validar los datos del formulario
        $request->validate([
            'producto_id' => 'required',
            'categoria_id' => 'required',
            'fecha_de_entrada' => 'nullable|date',
            'fecha_de_salida' => 'nullable|date',
            'motivo' => 'required|string',
            'movimiento' => 'required|string|in:entry,exit',
            'cantidad' => 'required|integer',
        ]);
    
        // Obtener el producto relacionado
        $producto = Producto::findOrFail($request->producto_id);
    
        // Ajustar la cantidad del producto según el movimiento
        if ($request->movimiento === 'entry') {
            $producto->cantidad += $request->cantidad;
        } elseif ($request->movimiento === 'exit') {
            $producto->cantidad -= $request->cantidad;
    
            // Asegurarse de que la cantidad no sea negativa
            if ($producto->cantidad < 0) {
                return redirect()->back()->withErrors(['cantidad' => 'La cantidad no puede ser menor que cero.']);
            }
        }
    
        // Guardar los cambios en el producto
        $producto->save();
    
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
        $producto = Producto::findOrFail($request->input('producto_id'));
        $categoriaId = $producto->categoria_id;
    
        // Adjuntar la categoría a la solicitud antes de la validación
        $request->merge(['categoria_id' => $categoriaId]);
        
        // Validar los datos del formulario
        $request->validate([
            'producto_id' => 'required',
            'categoria_id' => 'required',
            'fecha_de_entrada' => 'nullable|date',
            'fecha_de_salida' => 'nullable|date',
            'movimiento' => 'required|string|in:entry,exit',
            'cantidad' => 'required|integer',
        ]);
    
        // Recuperar el inventario por su ID
        $inventario = Inventario::findOrFail($id);
    
        // Obtener el producto relacionado
        $producto = Producto::findOrFail($request->producto_id);
    
        // Obtener el movimiento y la cantidad anteriores
        $movimientoAnterior = $inventario->movimiento;
        $cantidadAnterior = $inventario->cantidad;
    
    
        // Verificar si el movimiento actual es diferente al movimiento anterior
        if ($request->movimiento !== $movimientoAnterior) {
            // Aplicar ajuste basado en el nuevo movimiento
            if ($request->movimiento === 'entry') {
                $producto->cantidad += $request->cantidad;
            } elseif ($request->movimiento === 'exit') {
                $producto->cantidad -= $request->cantidad;
            }
        } else {
            // Si el movimiento no ha cambiado, ajustar solo la cantidad
            if ($request->movimiento === 'entry') {
                $producto->cantidad += $request->cantidad - $cantidadAnterior;
            } elseif ($request->movimiento === 'exit') {
                $producto->cantidad -= $request->cantidad - $cantidadAnterior;
            }
        }
    
        // Asegurarse de que la cantidad no sea negativa
        if ($producto->cantidad < 0) {
            return redirect()->back()->withErrors(['cantidad' => 'La cantidad no puede ser menor que cero.']);
        }
    
        // Guardar los cambios en el producto
        $producto->save();
    
        // Actualizar el inventario con los nuevos datos
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
    public function generarReportePDF($id)
    {
        $inventario = Inventario::findOrFail($id); // Obtener el registro de inventario por su ID
        $pdf = Pdf::loadView('inventarios.reporte', compact('inventario')); // Cargar la vista de reporte en el PDF con el inventario específico
        return $pdf->download('reporte_inventario_' . $id . '.pdf'); // Descargar el PDF con el nombre especificado
    }
    

}
