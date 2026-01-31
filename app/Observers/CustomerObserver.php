<?php

namespace App\Observers;

use App\Models\Customer;
use App\Models\Movimiento;
use Illuminate\Support\Facades\Auth;

class CustomerObserver
{
    public $afterCommit = true;

    public function created(Customer $customer)
    {
        $detalle = "Se registró un nuevo cliente: **{$customer->name}** con Documento: {$customer->document_number}.";
        $this->registrar($customer, 'NUEVO_CLIENTE', $detalle, 'bg-emerald-500');
    }

    public function updated(Customer $customer)
    {
        // 1. Detectar si lo que cambió fueron los puntos
        if ($customer->wasChanged('points')) {
            $anterior = $customer->getOriginal('points');
            $nuevo = $customer->points;
            $diff = $nuevo - $anterior;
            
            $tipo = $diff > 0 ? 'SUMA_PUNTOS' : 'CANJE_PUNTOS';
            $detalle = "Cambio de puntos: {$anterior} → {$nuevo} (" . ($diff > 0 ? '+' : '') . "{$diff} pts).";
            
            return $this->registrar($customer, $tipo, $detalle, 'bg-indigo-600');
        }

        // 2. Detectar si cambió el nivel (VIP, etc)
        if ($customer->wasChanged('level')) {
            $detalle = "El cliente subió de nivel: **{$customer->level}**.";
            return $this->registrar($customer, 'CAMBIO_NIVEL', $detalle, 'bg-amber-500');
        }

        // 3. Actualización genérica (solo si hubo cambios en otros campos)
        if ($customer->isDirty()) {
            $detalle = "Se actualizaron datos generales del cliente: {$customer->name}.";
            $this->registrar($customer, 'ACTUALIZACIÓN', $detalle, 'bg-blue-500');
        }
    }

    public function deleted(Customer $customer)
    {
        $detalle = "Se eliminó al cliente: {$customer->name} (Documento: {$customer->document_number}).";
        $this->registrar($customer, 'ELIMINACIÓN', $detalle, 'bg-rose-600');
    }

    /**
     * Centraliza la creación del movimiento con soporte para sistema/admin
     */
    protected function registrar($customer, $accion, $detalle, $color)
    {
        Movimiento::create([
            // Si Auth::id() es null (ej. un proceso automático), asignamos ID 1 (Admin/Sistema)
            'user_id'         => Auth::id() ?? 1, 
            'customer_id'     => $customer->id,
            'customer_name'   => $customer->name,
            'accion'          => $accion,
            'detalle'         => $detalle,
            'color_badge'     => $color,
            // Aseguramos que los campos de producto/otros queden null
            'producto_id'     => null,
            'cantidad'        => 0,
        ]);
    }
}