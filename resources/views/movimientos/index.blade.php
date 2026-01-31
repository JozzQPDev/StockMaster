<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div>
                <h2 class="font-black text-2xl text-slate-800 dark:text-white flex items-center">
                    Control de<span class="text-indigo-600 ml-1">Trazabilidad</span>
                    <span class="relative flex h-2 w-2 ml-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                </h2>
            </div>

            {{-- Buscador, Filtros y Reportes --}}
            <div class="flex flex-wrap items-center gap-3">
                <form action="{{ route('movimientos.index') }}" method="GET" id="filter-form" class="flex flex-wrap items-center gap-3">
                    {{-- Input de Búsqueda --}}
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar registro..."
                            class="block w-full md:w-48 pl-10 pr-4 py-2 bg-white dark:bg-slate-800 border-none rounded-2xl text-xs shadow-sm focus:ring-2 focus:ring-indigo-500 transition-all text-slate-600 dark:text-slate-300">
                    </div>

                    {{-- Filtro de Fechas --}}
                    <div class="flex items-center gap-2 bg-white dark:bg-slate-800 px-3 py-1.5 rounded-2xl shadow-sm border border-transparent focus-within:ring-2 focus-within:ring-indigo-500 transition-all">
                        <input type="date" name="desde" value="{{ request('desde') }}"
                            class="bg-transparent border-none text-[10px] font-black text-slate-600 dark:text-slate-300 focus:ring-0 p-0 cursor-pointer uppercase">
                        <span class="text-slate-300 dark:text-slate-600 text-xs font-black">/</span>
                        <input type="date" name="hasta" value="{{ request('hasta') }}"
                            class="bg-transparent border-none text-[10px] font-black text-slate-600 dark:text-slate-300 focus:ring-0 p-0 cursor-pointer uppercase">
                    </div>

                    {{-- Selector de Tipo --}}
                    <select name="tipo" onchange="this.form.submit()"
                        class="rounded-2xl border-none bg-white dark:bg-slate-800 text-[10px] font-black uppercase tracking-tight focus:ring-2 focus:ring-indigo-500 cursor-pointer shadow-sm py-2 px-4">
                        <option value="">TODOS</option>
                        <option value="VENTA" {{ request('tipo') == 'VENTA' ? 'selected' : '' }}>Ventas</option>
                        <option value="ENTRADA" {{ request('tipo') == 'ENTRADA' ? 'selected' : '' }}>Entradas</option>
                        <option value="PUNTOS" {{ request('tipo') == 'PUNTOS' ? 'selected' : '' }}>Fidelización</option>
                        <option value="ELIMINACIÓN" {{ request('tipo') == 'ELIMINACIÓN' ? 'selected' : '' }}>Eliminados</option>
                    </select>

                    <button type="submit" class="hidden">Filtrar</button>

                    {{-- Botón Limpiar --}}
                    @if(request()->anyFilled(['buscar', 'tipo', 'desde', 'hasta']))
                    <a href="{{ route('movimientos.index') }}" class="p-2 text-slate-400 hover:text-rose-500 transition-colors" title="Limpiar filtros">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                    @endif
                </form>

                <div class="h-8 w-[1px] bg-slate-200 dark:bg-slate-700 mx-1"></div>

                {{-- Acciones de Exportación --}}
                <div class="flex items-center gap-2">
                    {{-- Botón Excel --}}
                    <a href="{{ route('movimientos.excel', request()->all()) }}"
                        class="p-2.5 bg-emerald-500/10 hover:bg-emerald-500 text-emerald-600 hover:text-white rounded-xl transition-all duration-300 group shadow-sm border border-emerald-500/20"
                        title="Exportar Excel">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16M10 6v12m4-12v12" />
                        </svg>
                    </a>

                    {{-- Botón PDF --}}
                    <a href="{{ route('movimientos.pdf', request()->all()) }}"
                        class="p-2.5 bg-rose-500/10 hover:bg-rose-500 text-rose-600 hover:text-white rounded-xl transition-all duration-300 group shadow-sm border border-rose-500/20"
                        title="Exportar PDF">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-4">

                {{-- Table Header --}}
                <div class="hidden md:grid grid-cols-12 px-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                    <div class="col-span-3">Autor del Cambio</div>
                    <div class="col-span-2">Operación</div>
                    <div class="col-span-5">Entidad / Detalle del Movimiento</div>
                    <div class="col-span-2 text-right">Fecha y Hora</div>
                </div>

                @forelse($movimientos as $mov)
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-4 shadow-sm hover:shadow-2xl hover:scale-[1.01] transition-all duration-300 border border-slate-100 dark:border-slate-800 group">
                    <div class="grid grid-cols-1 md:grid-cols-12 items-center gap-4">

                        {{-- Usuario Responsable --}}
                        <div class="col-span-3 flex items-center gap-4 border-r border-slate-50 dark:border-slate-800">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-sm text-indigo-600 dark:text-indigo-400 font-black shadow-inner">
                                {{ substr($mov->user->name, 0, 2) }}
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-slate-800 dark:text-white line-clamp-1">{{ $mov->user->name }}</span>
                                <span class="text-[10px] text-indigo-500 font-bold uppercase tracking-widest">ID: #{{ $mov->user_id }}</span>
                            </div>
                        </div>

                        {{-- Badge Dinámico --}}
                        <div class="col-span-2">
                            @php
                            $colorClass = match($mov->color_badge) {
                            'bg-emerald-500', 'emerald' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400',
                            'bg-rose-600', 'rose', 'red' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400',
                            'bg-indigo-600', 'indigo' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400',
                            'bg-amber-500', 'amber', 'yellow' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400',
                            'bg-purple-500', 'purple' => 'bg-purple-100 text-purple-700 dark:bg-purple-500/10 dark:text-purple-400',
                            default => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-400',
                            };
                            @endphp
                            <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-tighter {{ $colorClass }}">
                                {{ str_replace('_', ' ', $mov->accion) }}
                            </span>
                        </div>

                        {{-- Información de la Entidad (Producto, Cliente, etc.) --}}
                        <div class="col-span-5 flex flex-col justify-center">
                            <div class="flex items-center gap-3">
                                {{-- Icono según tipo de ID presente --}}
                                @if($mov->producto_id)
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="2" />
                                </svg>
                                @elseif($mov->customer_id)
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" />
                                </svg>
                                @elseif($mov->proveedor_id)
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5h10v11H3V5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 8h4l3 3v5h-7V8z" />
                                    <circle cx="6.5" cy="16.5" r="1.5" stroke-width="2" />
                                    <circle cx="16.5" cy="16.5" r="1.5" stroke-width="2" />
                                </svg>
                                @elseif($mov->categoria_id) {{-- NUEVO: ICONO DE CATEGORÍA --}}
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                @endif

                                <h3 class="text-sm font-black text-slate-700 dark:text-slate-200 uppercase tracking-tight">
                                    {{ $mov->producto_nombre ?? $mov->customer_name ?? $mov->proveedor_name ?? $mov->categoria_name ?? 'Sistema' }}
                                </h3>

                                @if($mov->cantidad != 0)
                                <span class="text-xs font-black px-2 py-0.5 rounded-lg {{ $mov->cantidad > 0 ? 'bg-emerald-500/10 text-emerald-600' : 'bg-rose-500/10 text-rose-600' }}">
                                    {{ $mov->cantidad > 0 ? '+' : '' }}{{ (float)$mov->cantidad }}
                                </span>
                                @endif
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 font-medium italic">
                                {!! str_replace('**', '', $mov->detalle) !!}
                            </p>
                        </div>

                        {{-- Timestamp --}}
                        <div class="col-span-2 text-right border-l border-slate-50 dark:border-slate-800 pl-4">
                            <span class="block text-xs font-black text-slate-700 dark:text-slate-300">
                                {{ $mov->created_at->translatedFormat('d M, Y') }}
                            </span>
                            <span class="text-[10px] font-bold text-indigo-500 uppercase">
                                {{ $mov->created_at->format('h:i:s A') }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-20 bg-white dark:bg-slate-900 rounded-[3rem] border-2 border-dashed border-slate-100 dark:border-slate-800">
                    <div class="flex justify-center mb-4 text-slate-300">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-width="2" />
                        </svg>
                    </div>
                    <p class="text-slate-400 font-black uppercase tracking-widest text-xs">Sin actividad reciente para mostrar</p>
                </div>
                @endforelse

                <div class="mt-8">
                    {{ $movimientos->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        let typingTimer;
        const buscarInput = document.querySelector('input[name="buscar"]');

        buscarInput.addEventListener('input', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                document.getElementById('filter-form').submit();
            }, 800); // Espera 800ms después de que el usuario deja de escribir
        });

        document.querySelectorAll('input[type="date"]').forEach(input => {
            input.addEventListener('change', () => {
                document.getElementById('filter-form').submit();
            });
        });

        // Al cargar la página, si hay algo en el buscador, poner el foco al final
        window.onload = () => {
            const input = document.querySelector('input[name="buscar"]');
            if (input.value.length > 0) {
                input.focus();
                input.setSelectionRange(input.value.length, input.value.length);
            }
        };
    </script>
</x-app-layout>