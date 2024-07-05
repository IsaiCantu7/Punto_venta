<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotizacion;
use App\Models\Cliente;
use App\Models\Vendedor;
use App\Models\Producto;

class CotizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las cotizaciones con paginación
        $cotizaciones = Cotizacion::with(['cliente', 'vendedor'])->paginate(10);
        
        return view('cotizaciones.index', compact('cotizaciones'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todos los clientes, vendedores y productos
        $clientes = Cliente::all();
        $vendedores = Vendedor::all();
        $productos = Producto::all();
    
        // Pasar los clientes, vendedores y productos a la vista
        return view('cotizaciones.create', compact('clientes', 'vendedores', 'productos'));
    }
    

   /**
 * Store a newly created resource in storage.
 */
// Formulario de creación de cotización
public function store(Request $request)
{
    $request->validate([
        'id_cliente' => 'required|exists:clientes,id',
        'id_vendedor' => 'required|exists:vendedores,id',
        'fecha_cot' => 'required|date',
        'vigencia' => 'required|date',
        'comentarios' => 'nullable|string',
        'products' => 'required|array', // Validar que se envíe un array de productos seleccionados
    ]);

    // Crear la cotización
    $cotizacion = Cotizacion::create([
        'id_cliente' => $request->id_cliente,
        'id_vendedor' => $request->id_vendedor,
        'fecha_cot' => $request->fecha_cot,
        'vigencia' => $request->vigencia,
        'comentarios' => $request->comentarios,
        'subtotal' => $request->subtotal,
        'iva' => $request->iva,
        'total' => $request->total,
    ]);

    // Asociar los productos a la cotización
    $cotizacion->productos()->attach($request->products);

    return redirect()->route('cotizaciones.index')->with('success', 'Cotización creada exitosamente.');
}

    /**
     * Display the specified resource.
     */
    // Mostrar una cotización específica
    public function show($id)
    {
        // Buscar la cotización a mostrar
        $cotizacion = Cotizacion::with('productos')->findOrFail($id);

        // Pasar la cotización a la vista
        return view('cotizaciones.show', compact('cotizacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Formulario de edición de cotización
    public function edit($id)
    {
        // Buscar la cotización a editar
        $cotizacion = Cotizacion::with('productos')->findOrFail($id);
        $clientes = Cliente::all();
        $vendedores = Vendedor::all();
        $productos = Producto::all();
        // Pasar la cotización, clientes, vendedores y productos a la vista
        return view('cotizaciones.edit', compact('cotizacion', 'clientes', 'vendedores', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    // Actualizar cotización
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id',
            'id_vendedor' => 'required|exists:vendedores,id',
            'fecha_cot' => 'required|date',
            'vigencia' => 'required|date',
            'comentarios' => 'nullable|string',
            'products' => 'required|array',
        ]);

        // Buscar la cotización a actualizar
        $cotizacion = Cotizacion::findOrFail($id);

        // Actualizar los campos de la cotización
        $cotizacion->update([
            'id_cliente' => $request->id_cliente,
            'id_vendedor' => $request->id_vendedor,
            'fecha_cot' => $request->fecha_cot,
            'vigencia' => $request->vigencia,
            'comentarios' => $request->comentarios,
            'subtotal' => $request->subtotal, 
            'iva' => $request->iva, 
            'total' => $request->total,
        ]);

        // Sincronizar los productos asociados a la cotización
        $cotizacion->productos()->sync($request->products);

        return redirect()->route('cotizaciones.index')->with('success', 'Cotización actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Buscar la cotización a eliminar
        $cotizacion = Cotizacion::findOrFail($id);

        // Eliminar la relación con los productos en la tabla pivote
        $cotizacion->productos()->detach();

        // Eliminar la cotización
        $cotizacion->delete();

        return redirect()->route('cotizaciones.index')->with('success', 'Cotización eliminada exitosamente.');
    }
}
