<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categorias')->insert([
            ['nombre' => 'Hardware', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Periféricos', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Software', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Accesorios', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
