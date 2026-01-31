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
                                <span class="text-indigo-600">Agregar</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="font-black text-2xl text-slate-800 dark:text-white leading-tight">
                    Crear <span class="text-indigo-600">Registro</span>
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

    <div class="py-2">
        <div class="max-w-3xl mx-auto px-4">
            <div class="bg-white dark:bg-slate-900 rounded-[3rem] p-8 md:p-12 shadow-2xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800">

                <div class="mb-10 text-center">
                    <span class="bg-indigo-600 text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-[0.2em]">Membresía Nueva</span>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white uppercase italic tracking-tighter mt-4">Datos del <span class="text-indigo-600">Socio</span></h3>
                </div>

                <form action="{{ route('customers.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Identificación --}}
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase ml-4 tracking-widest">Identificación</label>
                            <div class="flex gap-2 p-1 bg-slate-50 dark:bg-slate-800 rounded-2xl border transition-all focus-within:ring-2 focus-within:ring-indigo-500 
                              {{ $errors->has('document_number') ? 'border-rose-500' : 'border-slate-100 dark:border-slate-700' }}">
                                <select name="document_type" class="bg-white dark:bg-slate-700 border-none rounded-xl font-black text-[10px] uppercase py-2 focus:ring-0">
                                    <option value="DNI" {{ old('document_type') == 'DNI' ? 'selected' : '' }}>DNI</option>
                                    <option value="RUC" {{ old('document_type') == 'RUC' ? 'selected' : '' }}>RUC</option>
                                </select>
                                <input type="text" name="document_number" value="{{ old('document_number') }}" placeholder="00000000" required
                                    class="flex-1 bg-transparent border-none font-bold text-sm focus:ring-0 text-slate-700 dark:text-slate-200">
                            </div>
                            @error('document_number') <p class="text-[10px] font-bold text-rose-500 ml-4 uppercase">{{ $message }}</p> @enderror
                        </div>

                        {{-- Nivel --}}
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase ml-4 tracking-widest">Nivel Inicial</label>
                            <select name="level" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 px-5 font-bold text-sm focus:ring-2 focus:ring-indigo-500">
                                <option value="REGULAR" {{ old('level') == 'REGULAR' ? 'selected' : '' }}>REGULAR</option>
                                <option value="VIP" {{ old('level') == 'VIP' ? 'selected' : '' }}>VIP</option>
                            </select>
                        </div>
                    </div>

                    {{-- Nombre --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase ml-4 tracking-widest">Nombre Completo</label>
                        {{-- Reemplaza el input de nombre con esto --}}
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ej. Juan Pérez"
                            class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 px-5 font-bold text-sm focus:ring-2 focus:ring-indigo-500 
                                                        {{ $errors->has('name') ? 'ring-2 ring-rose-500' : '' }}">
                        @error('name') <p class="text-[10px] font-bold text-rose-500 ml-4 uppercase">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Teléfono --}}
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase ml-4 tracking-widest">Teléfono / Móvil</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="999 999 999"
                                class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 px-5 font-bold text-sm focus:ring-2 focus:ring-indigo-500">
                        </div>
                        {{-- Email --}}
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase ml-4 tracking-widest">Correo Electrónico</label>
                            {{-- Reemplaza el input de email con esto --}}
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="cliente@correo.com"
                                class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 px-5 font-bold text-sm focus:ring-2 focus:ring-indigo-500 
                                            {{ $errors->has('email') ? 'ring-2 ring-rose-500' : '' }}">
                            @error('email') <p class="text-[10px] font-bold text-rose-500 ml-4 uppercase">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="pt-8">
                        <button type="submit" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-[2rem] font-black text-sm uppercase tracking-[0.2em] shadow-xl shadow-indigo-200 dark:shadow-none transition-all transform active:scale-95">
                            Registrar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>