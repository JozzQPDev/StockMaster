<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Añadimos la columna después de 'value'
            $table->text('default_value')->nullable()->after('value');
        });

        // Copiamos los valores actuales a la columna default para que no queden vacíos
        DB::statement('UPDATE settings SET default_value = value');
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('default_value');
        });
    }
};