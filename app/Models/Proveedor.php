<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importante añadir esta línea

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';
    protected $fillable = ['nombre', 'email', 'telefono', 'direccion'];

    // LA RELACIÓN VA AQUÍ
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }
}
