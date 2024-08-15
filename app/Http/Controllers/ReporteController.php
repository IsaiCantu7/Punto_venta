<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Compra;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Cotizacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }
    public function generar(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);
    
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
    
        // Obtener datos de Compras
        $compraData = Compra::select(DB::raw('DATE(Fecha_de_compra) as date'), DB::raw('SUM(total) as total'))
                            ->whereBetween('Fecha_de_compra', [$fechaInicio, $fechaFin])
                            ->groupBy('date')
                            ->get();
    
        // Obtener datos de Cotizaciones
        $cotizacionData = Cotizacion::select(DB::raw('DATE(fecha_cot) as date'), DB::raw('SUM(total) as total'))
                                    ->whereBetween('fecha_cot', [$fechaInicio, $fechaFin])
                                    ->groupBy('date')
                                    ->get();
    
        // Obtener productos más vendidos
        $productosMasVendidos = DB::table('venta_producto')
            ->select('producto_id', DB::raw('SUM(cantidad) as total_cantidad'))
            ->groupBy('producto_id')
            ->orderBy('total_cantidad', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($producto) {
                return [
                    'nombre' => Producto::find($producto->producto_id)->nombre,
                    'cantidad' => $producto->total_cantidad,
                ];
            });
    
        // Obtener detalles de ventas con el total calculado a partir de la tabla pivote
        $detallesVentas = Venta::select('ventas.id', 'ventas.Fecha_de_venta', DB::raw('SUM(venta_producto.cantidad * venta_producto.precio_unitario) as total'))
            ->join('venta_producto', 'ventas.id', '=', 'venta_producto.venta_id')
            ->whereBetween('ventas.Fecha_de_venta', [$fechaInicio, $fechaFin])
            ->groupBy('ventas.id', 'ventas.Fecha_de_venta')
            ->get();
    
        return view('reportes.resultado', compact('compraData', 'cotizacionData', 'productosMasVendidos', 'detallesVentas', 'fechaInicio', 'fechaFin'));
    }
    
    public function descargarReporte(Request $request)
    {
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        $productosMasVendidos = json_decode($request->input('productosMasVendidos'), true);
        $detallesVentas = json_decode($request->input('detallesVentas'), true);

    
        // Preparar los datos para la vista PDF
        $data = [
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'productosMasVendidos' => $productosMasVendidos,
            'detallesVentas' => $detallesVentas,
        ];
    
        // Generar el PDF
        $pdf = Pdf::loadView('reportes.pdf', $data);
    
        // Devolver el PDF como una descarga
        return $pdf->download('reporte_compras.pdf');
    }
    
    
}
