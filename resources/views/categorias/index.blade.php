<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-slate-800 dark:text-white flex items-center">
                    Gestion de<span class="text-indigo-600 ml-1">Categorias</span>
                    {{-- El punto parpadeante --}}
                    <span class="relative flex h-2 w-2 ml-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                </h2>
            </div>

            <div class="flex items-center gap-3">
                {{-- Formulario de Búsqueda --}}
                <form action="{{ route('categorias.index') }}" method="GET" class="flex items-center gap-2">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar categoría..."
                            class="block w-full md:w-64 pl-10 pr-10 py-2 bg-white dark:bg-slate-800 border-none rounded-xl text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 transition-all text-slate-600 dark:text-slate-300">

                        @if(request('search'))
                            <a href="{{ route('categorias.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-rose-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>

                <a href="{{ route('categorias.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
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

            {{-- Alertas de éxito --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                     class="mb-4 p-4 bg-emerald-50 dark:bg-emerald-500/10 border-l-4 border-emerald-500 text-emerald-700 dark:text-emerald-400 rounded-xl shadow-sm">
                    <div class="flex items-center font-bold">
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm sm:rounded-[2rem] border border-slate-100 dark:border-slate-800">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-slate-800/50 dark:text-slate-300">
                            <tr>
                                <th class="px-6 py-4 font-bold">Nombre de la Categoría</th>
                                <th class="px-6 py-4 font-bold text-center">Productos Vinculados</th>
                                <th class="px-6 py-4 font-bold text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($categorias as $categoria)
                                <tr class="bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                                            <span class="font-bold text-slate-900 dark:text-white text-base">{{ $categoria->nombre }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-black">
                                            <svg class="w-3 h-3 mr-1.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                            {{ $categoria->productos->count() }} ítems
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center items-center space-x-3">
                                            <a href="{{ route('categorias.edit', $categoria) }}" class="p-2 text-indigo-600 bg-indigo-50 dark:bg-indigo-500/10 rounded-lg hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            
                                            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-delete-{{ $categoria->id }}')"
                                                class="p-2 bg-rose-50 dark:bg-rose-500/10 text-rose-600 hover:bg-rose-600 hover:text-white rounded-lg transition-all shadow-sm">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="h-12 w-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            <p class="text-slate-500 text-lg font-medium">No se encontraron categorías</p>
                                            <a href="{{ route('categorias.index') }}" class="mt-2 text-indigo-600 hover:underline text-sm font-bold italic">Ver todas las categorías</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                @if(method_exists($categorias, 'hasPages') && $categorias->hasPages())
                    <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800">
                        {{ $categorias->appends(['search' => request('search')])->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modales de Eliminación --}}
    @foreach($categorias as $categoria)
        <x-modal name="confirm-delete-{{ $categoria->id }}" focusable>
            <form method="post" action="{{ route('categorias.destroy', $categoria) }}" class="p-8">
                @csrf
                @method('delete')
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-rose-100 dark:bg-rose-500/20 mb-4">
                        <svg class="h-8 w-8 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-black text-slate-800 dark:text-white">¿Eliminar categoría?</h2>
                    <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">
                        Estás eliminando <span class="font-bold text-rose-600">"{{ $categoria->nombre }}"</span>. 
                        @if($categoria->productos->count() > 0)
                            <br><span class="text-rose-500 font-bold italic underline">¡Cuidado! Esta categoría tiene {{ $categoria->productos->count() }} productos asociados.</span>
                        @endif
                    </p>
                </div>
                <div class="mt-8 flex justify-center gap-3">
                    <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl px-6">Cancelar</x-secondary-button>
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-rose-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-rose-700 transition-all shadow-lg shadow-rose-500/30">
                        Confirmar Eliminación
                    </button>
                </div>
            </form>
        </x-modal>
    @endforeach
    {{-- 5. PIE DE PÁGINA --}}
    <div class="mt-12 text-center">
        <p class="text-slate-400 dark:text-slate-500 text-[10px] font-medium uppercase tracking-[0.4em]">
            StockMaster v1.0 • {{ now()->year }}
        </p>
    </div>
</x-app-layout>