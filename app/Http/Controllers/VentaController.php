<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Inventario;
use App\Models\FormaDePago;
use TCPDF;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class VentaController extends Controller
{
    /**
     * Mostrar una lista de las ventas.
     */
    public function index()
    {

        $ventas = Venta::with('cliente', 'productos')->get();
        return view('ventas.index', compact('ventas'));
    }

    /**
     * Mostrar el formulario para crear una nueva venta.
     */
    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        $formasPago = FormaDePago::all();
        return view('ventas.create', compact('clientes', 'productos', 'formasPago'));
    }

    /**
     * Almacenar una nueva venta en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'productos' => 'required|array',
            'productos.*' => 'exists:productos,id',
            'descuento' => 'nullable|numeric|min:0',
            'efectivo' => 'required|numeric|min:0',
            'cambio' => 'required|numeric|min:0',
        ]);
    
        try {
            DB::beginTransaction();
    
            // Crear la venta
            $venta = new Venta();
            $venta->cliente_id = $request->cliente_id;
            $venta->Fecha_de_venta = now();
            $venta->precio_total = $request->total ?? 0;
            $venta->descuento = $request->descuento ?? 0;
            $venta->efectivo = $request->efectivo;
            $venta->cambio = $request->cambio;
            $venta->iva = $request->iva ?? 0;
            $venta->save();
    
            // Procesar cada producto
            foreach ($request->productos as $producto_id) {
                $producto = Producto::find($producto_id);
                if ($producto) {
                    $cantidad = $request->input("cantidad_{$producto_id}", 1);
                    $precio_unitario = $producto->PV; // Usar el precio de venta (PV)
    
                    // Verificar stock en inventario
                    $inventario = Inventario::where('producto_id', $producto_id)->first();
                    if ($inventario && $inventario->cantidad >= $cantidad) {
                        // Reducir el stock en inventario
                        $inventario->cantidad -= $cantidad;
                        $inventario->save();
    
                        // Adjuntar el producto a la venta
                        $venta->productos()->attach($producto_id, [
                            'cantidad' => $cantidad,
                            'precio_unitario' => $precio_unitario,
                        ]);
    
                        // Debugging message
                        \Log::info("Producto {$producto_id} adjuntado a la venta {$venta->id} con cantidad {$cantidad} y precio unitario {$precio_unitario}");
                    } else {
                        throw new \Exception("No hay suficiente stock para el producto {$producto->nombre}.");
                    }
                }
            }
    
            DB::commit();
    
            return redirect()->route('ventas.index')->with('success', 'Venta creada correctamente.');
        } catch (\Exception $e) {
            DB::rollback();
            // Logging the error
            \Log::error('Error al crear la venta: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error al crear la venta: ' . $e->getMessage());
        }
    }
    


    /**
     * Mostrar la venta especificada.
     */
    public function show($id)
    {
        $venta = Venta::findOrFail($id);
        $clientes = Cliente::all();
        $productos = Producto::all();

        // Cargar relaciones productos y cliente
        $venta->load('productos', 'cliente');

        // Calcular subtotal, IVA y total
        $total = 0;
        foreach ($venta->productos as $producto) {
            $total += $producto->pivot->precio_unitario * $producto->pivot->cantidad;
        }
        $iva2 = $total * 0.16;
        $subtotal = $total - $iva2;
        $iva = $iva2;


        return view('ventas.show', compact('venta', 'clientes', 'productos', 'subtotal', 'iva', 'total'));
    }

    /**
     * Mostrar el formulario para editar la venta especificada.
     */
    public function edit(Venta $venta)
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('ventas.edit', compact('venta', 'clientes', 'productos'));
    }

    /**
     * Actualizar la venta especificada en el almacenamiento.
     */
    public function update(Request $request, Venta $venta)
    {
        // Validación de los datos del formulario
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'descuento' => 'nullable|numeric|min:0',
            'productos' => 'required|array',
            'productos.*' => 'exists:productos,id',
            'efectivo' => 'required|numeric|min:0',
            'cambio' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Actualizar la venta con los datos proporcionados
            $venta->update([
                'cliente_id' => $request->cliente_id,
                'descuento' => $request->descuento ?? 0,
                'efectivo' => $request->efectivo,
                'cambio' => $request->cambio,
            ]);

            // Actualizar los productos asociados a la venta
            $venta->productos()->detach(); // Eliminar los productos actuales asociados a la venta

            foreach ($request->productos as $producto_id) {
                $cantidad = $request->input("cantidad_{$producto_id}", 1); // Obtener la cantidad del formulario
                $precio_unitario = $request->input("precio_{$producto_id}", 0); // Obtener el precio unitario del formulario

                // Verificar stock disponible
                $producto = Producto::find($producto_id);
                if ($producto) {
                    if ($producto->stock >= $cantidad) {
                        // Reducir el stock del producto
                        $producto->stock -= $cantidad;
                        $producto->save();

                        // Adjuntar el producto a la venta con la cantidad y precio_unitario
                        $venta->productos()->attach($producto_id, [
                            'cantidad' => $cantidad,
                            'precio_unitario' => $precio_unitario,
                        ]);
                    } else {
                        // Si no hay suficiente stock, lanzar una excepción
                        throw new \Exception("No hay suficiente stock para el producto {$producto->nombre}.");
                    }
                }
            }

            DB::commit();

            return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Error al actualizar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar la venta especificada del almacenamiento.
     */
    public function destroy(Venta $venta)
    {
        try {
            $venta->delete();
            return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }

    public function exportPdf(Venta $venta)
    {

        // Cargar relaciones productos y cliente
        $venta->load('productos', 'cliente');

        // Calcular subtotal, IVA y total
        $total = 0;
        foreach ($venta->productos as $producto) {
            $total += $producto->pivot->precio_unitario * $producto->pivot->cantidad;
        }
        $iva = $total * 0.16;
        $subtotal = $total - $iva;

        // Configurar y generar el PDF
        $pdf = new TCPDF();
        $pdf->SetTitle('Ticket de Venta');
        $pdf->AddPage();

        // Agregar contenido al PDF
        $html = view('ventas.ticket', compact('venta', 'subtotal', 'iva', 'total'))->render();
        $pdf->writeHTML($html, true, false, true, false, '');

        // Descargar el PDF
        $pdf->Output('ticket_venta.pdf', 'D');
    }
}
