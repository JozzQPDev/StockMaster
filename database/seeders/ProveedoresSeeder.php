<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proveedor;

class ProveedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear proveedores de ejemplo
        Proveedor::create([
            'nombre' => 'Proveedor ABC',
            'email' => 'abc@proveedores.com',
            'telefono' => '987654321',
            'direccion' => 'Av. Principal 123',
        ]);

        Proveedor::create([
            'nombre' => 'Proveedor XYZ',
            'email' => 'xyz@proveedores.com',
            'telefono' => '912345678',
            'direccion' => 'Calle Secundaria 456',
        ]);

        Proveedor::create([
            'nombre' => 'Proveedor Demo',
            'email' => 'demo@proveedores.com',
            'telefono' => '900123456',
            'direccion' => 'Av. Demo 789',
        ]);
    }
}
