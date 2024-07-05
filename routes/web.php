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

    // Clientes
    Route::resource('clientes', ClienteController::class);

    // Compras
    Route::resource('compras', CompraController::class);

    // Proveedores
    Route::resource('proveedores', ProveedorController::class);

    // Forma de Pago
    Route::resource('forma-pago', FormaDePagoController::class);

    // Vendedores
    Route::resource('vendedores', VendedorController::class);

    // Cotizaciones
    Route::resource('cotizaciones', CotizacionController::class);
});

require __DIR__.'/auth.php';
