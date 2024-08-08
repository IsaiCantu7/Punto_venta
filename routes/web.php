<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\FormaDePagoController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Productos
    Route::resource('productos', ProductoController::class);

    // Categorías
    Route::resource('categorias', CategoriaController::class);

    // Ventas
    Route::resource('ventas', VentaController::class);
    Route::get('ventas/{compra}/pdf', [VentaController::class, 'exportPdf'])->name('ventas.pdf');


    // Inventarios
    Route::resource('inventarios', InventarioController::class);
    Route::get('inventarios/reporte/pdf/{id}', [InventarioController::class, 'generarReportePDF'])->name('inventarios.reporte.pdf');


    // Clientes
    Route::resource('clientes', ClienteController::class);

    // Compras
    Route::resource('compras', CompraController::class);
    Route::get('compras/{id}/reporte', [CompraController::class, 'generarReportePDFCompra'])->name('compras.reporte');


    // Proveedores
    Route::resource('proveedores', ProveedorController::class);

    // Forma de Pago
    Route::resource('forma-pago', FormaDePagoController::class);

    // Vendedores
    Route::resource('vendedores', VendedorController::class);

    // Cotizaciones
    Route::resource('cotizaciones', CotizacionController::class);
    Route::get('cotizaciones/{id}/reporte', [CotizacionController::class, 'generarReportePDF'])->name('cotizaciones.reporte.pdf');

    //Reportes
    Route::resource('reportes', ReporteController::class);
    Route::post('reportes/generar', [ReporteController::class, 'generar'])->name('reportes.generar');
    // Rutas para reportes
    Route::post('/reporte/descargar', [ReporteController::class, 'descargarReporte'])->name('reporte.descargar');

});

require __DIR__.'/auth.php';
