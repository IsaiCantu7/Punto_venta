<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
    
                // Actualizar la cantidad del producto en la tabla 'productos'
                $producto->cantidad += $cantidad;
                $producto->save();
    
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
        $compra->load('proveedor', 'productos'); 
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
            $nuevaCantidad = $details['cantidad'];
            $precio = $details['precio'];
    
            // Obtener la cantidad anterior del producto en la compra
            $cantidadAnteriorPivot = $compra->productos()->find($producto_id)->pivot->cantidad;
    
            // Verificar si la cantidad nueva es diferente a la cantidad anterior en la compra
            if ($nuevaCantidad != $cantidadAnteriorPivot) {
                $diferenciaCantidad = $nuevaCantidad - $cantidadAnteriorPivot;
    
                // Actualizar la cantidad del producto sumando la diferencia
                $producto = Producto::find($producto_id);
                $producto->cantidad += $diferenciaCantidad;
                $producto->save();
            }
    
            // Asociar el producto a la compra (actualizar o añadir)
            $compra->productos()->updateExistingPivot($producto_id, [
                'cantidad' => $nuevaCantidad,
                'precio' => $precio
            ]);
        }
    
        // Eliminar productos que ya no están en la compra
        foreach ($productosAntiguos as $producto_id) {
            if (!isset($request->productos[$producto_id])) {
                // Si el producto fue eliminado, puedes desasociarlo de la compra
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

    public function generarReportePDFCompra($id)
    {
        // Obtener la compra con sus relaciones (proveedor y productos)
        $compra = Compra::with(['proveedor', 'productos'])->findOrFail($id);

        // Obtener la información del proveedor y productos
        $proveedor = $compra->proveedor;
        $productos = $compra->productos;

        // Cargar la vista de reporte en el PDF
        $pdf = Pdf::loadView('compras.reporte', compact('compra', 'proveedor', 'productos'));

        // Descargar el PDF con el nombre especificado
        return $pdf->download('reporte_compra_' . $id . '.pdf');
    }

}
