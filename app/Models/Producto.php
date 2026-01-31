<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'proveedor_id',
        'categoria_id',
        'codigo',
        'nombre',
        'descripcion',
        'precio_compra',
        'precio_venta',
        'stock_actual',
        'stock_minimo',
        'imagen'
    ];

    protected $casts = [
        'stock_actual' => 'integer',
        'stock_minimo' => 'integer',
        'precio_compra' => 'decimal:2',
        'precio_venta' => 'decimal:2',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    // Accesores para Formato de Moneda
    public function getPrecioVentaSolesAttribute()
    {
        return 'S/ ' . number_format($this->precio_venta, 2);
    }

    public function getPrecioCompraSolesAttribute()
    {
        return 'S/ ' . number_format($this->precio_compra, 2);
    }

    public function getGananciaAttribute()
    {
        return (float) $this->precio_venta - (float) $this->precio_compra;
    }

    public function getGananciaSolesAttribute()
    {
        return 'S/ ' . number_format($this->ganancia, 2);
    }
}
