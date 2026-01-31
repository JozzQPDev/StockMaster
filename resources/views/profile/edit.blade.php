<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="font-black text-2xl text-slate-800 dark:text-white leading-tight tracking-tight">
                Configuración de <span class="text-indigo-600 italic">Perfil</span>
            </h2>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">
                Panel de control de identidad y seguridad
            </p>
        </div>
    </x-slot>

    <div class="pt-4 pb-12">
        <div class="max-w-10xl mx-auto sm:px-4 lg:px-2 space-y-8">

            {{-- 1. TARJETA DE RESUMEN DE USUARIO (NUEVO) --}}
            <div class="bg-indigo-600 dark:bg-indigo-900 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-indigo-200 dark:shadow-none relative overflow-hidden flex flex-col md:flex-row items-center gap-8">
                <div class="absolute right-0 top-0 opacity-10 translate-x-10 -translate-y-10">
                    <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                </div>

                <div class="relative z-10">
                    <div class="h-24 w-24 rounded-3xl bg-white/20 backdrop-blur-md border-2 border-white/30 flex items-center justify-center text-4xl font-black shadow-inner overflow-hidden">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="h-full w-full object-cover">
                        @else
                            {{ substr(Auth::user()->name, 0, 1) }}
                        @endif
                    </div>
                </div>

                <div class="relative z-10 flex-1 text-center md:text-left">
                    <h1 class="text-4xl font-black tracking-tighter leading-none mb-2">
                        {{ Auth::user()->name }}
                    </h1>

                    <div class="flex flex-wrap justify-center md:justify-start gap-3 items-center">
                        <span class="flex items-center gap-1.5 bg-white/10 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-white/10">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            {{ Auth::user()->email }}
                        </span>

                        <span class="bg-indigo-400/20 text-indigo-100 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-indigo-400/20">
                            Miembro desde {{ Auth::user()->created_at->format('M Y') }}
                        </span>
                    </div>

                    <div class="flex flex-wrap justify-center md:justify-start gap-2 mt-4">
                        <span class="flex items-center gap-1.5 {{ Auth::user()->role === 'admin' ? 'bg-amber-400 text-amber-950' : 'bg-white text-indigo-900' }} px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-tight shadow-lg">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            {{ Auth::user()->role ?? 'Vendedor' }}
                        </span>

                        <span class="flex items-center gap-1.5 bg-emerald-400/20 text-emerald-300 px-2.5 py-1 rounded-lg text-[9px] font-black uppercase border border-emerald-400/30">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            En línea
                        </span>

                        <span class="bg-slate-900/40 text-slate-300 px-2.5 py-1 rounded-lg text-[9px] font-black border border-white/5">
                            ID: #{{ str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT) }}
                        </span>

                        @if(Auth::user()->phone)
                        <span class="flex items-center gap-1.5 bg-slate-900/40 text-slate-300 px-2.5 py-1 rounded-lg text-[9px] font-black border border-white/5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            {{ Auth::user()->phone }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- GRID DE CONFIGURACIÓN --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- Sección: Información del Perfil --}}
                <div class="p-8 bg-white dark:bg-slate-900 shadow-sm border border-slate-100 dark:border-slate-800 rounded-[2.5rem] flex flex-col h-full">
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-slate-100 dark:bg-slate-800 rounded-lg text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white uppercase tracking-tighter italic">Datos Personales</h3>
                        </div>
                        <p class="text-xs text-slate-500">Cambia la información pública de tu cuenta.</p>
                    </div>
                    @include('profile.partials.update-profile-information-form')
                </div>

                {{-- Sección: Actualizar Contraseña --}}
                <div class="p-8 bg-white dark:bg-slate-900 shadow-sm border border-slate-100 dark:border-slate-800 rounded-[2.5rem] flex flex-col h-full">
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-slate-100 dark:bg-slate-800 rounded-lg text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white uppercase tracking-tighter italic">Seguridad</h3>
                        </div>
                        <p class="text-xs text-slate-500">Recomendamos usar una contraseña de al menos 12 caracteres.</p>
                    </div>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Sección: Eliminar Cuenta --}}
            <div class="p-8 bg-rose-50/30 dark:bg-rose-950/10 border border-rose-100 dark:border-rose-900/30 rounded-[2.5rem]">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div class="max-w-xl">
                        <h3 class="text-lg font-bold text-rose-600 uppercase tracking-tighter italic">Zona de Peligro</h3>
                        <p class="text-sm text-slate-500 mt-1">Si decides borrar tu cuenta, no podrás recuperar la información de tus ventas e inventarios.</p>
                    </div>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>

    {{-- PIE DE PÁGINA --}}
    <div class="mt-4 mb-12 text-center">
        <p class="text-slate-400 dark:text-slate-500 text-[10px] font-black uppercase tracking-[0.4em]">
            StockMaster Cloud POS • {{ now()->year }}
        </p>
    </div>
</x-app-layout>