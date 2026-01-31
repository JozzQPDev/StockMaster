<x-app-layout>
     <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-medium uppercase tracking-widest">
                        <li class="inline-flex items-center text-slate-400">
                            <a href="{{ route('customers.index') }}" class="hover:text-indigo-600 transition-colors">Clientes</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-slate-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path>
                                </svg>
                                <span class="text-indigo-600">Etidar</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="font-black text-2xl text-slate-800 dark:text-white leading-tight">
                      {{ $customer->name }}
                </h2>
            </div>

            <div class="flex items-center">
                <a href="{{ route('customers.index') }}"
                    class="group inline-flex items-center px-8 py-4 bg-white dark:bg-slate-800 text-slate-500 border border-slate-200 dark:border-slate-700 rounded-3xl font-black text-[10px] uppercase tracking-widest hover:text-indigo-600 transition-all shadow-sm hover:shadow-md active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-2" x-data="{ 
        name: '{{ $customer->name }}',
        doc: '{{ $customer->document_number }}',
        level: '{{ $customer->level }}'
    }">
        <div class="max-w-5xl mx-auto px-4">
            <div class="grid grid-cols-12 gap-8">

                {{-- COLUMNA IZQUIERDA: Tarjeta de Identidad --}}
                {{-- COLUMNA IZQUIERDA: Tarjeta de Identidad --}}
                <div class="col-span-12 lg:col-span-4 space-y-6">
                    {{-- Eliminamos 'relative' y dejamos solo 'sticky' (que ya maneja el contexto de posición) --}}
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[3rem] p-8 shadow-sm overflow-hidden sticky top-10">

                        {{-- Mantenemos los círculos decorativos, el sticky servirá de contenedor --}}
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-500/5 rounded-full blur-3xl"></div>

                        <div class="relative flex flex-col items-center">
                            <div class="relative group mb-6">
                                <div class="absolute inset-0 bg-indigo-600 rounded-[2rem] blur-xl opacity-20 group-hover:opacity-40 transition-opacity"></div>
                                <div class="relative w-24 h-24 rounded-[2rem] bg-gradient-to-br from-indigo-600 to-violet-700 flex items-center justify-center text-white text-4xl font-black italic shadow-2xl rotate-3 group-hover:rotate-0 transition-transform duration-500">
                                    <span x-text="name.charAt(0)"></span>
                                </div>
                            </div>

                            <h3 class="font-black text-slate-800 dark:text-white uppercase text-xl tracking-tighter italic leading-tight mb-2" x-text="name"></h3>
                            <div class="px-4 py-1 bg-indigo-50 dark:bg-indigo-900/30 rounded-full border border-indigo-100 dark:border-indigo-800">
                                <span class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest italic" x-text="'Socio ' + level"></span>
                            </div>
                        </div>

                        <div class="mt-10 space-y-6 pt-8 border-t border-slate-100 dark:border-slate-800/50">
                            <div class="flex items-center gap-4 group">
                                <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-400 group-hover:text-indigo-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Documento ID</p>
                                    <p class="text-xs font-black text-slate-700 dark:text-slate-200" x-text="doc"></p>
                                </div>
                            </div>
                            {{-- Badge de última edición para llenar el header --}}
                            <div class="hidden md:flex items-center gap-2 px-4 py-1.5 bg-slate-100 dark:bg-slate-800 rounded-full border border-slate-200 dark:border-slate-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400 animate-pulse"></span>
                                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Editado {{ $customer->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Tip box (fuera del sticky para que no se amontonen) --}}
                    <div class="bg-indigo-600 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-xl shadow-indigo-200 dark:shadow-none">
                        <svg class="absolute -right-4 -bottom-4 w-24 h-24 opacity-20 rotate-12" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="relative text-[10px] font-black uppercase tracking-[0.2em] mb-2 opacity-80">Sugerencia</p>
                        <p class="relative text-xs font-bold leading-relaxed italic">Revisa bien los puntos antes de guardar para evitar discrepancias en el historial.</p>
                    </div>
                    
                </div>
               {{-- COLUMNA DERECHA: El Formulario Compacto --}}
<div class="col-span-12 lg:col-span-8">
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[2.5rem] shadow-sm overflow-hidden">
        
        {{-- Cabecera Compacta --}}
        <div class="px-8 py-4 bg-slate-50/50 dark:bg-slate-800/30 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
            <h4 class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em] italic">
                Formulario de Edición
            </h4>
            <span class="text-[9px] font-bold px-3 py-1 bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 rounded-full uppercase">
                Campos Requeridos
            </span>
        </div>

        <form action="{{ route('customers.update', $customer) }}" method="POST" class="p-8 space-y-6">
            @csrf @method('PATCH')

            {{-- Bloque 1: Información Personal --}}
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div class="md:col-span-4 space-y-1.5">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Nombre Completo</label>
                    <div class="relative group">
                        <input type="text" name="name" x-model="name" required
                            class="w-full bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 focus:ring-0 rounded-xl py-3 px-4 font-bold text-sm transition-all dark:text-white">
                    </div>
                </div>
                <div class="md:col-span-2 space-y-1.5">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Categoría</label>
                    <select name="level" x-model="level" 
                        class="w-full bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 focus:ring-0 rounded-xl py-3 px-4 font-bold text-sm transition-all dark:text-white appearance-none cursor-pointer">
                        <option value="REGULAR">Regular</option>
                        <option value="VIP">VIP</option>
                    </select>
                </div>
            </div>

            {{-- Bloque 2: Documentación y Contacto --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-1.5">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">DNI / RUC</label>
                    <input type="text" name="document_number" x-model="doc" required
                        class="w-full bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 focus:ring-0 rounded-xl py-3 px-4 font-bold text-sm transition-all dark:text-white">
                </div>
                <div class="space-y-1.5 md:col-span-2">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Correo Electrónico</label>
                    <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                        class="w-full bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 focus:ring-0 rounded-xl py-3 px-4 font-bold text-sm transition-all dark:text-white">
                </div>
            </div>

            {{-- Bloque 3: Teléfono y Otros --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">WhatsApp / Teléfono</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-emerald-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                        </span>
                        <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                            class="w-full bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 focus:ring-0 rounded-xl py-3 pl-10 pr-4 font-bold text-sm transition-all dark:text-white">
                    </div>
                </div>
                <div class="flex items-end pb-1">
                    <p class="text-[10px] text-slate-400 italic leading-tight">
                        * Los cambios realizados se reflejarán inmediatamente en el panel de control.
                    </p>
                </div>
            </div>

            {{-- Footer de Acciones Compacto --}}
            <div class="pt-6 mt-4 border-t border-slate-100 dark:border-slate-800 flex gap-3">
                <button type="submit"
                    class="flex-1 py-4 bg-indigo-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all active:scale-95 shadow-lg shadow-indigo-200 dark:shadow-none">
                    Guardar Cambios
                </button>
                <a href="{{ route('customers.show', $customer) }}"
                    class="px-8 py-4 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 dark:hover:bg-slate-700 transition-all">
                    Volver
                </a>
            </div>
        </form>
    </div>
</div>
            </div>
        </div>
    </div>
</x-app-layout>