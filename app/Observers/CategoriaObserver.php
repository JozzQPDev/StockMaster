<?php

namespace App\Observers;

use App\Models\Categoria;
use App\Models\Movimiento;
use Illuminate\Support\Facades\Auth;

class CategoriaObserver
{
    public $afterCommit = true;

    public function created(Categoria $categoria)
    {
        $detalle = "Se ha creado una nueva categoría: **{$categoria->nombre}**.";
        $this->registrar($categoria, 'NUEVA_CATEGORIA', $detalle, 'bg-purple-500');
    }

    public function updated(Categoria $categoria)
    {
        // 1. Detectar si cambió el nombre
        if ($categoria->wasChanged('nombre')) {
            $anterior = $categoria->getOriginal('nombre');
            $detalle = "Se cambió el nombre de la categoría: '{$anterior}' → '{$categoria->nombre}'.";
            return $this->registrar($categoria, 'RENOMBRAR_CATEGORIA', $detalle, 'bg-cyan-600');
        }

        // 2. Actualización genérica
        if ($categoria->isDirty()) {
            $detalle = "Se actualizaron parámetros de la categoría: {$categoria->nombre}.";
            $this->registrar($categoria, 'ACTUALIZACIÓN', $detalle, 'bg-slate-500');
        }
    }

    public function deleted(Categoria $categoria)
    {
        $detalle = "Se eliminó la categoría: **{$categoria->nombre}**. Los productos asociados podrían haber quedado sin categoría.";
        $this->registrar($categoria, 'ELIMINACIÓN', $detalle, 'bg-red-600');
    }

    /**
     * Registro centralizado en la tabla movimientos
     */
    protected function registrar($categoria, $accion, $detalle, $color)
    {
        Movimiento::create([
            'user_id'        => Auth::id() ?? 1, // ID 1 como fallback (Sistema/Admin)
            'categoria_id'   => $categoria->id,
            'categoria_name' => $categoria->nombre,
            'accion'         => $accion,
            'detalle'        => $detalle,
            'color_badge'    => $color,
            // Limpieza de campos no relacionados
            'producto_id'    => null,
            'customer_id'    => null,
        ]);
    }
}