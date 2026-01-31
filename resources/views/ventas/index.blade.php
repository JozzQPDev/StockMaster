<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between gap-4 px-2 no-print">
            <div class="flex items-center justify-between md:justify-start">
                <h2 class="font-black text-xl md:text-2xl text-slate-800 dark:text-white flex items-center">
                    Historial de<span class="text-indigo-600 ml-1">Ventas</span>
                </h2>
                {{-- El punto parpadeante --}}
                <span class="relative flex h-2 w-2 ml-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch gap-3">
                <form action="{{ route('ventas.index') }}" method="GET" class="relative group flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar venta..."
                        class="block w-full md:w-64 pl-9 pr-4 py-2.5 bg-white dark:bg-slate-800 border-none rounded-2xl text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 transition-all text-slate-600 dark:text-slate-300">
                </form>

                <a href="{{ route('ventas.create') }}"
                    class="inline-flex justify-center items-center px-6 py-2.5 bg-indigo-600 rounded-2xl font-black text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                    Nueva Venta
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-2" x-data="{ 
        showTicket: {{ (session('venta_reciente') || (request('open_id') && !request('page'))) ? 'true' : 'false' }},
        closeTicket() {
            this.showTicket = false;
            const url = new URL(window.location);
            url.searchParams.delete('open_id');
            window.history.replaceState({}, document.title, url.pathname + url.search);
        }
    }">
        <div class="max-w-10xl mx-auto px-4 sm:px-6 lg:px-8 no-print">
            @if($ventas->isEmpty())
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-16 text-center border-2 border-dashed border-slate-100 dark:border-slate-800">
                <p class="text-slate-400 font-black uppercase italic tracking-tighter">No hay registros</p>
            </div>
            @else
            {{-- VISTA MÓVIL (Cards) - CORREGIDA --}}
            <div class="grid grid-cols-1 gap-4 md:hidden">
                @foreach($ventas as $venta)
                <div class="bg-white dark:bg-slate-900 p-5 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800 active:scale-[0.98] transition-all"
                    @click="window.location='{{ route('ventas.index', ['open_id' => $venta->id, 'page' => request('page')]) }}'">
                    <div class="flex justify-between items-start mb-3">
                        <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest">{{ $venta->codigo_factura }}</span>
                        <span class="text-[10px] text-slate-400 font-bold uppercase">{{ $venta->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-sm font-black text-slate-800 dark:text-slate-200">{{ $venta->user->name }}</p>
                            @php
                            $metodo = strtolower($venta->metodo_pago ?? 'efectivo');
                            $mColor = match($metodo) {
                            'efectivo' => 'text-emerald-500',
                            'yape', 'plin' => 'text-purple-500',
                            default => 'text-blue-500',
                            };
                            @endphp
                            <p class="text-[10px] font-black uppercase {{ $mColor }}">{{ $venta->metodo_pago ?? 'Efectivo' }}</p>
                        </div>
                        <p class="text-xl font-black text-slate-900 dark:text-white italic">S/ {{ number_format($venta->total, 2) }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- TABLA ESCRITORIO --}}
            <div class="hidden md:block bg-white dark:bg-slate-900 shadow-sm rounded-[2.5rem] border border-slate-100 dark:border-slate-800 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 dark:bg-slate-800/50">
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest italic">Código / Fecha</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest italic">Vendedor</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest italic">Método</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest italic text-right">Total</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest italic text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach($ventas as $venta)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-black text-indigo-600 text-sm italic">{{ $venta->codigo_factura }}</div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase">{{ $venta->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-slate-700 dark:text-slate-300">{{ $venta->user->name }}</td>

                            <td class="px-6 py-4">
                                @php
                                $metodo = strtolower($venta->metodo_pago ?? 'efectivo');
                                $color = match($metodo) {
                                'efectivo' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                'yape', 'plin' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                default => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase {{ $color }}">
                                    {{ $venta->metodo_pago ?? 'Efectivo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="font-black text-slate-900 dark:text-white italic">
                                    S/ {{ number_format($venta->total, 2) }}
                                </div>
                                @if($venta->descuento > 0)
                                <div class="text-[9px] text-emerald-500 font-bold uppercase tracking-tighter">
                                    Desc. Puntos: -S/ {{ number_format($venta->descuento, 2) }}
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center space-x-3">
                                    {{-- Botón 1: VER DETALLES (Ir a show.blade.php) --}}
                                    <a href="{{ route('ventas.show', $venta) }}"
                                        class="p-2 inline-flex bg-slate-100 dark:bg-slate-800 rounded-xl text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all duration-200"
                                        title="Ver detalles completos">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    {{-- Botón 2: IMPRIMIR (Acción rápida) --}}
                                    <a href="{{ route('ventas.index', ['open_id' => $venta->id, 'page' => request('page')]) }}"
                                        class="p-2 inline-flex bg-slate-100 dark:bg-slate-800 rounded-xl text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all duration-200"
                                        title="Imprimir Ticket">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6 no-print">
                {{ $ventas->links() }}
            </div>
            @endif
        </div>

        {{-- MODAL DEL TICKET --}}
        @php
        $ventaParaModal = session('venta_reciente') ?? (request('open_id') ? \App\Models\Venta::with(['detalles.producto', 'user'])->find(request('open_id')) : null);
        @endphp

        @if($ventaParaModal)
        <div x-show="showTicket" id="modal-container"
            class="fixed inset-0 z-[200] flex items-center justify-center p-2 sm:p-4 bg-slate-950/90 backdrop-blur-md no-print"
            x-cloak>

            <div @click.away="closeTicket()"
                class="bg-white dark:bg-slate-900 w-full max-w-[420px] max-h-[92vh] rounded-[2.5rem] shadow-3xl flex flex-col relative border border-slate-100 dark:border-slate-800 overflow-hidden">

                <div class="flex-1 overflow-y-auto custom-scrollbar p-6 sm:p-8" id="printable-ticket">
                    {{-- Logo/Header --}}
                    <div class="text-center mb-6">
                        {{-- Logo Estilizado Dinámico --}}
                        <div class="inline-block p-4 bg-slate-900 rounded-3xl mb-3 print-bg-black">
                            <h1 class="text-2xl font-black uppercase italic text-white leading-none tracking-tighter">
                                {{ \App\Models\Setting::get('store_name', 'STOCK MASTER') }}
                            </h1>
                        </div>

                        {{-- Datos de la Empresa --}}
                        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-widest leading-tight space-y-0.5">
                            {{-- Razón Social (Si es distinta al nombre comercial, puedes crear otra llave 'store_legal_name') --}}
                            <h2 class="font-bold text-lg text-slate-800 tracking-normal">
                                {{ \App\Models\Setting::get('store_legal_name', \App\Models\Setting::get('store_name')) }}
                            </h2>

                            <p>RUC: {{ \App\Models\Setting::get('store_ruc') }}</p>
                            <p>{{ \App\Models\Setting::get('store_address') }}</p>
                            <p>Cel/WhatsApp: {{ \App\Models\Setting::get('store_phone') }}</p>

                            @if(\App\Models\Setting::get('store_email'))
                            <p>{{ \App\Models\Setting::get('store_email') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="border-y-2 border-dashed border-slate-100 dark:border-slate-800 py-4 mb-6 space-y-1.5">
                        {{-- Datos Documento --}}
                        <div class="flex justify-between text-[11px]">
                            <span class="text-slate-400 font-bold uppercase tracking-tighter">Ticket:</span>
                            <span class="font-black text-indigo-600 italic tracking-tighter">{{ $ventaParaModal->codigo_factura }}</span>
                        </div>
                        <div class="flex justify-between text-[11px]">
                            <span class="text-slate-400 font-bold uppercase tracking-tighter">Fecha:</span>
                            <span class="font-black dark:text-slate-200 tracking-tighter">{{ $ventaParaModal->created_at->format('d/m/Y - H:i') }}</span>
                        </div>
                        {{-- Datos del Cliente --}}
                        <div class="border-t border-dashed border-slate-100 dark:border-slate-800 pt-3 pb-1 space-y-1">
                            <div class="flex justify-between text-[11px]">
                                <span class="text-slate-400 font-bold uppercase tracking-tighter">Cliente:</span>
                                <span class="font-black text-slate-800 dark:text-slate-200 uppercase tracking-tighter">
                                    {{ $ventaParaModal->customer->name ?? 'PÚBLICO EN GENERAL' }}
                                </span>
                            </div>
                            @if($ventaParaModal->customer)
                            <div class="flex justify-between text-[11px]">
                                <span class="text-slate-400 font-bold uppercase tracking-tighter">
                                    {{ $ventaParaModal->customer->document_type }}:
                                </span>
                                <span class="font-black text-slate-800 dark:text-slate-200 tracking-tighter">
                                    {{ $ventaParaModal->customer->document_number }}
                                </span>
                            </div>
                            {{-- Puntos acumulados (Opcional) --}}
                            <div class="flex justify-between text-[10px] italic">
                                <span class="text-slate-400 font-bold uppercase tracking-tighter">Puntos Ganados:</span>
                                <span class="font-black text-emerald-600 tracking-tighter">
                                    +{{ floor($ventaParaModal->total / 10) }} pts
                                </span>
                            </div>
                            @endif
                        </div>

                        {{-- Separador sutil o espacio --}}
                        <div class="flex justify-between text-[10px] pt-1 border-t border-slate-50 dark:border-slate-800/50">
                            <span class="text-slate-400/80 font-bold uppercase italic">Lo atendió:</span>
                            <span class="font-black text-slate-500 dark:text-slate-400 uppercase">{{ $ventaParaModal->user->name }}</span>
                        </div>
                    </div>

                    {{-- Productos --}}
                    <div class="space-y-4 mb-8">
                        @foreach($ventaParaModal->detalles as $det)
                        <div class="flex flex-col gap-1 border-b border-slate-50 dark:border-slate-800 pb-2">
                            <p class="text-[12px] font-black text-slate-800 dark:text-slate-200 uppercase leading-none">{{ $det->producto->nombre }}</p>
                            <div class="flex justify-between items-end">
                                <p class="text-[11px] text-slate-500 font-medium">{{ $det->cantidad }} x S/ {{ number_format($det->precio_unitario, 2) }}</p>
                                <span class="text-[12px] font-black dark:text-white italic tabular-nums">S/ {{ number_format($det->subtotal, 2) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Totales --}}
                    <div class="space-y-2 mb-6 px-2">
                        {{-- Op. Gravada --}}
                        <div class="flex justify-between text-[11px]">
                            <span class="text-slate-500 font-bold uppercase">Op. Gravada:</span>
                            <span class="font-black dark:text-slate-200 italic">S/ {{ number_format($ventaParaModal->total / 1.18, 2) }}</span>
                        </div>

                        {{-- IGV --}}
                        <div class="flex justify-between text-[11px]">
                            <span class="text-slate-500 font-bold uppercase">IGV (18%):</span>
                            <span class="font-black dark:text-slate-200 italic">S/ {{ number_format($ventaParaModal->total - ($ventaParaModal->total / 1.18), 2) }}</span>
                        </div>

                        {{-- DESCUENTO POR PUNTOS (Solo se muestra si hubo canje) --}}
                        @if($ventaParaModal->descuento > 0)
                        <div class="flex justify-between text-[11px] text-emerald-600 dark:text-emerald-400 font-bold">
                            <span class="uppercase tracking-tighter italic">Ahorro Puntos:</span>
                            <span class="font-black italic">- S/ {{ number_format($ventaParaModal->descuento, 2) }}</span>
                        </div>
                        @endif

                        {{-- TOTAL FINAL --}}
                        <div class="flex justify-between items-center pt-2 border-t-2 border-slate-900 dark:border-slate-700">
                            <span class="text-[13px] font-black uppercase text-slate-900 dark:text-white tracking-tighter italic">TOTAL:</span>
                            <span class="text-xl font-black text-indigo-600 italic tabular-nums">
                                S/ {{ number_format($ventaParaModal->total, 2) }}
                            </span>
                        </div>
                    </div>

                    {{-- QR --}}
                    <div class="flex flex-col items-center gap-4 py-4 bg-slate-50 dark:bg-slate-800/50 rounded-[2.5rem]">
                        <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-100">
                            @php
                            // Construimos una cadena de datos más completa
                            $clienteNom = $ventaParaModal->customer->name ?? 'PUBLICO GENERAL';
                            $clienteDoc = $ventaParaModal->customer->document_number ?? '00000000';

                            // Estructura: Ticket | Total | Cliente | Doc
                            $qrData = "TK:{$ventaParaModal->codigo_factura}|TOT:{$ventaParaModal->total}|CLI:{$clienteNom}|DOC:{$clienteDoc}";

                            $qrUrl = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=".urlencode($qrData)."&choe=UTF-8";
                            @endphp
                            <img src="{{ $qrUrl }}" alt="QR" class="w-32 h-32">
                        </div>
                        <p class="text-[10px] font-black uppercase text-slate-800 dark:text-slate-200 italic">¡Vuelva pronto!</p>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="p-6 bg-slate-100 dark:bg-slate-800/80 backdrop-blur flex gap-3 no-print">
                    <button @click="closeTicket()" class="flex-1 py-4 bg-white dark:bg-slate-700 text-slate-600 dark:text-slate-200 rounded-3xl font-black text-[11px] uppercase border border-slate-200 transition-all">Regresar</button>
                    <button onclick="window.print()" class="flex-[2] py-4 bg-indigo-600 text-white rounded-3xl font-black text-[11px] uppercase shadow-xl shadow-indigo-200 active:scale-95 transition-all">Imprimir Ticket</button>
                </div>
            </div>
        </div>
        @endif
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body>*:not(#modal-container),
            .no-print,
            nav,
            header,
            aside,
            form,
            .fixed,
            button {
                display: none !important;
            }

            #modal-container {
                position: absolute !important;
                top: 0;
                left: 0;
                width: 100% !important;
                background: white !important;
                display: flex !important;
                justify-content: center !important;
                padding: 0 !important;
            }

            #modal-container>div {
                border: none !important;
                box-shadow: none !important;
                max-width: 100% !important;
                width: 100% !important;
                background: white !important;
            }

            #printable-ticket {
                width: 80mm !important;
                margin: 0 auto !important;
                padding: 5mm !important;
                overflow: visible !important;
                height: auto !important;
                display: block !important;
                color: black !important;
            }

            .print-bg-black {
                background-color: #000 !important;
                color: #fff !important;
            }

            .bg-slate-50 {
                background-color: transparent !important;
            }
        }
    </style>
</x-app-layout>