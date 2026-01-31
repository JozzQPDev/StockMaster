<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between gap-4 px-2 no-print">
            {{-- Título y Contador Móvil --}}
            <div>
                <h2 class="font-black text-2xl text-slate-800 dark:text-white flex items-center">
                    Gestion de<span class="text-indigo-600 ml-1">CLientes</span>
                    {{-- El punto parpadeante --}}
                    <span class="relative flex h-2 w-2 ml-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                </h2>
            </div>

            {{-- Buscador y Acción --}}
            <div class="flex items-center gap-3">
                <form action="{{ route('customers.index') }}" method="GET" class="relative group flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por DNI o nombre..."
                        class="block w-full md:w-64 pl-9 pr-4 py-2.5 bg-white dark:bg-slate-800 border-none rounded-2xl text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 transition-all text-slate-600 dark:text-slate-300">
                </form>

                {{-- Botón que ahora redirige a una página independiente --}}
                <a href="{{ route('customers.create') }}"
                    class="inline-flex justify-center items-center px-6 py-2.5 bg-indigo-600 rounded-2xl font-black text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-lg active:scale-95 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                    Agergar
                </a>
            </div>
        </div>
    </x-slot>

    {{-- CONTENEDOR PRINCIPAL CON X-DATA UNIFICADO --}}
    <div class="py-10" x-data="{ 
        openEdit: false, 
        openView: false, 
        openDelete: false, 
        customerId: null,
        customerName: '',
        customer: {},
        emailValid: true,
        validateEmail(email) {
            if (!email) return true;
            return /^[^@]+@[^@]+\.[^@]+$/.test(email);
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- GRID DE TARJETAS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($customers as $customer)
                <div class="group relative bg-white dark:bg-slate-900 rounded-[2.5rem] p-6 shadow-xl shadow-slate-200/60 dark:shadow-none border border-slate-100 dark:border-slate-800 transition-all hover:scale-[1.03] hover:shadow-2xl overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-50 dark:bg-indigo-500/5 rounded-full transition-transform group-hover:scale-150"></div>

                    <div class="relative">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-xl text-white font-black italic shadow-lg shadow-indigo-200">
                                {{ substr($customer->name, 0, 1) }}
                            </div>
                            <span class="px-3 py-1 rounded-xl text-[9px] font-black uppercase tracking-tighter italic border {{ $customer->level == 'VIP' ? 'bg-amber-50 text-amber-600 border-amber-200' : 'bg-slate-50 text-slate-500 border-slate-200' }}">
                                {{ $customer->level }}
                            </span>
                        </div>

                        <h3 class="font-black text-slate-800 dark:text-white text-lg italic leading-tight mb-1 truncate">{{ $customer->name }}</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">{{ $customer->document_number }}</p>

                        <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-4 flex justify-between items-center mb-6 border border-slate-100 dark:border-slate-700/50">
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase leading-none">Puntos</p>
                                <p class="text-xl font-black text-indigo-600 italic mt-1">{{ number_format($customer->points) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[9px] font-black text-slate-400 uppercase leading-none">Saldo</p>
                                <p class="text-sm font-black text-emerald-500 italic mt-1">S/ {{ number_format($customer->points / 100, 2) }}</p>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('customers.show', $customer) }}" class="flex-1 py-3 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-xl font-black text-[10px] uppercase text-center hover:bg-cyan-500 hover:text-white transition-all">Detalles</a>

                            <a href="{{ route('customers.edit', $customer) }}" class="p-3 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-slate-400 rounded-xl hover:text-indigo-600 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <path d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>

                            <button @click="openDelete = true; customerId = {{ $customer->id }}; customerName = '{{ $customer->name }}'"
                                class="p-3 bg-rose-50 dark:bg-rose-500/10 text-rose-500 rounded-xl hover:bg-rose-500 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center">
                    <p class="font-black text-slate-300 text-4xl uppercase italic tracking-tighter opacity-50">No hay clientes registrados</p>
                </div>
                @endforelse
            </div>

            <div class="mt-12">{{ $customers->appends(request()->query())->links() }}</div>
        </div>

        {{-- MODAL: CONFIRMAR ELIMINACIÓN --}}
        <div x-show="openDelete" x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="fixed inset-0 z-[120] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm" @click="openDelete = false"></div>

            <div class="relative bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-3xl max-w-sm w-full p-8 text-center border border-slate-100 dark:border-slate-800">
                <div class="mx-auto w-20 h-20 bg-rose-50 dark:bg-rose-500/10 rounded-3xl flex items-center justify-center text-rose-500 mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-xl font-black text-slate-800 dark:text-white uppercase italic">¿Eliminar <span class="text-rose-600">Cliente</span>?</h3>
                <p class="text-xs font-bold text-slate-400 mt-3">Estás a punto de eliminar a <span class="text-slate-700 dark:text-slate-200" x-text="customerName"></span>. Esta acción no se puede deshacer.</p>

                {{-- FORMULARIO DINÁMICO --}}
                <form :action="'/customers/' + customerId" method="POST" class="mt-8 flex gap-3">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="openDelete = false" class="flex-1 py-4 bg-slate-100 dark:bg-slate-800 text-slate-500 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-all">Cancelar</button>
                    <button type="submit" class="flex-1 py-4 bg-rose-500 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg hover:bg-rose-600 transition-all transform active:scale-95">Sí, Eliminar</button>
                </form>
            </div>
        </div>
</x-app-layout>