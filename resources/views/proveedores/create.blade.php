<x-app-layout>
        <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-medium uppercase tracking-widest">
                        <li class="inline-flex items-center text-slate-400">
                            <a href="{{ route('proveedores.index') }}" class="hover:text-indigo-600 transition-colors">Categorias</a>
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
                   Nuevo <span class="text-indigo-600">Proveedor</span>
                </h2>
            </div>
            <div class="flex items-center">
                <a href="{{ route('proveedores.index') }}"
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
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                {{-- Columna Lateral: Status y Guía --}}
                <div class="lg:col-span-1 space-y-4">
                    <div class="bg-white dark:bg-slate-900 p-6 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm">
                        <div class="w-14 h-14 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center mb-6 border border-slate-100 dark:border-slate-700 shadow-inner">
                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h4 class="font-black text-slate-800 dark:text-white uppercase text-[10px] tracking-widest mb-2">Requerimientos</h4>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Razón Social Válida
                            </li>
                            <li class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-200"></span> Email Corporativo
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Columna Principal: Formulario --}}
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-slate-900 p-8 md:p-12 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none">
                        
                        <form action="{{ route('proveedores.store') }}" method="POST" class="space-y-10">
                            @csrf

                            {{-- Campo Principal (Nombre) --}}
                            <div class="relative group">
                                <label for="nombre" class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.3em] mb-4 block ml-1">
                                    Nombre o Razón Social
                                </label>
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required autofocus
                                    class="w-full bg-transparent border-0 border-b-2 border-slate-100 dark:border-slate-800 focus:border-indigo-500 focus:ring-0 text-2xl font-black text-slate-800 dark:text-white placeholder-slate-200 dark:placeholder-slate-700 transition-all pb-4 italic uppercase tracking-tighter"
                                    placeholder="NOMBRE DE LA EMPRESA...">
                                <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                            </div>

                            {{-- Grid de Datos Secundarios --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-10">
                                {{-- Email --}}
                                <div class="relative group">
                                    <label for="email" class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 block ml-1">Correo Electrónico</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        class="w-full bg-transparent border-0 border-b border-slate-100 dark:border-slate-800 focus:border-indigo-500 focus:ring-0 text-sm font-bold text-slate-700 dark:text-slate-300 pb-2 transition-all italic"
                                        placeholder="ejemplo@correo.com">
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>

                                {{-- Teléfono --}}
                                <div class="relative group">
                                    <label for="telefono" class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 block ml-1">Teléfono</label>
                                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}"
                                        class="w-full bg-transparent border-0 border-b border-slate-100 dark:border-slate-800 focus:border-indigo-500 focus:ring-0 text-sm font-bold text-slate-700 dark:text-slate-300 pb-2 transition-all italic"
                                        placeholder="+00 000 000 000">
                                    <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
                                </div>

                                {{-- Dirección --}}
                                <div class="md:col-span-2 relative group">
                                    <label for="direccion" class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 block ml-1">Dirección Física</label>
                                    <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}"
                                        class="w-full bg-transparent border-0 border-b border-slate-100 dark:border-slate-800 focus:border-indigo-500 focus:ring-0 text-sm font-bold text-slate-700 dark:text-slate-300 pb-2 transition-all italic"
                                        placeholder="CALLE, NÚMERO, CIUDAD...">
                                    <x-input-error class="mt-2" :messages="$errors->get('direccion')" />
                                </div>
                            </div>

                            {{-- Botonera --}}
                            <div class="flex items-center justify-between gap-4 pt-10">
                                <a href="{{ route('proveedores.index') }}" class="text-[10px] font-black text-slate-400 hover:text-rose-500 transition-colors uppercase tracking-[0.2em]">
                                    Descartar
                                </a>

                                <button type="submit" class="group relative px-10 py-4 bg-indigo-600 text-white rounded-2xl transition-all hover:scale-[1.02] active:scale-95 shadow-xl shadow-indigo-200 dark:shadow-none">
                                    <div class="flex items-center relative z-10">
                                        <span class="text-[10px] font-black uppercase tracking-[0.2em]">Guardar Proveedor</span>
                                        <svg class="w-4 h-4 ml-3 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </div>
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