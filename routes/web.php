<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Controladores
use App\Http\Controllers\{
    ProfileController,
    CategoriaController,
    ProveedorController,
    ProductoController,
    DashboardController,
    VentaController,
    CustomerController,
    MovimientoController,
    SettingsController
};

Route::get('/', function () {
    return view('home');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // --- DASHBOARD & CORE ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Nota: Asegúrate de que la vista 'loading' exista si usas esta ruta
    Route::get('/loading', fn() => view('loading'))->name('loading');
    Route::get('/movimientos', [MovimientoController::class, 'index'])->name('movimientos.index');


    // --- MÓDULO VENTAS (POS) ---
    Route::resource('ventas', VentaController::class)->except(['edit', 'update', 'destroy']);
    Route::get('/ventas/{id}/factura', [VentaController::class, 'show'])->name('ventas.factura');


    // Mueve esto ARRIBA del resource
    Route::get('/productos/validar-sku', [ProductoController::class, 'validarSku'])->name('productos.validar-sku');
    Route::resource('productos', ProductoController::class)->parameters(['productos' => 'producto']);
    Route::post('/productos/{producto}/ajustar', [ProductoController::class, 'ajustar'])->name('productos.ajustar');

    // Ajustes de Sistema
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/reset', [SettingsController::class, 'reset'])->name('settings.reset');

    // --- MÓDULO CLIENTES & FIDELIZACIÓN ---
    // Definimos primero las rutas específicas dentro del prefijo para evitar conflictos
    Route::prefix('customers')->group(function () {
        // Ruta para la búsqueda en tiempo real (Select2 o similar)
        Route::get('/buscar', [CustomerController::class, 'buscar'])->name('customers.buscar');

        // Registro rápido vía AJAX (La que usa tu Modal)
        Route::post('/rapido', [CustomerController::class, 'storeRapido'])->name('customers.storeRapido');

        // Ajuste de puntos manual
        Route::post('/{customer}/adjust-points', [CustomerController::class, 'adjustPoints'])->name('customers.adjustPoints');
    });

    // CRUD estándar de clientes (index, create, store, show, edit, update, destroy)
    Route::resource('customers', CustomerController::class);

    // Rutas accesibles por AMBOS
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/ventas/create', [VentaController::class, 'create'])->name('ventas.create');
    });

    // --- OTROS MANTENIMIENTOS ---
    Route::resource('categorias', CategoriaController::class)->parameters(['categorias' => 'categoria']);
    Route::resource('proveedores', ProveedorController::class)->parameters(['proveedores' => 'proveedor']);


    // --- PERFIL DE USUARIO ---
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    Route::get('/movimientos', [MovimientoController::class, 'index'])->name('movimientos.index');
    Route::get('/movimientos/excel', [MovimientoController::class, 'exportExcel'])->name('movimientos.excel');
    Route::get('/movimientos/pdf', [MovimientoController::class, 'exportPdf'])->name('movimientos.pdf');
});
