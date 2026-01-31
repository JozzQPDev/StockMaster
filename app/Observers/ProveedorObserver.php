<?php

namespace App\Observers;

use App\Models\Proveedor;
use App\Models\Movimiento;
use Illuminate\Support\Facades\Auth;

class ProveedorObserver
{
    public $afterCommit = true;

    public function created(Proveedor $proveedor)
    {
        $detalle = "Nuevo proveedor registrado: **{$proveedor->nombre}** (RUC/Doc: {$proveedor->ruc}).";
        $this->registrar($proveedor, 'NUEVO_PROVEEDOR', $detalle, 'bg-blue-600');
    }

    public function updated(Proveedor $proveedor)
    {
        // 1. Detectar cambios en información crítica (Teléfono/Contacto)
        if ($proveedor->wasChanged(['telefono', 'contacto', 'email'])) {
            $detalle = "Se actualizó la información de contacto del proveedor: {$proveedor->nombre}.";
            return $this->registrar($proveedor, 'ACTUALIZACION_CONTACTO', $detalle, 'bg-cyan-500');
        }

        // 2. Detectar cambio de nombre comercial
        if ($proveedor->wasChanged('nombre')) {
            $anterior = $proveedor->getOriginal('nombre');
            $detalle = "Cambio de razón social/nombre: '{$anterior}' → '{$proveedor->nombre}'.";
            return $this->registrar($proveedor, 'CAMBIO_NOMBRE_PROV', $detalle, 'bg-indigo-500');
        }

        // 3. Actualización genérica
        if ($proveedor->isDirty()) {
            $detalle = "Datos generales actualizados para: {$proveedor->nombre}.";
            $this->registrar($proveedor, 'ACTUALIZACIÓN', $detalle, 'bg-slate-500');
        }
    }

    public function deleted(Proveedor $proveedor)
    {
        $detalle = "Se eliminó al proveedor: **{$proveedor->nombre}**. Las compras asociadas ahora referencian a un registro inexistente.";
        $this->registrar($proveedor, 'ELIMINACIÓN', $detalle, 'bg-rose-700');
    }

    /**
     * Registro centralizado en la tabla movimientos
     */
    protected function registrar($proveedor, $accion, $detalle, $color)
    {
        Movimiento::create([
            'user_id'        => Auth::id() ?? 1, 
            'proveedor_id'   => $proveedor->id,
            'proveedor_name' => $proveedor->nombre,
            'accion'         => $accion,
            'detalle'        => $detalle,
            'color_badge'    => $color,
            // Aseguramos que el resto de llaves sean null
            'producto_id'    => null,
            'customer_id'    => null,
            'categoria_id'   => null,
        ]);
    }
}