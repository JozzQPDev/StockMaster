<?php

namespace App\Http\Controllers;

use App\Models\{Producto, Categoria, Proveedor, Movimiento, Venta, Customer};
use Illuminate\Support\Facades\{DB, Cache, Auth}; // Asegúrate de importar Auth aquí
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Usamos Auth::id() que es más seguro para el linter de VS Code
        $cacheKey = 'dashboard_stats_' . (Auth::id() ?? 'guest');

        $data = Cache::remember($cacheKey, 600, function () {
            $hoy = Carbon::today();
            $ayer = Carbon::yesterday();

            // 2. Ejecutamos consultas de métricas base de forma eficiente
            $stats = [
                'productos'   => Producto::count(),
                'categorias'  => Categoria::count(),
                'proveedores' => Proveedor::count(),
                'clientes'    => Customer::count(),
            ];

            // 3. Stock Crítico: Obtenemos datos y conteo en una sola lógica
            $productosCriticos = Producto::whereColumn('stock_actual', '<=', 'stock_minimo')
                ->orderBy('stock_actual')
                ->limit(4)
                ->get(['id', 'nombre', 'stock_actual', 'stock_minimo']);

            $stockCriticoCount = Producto::whereColumn('stock_actual', '<=', 'stock_minimo')->count();

            // 4. Valor del Inventario
            $valorInventario = Producto::selectRaw('
                    SUM(stock_actual * precio_venta) as total_venta, 
                    SUM(stock_actual * precio_compra) as total_costo
                ')->first();

            // 5. Ventas y Tendencia: Usamos una sola query para obtener ambos días
            $ingresosCoyuntura = Venta::whereIn(DB::raw('DATE(created_at)'), [$hoy, $ayer])
                ->selectRaw('DATE(created_at) as fecha, SUM(total) as total')
                ->groupBy('fecha')
                ->pluck('total', 'fecha');

            $ingresosHoy = $ingresosCoyuntura[$hoy->format('Y-m-d')] ?? 0;
            $ingresosAyer = $ingresosCoyuntura[$ayer->format('Y-m-d')] ?? 0;
            $tendenciaHoy = $ingresosAyer > 0 ? (($ingresosHoy - $ingresosAyer) / $ingresosAyer) * 100 : 0;

            // 6. Construcción del Gráfico de 7 días
            $ventas7Dias = Venta::where('created_at', '>=', now()->subDays(6))
                ->selectRaw('DATE(created_at) as fecha, SUM(total) as total')
                ->groupBy('fecha')
                ->orderBy('fecha')
                ->pluck('total', 'fecha');

            $ventasChart = collect();
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $f = $date->format('Y-m-d');
                $ventasChart->push([
                    'label' => $date->translatedFormat('D d'),
                    'total' => $ventas7Dias[$f] ?? 0
                ]);
            }

            return compact(
                'stats',
                'productosCriticos',
                'stockCriticoCount',
                'valorInventario',
                'ingresosHoy',
                'tendenciaHoy',
                'ventasChart'
            );
        });

        // 7. Datos en tiempo real (No se cachean para mantener frescura)
        $realTimeData = [
            'movimientos'     => Movimiento::with('user:id,name')->latest()->limit(5)->get(),
            'ventasSemana'    => Venta::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total'),
            'ventasMes'       => Venta::whereMonth('created_at', now()->month)->sum('total'),
            'ventasRecientes' => Venta::with(['user:id,name', 'customer:id,name'])->latest()->limit(4)->get(),
            'productosMasVendidos' => DB::table('detalle_ventas')
                ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
                ->select('productos.nombre', DB::raw('SUM(detalle_ventas.cantidad) as cant'))
                ->groupBy('productos.id', 'productos.nombre')
                ->orderBy('cant', 'desc')->take(5)->get(),
            'clientesMasActivos' => DB::table('ventas')
                ->join('customers', 'ventas.customer_id', '=', 'customers.id')
                ->select('customers.name', DB::raw('SUM(ventas.total) as total'))
                ->groupBy('customers.id', 'customers.name')
                ->orderBy('total', 'desc')->take(5)->get()
        ];

        return view('dashboard', array_merge($data, $data['stats'], $realTimeData));
    }
}
