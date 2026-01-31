<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'StockMaster') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/images/icon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/images/icon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/images/icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased h-full bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100">

    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-slate-900 border-r border-slate-100 dark:border-slate-800 transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0 flex-shrink-0">

            <div class="flex flex-col h-full">
                <div class="h-24 flex items-center px-8 border-b border-slate-50 dark:border-slate-800/50">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        {{-- Contenedor del Icono --}}
                        <div class="p-2 bg-indigo-600 rounded-xl shadow-lg shadow-indigo-200 dark:shadow-none transition-transform group-hover:rotate-12">
                            <x-application-logo class="h-6 w-6 fill-current text-white" />
                        </div>

                        {{-- Bloque de Texto: Nombre + Slogan alineados --}}
                        <div class="flex flex-col justify-center">
                            <span class="font-black text-xl tracking-tighter uppercase italic text-slate-800 dark:text-white leading-[0.8]">
                                Stock<span class="text-indigo-600">Master</span>
                            </span>
                            <p class="text-[8px] font-bold text-slate-400 uppercase tracking-[0.1em] mt-1 opacity-70">
                                Monitoreo de inventario <br> en tiempo real
                            </p>
                        </div>
                    </a>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        Dashboard
                    </x-sidebar-link>

                    <div class="pt-6 pb-2 px-4 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">
                        Operaciones
                    </div>

                    <x-sidebar-link :href="route('ventas.create')" :active="request()->routeIs('ventas.create')" icon="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                        <span class="text-emerald-500 font-black">Vender Ahora</span>
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('ventas.index')" :active="request()->routeIs('ventas.index')" icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        Historial de Ventas
                    </x-sidebar-link>

                    <div class="pt-6 pb-2 px-4 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">
                        Fidelización
                    </div>

                    <x-sidebar-link :href="route('customers.index')" :active="request()->routeIs('customers.*')" icon="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                        <div class="flex items-center justify-between w-full">
                            <span>Clientes y Puntos</span>
                            <span class="bg-indigo-600/20 text-indigo-400 text-[8px] px-2 py-0.5 rounded-full font-black uppercase tracking-tighter">VIP</span>
                        </div>
                    </x-sidebar-link>

                    <div class="pt-6 pb-2 px-4 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">
                        Gestión de Stock
                    </div>

                    <x-sidebar-link :href="route('productos.index')" :active="request()->routeIs('productos.*')" icon="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                        Productos
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*')" icon="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                        Categorías
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('proveedores.index')" :active="request()->routeIs('proveedores.*')"
                        icon="M3 5h10v11H3V5z M13 8h4l3 3v5h-7V8z M6.5 16.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z M16.5 16.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z">
                        Proveedores
                    </x-sidebar-link>

                    <div class="pt-6 pb-2 px-4 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">
                        Auditoría
                    </div>

                    <x-sidebar-link :href="route('movimientos.index')" :active="request()->routeIs('movimientos.*')" icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                        Movimientos
                    </x-sidebar-link>                    
                </nav>

                <div class="p-4 border-t border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20">
                    <div class="flex items-center gap-3 px-4 py-3 mb-2">
                        <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-black text-xs">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs font-black text-slate-700 dark:text-slate-200 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-rose-500 font-bold text-[11px] uppercase tracking-widest hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-xl transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                            </svg>
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <header class="h-20 bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between px-4 sm:px-8">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    @isset($header)
                    <div class="hidden lg:block">
                        {{ $header }}
                    </div>
                    @endisset
                </div>

                <div class="flex items-center gap-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">


                    <div class="flex items-center gap-6">
                        <div class="hidden md:flex flex-col text-right">
                            <span class="hidden md:inline">{{ now()->translatedFormat('l, d F Y') }}</span>
                            <span class="text-[9px] font-bold text-indigo-500 uppercase mt-1">{{ now()->format('H:i') }}</span>
                        </div>

                        <div x-data="{ open: false }" @click.away="open = false" class="relative">
                            <button @click="open = !open" class="p-2.5 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all text-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <circle cx="12" cy="12" r="3" stroke-width="2" />
                                </svg>
                            </button>
                            <div x-show="open" x-cloak x-transition class="absolute right-0 mt-3 w-56 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl shadow-2xl z-50 overflow-hidden py-2">
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800">Mi Perfil</a>
                                <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 border-t border-slate-50 dark:border-slate-800">Ajustes</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            @isset($header)
            <div class="lg:hidden bg-white dark:bg-slate-900 px-8 py-4 border-b border-slate-100 dark:border-slate-800">
                {{ $header }}
            </div>
            @endisset

            <main class="flex-1 overflow-y-auto p-4 sm:p-8">
                {{ $slot }}
            </main>
        </div>

        <div x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden">
        </div>
    </div>

    {{-- Notificaciones Flotantes --}}
    @php
    $message = session('success') ?? session('error') ?? session('status');
    $type = session('success') ? 'success' : (session('error') ? 'error' : 'info');
    @endphp

    @if ($message)
    <div x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 4000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-4"
        class="fixed bottom-8 right-8 z-[100]">

        <div class="{{ $type === 'error' ? 'bg-rose-600' : 'bg-slate-900 dark:bg-indigo-600' }} text-white px-6 py-4 rounded-[1.5rem] shadow-2xl flex items-center gap-4 border border-white/10">
            <div class="{{ $type === 'error' ? 'bg-white/20' : 'bg-green-500' }} rounded-full p-1.5 shadow-sm">
                @if($type === 'error')
                <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                </svg>
                @else
                <svg class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                @endif
            </div>
            <span class="font-bold tracking-tight text-sm">{{ $message }}</span>
            <button @click="show = false" class="text-white/50 hover:text-white transition-colors">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    @endif

</body>

</html>