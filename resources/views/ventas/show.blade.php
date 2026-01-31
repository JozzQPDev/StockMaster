<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-medium uppercase tracking-widest">
                        <li class="inline-flex items-center text-slate-400">
                            <a href="{{ route('ventas.index') }}" class="hover:text-indigo-600 transition-colors">ventas</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-slate-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path>
                                </svg>
                                <span class="text-indigo-600">Detalle </span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">
                    Venta <span class="text-indigo-600">#{{ $venta->codigo_factura }}</span>
                </h1>
            </div>

            <div class="flex space-x-5 no-print">
                <button onclick="window.print()" class="flex items-center px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold text-sm hover:bg-slate-50 transition-all shadow-sm">
                    <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2h2m8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Imprimir
                </button>
                <a href="{{ route('ventas.index') }}" class="flex items-center px-4 py-2 bg-slate-800 text-white rounded-xl font-bold text-sm hover:bg-slate-900 transition-all shadow-lg">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Columna Izquierda --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Tabla de Productos --}}
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-50 bg-slate-50/50">
                        <h3 class="font-black text-slate-700 uppercase text-xs tracking-widest">Artículos Vendidos</h3>
                    </div>
                    <table class="w-full">
                        <thead class="bg-slate-50/30">
                            <tr>
                                <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase">Producto</th>
                                <th class="px-6 py-3 text-center text-[10px] font-black text-slate-400 uppercase">Cant.</th>
                                <th class="px-6 py-3 text-right text-[10px] font-black text-slate-400 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($venta->detalles as $detalle)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-700 text-sm">
                                        {{ $detalle->producto->nombre ?? $detalle->producto_nombre ?? 'Producto sin nombre' }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">
                                        P. Unit: S/ {{ number_format($detalle->precio_unitario, 2) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                        {{ $detalle->cantidad }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-black text-slate-700">
                                    S/ {{ number_format($detalle->subtotal, 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Card Detallada del Cliente --}}
                <div class="bg-indigo-600 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <p class="text-indigo-200 text-[10px] font-black uppercase tracking-widest mb-1">Datos del Cliente</p>
                                <h4 class="text-2xl font-bold">{{ $venta->customer->name ?? 'Cliente General' }}</h4>
                                <p class="text-indigo-100 text-sm opacity-80 italic">{{ $venta->customer->document_number ?? 'Sin documento' }}</p>
                            </div>
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3 border border-white/20 text-center">
                                <p class="text-[10px] font-black uppercase opacity-70">Nivel</p>
                                <p class="text-lg font-black">{{ $venta->customer->level ?? 'Estándar' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6 pb-6 border-b border-white/10">
                            <div>
                                <p class="text-indigo-200 text-[10px] font-black uppercase tracking-widest mb-1">Contacto</p>
                                <p class="text-sm font-medium">{{ $venta->customer->phone ?? 'Sin teléfono' }}</p>
                            </div>
                            <div>
                                <p class="text-indigo-200 text-[10px] font-black uppercase tracking-widest mb-1">Email</p>
                                <p class="text-sm font-medium">{{ $venta->customer->email ?? 'Sin email' }}</p>
                            </div>
                        </div>
                    </div>
                    <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-white/10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                    </svg>
                </div>
            </div>

            {{-- Columna Derecha: Resumen de Pago --}}
            <div class="space-y-8">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                    <h3 class="font-black text-slate-700 uppercase text-[10px] tracking-widest mb-6 border-b border-slate-50 pb-2">Resumen Financiero</h3>

                    <div class="space-y-2">
                        @php
                        // Usamos los nombres reales de tu modelo: 'descuento' y 'puntos_canjeados'
                        $valorDescuento = (float) ($venta->descuento ?? 0);
                        $puntosUsados = (int) ($venta->puntos_canjeados ?? 0);
                        $montoBruto = $venta->total + $valorDescuento;
                        @endphp

                        {{-- Subtotal --}}
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400 font-bold tracking-tight">Monto Bruto</span>
                            <span class="text-slate-700 font-bold italic">S/ {{ number_format($montoBruto, 2) }}</span>
                        </div>

                        {{-- SECCIÓN PUNTOS RESTADOS (Ahora con nombres correctos) --}}
                        @if($valorDescuento > 0 || $puntosUsados > 0)
                        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-100 relative overflow-hidden my-3">
                            <div class="relative z-10">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-rose-600 font-black text-[10px] uppercase tracking-widest">Puntos Canjeados</span>
                                    <span class="bg-rose-600 text-white text-[9px] px-2 py-0.5 rounded-full font-black uppercase italic shadow-sm">Ahorro</span>
                                </div>
                                <div class="flex justify-between items-end">
                                    <div class="flex flex-col">
                                        <span class="text-2xl font-black text-rose-700 tracking-tighter">
                                            - {{ $puntosUsados }} <span class="text-xs font-bold">pts</span>
                                        </span>
                                    </div>
                                    <span class="text-sm font-black text-rose-600">
                                        - S/ {{ number_format($valorDescuento, 2) }}
                                    </span>
                                </div>
                            </div>
                            <svg class="absolute -right-2 -bottom-2 w-16 h-16 text-rose-600 opacity-10" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        </div>
                        @endif

                        {{-- Total Final --}}
                        <div class="pt-4 border-t-2 border-slate-100 border-dashed flex justify-between items-end">
                            <span class="text-slate-800 font-black text-xs uppercase tracking-widest">Total Pagado</span>
                            <div class="text-right">
                                <span class="text-4xl font-black text-indigo-600 tracking-tighter leading-none">S/ {{ number_format($venta->total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-50 space-y-3">
                        <div class="flex items-center text-[10px] justify-between">
                            <span class="text-slate-400 font-black uppercase italic">Puntos Ganados Hoy:</span>
                            <span class="text-emerald-600 font-black">+ {{ $venta->puntos_ganados ?? floor($venta->total / 10) }} pts</span>
                        </div>
                        <div class="flex items-center text-[10px] justify-between">
                            <span class="text-slate-400 font-black uppercase">Método de Pago:</span>
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded-md font-black uppercase">{{ $venta->metodo_pago }}</span>
                        </div>
                        <div class="flex items-center text-[10px] justify-between">
                            <span class="text-slate-400 font-black uppercase tracking-tighter">Atendido por:</span>
                            <span class="text-slate-600 font-bold uppercase">{{ $venta->user->name ?? 'Admin' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Nota Auditoría --}}
                <div class="bg-slate-50 rounded-2xl p-4 border border-dashed border-slate-200">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-slate-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="text-[11px] text-slate-500 leading-relaxed font-medium">
                            Movimiento de inventario validado bajo operación <strong class="text-slate-700">#STK-{{ $venta->codigo_factura }}</strong>. Los puntos han sido procesados y cargados a la cuenta del cliente.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>