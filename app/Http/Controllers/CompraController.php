<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\Producto;
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
        // Validar y almacenar la nueva compra
        $request->validate([
            'id_proveedor' => 'required|exists:proveedores,id',
            'id_producto' => 'required|exists:productos,id',
            'Fecha_de_compra' => 'required|date',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
            'total' => 'required|numeric',
            'descuento' => 'nullable|numeric',
        ]);

        // Crear una nueva compra con los datos validados
        Compra::create($request->all());

        // Redireccionar a la lista de compras con un mensaje de éxito
        return redirect()->route('compras.index')
                         ->with('success', 'Compra creada exitosamente.');
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
    public function update(Request $request, Compra $compra)
    {
        // Validar y actualizar la compra existente
        $request->validate([
            'id_proveedor' => 'required|exists:proveedores,id',
            'id_producto' => 'required|exists:productos,id',
            'Fecha_de_compra' => 'required|date',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
            'total' => 'required|numeric',
            'descuento' => 'nullable|numeric',
        ]);

        // Actualizar la compra con los datos validados
        $compra->update($request->all());

        // Redireccionar a la lista de compras con un mensaje de éxito
        return redirect()->route('compras.index')
                         ->with('success', 'Compra actualizada exitosamente.');
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
