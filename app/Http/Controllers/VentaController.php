<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Movimiento;
use App\Models\Customer;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $ventas = Venta::with(['user', 'customer', 'detalles.producto'])
            ->when($request->filled('search'), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('codigo_factura', 'LIKE', "%{$search}%")
                        ->orWhereHas('user', function ($u) use ($search) {
                            $u->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('customer', function ($c) use ($search) {
                            $c->where('name', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10);

        if ($request->has('open_id')) {
            $ventaParaModal = Venta::with(['user', 'customer', 'detalles.producto'])->find($request->open_id);
            if ($ventaParaModal) {
                session()->flash('venta_reciente', $ventaParaModal);
            }
        }

        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $productos = Producto::where('stock_actual', '>', 0)
            ->orderBy('nombre', 'asc')
            ->get();

        $clientes = Customer::orderBy('name', 'asc')->get();

        // Configuraciones de fidelización para el frontend
        $fidelizacionSettings = [
            'puntos_factor_ganancia' => Setting::get('puntos_factor_ganancia', 10),
            'puntos_equivalencia' => Setting::get('puntos_equivalencia', 100),
            'puntos_minimo_canje' => Setting::get('puntos_minimo_canje', 50),
        ];

        return view('ventas.create', compact('productos', 'clientes', 'fidelizacionSettings'));
    }

    public function store(Request $request)
    {
        // 1. Validación estricta
        $request->validate([
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'metodo_pago' => 'required|string',
            'customer_id' => 'nullable|exists:customers,id',
            'descuento_puntos' => 'nullable|numeric|min:0',
            'puntos_canjeados' => 'nullable|integer|min:0',
            'total' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            // 2. Crear la venta inicial
            $venta = Venta::create([
                'codigo_factura'   => 'V-' . strtoupper(uniqid()),
                'user_id'          => Auth::id(),
                'customer_id'      => $request->customer_id ?? 1,
                'total'            => 0,
                'descuento'        => 0,
                'puntos_canjeados' => 0,
                'impuesto'         => 0,
                'metodo_pago'      => $request->metodo_pago,
            ]);

            $totalCalculadoRelativo = 0;

            // 3. Procesar productos y Stock
            foreach ($request->productos as $item) {
                $producto = Producto::lockForUpdate()->find($item['id']);

                if (!$producto || $producto->stock_actual < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para: " . ($producto->nombre ?? 'Producto'));
                }

                $subtotalItem = $item['cantidad'] * $producto->precio_venta;
                $totalCalculadoRelativo += $subtotalItem;

                $venta->detalles()->create([
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio_venta,
                    'subtotal' => $subtotalItem,
                ]);

                $producto->decrement('stock_actual', $item['cantidad']);

                Movimiento::create([
                    'producto_id'     => $producto->id,
                    'user_id'         => Auth::id(),
                    'accion'          => 'VENTA',
                    'producto_nombre' => $producto->nombre,
                    'cantidad'        => $item['cantidad'],
                    'detalle'         => "VENTA #{$venta->codigo_factura}",
                    'color_badge'     => 'indigo'
                ]);
            }

            // 4. Lógica de Descuentos y Puntos (Uso de Settings)
            $descuentoPuntos = (float) ($request->descuento_puntos ?? 0);
            $puntosCanjeados = (int) ($request->puntos_canjeados ?? 0);
            $totalFinalRecibido = (float) $request->total;

            // Verificación de seguridad
            if (abs(($totalCalculadoRelativo - $descuentoPuntos) - $totalFinalRecibido) > 0.1) {
                throw new \Exception("Discrepancia de cálculos: Bruto(" . $totalCalculadoRelativo . ") - Desc(" . $descuentoPuntos . ") != Neto(" . $totalFinalRecibido . ")");
            }

            // 5. Actualización final de la Venta
            $venta->update([
                'total'            => $totalFinalRecibido,
                'descuento'        => $descuentoPuntos,
                'puntos_canjeados' => $puntosCanjeados,
            ]);

            // 6. Actualizar puntos del Cliente dinámicamente
            if ($venta->customer_id != 1) {
                $cliente = Customer::find($venta->customer_id);

                // Descontar puntos canjeados
                if ($puntosCanjeados > 0) {
                    if ($cliente->points < $puntosCanjeados) {
                        throw new \Exception("El cliente ya no tiene puntos suficientes.");
                    }
                    $cliente->decrement('points', $puntosCanjeados);
                }

                // --- CÁLCULO DINÁMICO DE PUNTOS GANADOS ---
                // Usamos el factor configurado en el panel (puntos_factor_ganancia)
                $factorGanancia = Setting::get('puntos_factor_ganancia', 10); // Default 10 si no existe

                $puntosGanados = floor($totalFinalRecibido / $factorGanancia);

                if ($puntosGanados > 0) {
                    $cliente->increment('points', $puntosGanados);
                }

                $cliente->increment('total_spent', $totalFinalRecibido);
            }

            DB::commit();

            return redirect()->route('ventas.index')
                ->with('venta_reciente', $venta->load('detalles.producto', 'user', 'customer'))
                ->with('success', "Venta #{$venta->codigo_factura} procesada. ¡Puntos ganados: $puntosGanados!");
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al procesar la venta: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $venta = Venta::with(['user', 'customer', 'detalles.producto'])->findOrFail($id);
        return view('ventas.show', compact('venta'));
    }

    public function storeRapido(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'document_number' => 'required|string|unique:customers,document_number',
            ]);

            $doc = $request->document_number;
            $tipoDoc = strlen($doc) == 11 ? 'RUC' : (strlen($doc) == 8 ? 'DNI' : 'OTRO');

            $cliente = Customer::create([
                'name'            => mb_strtoupper($request->name),
                'document_number' => $doc,
                'document_type'   => $tipoDoc,
                'phone'           => $request->phone,
                'points'          => 0,
                'total_spent'     => 0,
            ]);

            return response()->json($cliente);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 422);
        }
    }
}
