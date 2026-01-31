<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'user_id',
        'customer_id',
        'proveedor_id',
        'categoria_id',
        'accion',
        'producto_nombre',
        'customer_name',
        'proveedor_name',
        'categoria_name',
        'cantidad',
        'detalle',
        'color_badge',
    ];

    /**
     * Casts para asegurar tipos de datos correctos
     */
    protected $casts = [
        'cantidad' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    // --- RELACIONES ---

    /**
     * Usuario que realizó la acción (Auditoría)
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Sistema / Eliminado'
        ]);
    }

    /**
     * Relación con Producto (Opcional, por si el producto aún existe)
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Relación con Cliente
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relación con Proveedor
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    // --- SCOPES DE BÚSQUEDA (Para limpiar el Controlador) ---

    public function scopeFiltrar($query, $filtros)
    {
        return $query->when($filtros['tipo'] ?? null, function ($q, $tipo) {
            $q->where('accion', $tipo);
        })->when($filtros['buscar'] ?? null, function ($q, $buscar) {
            $q->where(function ($sub) use ($buscar) {
                $sub->where('producto_nombre', 'like', "%{$buscar}%")
                    ->orWhere('customer_name', 'like', "%{$buscar}%")
                    ->orWhere('proveedor_name', 'like', "%{$buscar}%")
                    ->orWhere('detalle', 'like', "%{$buscar}%");
            });
        });
    }
}