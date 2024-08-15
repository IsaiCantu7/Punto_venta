<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\Compra;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener el total de productos
        $totalProductos = Producto::count();
        // Obtener el total de productos vendidos en el mes actual
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        // Obtener las ventas y compras del mes actual
        $ventas = Venta::with('productos')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get();
        // Obtener las compras del mes actual
        $compras = Compra::with('productos')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get();
        // Obtener el total de productos vendidos y comprados
        $totalVendidos = $ventas->sum(function($venta) {
            return $venta->productos->sum('pivot.cantidad');
        });
        // Obtener el total de productos comprados
        $totalCompras = $compras->sum(function($compra) {
            return $compra->productos->sum('pivot.cantidad');
        });
        // Datos para los gráficos
        $ventaData = $ventas->groupBy(function ($venta) {
            return $venta->created_at->format('Y-m-d');
        })->map(function ($ventas) {
            return $ventas->sum(function ($venta) {
                return $venta->productos->sum('pivot.cantidad');
            });
        });
        // Datos para los gráficos
        $compraData = $compras->groupBy(function ($compra) {
            return $compra->created_at->format('Y-m-d');
        })->map(function ($compras) {
            return $compras->sum(function ($compra) {
                return $compra->productos->sum('pivot.cantidad');
            });
        });
        // Retornar la vista del dashboard con los datos
        return view('dashboard', [
            'totalProductos' => $totalProductos,
            'totalVendidos' => $totalVendidos,
            'totalCompras' => $totalCompras,
            'ventaData' => $ventaData,
            'compraData' => $compraData,
            'startOfMonth' => $startOfMonth->format('Y-m-d'),
            'endOfMonth' => $endOfMonth->format('Y-m-d'),
        ]);
    }
}
