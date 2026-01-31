<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            // Identificación (Pensado para Perú: DNI/RUC)
            $table->string('document_type')->default('DNI'); // DNI, RUC, etc.
            $table->string('document_number')->unique()->nullable();
            $table->string('name');

            // Datos de contacto para fidelizar
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            // Lógica de puntos
            $table->integer('points')->default(0);
            $table->decimal('total_spent', 12, 2)->default(0); // Acumulado histórico

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
