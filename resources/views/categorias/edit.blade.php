<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-medium uppercase tracking-widest">
                        <li class="inline-flex items-center text-slate-400">
                            <a href="{{ route('categorias.index') }}" class="hover:text-indigo-600 transition-colors">Categorias</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-slate-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path>
                                </svg>
                                <span class="text-indigo-600">Editar</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="font-black text-2xl text-slate-800 dark:text-white leading-tight">
                    Configuración de <span class="text-indigo-600">Categoría</span>
                </h2>
            </div>
            <div class="flex items-center">
                <a href="{{ route('categorias.index') }}"
                    class="group inline-flex items-center px-8 py-4 bg-white dark:bg-slate-800 text-slate-500 border border-slate-200 dark:border-slate-700 rounded-3xl font-black text-[10px] uppercase tracking-widest hover:text-indigo-600 transition-all shadow-sm hover:shadow-md active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-10xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Columna Izquierda: Información Técnica --}}
                <div class="lg:col-span-1 space-y-4">
                    <div class="bg-white dark:bg-slate-900 p-6 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm">
                        <div class="w-16 h-16 bg-indigo-50 dark:bg-indigo-500/10 rounded-3xl flex items-center justify-center mb-4 border border-indigo-100 dark:border-indigo-500/20">
                            <span class="text-2xl font-black text-indigo-600">{{ strtoupper(substr($categoria->nombre, 0, 1)) }}</span>
                        </div>
                        <h4 class="font-black text-slate-800 dark:text-white uppercase text-xs tracking-widest mb-1">Identificador</h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase mb-4">CAT-SYSTEM-{{ str_pad($categoria->id, 4, '0', STR_PAD_LEFT) }}</p>

                        <div class="pt-4 border-t border-slate-50 dark:border-slate-800">
                            <span class="text-[9px] font-black text-slate-300 uppercase tracking-tighter">Última actualización:</span>
                            <p class="text-[10px] font-bold text-slate-500">{{ $categoria->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                {{-- Columna Derecha: Formulario --}}
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-slate-900 p-8 md:p-12 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none">

                        <form action="{{ route('categorias.update', $categoria) }}" method="POST" class="space-y-10">
                            @csrf
                            @method('PUT')

                            <div class="relative">
                                <label for="nombre" class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.3em] mb-4 block ml-1">
                                    Etiqueta de la Categoría
                                </label>
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $categoria->nombre) }}"
                                    class="w-full bg-transparent border-0 border-b-2 border-slate-100 dark:border-slate-800 focus:border-indigo-500 focus:ring-0 text-2xl font-black text-slate-800 dark:text-white placeholder-slate-200 transition-all pb-4 italic uppercase tracking-tighter"
                                    placeholder="NOMBRE AQUI...">

                                @error('nombre')
                                <p class="mt-4 text-[10px] font-black text-rose-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-4 h-0.5 bg-rose-500"></span> {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div class="bg-slate-50 dark:bg-slate-800/40 p-6 rounded-[2rem] border border-dashed border-slate-200 dark:border-slate-700">
                                <div class="flex items-start gap-4">
                                    <div class="p-2 bg-white dark:bg-slate-900 rounded-xl shadow-sm">
                                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h5 class="text-[10px] font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest mb-1">Impacto de Cambio</h5>
                                        <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
                                            Esta acción renombrará el acceso directo para <span class="font-bold text-indigo-600">{{ $categoria->productos->count() }} productos</span> vinculados actualmente.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-4 pt-6">
                                <a href="{{ route('categorias.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] hover:text-rose-500 transition-colors">
                                    Descartar Cambios
                                </a>

                                <button type="submit" class="group relative px-10 py-4 bg-slate-900 dark:bg-indigo-600 text-white rounded-2xl overflow-hidden transition-all hover:pr-14 active:scale-95 shadow-xl shadow-indigo-200 dark:shadow-none">
                                    <span class="relative z-10 text-[10px] font-black uppercase tracking-[0.2em]">Guardar Sistema</span>
                                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 opacity-0 group-hover:opacity-100 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </div>
                        </form>
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