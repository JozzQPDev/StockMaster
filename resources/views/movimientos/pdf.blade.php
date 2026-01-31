<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #4f46e5; color: white; padding: 8px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #eee; }
        .header { text-align: center; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Reporte de Trazabilidad de Inventario</h2>
        <p>Generado: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>FECHA</th><th>RESPONSABLE</th><th>ACCION</th><th>ENTIDAD</th><th>CANT.</th><th>DETALLE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movimientos as $mov)
            <tr>
                <td>{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $mov->user->name }}</td>
                <td>{{ $mov->accion }}</td>
                <td>{{ $mov->producto_nombre ?? $mov->customer_name ?? 'Sistema' }}</td>
                <td>{{ (float)$mov->cantidad }}</td>
                <td>{{ str_replace('**', '', $mov->detalle) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>