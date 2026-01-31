<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'nombre',
    ];

    // Relación con productos (opcional)
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
