<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tabla Maestra de Ventas
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_factura')->unique();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');

            $table->decimal('total', 10, 2); // Monto neto pagado
            $table->decimal('descuento', 10, 2)->default(0); // Monto en Soles ahorrado
            $table->integer('puntos_canjeados')->default(0); // Cantidad de puntos usados

            $table->decimal('impuesto', 10, 2)->default(0);
            $table->string('metodo_pago')->default('efectivo');
            $table->timestamps();
        });

        // Detalle de la Venta
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained()->onDelete('cascade');
            $table->foreignId('producto_id')->constrained();
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalle_ventas');
        Schema::dropIfExists('ventas');
    }
};
