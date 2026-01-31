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
                                <span class="text-indigo-600">Detalle</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="font-black text-2xl text-slate-800 dark:text-white leading-tight">
                    {{ $customer->name }}
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('customers.index') }}"
                    class="group inline-flex items-center px-8 py-2.5 bg-white dark:bg-slate-800 text-slate-500 border border-slate-200 dark:border-slate-700 rounded-3xl font-black text-[10px] uppercase tracking-widest hover:text-indigo-600 transition-all shadow-sm hover:shadow-md active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver
                </a>
                <a href="{{ route('customers.edit', $customer) }}"
                    class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar Perfil
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-2" x-data="{ openAdjust: false }">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-12 gap-6">

                {{-- COLUMNA IZQUIERDA --}}
                <div class="col-span-12 lg:col-span-4 space-y-6">
                    {{-- Card de Usuario --}}
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[2.5rem] p-8 shadow-sm relative overflow-hidden">
                        <div class="absolute -top-12 -left-12 w-32 h-32 bg-indigo-500/5 rounded-full blur-3xl"></div>

                        <div class="relative flex flex-col items-center text-center">
                            <div class="relative group">
                                <div class="absolute inset-0 bg-indigo-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition-opacity"></div>
                                <div class="relative w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white text-3xl font-black italic shadow-2xl mb-4 rotate-3 group-hover:rotate-0 transition-transform duration-500">
                                    {{ substr($customer->name, 0, 1) }}
                                </div>
                            </div>

                            <h3 class="font-black text-slate-800 dark:text-white leading-tight uppercase text-lg tracking-tighter italic">{{ $customer->name }}</h3>
                            <div class="mt-2 inline-flex items-center px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 rounded-full border border-indigo-100 dark:border-indigo-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse mr-2"></span>
                                <span class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">Socio {{ $customer->level ?? 'Standard' }}</span>
                            </div>
                        </div>

                        <div class="mt-8 space-y-4 pt-6 border-t border-slate-100 dark:border-slate-800/50">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Documento</span>
                                <span class="text-xs font-black text-slate-700 dark:text-slate-200 bg-slate-50 dark:bg-slate-800 px-2 py-1 rounded-md">{{ $customer->document_number }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Desde</span>
                                <span class="text-xs font-black text-slate-700 dark:text-slate-200">{{ $customer->created_at->format('d M, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Datos de Contacto --}}
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[2rem] p-6 shadow-sm">
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-5 ml-2">Contacto Directo</h4>
                        <div class="space-y-3">
                            {{-- Email --}}
                            <div class="flex items-center gap-4 p-3 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 group-hover:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Email</p>
                                    <p class="text-xs font-bold text-slate-700 dark:text-slate-200 truncate">{{ $customer->email ?? 'Sin correo' }}</p>
                                </div>
                            </div>
                            {{-- Teléfono --}}
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer->phone) }}" target="_blank"
                                class="flex items-center gap-4 p-3 rounded-2xl hover:bg-emerald-50 dark:hover:bg-emerald-500/10 transition-colors group">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 group-hover:text-emerald-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Teléfono / WA</p>
                                    <p class="text-xs font-bold text-slate-700 dark:text-slate-200">{{ $customer->phone ?? 'Sin número' }}</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    {{-- Acciones Rápidas --}}
                    <div class="grid grid-cols-1 gap-3">
                        <button @click="openAdjust = true"
                            class="flex items-center justify-between p-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl transition-all duration-300 group shadow-lg shadow-indigo-200 dark:shadow-none">
                            <span class="text-xs font-black uppercase tracking-[0.15em] italic">Ajustar Saldo</span>
                            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- COLUMNA DERECHA --}}
                <div class="col-span-12 lg:col-span-8 space-y-6">
                    {{-- Stats Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-slate-900 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-2xl group">
                            <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform duration-700 text-indigo-500">
                                <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                            </div>
                            <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mb-4">Puntos Acumulados</p>
                            <div class="flex items-end gap-3">
                                <span class="text-6xl font-black italic tracking-tighter">{{ number_format($customer->points) }}</span>
                                <span class="text-indigo-400 font-black text-sm uppercase italic mb-2 tracking-widest">pts</span>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[2rem] p-8 shadow-sm flex flex-col justify-between">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Valor en Efectivo</p>
                            <div class="flex justify-between items-end">
                                <p class="text-5xl font-black italic text-slate-800 dark:text-white tracking-tighter">
                                    {{-- CORRECCIÓN AQUÍ: Se eliminó el conflicto italic/not-italic --}}
                                    <span class="text-2xl text-indigo-600 mr-1 not-italic">S/</span>{{ number_format($customer->points / 100, 2) }}
                                </p>
                                <span class="px-3 py-1.5 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl text-[10px] font-black uppercase tracking-wider border border-emerald-500/20 italic">Cashback</span>
                            </div>
                        </div>
                    </div>

                    {{-- Historial de Actividad --}}
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[2.5rem] shadow-sm overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-50 dark:border-slate-800/50 flex justify-between items-center">
                            <h4 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-widest italic flex items-center gap-3">
                                <div class="w-2 h-6 bg-indigo-600 rounded-full"></div>
                                Últimos Movimientos
                            </h4>
                            <button class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest hover:underline">Ver Todo</button>
                        </div>

                        <div class="p-0 overflow-x-auto">
                            <table class="w-full text-left min-w-[400px]">
                                <tbody class="divide-y divide-slate-50 dark:divide-slate-800/50">
                                    @php
                                    $transactions = method_exists($customer, 'transactions') ? $customer->transactions()->latest()->take(5)->get() : collect([]);
                                    @endphp

                                    @forelse($transactions as $transaction)
                                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all duration-300">
                                        <td class="px-8 py-5">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-xl {{ $transaction->amount > 0 ? 'bg-emerald-500/10 text-emerald-600' : 'bg-rose-500/10 text-rose-600' }} flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $transaction->amount > 0 ? 'M12 4v16m8-8H4' : 'M20 12H4' }}" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-black text-slate-700 dark:text-slate-200 uppercase tracking-tighter italic">{{ $transaction->reason }}</p>
                                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $transaction->created_at->format('d M, Y · H:i') }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5 text-right font-black italic">
                                            <span class="{{ $transaction->amount > 0 ? 'text-emerald-500' : 'text-rose-500' }} text-base">
                                                {{ $transaction->amount > 0 ? '+' : '' }}{{ number_format($transaction->amount) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2" class="px-8 py-16 text-center">
                                            <div class="flex flex-col items-center justify-center opacity-30 grayscale">
                                                <svg class="w-12 h-12 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-width="1.5" />
                                                </svg>
                                                <p class="text-xs font-black uppercase tracking-widest">Sin actividad registrada</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL AJUSTE --}}
        <div x-show="openAdjust" x-transition:enter="duration-300 ease-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm" @click="openAdjust = false"></div>
            <div class="relative bg-white dark:bg-slate-900 rounded-[3rem] p-10 max-w-sm w-full shadow-2xl border border-slate-200 dark:border-slate-800">
                <form action="{{ route('customers.adjustPoints', $customer) }}" method="POST">
                    @csrf
                    <div class="text-center mb-8">
                        <div class="inline-flex p-4 bg-indigo-600 text-white rounded-2xl shadow-xl shadow-indigo-200 dark:shadow-none mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-white uppercase italic tracking-tighter">Ajustar <span class="text-indigo-600">Puntos</span></h3>
                    </div>

                    <div class="space-y-4">
                        <div class="group">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 mb-1 block">Cantidad (pts)</label>
                            <input type="number" name="amount" required placeholder="0" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent focus:border-indigo-500 focus:ring-0 rounded-2xl py-4 px-6 text-center text-2xl font-black transition-all dark:text-white">
                        </div>
                        <div class="group">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 mb-1 block">Motivo</label>
                            <input type="text" name="reason" required placeholder="Ej. Bono especial" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent focus:border-indigo-500 focus:ring-0 rounded-2xl py-4 px-6 text-center text-xs font-bold transition-all dark:text-white">
                        </div>
                    </div>

                    <div class="mt-10 flex flex-col gap-3">
                        <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-lg active:scale-95 transition-all">Confirmar Operación</button>
                        <button type="button" @click="openAdjust = false" class="w-full py-2 text-[10px] font-black text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 uppercase tracking-widest transition-colors">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>