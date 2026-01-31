<?php

namespace App\Observers;

use App\Models\Producto;
use App\Models\Movimiento;
use Illuminate\Support\Facades\Auth;

class ProductoObserver
{
    public $afterCommit = true;

    public function created(Producto $producto)
    {
        $detalle = "Registro inicial de producto: **{$producto->nombre}** con stock de {$producto->stock_actual}.";
        $this->registrar($producto, 'NUEVO_PRODUCTO', $detalle, 'bg-blue-500', $producto->stock_actual);
    }

    public function updated(Producto $producto)
    {
        // 1. DETECTAR CAMBIO DE PRECIO
        if ($producto->wasChanged('precio_venta')) {
            $antiguo = $producto->getOriginal('precio_venta');
            $nuevo = $producto->precio_venta;
            $detalle = "Cambio de precio: S/ {$antiguo} → S/ {$nuevo}.";
            $this->registrar($producto, 'CAMBIO_PRECIO', $detalle, 'bg-amber-500', 0);
        }

        // 2. DETECTAR CAMBIO DE STOCK
        if ($producto->wasChanged('stock_actual')) {
            
            // --- REGLAS DE ORO PARA PRODUCCIÓN ---
            
            // A. Si silenciamos el observer manualmente
            if (isset($producto->evitar_observer) && $producto->evitar_observer) {
                return;
            }

            // B. Si es una VENTA o POS, el controlador de ventas ya crea su propio movimiento.
            // Ignoramos aquí para evitar la duplicidad.
            if (request()->routeIs('ventas.*') || request()->routeIs('pos.*')) {
                return;
            }

            $nuevoStock = (int)$producto->stock_actual;
            $antiguoStock = (int)$producto->getOriginal('stock_actual');
            $diferencia = $nuevoStock - $antiguoStock;

            // C. Si no hay diferencia real (ej. 0 -> 0), no registramos nada.
            if ($diferencia === 0) {
                return;
            }

            // Si llegamos aquí, es un AJUSTE MANUAL (desde el formulario de editar producto)
            $accion = $diferencia < 0 ? 'SALIDA_MANUAL' : 'ENTRADA_STOCK';
            $color = $diferencia < 0 ? 'bg-rose-600' : 'bg-emerald-600';
            
            $detalle = "Ajuste manual de inventario: {$antiguoStock} → {$nuevoStock} unidades.";
            $this->registrar($producto, $accion, $detalle, $color, $diferencia);
        }
    }

    public function deleted(Producto $producto)
    {
        $this->registrar($producto, 'ELIMINACIÓN', "Se eliminó el producto del catálogo.", 'bg-black', 0);
    }

    protected function registrar($producto, $accion, $detalle, $color, $cantidad = 0)
    {
        Movimiento::create([
            'user_id'         => Auth::id() ?? 1,
            'producto_id'     => $producto->id,
            'producto_nombre' => $producto->nombre,
            'accion'          => $accion,
            'cantidad'        => $cantidad,
            'detalle'         => $detalle,
            'color_badge'     => $color,
        ]);
    }
}