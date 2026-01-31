<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductosSeeder extends Seeder
{
    public function run()
    {
        DB::table('productos')->insert([
            [
                'codigo' => 'LAP-G01',
                'nombre' => 'Laptop Gamer',
                'descripcion' => 'Laptop potente para juegos con tarjeta gráfica dedicada.',
                'precio_compra' => 3800.00,
                'precio_venta' => 4500.00,
                'stock_actual' => 10,
                'stock_minimo' => 3,
                'categoria_id' => 1,
                'proveedor_id' => 1,
                'imagen' => 'productos/laptop_gamer.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'MOU-W02',
                'nombre' => 'Mouse Inalámbrico',
                'descripcion' => 'Mouse ergonómico sin cables, ideal para oficina y gaming.',
                'precio_compra' => 80.00,
                'precio_venta' => 120.00,
                'stock_actual' => 50,
                'stock_minimo' => 10,
                'categoria_id' => 2,
                'proveedor_id' => 2,
                'imagen' => 'productos/mouse.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'TEC-M03',
                'nombre' => 'Teclado Mecánico',
                'descripcion' => 'Teclado mecánico con retroiluminación RGB.',
                'precio_compra' => 210.00,
                'precio_venta' => 300.00,
                'stock_actual' => 2, // ¡OJO! Esto activará la alerta de stock bajo
                'stock_minimo' => 5,
                'categoria_id' => 2,
                'proveedor_id' => 2,
                'imagen' => 'productos/teclado.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'AUR-M01',
                'nombre' => 'Auriculares Gamer',
                'descripcion' => 'Auriculares con micrófono y sonido envolvente 7.1.',
                'precio_compra' => 250.00,
                'precio_venta' => 320.00,
                'stock_actual' => 10, // ¡OJO! Esto activará la alerta de stock bajo
                'stock_minimo' => 5,
                'categoria_id' => 2,
                'proveedor_id' => 2,
                'imagen' => 'productos/auriculares.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'MON-M01',
                'nombre' => 'Monitor 24 pulgadas',
                'descripcion' => 'Monitor Full HD, ideal para juegos y trabajo.',
                'precio_compra' => 800.00,
                'precio_venta' => 1000.00,
                'stock_actual' => 12, // ¡OJO! Esto activará la alerta de stock bajo
                'stock_minimo' => 5,
                'categoria_id' => 1,
                'proveedor_id' => 1,
                'imagen' => 'productos/auriculares.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
