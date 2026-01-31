<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // <--- Importante añadir esta línea
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Forzar el uso de Tailwind en la paginación
        Paginator::useTailwind();

        // 2. Configurar Carbon en español (opcional, pero recomendado)
        Carbon::setLocale('es');

        // Tu observador existente
        \App\Models\Producto::observe(\App\Observers\ProductoObserver::class);

        // Nuevos observadores
        \App\Models\Customer::observe(\App\Observers\CustomerObserver::class);
        \App\Models\Proveedor::observe(\App\Observers\ProveedorObserver::class);
        \App\Models\Categoria::observe(\App\Observers\CategoriaObserver::class);
    }
}