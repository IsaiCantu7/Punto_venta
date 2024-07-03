<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\FormaDePago;
use TCPDF;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    /**
     * Mostrar una lista de las compras.
     */
    public function index()
    {
        $compras = Compra::with('proveedor', 'productos')->get();
        return view('compras.index', compact('compras'));
    }

    /**
     * Mostrar el formulario para crear una nueva compra.
     */
    public function create()
    {
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        $formasPago = FormaDePago::all();
        return view('compras.create', compact('proveedores', 'productos', 'formasPago'));
    }
    
    /**
     * Almacenar una nueva compra en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_proveedor' => 'required|exists:proveedores,id',
            'productos.*' => 'exists:productos,id',
            'descuento' => 'numeric|min:0',
            'efectivo' => 'required|numeric|min:0',
            'cambio' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Verificar y almacenar la compra
            $compra = Compra::create([
                'id_proveedor' => $request->id_proveedor,
                'Fecha_de_compra' => now(),
                'precio_total' => $request->total,
                'descuento' => $request->descuento ?: 0,
                'efectivo' => $request->efectivo,
                'cambio' => $request->cambio,
            ]);

            // Verificar disponibilidad de productos y almacenarlos
            foreach ($request->productos as $producto_id) {
                $producto = Producto::find($producto_id);
                if ($producto) {
                    $cantidad = $request->input("cantidad_{$producto_id}", 1);
                    $precio_unitario = $request->input("precio_{$producto_id}", $producto->PV);

                    // Validar stock disponible
                    if ($producto->stock >= $cantidad) {
                        // Reducir el stock del producto
                        $producto->stock -= $cantidad;
                        $producto->save();

                        // Adjuntar el producto a la compra con la cantidad y precio_unitario
                        $compra->productos()->attach($producto_id, [
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

            return redirect()->route('compras.index')->with('success', 'Compra creada correctamente.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Error al crear la compra: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar la compra especificada.
     */
    /**
     * Mostrar la compra especificada.
     */
    public function show($id)
    {
        $compra = Compra::findOrFail($id);
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        
        // Cargar relaciones productos y proveedor
        $compra->load('productos', 'proveedor');
        
        // Calcular subtotal, IVA y total
        $total = 0;
        foreach ($compra->productos as $producto) {
            $total += $producto->pivot->precio_unitario * $producto->pivot->cantidad;
        }
        $iva2 = $total * 0.16;
        $subtotal = $total - $iva2;
        $iva = $iva2;

    
        return view('compras.show', compact('compra', 'proveedores', 'productos', 'subtotal', 'iva', 'total'));
    }
    

    /**
     * Mostrar el formulario para editar la compra especificada.
     */
    public function edit(Compra $compra)
    {
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        return view('compras.edit', compact('compra', 'proveedores', 'productos'));
    }

    /**
     * Actualizar la compra especificada en el almacenamiento.
     */
    public function update(Request $request, Compra $compra)
    {
        // Validación de los datos del formulario
        $request->validate([
            'id_proveedor' => 'required|exists:proveedores,id',
            'descuento' => 'nullable|numeric|min:0',
            'productos' => 'required|array',
            'productos.*' => 'exists:productos,id',
            'efectivo' => 'required|numeric|min:0',
            'cambio' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Actualizar la compra con los datos proporcionados
            $compra->update([
                'id_proveedor' => $request->id_proveedor,
                'descuento' => $request->descuento ?? 0,
                'efectivo' => $request->efectivo,
                'cambio' => $request->cambio,
            ]);

            // Actualizar los productos asociados a la compra
            $compra->productos()->detach(); // Eliminar los productos actuales asociados a la compra

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

                        // Adjuntar el producto a la compra con la cantidad y precio_unitario
                        $compra->productos()->attach($producto_id, [
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

            return redirect()->route('compras.index')->with('success', 'Compra actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Error al actualizar la compra: ' . $e->getMessage());
        }
    }


    /**
     * Eliminar la compra especificada del almacenamiento.
     */
    public function destroy(Compra $compra)
    {
        try {
            $compra->delete();
            return redirect()->route('compras.index')->with('success', 'Compra eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la compra: ' . $e->getMessage());
        }
    }

    public function exportPdf(Compra $compra)
    {
        // Cargar relaciones productos y proveedor
        $compra->load('productos', 'proveedor');
    
        // Calcular subtotal, IVA y total
        $total = 0;
        foreach ($compra->productos as $producto) {
            $total += $producto->pivot->precio_unitario * $producto->pivot->cantidad;
        }
        $iva = $total * 0.16;
        $subtotal = $total - $iva;
    
        // Configurar y generar el PDF
        $pdf = new TCPDF();
        $pdf->SetTitle('Ticket de Compra');
        $pdf->AddPage();
    
        // Agregar contenido al PDF
        $html = view('compras.ticket', compact('compra', 'subtotal', 'iva', 'total'))->render();
        $pdf->writeHTML($html, true, false, true, false, '');
    
        // Descargar el PDF
        $pdf->Output('ticket_compra.pdf', 'D');
    }
}
