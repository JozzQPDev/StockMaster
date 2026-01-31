<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- IMPORTANTE: Añade esta línea
use App\Models\Customer;

class Venta extends Model
{
    protected $fillable = [
        'codigo_factura',
        'user_id',
        'customer_id',
        'total',
        'descuento',
        'puntos_canjeados',
        'impuesto',
        'metodo_pago'
    ];

    // Relación: Una venta tiene muchos detalles (productos)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    // Relación: Una venta pertenece a un cliente
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id')->withDefault([
            'name' => 'PÚBLICO GENERAL',
            'document_number' => '00000000',
        ]);
    }

    public function getTotalFormateadoAttribute()
    {
        return 'S/ ' . number_format($this->total, 2);
    }
}
