<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-slate-800 dark:text-white flex items-center">
                    Control de<span class="text-indigo-600 ml-1">Inventario</span>
                    {{-- El punto parpadeante --}}
                    <span class="relative flex h-2 w-2 ml-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                </h2>
            </div>

            <div class="flex items-center gap-3">
                {{-- Formulario de Búsqueda --}}
                <form action="{{ route('productos.index') }}" method="GET" class="flex items-center gap-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Código, nombre o proveedor..."
                            class="block w-full md:w-80 pl-10 pr-10 py-2 bg-white dark:bg-slate-800 border-none rounded-xl text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 transition-all text-slate-600 dark:text-slate-300">

                        @if(request('search'))
                        <a href="{{ route('productos.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-rose-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                        @endif
                    </div>
                </form>

                <a href="{{ route('productos.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Agregar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-1 ph-2">
        <div class="max-w-10xl mx-auto sm:px-2 lg:px-2">

            {{-- Indicador de búsqueda activa (Como en Proveedores) --}}
            @if(request('search'))
            <div class="mb-4 flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Mostrando resultados para: <span class="font-bold text-indigo-600">"{{ request('search') }}"</span>
            </div>
            @endif

            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm sm:rounded-[2rem] border border-slate-100 dark:border-slate-800">
                <div class="overflow-x-auto">
                    @if(request('filtro') === 'critico')
                    <div class="mb-6 group relative overflow-hidden bg-white dark:bg-slate-900 border border-red-100 dark:border-red-900/30 p-1 rounded-[2rem] shadow-xl shadow-red-100/50 dark:shadow-none">
                        <div class="flex flex-col md:flex-row items-center justify-between p-4 px-6 relative z-10">

                            <div class="flex items-center gap-4 mb-4 md:mb-0">
                                {{-- Icono con Pulso --}}
                                <div class="flex-shrink-0 w-12 h-12 bg-red-50 dark:bg-red-500/10 rounded-2xl flex items-center justify-center text-red-600">
                                    <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                </div>

                                <div>
                                    <h4 class="text-slate-800 dark:text-white font-black uppercase tracking-tighter italic leading-none">
                                        Vista de <span class="text-red-600">Emergencia</span>
                                    </h4>
                                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">
                                        Mostrando solo productos con <span class="text-red-600 font-bold">Stock Crítico</span> (≤ {{ $productos->first()->stock_minimo ?? 5 }} un.)
                                    </p>
                                </div>
                            </div>

                            {{-- Botón para quitar filtro --}}
                            <a href="{{ route('productos.index') }}"
                                class="group/btn flex items-center gap-2 bg-slate-100 hover:bg-red-600 dark:bg-slate-800 dark:hover:bg-red-600 text-slate-600 hover:text-white dark:text-slate-300 px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all duration-300 active:scale-95">
                                <span>Quitar Filtro</span>
                                <svg class="w-4 h-4 transition-transform group-hover/btn:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        </div>

                        {{-- Decoración de fondo sutil --}}
                        <div class="absolute top-0 right-0 w-32 h-32 bg-red-50 dark:bg-red-500/5 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-150 duration-700"></div>
                    </div>
                    @endif
                    <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-slate-800/50 dark:text-slate-300">
                            <tr>
                                <th class="px-6 py-4 font-bold">Producto</th>
                                <th class="px-6 py-4 font-bold">Categoría / Proveedor</th>
                                <th class="px-6 py-4 font-bold">Precios</th>
                                <th class="px-6 py-4 font-bold text-center">Stock Actual</th>
                                <th class="px-6 py-4 font-bold text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($productos as $producto)
                            <tr class="bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-16 w-16 rounded-full bg-slate-100 dark:bg-slate-800 flex-shrink-0 flex items-center justify-center overflow-hidden border border-slate-200 dark:border-slate-700 shadow-sm">
                                            @if($producto->imagen)
                                            <img src="{{ asset('storage/' . $producto->imagen) }}" class="h-full w-full object-cover">
                                            @else
                                            <svg class="h-6 w-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            @endif
                                        </div>

                                        <div class="flex flex-col">
                                            <span class="text-slate-900 dark:text-white font-bold text-base leading-tight">{{ $producto->nombre }}</span>
                                            <span class="text-indigo-500 font-mono text-[10px] uppercase tracking-widest font-bold">{{ $producto->codigo }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <span class="px-2 py-0.5 text-[10px] font-bold bg-indigo-50 dark:bg-indigo-500/10 rounded text-indigo-600 dark:text-indigo-400 w-fit italic">
                                            {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                                        </span>
                                        <span class="text-xs font-medium text-slate-600 dark:text-slate-400">
                                            <span class="text-[10px] uppercase text-slate-400">Prov:</span> {{ $producto->proveedor->nombre ?? 'Sin proveedor' }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-slate-900 dark:text-white font-bold text-sm">
                                            {{ $producto->precio_venta_soles }}
                                        </span>
                                        <span class="text-[10px] text-emerald-500 font-bold uppercase tracking-tighter">
                                            Ganancia: {{ $producto->ganancia_soles }}
                                        </span>
                                    </div>
                                </td>


                                <td class="px-6 py-4 text-center">
                                    @php
                                    $esBajo = $producto->stock_actual <= $producto->stock_minimo;
                                        $statusClass = $esBajo ? 'bg-rose-50 text-rose-600 dark:bg-rose-500/10' : 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10';
                                        $dotClass = $esBajo ? 'bg-rose-500' : 'bg-emerald-500';
                                        @endphp
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full {{ $statusClass }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $dotClass }} {{ $esBajo ? 'animate-pulse' : '' }}"></span>
                                            <span class="text-xs font-black uppercase tracking-wider">{{ $producto->stock_actual }} un.</span>
                                        </div>
                                        @if($esBajo)
                                        <p class="text-[10px] text-rose-500 mt-1 font-bold animate-bounce italic">¡Reabastecer!</p>
                                        @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center space-x-2">
                                        {{-- Botón VER DATOS --}}
                                        <a href="{{ route('productos.show', $producto) }}"
                                            class="p-2 text-emerald-600 bg-emerald-50 dark:bg-emerald-500/10 rounded-lg hover:bg-emerald-600 hover:text-white transition-all"
                                            title="Ver detalles">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                        {{-- Botón Editar (Tu código original) --}}
                                        <a href="{{ route('productos.edit', $producto) }}" class="p-2 text-indigo-600 bg-indigo-50 dark:bg-indigo-500/10 rounded-lg hover:bg-indigo-600 hover:text-white transition-all">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        {{-- Botón Eliminar (Tu código original) --}}
                                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-del-{{ $producto->id }}')"
                                            class="p-2 bg-rose-50 dark:bg-rose-500/10 text-rose-600 hover:bg-rose-600 hover:text-white rounded-lg transition-all">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>

                                        {{-- Botón que abre el modal --}}
                                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'modal-salida-{{ $producto->id }}')"
                                            class="p-2 bg-amber-50 dark:bg-amber-500/10 text-amber-600 hover:bg-amber-600 hover:text-white rounded-lg transition-all"
                                            title="Registrar Salida/Merma">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                        {{-- El nuevo Modal usando tu componente x-modal --}}
                                        <x-modal name="modal-salida-{{ $producto->id }}" maxWidth="sm">
                                            <div class="p-8">
                                                <form action="{{ route('productos.ajustar', $producto) }}" method="POST">
                                                    @csrf
                                                    <div class="flex items-center gap-3 mb-6">
                                                        <div class="w-10 h-10 bg-rose-100 dark:bg-rose-500/20 rounded-full flex items-center justify-center text-rose-600">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                                            </svg>
                                                        </div>
                                                        <h3 class="text-lg font-black uppercase italic text-slate-800 dark:text-white">Registrar <span class="text-rose-500">Salida</span></h3>
                                                    </div>

                                                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-6 bg-slate-50 dark:bg-slate-800 p-3 rounded-xl border border-slate-100 dark:border-slate-700">
                                                        <span class="font-bold uppercase block text-[10px]">Producto:</span>
                                                        {{ $producto->nombre }} (Actual: {{ $producto->stock_actual }} un.)
                                                    </p>

                                                    <div class="space-y-5">
                                                        <div>
                                                            <label class="block text-[10px] font-black uppercase text-slate-400 mb-1 ml-1">Cantidad a retirar</label>
                                                            <input type="number" name="cantidad" required min="1" max="{{ $producto->stock_actual }}"
                                                                placeholder="0"
                                                                class="w-full rounded-2xl border-none bg-slate-100 dark:bg-slate-800 focus:ring-2 focus:ring-rose-500 text-slate-700 dark:text-white font-bold">
                                                        </div>
                                                        <div>
                                                            <label class="block text-[10px] font-black uppercase text-slate-400 mb-1 ml-1">Motivo de la salida</label>
                                                            <textarea name="motivo" required placeholder="Ej. Producto dañado, Vencimiento..."
                                                                class="w-full rounded-2xl border-none bg-slate-100 dark:bg-slate-800 focus:ring-2 focus:ring-rose-500 text-sm text-slate-700 dark:text-white"
                                                                rows="3"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="mt-8 flex flex-col gap-2">
                                                        <button type="submit" class="w-full py-3 bg-rose-500 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-rose-600 transition-all shadow-lg shadow-rose-200">
                                                            Confirmar Salida
                                                        </button>
                                                        <button type="button" x-on:click="$dispatch('close')" class="w-full py-3 text-xs font-bold uppercase text-slate-400 hover:text-slate-600">
                                                            Cancelar
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </x-modal>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="h-12 w-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="text-slate-500 text-lg font-medium">No se encontraron productos</p>
                                        <a href="{{ route('productos.index') }}" class="mt-2 text-indigo-600 hover:underline text-sm font-bold italic">Ver todos los productos</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación (Fuera de la tabla para evitar errores de CSS) --}}
                @if($productos->hasPages())
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800">
                    {{ $productos->appends(['search' => request('search')])->links() }}
                </div>
                @endif
            </div>
        </div>
        {{-- 5. PIE DE PÁGINA --}}
        <div class="mt-12 text-center">
            <p class="text-slate-400 dark:text-slate-500 text-[10px] font-medium uppercase tracking-[0.4em]">
                StockMaster v1.0 • {{ now()->year }}
            </p>
        </div>
    </div>

    {{-- Modales de Eliminación --}}
    @foreach($productos as $producto)
    <x-modal name="confirm-del-{{ $producto->id }}" focusable>
        <form method="post" action="{{ route('productos.destroy', $producto) }}" class="p-8">
            @csrf
            @method('delete')
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-rose-100 dark:bg-rose-500/20 mb-4">
                    <svg class="h-8 w-8 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h2 class="text-xl font-black text-slate-800 dark:text-white italic">¿Eliminar producto?</h2>
                <p class="mt-3 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                    Estás a punto de borrar <span class="font-bold text-rose-600">"{{ $producto->nombre }}"</span>. Esta acción es permanente.
                </p>
            </div>
            <div class="mt-8 flex justify-center gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl px-6">Cancelar</x-secondary-button>
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-rose-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-rose-700 transition-all shadow-lg shadow-rose-500/30">
                    Sí, Borrar Producto
                </button>
            </div>
        </form>
    </x-modal>
    @endforeach
</x-app-layout>