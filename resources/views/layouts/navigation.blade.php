<nav x-data="{ open: false }" class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                        <div class="p-2 bg-indigo-600 rounded-xl shadow-lg shadow-indigo-200 dark:shadow-none group-hover:rotate-12 transition-transform">
                            <x-application-logo class="block h-6 w-auto fill-current text-white" />
                        </div>
                        <span class="font-black text-xl tracking-tighter text-slate-800 dark:text-white uppercase italic">Stock<span class="text-indigo-600">Master</span></span>
                    </a>
                </div>

                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="px-4 py-2 rounded-xl transition-all duration-200 font-bold text-xs uppercase tracking-widest">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*')"
                        class="px-4 py-2 rounded-xl transition-all duration-200 font-bold text-xs uppercase tracking-widest">
                        {{ __('Categorías') }}
                    </x-nav-link>

                    <x-nav-link :href="route('proveedores.index')" :active="request()->routeIs('proveedores.*')"
                        class="px-4 py-2 rounded-xl transition-all duration-200 font-bold text-xs uppercase tracking-widest">
                        {{ __('Proveedores') }}
                    </x-nav-link>

                    <x-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')"
                        class="px-4 py-2 rounded-xl transition-all duration-200 font-bold text-xs uppercase tracking-widest">
                        {{ __('Productos') }}
                    </x-nav-link>

                    <x-nav-link :href="route('ventas.index')" :active="request()->routeIs('ventas.*')"
                        class="px-4 py-2 rounded-xl transition-all duration-200 font-bold text-xs uppercase tracking-widest text-indigo-600">
                        {{ __('Ventas') }}
                    </x-nav-link>

                    {{-- Dentro del div de links ocultos en móvil (hidden space-x-4...) --}}
                    <x-nav-link :href="route('movimientos.index')" :active="request()->routeIs('movimientos.*')"
                        class="px-4 py-2 rounded-xl transition-all duration-200 font-bold text-xs uppercase tracking-widest">
                        {{ __('Movimientos') }}
                    </x-nav-link>

                    <div class="pt-6 pb-2 px-4 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">
                        Sistema
                    </div>

                    <x-sidebar-link :href="route('settings.index')" :active="request()->routeIs('settings.*')" icon="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                        Configuración
                    </x-sidebar-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">

                <a href="{{ route('ventas.create') }}"
                    class="flex items-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl transition-all shadow-lg shadow-emerald-200 dark:shadow-none group border-none">
                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="text-[10px] font-black uppercase tracking-tighter italic">Vender Ahora</span>
                </a>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-slate-100 dark:border-slate-700 text-sm leading-4 font-bold rounded-xl text-slate-600 dark:text-slate-300 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none transition-all duration-150">
                            <div class="flex items-center gap-2">
                                <div class="h-6 w-6 rounded-full bg-indigo-500 flex items-center justify-center text-[10px] text-white font-black uppercase">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="truncate max-w-[100px]">{{ Auth::user()->name }}</div>
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="p-2">
                            <x-dropdown-link :href="route('profile.edit')" class="rounded-lg font-bold text-xs uppercase tracking-widest flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('Mi Perfil') }}
                            </x-dropdown-link>

                            <hr class="my-2 border-slate-100 dark:border-slate-700">

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    class="rounded-lg font-bold text-xs uppercase tracking-widest text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors flex items-center gap-2"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Cerrar sesión') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 dark:text-slate-500 hover:text-indigo-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-2xl">
        <div class="pt-2 pb-3 space-y-1 p-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="rounded-xl font-bold">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('ventas.create')" class="rounded-xl font-black text-emerald-500 italic bg-emerald-50 dark:bg-emerald-500/10">
                {{ __('+ NUEVA VENTA') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*')" class="rounded-xl font-bold">
                {{ __('Categorías') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')" class="rounded-xl font-bold">
                {{ __('Productos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('ventas.index')" :active="request()->routeIs('ventas.*')" class="rounded-xl font-bold">
                {{ __('Historial Ventas') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 p-4">
            <div class="flex items-center px-4">
                <div class="shrink-0">
                    <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-black italic">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
                <div class="ms-3">
                    <div class="font-bold text-base text-slate-800 dark:text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-xl">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        class="rounded-xl text-rose-500"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Cerrar sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>