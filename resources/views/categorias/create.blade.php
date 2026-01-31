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
                                <span class="text-indigo-600">Agregar</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="font-black text-2xl text-slate-800 dark:text-white leading-tight">
                    Crear <span class="text-indigo-600">Categoria</span>
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

    <div class="py-10">
        <div class="max-w-10xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-1 space-y-4">
                    <div class="bg-white dark:bg-slate-900 p-6 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm">
                        <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 rounded-3xl flex items-center justify-center mb-6 border border-slate-100 dark:border-slate-700 shadow-inner text-slate-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>
                        </div>
                        <h4 class="font-black text-indigo-600 uppercase text-xs tracking-widest mb-2">Instrucciones</h4>
                        <p class="text-[11px] text-slate-400 font-bold leading-relaxed mb-6">
                            Define un nombre corto y descriptivo para agrupar tus productos.
                        </p>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-slate-900 p-8 md:p-12 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none relative overflow-hidden">
                        <form action="{{ route('categorias.store') }}" method="POST" class="space-y-12 relative">
                            @csrf
                            <div class="relative group">
                                <label for="nombre" class="text-[10px] font-black text-indigo-500 dark:text-indigo-400 uppercase tracking-[0.3em] mb-6 block ml-1">
                                    Nombre de la Nueva Categoría
                                </label>
                                {{-- INPUT CORREGIDO: Solo un color de texto base --}}
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" autofocus
                                    class="w-full bg-transparent border-0 border-b-2 border-slate-100 dark:border-slate-800 focus:border-indigo-500 focus:ring-0 text-3xl font-black text-slate-800 dark:text-white placeholder-slate-200 dark:placeholder-slate-700 transition-all pb-6 italic uppercase tracking-tighter"
                                    placeholder="EJ: SMARTPHONES...">

                                @error('nombre')
                                <p class="mt-4 text-[10px] font-black text-rose-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-4 h-0.5 bg-rose-500"></span> {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between gap-4 pt-4">
                                <a href="{{ route('categorias.index') }}" class="text-[10px] font-black text-slate-400 hover:text-rose-500 transition-colors uppercase tracking-[0.2em]">
                                    Cancelar Operación
                                </a>

                                <button type="submit" class="px-10 py-5 bg-indigo-600 text-white rounded-[1.25rem] transition-all hover:scale-[1.02] active:scale-95 shadow-xl shadow-indigo-200 dark:shadow-none">
                                    <span class="text-[10px] font-black uppercase tracking-[0.2em]">Registrar Sistema</span>
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