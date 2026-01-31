<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'document_type',
        'document_number',
        'name',
        'phone',
        'email',
        'points',
        'total_spent'
    ];

    // Esto hace que el nivel y el valor aparezcan en las respuestas AJAX
    protected $appends = ['level', 'points_value'];

    public function getLevelAttribute()
    {
        if ($this->points >= 1000) return 'VIP';
        if ($this->points >= 500) return 'Frecuente';
        return 'Estándar';
    }

    public function getPointsValueAttribute()
    {
        // 100 puntos = S/ 1.00 (ajusta según tu negocio)
        return $this->points / 100;
    }

    public function ventas(): HasMany
    {
        return $this->hasMany(Venta::class, 'customer_id');
    }

    /**
     * Limpiador de nombres para el buscador
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = mb_strtoupper($value);
    }
}