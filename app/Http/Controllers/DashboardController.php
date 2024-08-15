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
        $totalProductos = Producto::count();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $ventas = Venta::with('productos')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get();

        $compras = Compra::with('productos')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get();

        $totalVendidos = $ventas->sum(function($venta) {
            return $venta->productos->sum('pivot.cantidad');
        });

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

        $compraData = $compras->groupBy(function ($compra) {
            return $compra->created_at->format('Y-m-d');
        })->map(function ($compras) {
            return $compras->sum(function ($compra) {
                return $compra->productos->sum('pivot.cantidad');
            });
        });

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
