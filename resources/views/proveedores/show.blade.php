<x-app-layout>
    <x-slot name="header">
       <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-medium uppercase tracking-widest">
                        <li class="inline-flex items-center text-slate-400">
                            <a href="{{ route('proveedores.index') }}" class="hover:text-indigo-600 transition-colors">Proveedores</a>
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
                    {{ $proveedor->nombre }}
                </h2>
            </div>


            <div class="flex items-center gap-3">
                <a href="{{ route('proveedores.index') }}"
                    class="group inline-flex items-center px-8 py-2.5 bg-white dark:bg-slate-800 text-slate-500 border border-slate-200 dark:border-slate-700 rounded-3xl font-black text-[10px] uppercase tracking-widest hover:text-indigo-600 transition-all shadow-sm hover:shadow-md active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver al listado
                </a>


                <a href="{{ route('proveedores.edit', $proveedor) }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar Datos
                </a>

            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Card Principal --}}
            <div class="bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none overflow-hidden">

                {{-- Header de la Ficha --}}
                <div class="relative p-8 md:p-12 bg-slate-50/50 dark:bg-slate-800/30 border-b border-slate-100 dark:border-slate-800">
                    <div class="absolute top-0 right-0 p-12 opacity-10 dark:opacity-20">
                        <svg class="w-32 h-32 text-slate-900 dark:text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" />
                        </svg>
                    </div>

                    <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                        {{-- Avatar con Inicial --}}
                        <div class="w-24 h-24 bg-indigo-600 rounded-[2rem] flex items-center justify-center text-white text-4xl font-black shadow-2xl shadow-indigo-500/40">
                            {{ strtoupper(substr($proveedor->nombre, 0, 1)) }}
                        </div>

                        <div class="text-center md:text-left">
                            <span class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.4em]">Proveedor Verificado</span>
                            <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tighter uppercase italic">{{ $proveedor->nombre }}</h3>
                            <p class="text-slate-400 font-bold text-sm mt-1">ID de Sistema: PRV-{{ str_pad($proveedor->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                </div>

                {{-- Cuerpo de Información --}}
                <div class="p-8 md:p-12 grid grid-cols-1 md:grid-cols-3 gap-12">

                    {{-- Bloque Contacto --}}
                    <div class="space-y-6">
                        <h4 class="text-[10px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-[0.2em] border-b pb-2">Información de Contacto</h4>

                        <div class="flex items-start gap-4">
                            <div class="p-2 bg-emerald-50 dark:bg-emerald-500/10 rounded-lg text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase">Correo Electrónico</p>
                                <p class="text-slate-700 dark:text-slate-200 font-bold">{{ $proveedor->email ?? 'Sin registro' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="p-2 bg-sky-50 dark:bg-sky-500/10 rounded-lg text-sky-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase">Teléfono Móvil</p>
                                <p class="text-slate-700 dark:text-slate-200 font-bold">{{ $proveedor->telefono ?? 'Sin registro' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Bloque Ubicación --}}
                    <div class="space-y-6">
                        <h4 class="text-[10px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-[0.2em] border-b pb-2">Localización</h4>

                        <div class="flex items-start gap-4">
                            <div class="p-2 bg-rose-50 dark:bg-rose-500/10 rounded-lg text-rose-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase">Dirección Fiscal</p>
                                <p class="text-slate-700 dark:text-slate-200 font-bold italic">{{ $proveedor->direccion ?? 'No proporcionada' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Bloque Estadísticas Rápidas --}}
                    <div class="space-y-6">
                        <h4 class="text-[10px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-[0.2em] border-b pb-2">Actividad</h4>
                        <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-3xl border border-dashed border-slate-200 dark:border-slate-700">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-[10px] font-black text-slate-400 uppercase">Registrado:</span>
                                <span class="text-xs font-bold text-slate-600 dark:text-slate-300">{{ $proveedor->created_at->format('d M, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-slate-400 uppercase">Última Actualización:</span>
                                <span class="text-xs font-bold text-slate-600 dark:text-slate-300">{{ $proveedor->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer con Botón Volver --}}
                <div class="p-8 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800 flex justify-center">
                    <a href="{{ route('proveedores.index') }}" class="group flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-indigo-600 transition-all">
                        <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver al Panel General
                    </a>
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