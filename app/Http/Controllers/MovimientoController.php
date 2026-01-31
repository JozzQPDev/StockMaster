<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MovimientoController extends Controller
{
    public function index(Request $request)
    {
        $movimientos = $this->aplicarFiltros($request)
            ->paginate(15)
            ->appends($request->only(['buscar', 'tipo', 'desde', 'hasta'])); // Agregamos fechas aquí

        return view('movimientos.index', compact('movimientos'));
    }

    protected function aplicarFiltros(Request $request)
    {
        $query = Movimiento::query()->with('user')->latest();
        $query->when($request->desde, fn($q) => $q->whereDate('created_at', '>=', $request->desde));
        $query->when($request->hasta, fn($q) => $q->whereDate('created_at', '<=', $request->hasta));

        // Filtro por tipo exacto
        $query->when($request->tipo, function ($q, $tipo) {
            return $q->where('accion', $tipo);
        });

        // Búsqueda inteligente: agrupamos los 'orWhere' para que no rompan el filtro de 'tipo'
        $query->when($request->buscar, function ($q, $buscar) {
            return $q->where(function ($sub) use ($buscar) {
                $sub->where('producto_nombre', 'like', "%{$buscar}%")
                    ->orWhere('customer_name', 'like', "%{$buscar}%")
                    ->orWhere('proveedor_name', 'like', "%{$buscar}%")
                    ->orWhere('categoria_name', 'like', "%{$buscar}%") // Agregado categoría
                    ->orWhere('detalle', 'like', "%{$buscar}%");
            });
        });

        return $query;
    }

    public function exportExcel(Request $request)
    {
        // Importante: No cargar miles de registros de golpe si no hay filtros
        $movimientos = $this->aplicarFiltros($request)->take(2000)->get();

        $fileName = 'reporte_movimientos_' . now()->format('Y-m-d_Hi') . '.xls';

        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Cache-Control: max-age=0");

        echo "\xEF\xBB\xBF"; // UTF-8 BOM para tildes

        echo "<table border='1'>";
        echo "<tr style='background-color: #4f46e5; color: white; font-weight: bold;'>
                <th>FECHA</th>
                <th>RESPONSABLE</th>
                <th>ACCION</th>
                <th>ENTIDAD RELACIONADA</th>
                <th>CANTIDAD</th>
                <th>DETALLE / OBSERVACION</th>
              </tr>";

        foreach ($movimientos as $mov) {
            $entidad = $mov->producto_nombre ?? $mov->customer_name ?? $mov->proveedor_name ?? $mov->categoria_name ?? 'Sistema';
            $detalle = str_replace(['**', '_'], '', $mov->detalle);

            // Usamos strip_tags para evitar inyecciones de HTML en el Excel
            echo "<tr>
                    <td>{$mov->created_at->format('d/m/Y H:i')}</td>
                    <td>" . e($mov->user->name) . "</td>
                    <td style='text-align:center;'>{$mov->accion}</td>
                    <td>" . e($entidad) . "</td>
                    <td style='text-align:right;'>" . number_format((float)$mov->cantidad, 2) . "</td>
                    <td>" . e($detalle) . "</td>
                  </tr>";
        }
        echo "</table>";
        exit;
    }

    public function exportPdf(Request $request)
    {
        // Limitamos para evitar que DomPDF falle por falta de memoria (es común en hosting compartido o Laragon)
        $movimientos = $this->aplicarFiltros($request)->take(500)->get();

        // Pasamos una variable para saber cuántos se omitieron si el log es gigante
        $pdf = Pdf::loadView('movimientos.pdf', compact('movimientos'));

        return $pdf->setPaper('a4', 'landscape')->download('reporte_actividad.pdf');
    }
}
