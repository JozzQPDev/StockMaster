<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // --- RELACIONES FLEXIBLES (Cualquiera puede ser null) ---

            // Producto
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->string('producto_nombre')->nullable(); // Cambiado a nullable
            $table->decimal('cantidad', 12, 2)->default(0);

            // Cliente (Fidelización)
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name')->nullable();

            // Proveedor
            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->string('proveedor_name')->nullable();

            // Categoría
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->string('categoria_name')->nullable();

            // --- DATOS DEL MOVIMIENTO ---
            $table->string('accion'); // Ejemplo: 'STOCK_OUT', 'PUNTOS_CANJE', 'NUEVO_PROVEEDOR'
            $table->string('detalle')->nullable();
            $table->string('color_badge')->default('blue');

            $table->timestamps();

            // --- LLAVES FORÁNEAS (Corregidas para coincidir con tus tablas) ---
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('set null');
            // Cambiado 'categories' por 'categorias'
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
