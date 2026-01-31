<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-medium uppercase tracking-widest">
                        <li class="inline-flex items-center text-slate-400">
                            <a href="{{ route('productos.index') }}" class="hover:text-indigo-600 transition-colors">Productos</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-slate-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path>
                                </svg>
                                <span class="text-indigo-600">Detalle</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="font-black text-2xl text-slate-800 dark:text-white leading-tight">
                    {{ $producto->nombre }}
                </h2>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('productos.index') }}"
                    class="group inline-flex items-center px-8 py-2.5 bg-white dark:bg-slate-800 text-slate-500 border border-slate-200 dark:border-slate-700 rounded-3xl font-black text-[10px] uppercase tracking-widest hover:text-indigo-600 transition-all shadow-sm hover:shadow-md active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver al listado
                </a>

                <a href="{{ route('productos.edit', $producto) }}"
                    class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-10xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Card Principal --}}
            <div class="bg-white dark:bg-slate-900 rounded-[3rem] shadow-2xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 overflow-hidden">
                <div class="flex flex-col lg:flex-row">

                    {{-- Lado Izquierdo: Imagen con gradiente --}}
                    <div class="lg:w-2/5 p-8 bg-slate-50 dark:bg-slate-800/50 flex flex-col items-center justify-center border-r border-slate-100 dark:border-slate-800">
                        <div class="relative group">
                            <div class="absolute -inset-4 bg-gradient-to-tr from-indigo-500 to-emerald-400 rounded-full blur-2xl opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                            <div class="relative h-84 w-84 rounded-[2.5rem] bg-white dark:bg-slate-800 shadow-xl overflow-hidden border-4 border-white dark:border-slate-700">
                                @if($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" class="h-full w-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                @else
                                <div class="flex items-center justify-center h-full bg-slate-100 dark:bg-slate-700">
                                    <svg class="h-20 w-20 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="mt-8">
                            <span class="px-5 py-2 bg-white dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-2xl text-[12px] font-black uppercase tracking-[0.2em] shadow-sm border border-slate-100 dark:border-slate-600">
                                SKU: {{ $producto->codigo }}
                            </span>
                        </div>
                    </div>

                    {{-- Lado Derecho: Información --}}
                    <div class="lg:w-3/5 p-10 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <span class="bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider">
                                    {{ $producto->categoria->nombre ?? 'General' }}
                                </span>
                            </div>
                            <h3 class="text-4xl font-black text-slate-900 dark:text-white leading-tight mb-4">
                                {{ $producto->nombre }}
                            </h3>
                            <p class="text-slate-500 dark:text-slate-400 leading-relaxed text-lg">
                                {{ $producto->descripcion ?? 'Este producto no cuenta con una descripción detallada todavía.' }}
                            </p>
                        </div>

                        {{-- Widgets de Precio --}}
                        <div class="grid grid-cols-2 gap-6 my-8">
                            <div class="relative overflow-hidden p-6 rounded-[2rem] bg-slate-900 dark:bg-slate-950 text-white shadow-xl shadow-slate-200 dark:shadow-none">
                                <div class="relative z-10">
                                    <span class="text-[10px] uppercase font-bold text-slate-400 tracking-widest block mb-1">Precio de Venta</span>
                                    <span class="text-3xl font-black">{{ $producto->precio_venta_soles }}</span>
                                </div>
                                <svg class="absolute -right-4 -bottom-4 h-24 w-24 text-white/5 rotate-12" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 14h-2v-2h2v2zm0-4h-2V7h2v5z" />
                                </svg>
                            </div>

                            <div class="relative overflow-hidden p-6 rounded-[2rem] bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20">
                                <div class="relative z-10">
                                    <span class="text-[10px] uppercase font-bold text-emerald-600 block mb-1 tracking-widest">Ganancia Neta</span>
                                    <span class="text-3xl font-black text-emerald-600">{{ $producto->ganancia_soles }}</span>
                                </div>
                                <svg class="absolute -right-4 -bottom-4 h-24 w-24 text-emerald-500/10 -rotate-12" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                            </div>
                        </div>

                        {{-- Info Secundaria --}}
                        <div class="flex items-center justify-between p-6 bg-slate-50 dark:bg-slate-800/30 rounded-3xl border border-slate-100 dark:border-slate-800">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Proveedor</span>
                                <span class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ $producto->proveedor->nombre ?? 'S/P' }}</span>
                            </div>
                            <div class="h-10 w-px bg-slate-200 dark:bg-slate-700"></div>
                            <div class="flex flex-col text-right">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Stock Actual</span>
                                <div class="flex items-center justify-end gap-2">
                                    <span class="font-black text-xl {{ $producto->stock_actual <= $producto->stock_minimo ? 'text-rose-600' : 'text-slate-900 dark:text-white' }}">
                                        {{ $producto->stock_actual }}
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase">Unidades</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Historial / Kardex --}}
            <div class="mt-12">
                <div class="flex items-center gap-4 mb-6 px-4">
                    <div class="h-10 w-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white tracking-tight">Kardex de <span class="text-indigo-600 text-italic">Movimientos</span></h3>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-800/50">
                                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em]">Fecha y Hora</th>
                                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em]">Tipo</th>
                                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] text-center">Cantidad</th>
                                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em]">Detalles del Movimiento</th>
                                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em]">Operador</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                                @forelse($producto->movimientos()->latest()->take(8)->get() as $movimiento)
                                @php
                                // Lógica para detectar si es VENTA por el texto del detalle
                                $esVenta = str_contains(strtoupper($movimiento->detalle ?? $movimiento->accion), 'VENTA');
                                // También puede ser salida si la cantidad es negativa (según cómo guardes el dato)
                                $esSalida = $esVenta || $movimiento->cantidad < 0;
                                    @endphp
                                    <tr class="group hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors">
                                    <td class="px-8 py-5">
                                        <div class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ $movimiento->created_at->format('d M, Y') }}</div>
                                        <div class="text-[10px] text-slate-400 font-medium uppercase">{{ $movimiento->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-8 py-5">
                                        @if($esSalida)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase bg-rose-50 dark:bg-rose-500/10 text-rose-600 border border-rose-100 dark:border-rose-500/20">
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-600 mr-2"></span> Salida
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 border border-emerald-100 dark:border-emerald-500/20">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-600 mr-2"></span> Entrada
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <span class="text-lg font-black {{ $esSalida ? 'text-rose-600' : 'text-emerald-600' }}">
                                            {{ $esSalida ? '-' : '+' }}{{ abs($movimiento->cantidad) }}
                                        </span>
                                        <span class="text-[10px] font-bold text-slate-400 ml-1 italic">UND.</span>
                                    </td>
                                    <td class="px-8 py-5">
                                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400 leading-snug">
                                            {{ $movimiento->detalle ?? $movimiento->accion }}
                                        </p>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-xs font-black text-indigo-600 border border-slate-200 dark:border-slate-700 uppercase">
                                                {{ substr($movimiento->user->name ?? 'S', 0, 1) }}
                                            </div>
                                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ $movimiento->user->name ?? 'Sistema' }}</span>
                                        </div>
                                    </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-8 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <svg class="h-12 w-12 text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                                <span class="text-slate-400 text-sm font-medium italic">No hay historial para este producto.</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- 5. PIE DE PÁGINA --}}
    <div class="mt-12 text-center">
        <p class="text-slate-400 dark:text-slate-500 text-[10px] font-medium uppercase tracking-[0.4em]">
            StockMaster v1.0 • {{ now()->year }}
        </p>
    </div>
</x-app-layout>