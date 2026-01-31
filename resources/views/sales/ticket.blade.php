<div class="ticket-container" style="width: 80mm; font-family: monospace; font-size: 12px;">
    <div style="text-align: center; margin-bottom: 10px;">
        <h2 style="margin: 0; text-transform: uppercase;">{{ setting('store_name') }}</h2>
        <p style="margin: 2px 0;">RUC: {{ setting('store_ruc') }}</p>
        <p style="margin: 2px 0;">{{ setting('store_address') }}</p>
        <p style="margin: 2px 0;">Telf: {{ setting('store_phone') }}</p>
    </div>

    <hr style="border-top: 1px dashed #000;">

    <table style="width: 100%;">
        @foreach($venta->items as $item)
        <tr>
            <td colspan="2">{{ $item->producto->nombre }}</td>
        </tr>
        <tr>
            <td>{{ $item->cantidad }} x {{ number_format($item->precio, 2) }}</td>
            <td style="text-align: right;">S/ {{ number_format($item->subtotal, 2) }}</td>
        </tr>
        @endforeach
    </table>

    <hr style="border-top: 1px dashed #000;">

    <div style="text-align: right; font-weight: bold; font-size: 14px;">
        TOTAL: S/ {{ number_format($venta->total, 2) }}
    </div>

    <div style="margin-top: 15px; border: 1px solid #000; padding: 5px; text-align: center;">
        <p style="margin: 0;">¡PUNTOS GANADOS: **{{ $venta->puntos_ganados }}**!</p>
        <p style="margin: 0; font-size: 10px;">Acumula {{ setting('puntos_minimo_canje') }} puntos para canjes.</p>
    </div>

    <div style="text-align: center; margin-top: 10px;">
        <p>Atendido por: {{ auth()->user()->name }}</p>
        <p>*** Gracias por su preferencia ***</p>
    </div>
</div>