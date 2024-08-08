<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotizacion;
use App\Models\Cliente;
use App\Models\Vendedor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf;

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
        'products' => 'required|array',
        'products.*' => 'exists:productos,id', // Validar que cada ID de producto exista en la tabla productos
        'quantities.*' => 'required|numeric|min:1', // Validar que cada cantidad sea numérica y mayor o igual a 1
        'prices.*' => 'required|numeric|min:0', // Validar que cada precio sea numérico y mayor o igual a 0
    ]);

    try {
        DB::beginTransaction();

        // Crear la cotización
        $cotizacion = Cotizacion::create([
            'id_cliente' => $request->id_cliente,
            'id_vendedor' => $request->id_vendedor,
            'fecha_cot' => $request->fecha_cot,
            'vigencia' => $request->vigencia,
            'comentarios' => $request->comentarios,
            'subtotal' => $request->subtotal ?? 0,
            'iva' => $request->iva ?? 0,
            'total' => $request->total ?? 0,
        ]);

        // Procesar cada producto
        foreach ($request->products as $index => $producto_id) {
            $producto = Producto::find($producto_id);
            if ($producto) {
                $cantidad = $request->input("quantities.{$index}", 1);
                $precio_unitario = $request->input("prices.{$index}", $producto->PC); // Usar el precio enviado o el precio del producto

                // Adjuntar el producto a la cotización
                $cotizacion->productos()->attach($producto_id, [
                    'cantidad' => $cantidad,
                    'precio' => $precio_unitario,
                ]);

                // 
                Log::info("Producto {$producto_id} adjuntado a la cotización {$cotizacion->id} con cantidad {$cantidad} y precio {$precio_unitario}");
            }
        }

        DB::commit();

        return redirect()->route('cotizaciones.index')->with('success', 'Cotización creada correctamente.');
    } catch (\Exception $e) {
        DB::rollback();
        // Logging the error
        Log::error('Error al crear la cotización: ' . $e->getMessage());
        return redirect()->back()->withInput()->with('error', 'Error al crear la cotización: ' . $e->getMessage());
    }
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

        // Eliminar la relación con los productos 
        $cotizacion->productos()->detach();

        // Eliminar la cotización
        $cotizacion->delete();

        return redirect()->route('cotizaciones.index')->with('success', 'Cotización eliminada exitosamente.');
    }

    public function generarReportePDF($id)
{
    // Obtener la cotización con sus relaciones (cliente, vendedor, productos)
    $cotizacion = Cotizacion::with(['cliente', 'vendedor', 'productos'])->findOrFail($id);
    // Obtener la información del cliente, vendedor y productos
    $cliente = $cotizacion->cliente;
    $vendedor = $cotizacion->vendedor;
    $productos = $cotizacion->productos;
    
    // Cargar la vista de reporte en el PDF
    $pdf = Pdf::loadView('cotizaciones.reporte', compact('cotizacion', 'cliente', 'vendedor', 'productos'));

    // Descargar el PDF con el nombre especificado
    return $pdf->download('reporte_cotizacion_' . $id . '.pdf');
}

}
