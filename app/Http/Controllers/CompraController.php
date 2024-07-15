<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Inventario;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    /**
     * Mostrar una lista de las compras.
     */
    public function index()
    {
        
        $compras = Compra::all(); // Obtener todas las compras
        return view('compras.index', compact('compras')); // Retornar la vista con las compras
    }

    /**
     * Mostrar el formulario para crear una nueva compra.
     */
    public function create()
    {
        $proveedores = Proveedor::all(); // Obtener todos los proveedores
        $productos = Producto::all(); // Obtener todos los productos
        return view('compras.create', compact('proveedores', 'productos')); // Retornar la vista de creación con los proveedores y productos
    }

    /**
     * Almacenar una nueva compra en el almacenamiento.
     */
    public function store(Request $request)
    {
        // Crear la compra
        $compra = Compra::create($request->only('id_proveedor', 'Fecha_de_compra', 'total', 'descuento'));
    
        foreach ($request->productos as $producto_id => $details) {
            $cantidad = $details['cantidad'];
            $precio = $details['precio'];
    
            // Solo procesar si la cantidad es mayor que 0
            if ($cantidad > 0) {
                $producto = Producto::find($producto_id);
                $categoria_id = $producto->categoria_id;
    
                // Verificar si el producto ya está en el inventario
                $inventario = Inventario::where('producto_id', $producto_id)->first();
    
                if ($inventario) {
                    // Si hay registro, sumar la cantidad
                    $inventario->cantidad += $cantidad;
                    $inventario->save();
                } else {
                    // Si no hay registro, crear uno nuevo
                    Inventario::create([
                        'producto_id' => $producto_id,
                        'cantidad' => $cantidad,
                        'categoria_id' => $categoria_id,
                        'movimiento' => 'Compra'
                    ]);
                }
    
                // Asociar el producto a la compra
                $compra->productos()->attach($producto_id, [
                    'cantidad' => $cantidad,
                    'precio' => $precio
                ]);
            }
        }
    
        return redirect()->route('compras.index')->with('success', 'Compra creada exitosamente.');
    }
    
    
    
    

    /**
     * Mostrar la compra especificada.
     */
    public function show(Compra $compra)
    {
        return view('compras.show', compact('compra')); // Retornar la vista de detalle con la compra
    }

    /**
     * Mostrar el formulario para editar la compra especificada.
     */
    public function edit(Compra $compra)
    {
        $proveedores = Proveedor::all(); // Obtener todos los proveedores
        $productos = Producto::all(); // Obtener todos los productos
        return view('compras.edit', compact('compra', 'proveedores', 'productos')); // Retornar la vista de edición con la compra, proveedores y productos
    }

    /**
     * Actualizar la compra especificada en el almacenamiento.
     */
    public function update(Request $request, $id)
    {
        $compra = Compra::findOrFail($id);
        $compra->update($request->only('id_proveedor', 'Fecha_de_compra', 'total', 'descuento'));
    
        // Obtener los productos existentes en la compra
        $productosAntiguos = $compra->productos()->pluck('producto_id')->toArray();
    
        // Procesar productos nuevos
        foreach ($request->productos as $producto_id => $details) {
            $cantidad = $details['cantidad'];
            $precio = $details['precio'];
            $producto = Producto::find($producto_id);
            $categoria_id = $producto->categoria_id;
    
            // Verificar si el producto ya está en el inventario
            $inventario = Inventario::where('producto_id', $producto_id)->first();
    
            if ($inventario) {
                // Si hay registro, establecer la cantidad a la nueva cantidad
                $inventario->cantidad = $cantidad;
                $inventario->save();
            } else {
                // Si no hay registro, crear uno nuevo
                Inventario::create([
                    'producto_id' => $producto_id,
                    'cantidad' => $cantidad,
                    'categoria_id' => $categoria_id,
                    'movimiento' => 'Compra'
                ]);
            }
    
            // Asociar el producto a la compra (actualizar o añadir)
            $compra->productos()->updateExistingPivot($producto_id, [
                'cantidad' => $cantidad,
                'precio' => $precio
            ]);
        }
    
        // Eliminar productos que ya no están en la compra
        foreach ($productosAntiguos as $producto_id) {
            if (!isset($request->productos[$producto_id])) {
                $inventario = Inventario::where('producto_id', $producto_id)->first();
                // Si el producto fue eliminado, se puede manejar aquí si es necesario
                // Por ejemplo, puedes decidir restar la cantidad anterior o simplemente desasociar
                $compra->productos()->detach($producto_id);
            }
        }
    
        return redirect()->route('compras.index')->with('success', 'Compra actualizada exitosamente.');
    }
    
    

    /**
     * Eliminar la compra especificada del almacenamiento.
     */
    public function destroy(Compra $compra)
    {
        // Eliminar la compra
        $compra->delete();

        // Redireccionar a la lista de compras con un mensaje de éxito
        return redirect()->route('compras.index')
                         ->with('success', 'Compra eliminada exitosamente.');
    }
}
