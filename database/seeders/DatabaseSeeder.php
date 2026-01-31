<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. CREAR EL USUARIO PRIMERO
        // Esto garantiza que el ID 1 exista antes de que los otros seeders intenten usarlo
        User::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        // 2. EJECUTAR EL RESTO DE SEEDERS
        $this->call([
            CustomerSeeder::class,
            CategoriasSeeder::class,
            ProveedoresSeeder::class, // Ahora este no fallará al crear movimientos
            ProductosSeeder::class,
        ]);
    }
}