<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();         
            $table->text('value')->nullable();       
            $table->string('group')->default('general'); 
            $table->string('type')->default('string');   
            $table->string('description')->nullable();   
            $table->timestamps();
        });

        // Insertamos los datos base del negocio y fidelización
        DB::table('settings')->insert([
            // DATOS DE LA EMPRESA
            [
                'key' => 'store_name',
                'value' => 'STOCK MASTER POS',
                'group' => 'empresa',
                'type' => 'string',
                'description' => 'Nombre comercial de la tienda',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'key' => 'store_ruc',
                'value' => '20123456789',
                'group' => 'empresa',
                'type' => 'string',
                'description' => 'Número de RUC de la empresa',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'key' => 'store_address',
                'value' => 'Jr. Libertad 123, Ayacucho',
                'group' => 'empresa',
                'type' => 'string',
                'description' => 'Dirección física del establecimiento',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'key' => 'store_phone',
                'value' => '966123456',
                'group' => 'empresa',
                'type' => 'string',
                'description' => 'Teléfono o WhatsApp de contacto',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'key' => 'store_email',
                'value' => 'ventas@stockmaster.com',
                'group' => 'empresa',
                'type' => 'string',
                'description' => 'Email de contacto',
                'created_at' => now(), 'updated_at' => now(),
            ],

            // CONFIGURACIÓN DE PUNTOS
            [
                'key' => 'puntos_factor_ganancia',
                'value' => '10',
                'group' => 'fidelizacion',
                'type' => 'number',
                'description' => 'Soles necesarios para ganar 1 punto (Ej: S/ 10 = 1 pto)',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'key' => 'puntos_equivalencia',
                'value' => '100',
                'group' => 'fidelizacion',
                'type' => 'number',
                'description' => 'Cuántos puntos equivalen a S/ 1.00 de descuento',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'key' => 'puntos_minimo_canje',
                'value' => '50',
                'group' => 'fidelizacion',
                'type' => 'number',
                'description' => 'Mínimo de puntos acumulados para permitir un canje',
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};