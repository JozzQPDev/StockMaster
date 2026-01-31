<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-slate-800 dark:text-white flex items-center">
                    Gestion de<span class="text-indigo-600 ml-1">Proveedores</span>
                    {{-- El punto parpadeante --}}
                    <span class="relative flex h-2 w-2 ml-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                </h2>
            </div>
            <div class="flex items-center gap-3">
                {{-- Formulario de Búsqueda --}}
                <form action="{{ route('proveedores.index') }}" method="GET" class="flex items-center gap-2">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre, email o teléfono..."
                            class="block w-full md:w-64 pl-10 pr-10 py-2 bg-white dark:bg-slate-800 border-none rounded-xl text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 transition-all text-slate-600 dark:text-slate-300">

                        @if(request('search'))
                        <a href="{{ route('proveedores.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-rose-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                        @endif
                    </div>
                </form>

                <a href="{{ route('proveedores.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 transition-all duration-200 shadow-lg shadow-indigo-200 dark:shadow-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Agregar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-10xl mx-auto sm:px-2 lg:px-2">

            {{-- Indicador de búsqueda activa --}}
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
                    <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-slate-800/50 dark:text-slate-300">
                            <tr>
                                <th class="px-6 py-4 font-bold">ID</th>
                                <th class="px-6 py-4 font-bold">Información del Proveedor</th>
                                <th class="px-6 py-4 font-bold">Contacto</th>
                                <th class="px-6 py-4 font-bold">Ubicación</th>
                                <th class="px-6 py-4 font-bold text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($proveedores as $proveedor)
                            <tr class="bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-400">#{{ $proveedor->id }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-slate-900 dark:text-white font-bold text-base leading-tight">{{ $proveedor->nombre }}</span>
                                        <span class="text-indigo-500 dark:text-indigo-400 text-xs font-medium">{{ $proveedor->email }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="tel:{{ $proveedor->telefono }}" class="inline-flex items-center gap-1.5 text-slate-700 dark:text-slate-300 hover:text-indigo-600 transition-colors font-semibold">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ $proveedor->telefono }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 truncate max-w-xs italic text-slate-600 dark:text-slate-400">
                                    {{ $proveedor->direccion ?? 'No especificada' }}
                                </td>
                                {{-- ... (resto del código igual hasta llegar a la sección de acciones en la tabla) --}}

                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center space-x-2">
                                        {{-- NUEVO: Botón Ver Detalle (Show) --}}
                                        <a href="{{ route('proveedores.show', $proveedor) }}"
                                            class="p-2 text-emerald-600 bg-emerald-50 dark:bg-emerald-500/10 rounded-lg hover:bg-emerald-600 hover:text-white transition-all duration-200 group"
                                            title="Ver ficha completa">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                        {{-- Botón Editar --}}
                                        <a href="{{ route('proveedores.edit', $proveedor) }}"
                                            class="p-2 text-indigo-600 bg-indigo-50 dark:bg-indigo-500/10 rounded-lg hover:bg-indigo-600 hover:text-white transition-all duration-200"
                                            title="Editar registro">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        {{-- Botón Eliminar --}}
                                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $proveedor->id }}')"
                                            class="p-2 bg-rose-50 dark:bg-rose-500/10 text-rose-600 hover:bg-rose-600 hover:text-white rounded-lg transition-all duration-200"
                                            title="Eliminar proveedor">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>

                                {{-- ... (resto del código igual) --}}
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-slate-500 text-lg font-medium">No se encontraron proveedores</p>
                                        <a href="{{ route('proveedores.index') }}" class="mt-2 text-indigo-600 hover:underline text-sm font-bold">Ver todos los proveedores</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación fuera de la tabla --}}
                @if($proveedores->hasPages())
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800">
                    {{ $proveedores->appends(['search' => request('search')])->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modales de Eliminación --}}
    @foreach($proveedores as $proveedor)
    <x-modal name="confirm-deletion-{{ $proveedor->id }}" focusable>
        <div class="p-8">
            <form method="post" action="{{ route('proveedores.destroy', $proveedor) }}" class="text-center">
                @csrf
                @method('delete')

                <div class="w-20 h-20 bg-rose-100 dark:bg-rose-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                <h2 class="text-2xl font-black text-slate-800 dark:text-white italic text-center">Confirmar eliminación</h2>

                <p class="mt-4 text-slate-600 dark:text-slate-400 leading-relaxed text-center">
                    ¿Estás seguro de eliminar a <span class="font-bold text-rose-600">"{{ $proveedor->nombre }}"</span>? <br>
                    Esta acción es permanente en <strong>StockMaster</strong>.
                </p>

                <div class="mt-8 flex justify-center gap-3">
                    <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl px-6 border-slate-200 dark:border-slate-700">
                        {{ __('Cancelar') }}
                    </x-secondary-button>

                    <x-danger-button class="bg-rose-600 hover:bg-rose-700 rounded-xl px-6 shadow-lg shadow-rose-500/30">
                        {{ __('Eliminar') }}
                    </x-danger-button>
                </div>
            </form>
        </div>
    </x-modal>
    @endforeach
    {{-- 5. PIE DE PÁGINA --}}
    <div class="mt-12 text-center">
        <p class="text-slate-400 dark:text-slate-500 text-[10px] font-medium uppercase tracking-[0.4em]">
            StockMaster v1.0 • {{ now()->year }}
        </p>
    </div>
</x-app-layout>