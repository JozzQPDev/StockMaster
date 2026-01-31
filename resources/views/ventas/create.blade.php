<x-app-layout>
    <style>
        /* Estilos de paginación y UI */
        .pagination-indigo nav span[aria-current="page"] span {
            background-color: #4f46e5 !important;
            border-color: #4f46e5 !important;
            border-radius: 12px;
        }

        /* Corrección para impresión y visualización */
        @media print {

            .no-print,
            nav,
            header,
            aside,
            .pb-12,
            button {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .bg-slate-900 {
                background-color: #0f172a !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        /* Scrollbar estética para el carrito en móviles */
        .custom-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        /* Modal states to avoid CSS conflicts */
        .modal-closed {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            display: none;
        }

        .modal-visible {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="px-2 font-black text-2xl text-slate-800 dark:text-white flex items-center tracking-tighter">
                Punto de<span class="text-indigo-600 ml-1">Venta</span>
                <span class="relative flex h-2 w-2 ml-4">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
            </h2>
            <div class="flex items-center gap-1 text-[10px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-800 px-4 py-2 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                <div class="p-1.5 bg-indigo-50 dark:bg-indigo-500/10 rounded-lg">
                    <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <span> {{ auth()->user()->name }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-2 bg-slate-50/50 dark:bg-slate-950 min-h-screen relative" x-data="posSystem()">

        {{-- NOTIFICACIONES FLOTANTES --}}
        <div class="fixed top-14 right-8 z-[100] flex flex-col gap-3 w-80">
            <template x-for="note in notifications" :key="note.id">
                <div
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-12"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    class="p-4 rounded-2xl shadow-2xl flex items-start gap-4 border-l-4"
                    :class="{
                        'border-rose-500 bg-rose-50 dark:bg-rose-500/10 text-rose-500': note.type === 'error',
                        'border-amber-500 bg-amber-50 dark:bg-amber-500/10 text-amber-500': note.type === 'warning',
                        'border-emerald-500 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-500': note.type === 'info'
                    }">
                    <div class="p-2 rounded-xl flex items-center justify-center" :class="{
                        'bg-rose-100 dark:bg-rose-500/20': note.type === 'error',
                        'bg-amber-100 dark:bg-amber-500/20': note.type === 'warning',
                        'bg-emerald-100 dark:bg-emerald-500/20': note.type === 'info'
                    }">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400" x-text="note.title"></h4>
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-200" x-text="note.message"></p>
                    </div>
                </div>
            </template>
        </div>

        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-2">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                {{-- COLUMNA IZQUIERDA: PRODUCTOS Y TABLA --}}
                <div class="lg:col-span-8 space-y-6">

                    {{-- Buscador Premium --}}
                    <div class="bg-white dark:bg-slate-900 p-4 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm"
                        x-data="{
                            search: '',
                            products: {{ $productos->map(fn($p) => [
                                'id' => $p->id,
                                'nombre' => $p->nombre,
                                'precio' => (float)$p->precio_venta,
                                'stock' => $p->stock_actual,
                                'search_key' => strtolower($p->nombre . ' ' . $p->id)
                            ])->toJson() }},
                            get filteredProducts() {
                                return this.search === '' ? [] : this.products.filter(p => p.search_key.includes(this.search.toLowerCase())).slice(0, 5);
                            }
                        }">

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 transition-colors"
                                    :class="search.length > 0 ? 'text-indigo-500' : 'text-slate-400'"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>

                            <input
                                type="text"
                                x-model="search"
                                @keydown.escape="search = ''"
                                placeholder="Escribe el nombre o escanea código..."
                                class="block w-full pl-14 pr-20 py-4 bg-slate-50 dark:bg-slate-800 border-transparent focus:border-indigo-500 focus:ring-0 rounded-2xl font-bold text-slate-600 dark:text-slate-300 transition-all">

                            {{-- Resultados en tiempo real --}}
                            <div x-show="filteredProducts.length > 0"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                class="absolute z-[110] w-full mt-2 bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden">

                                <template x-for="product in filteredProducts" :key="product.id">
                                    <button
                                        @click="addProduct(product); search = ''"
                                        class="w-full flex items-center justify-between px-6 py-4 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 transition-colors border-b border-slate-50 dark:border-slate-800 last:border-none text-left">
                                        <div class="flex items-center gap-4">
                                            <div class="p-2 bg-slate-100 dark:bg-slate-800 rounded-lg text-xs font-black text-slate-400" x-text="'ID: ' + product.id"></div>
                                            <div>
                                                <p class="font-bold text-slate-800 dark:text-slate-200" x-text="product.nombre"></p>
                                                <p class="text-[10px] font-black uppercase tracking-widest" :class="product.stock <= 5 ? 'text-rose-500' : 'text-indigo-500'">
                                                    Stock: <span x-text="product.stock"></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-black text-slate-900 dark:text-white" x-text="'S/ ' + product.precio.toFixed(2)"></p>
                                            <span class="text-[9px] bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 px-2 py-0.5 rounded-full font-black uppercase">Seleccionar</span>
                                        </div>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- CONTENEDOR DE TABLA / CARDS ADAPTABLE --}}
                    <div class="bg-white dark:bg-slate-900 rounded-[2rem] sm:rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden min-h-[500px] flex flex-col">

                        {{-- VISTA ESCRITORIO (Table) --}}
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                                        <th class="px-8 py-5 text-[11px] font-black uppercase text-slate-400 tracking-widest italic">Item</th>
                                        <th class="px-6 py-5 text-[11px] font-black uppercase text-slate-400 tracking-widest italic text-center w-40">Cantidad</th>
                                        <th class="px-6 py-5 text-[11px] font-black uppercase text-slate-400 tracking-widest italic text-right">Subtotal</th>
                                        <th class="px-8 py-5"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                                    <template x-for="(item, index) in cart" :key="item.id">
                                        <tr class="hover:bg-indigo-50/30 dark:hover:bg-indigo-500/5 transition-colors group">
                                            <td class="px-8 py-4">
                                                <div class="flex items-center gap-4">
                                                    <div class="p-2.5 bg-indigo-50 dark:bg-slate-800 rounded-xl text-indigo-600 font-bold text-xs" x-text="index + 1"></div>
                                                    <div>
                                                        <p class="font-bold text-slate-800 dark:text-slate-200 text-sm" x-text="item.nombre"></p>
                                                        <p class="text-[10px] font-medium text-slate-400 uppercase" x-text="'SKU-' + item.id"></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center justify-center bg-slate-100 dark:bg-slate-800 rounded-xl p-1 max-w-[120px] mx-auto">
                                                    <button @click="updateQty(item, -1)" class="p-1 hover:bg-white dark:hover:bg-slate-700 rounded-lg text-slate-500 transition-all active:scale-90">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4" />
                                                        </svg>
                                                    </button>
                                                    <input type="number" x-model.number="item.cantidad" @input="validateStock(item)" class="w-10 bg-transparent border-none text-center font-black text-sm focus:ring-0 p-0 dark:text-white">
                                                    <button @click="updateQty(item, 1)" class="p-1 hover:bg-white dark:hover:bg-slate-700 rounded-lg text-slate-500 transition-all active:scale-90">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <p class="font-black text-slate-900 dark:text-white text-sm" x-text="'S/ ' + (item.precio * item.cantidad).toFixed(2)"></p>
                                                <p class="text-[10px] text-slate-400 font-bold" x-text="'u. S/ ' + item.precio.toFixed(2)"></p>
                                            </td>
                                            <td class="px-8 py-4 text-right">
                                                <button @click="removeItem(index)" class="p-2 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-xl transition-all">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        {{-- VISTA MÓVIL (Cards) --}}
                        <div class="sm:hidden flex-1 overflow-y-auto p-4 space-y-3 custom-scroll">
                            <template x-for="(item, index) in cart" :key="'mob-'+item.id">
                                <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-700 relative">
                                    <button @click="removeItem(index)" class="absolute top-3 right-3 text-rose-400">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div class="flex flex-col gap-3">
                                        <div class="pr-8">
                                            <p class="font-black text-slate-800 dark:text-white leading-tight" x-text="item.nombre"></p>
                                            <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mt-1" x-text="'Subtotal: S/ ' + (item.precio * item.cantidad).toFixed(2)"></p>
                                        </div>
                                        <div class="flex items-center justify-between mt-2 pt-3 border-t border-slate-200/50 dark:border-slate-700">
                                            <span class="text-xs font-bold text-slate-400" x-text="'S/ ' + item.precio.toFixed(2) + ' c/u'"></span>
                                            <div class="flex items-center bg-white dark:bg-slate-900 rounded-xl p-1 border border-slate-200 dark:border-slate-700 shadow-sm">
                                                <button @click="updateQty(item, -1)" class="p-1.5 text-indigo-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4" />
                                                    </svg></button>
                                                <span class="px-3 font-black text-sm dark:text-white" x-text="item.cantidad"></span>
                                                <button @click="updateQty(item, 1)" class="p-1.5 text-indigo-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                                                    </svg></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- EMPTY STATE --}}
                        <div x-show="cart.length === 0" class="flex-1 flex flex-col items-center justify-center p-12 text-center">
                            <div class="relative mb-4">
                                <div class="absolute inset-0 bg-indigo-100 dark:bg-indigo-500/10 blur-3xl rounded-full"></div>
                                <svg class="relative w-16 h-16 text-slate-300 dark:text-slate-700 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <p class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Esperando productos para la venta...</p>
                        </div>
                    </div>
                </div>

                {{-- PANEL DE COBRO (Columna Derecha) --}}
                <div class="lg:col-span-4">
                    <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl sticky top-6 text-white overflow-hidden border border-slate-800">
                        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-indigo-600/10 rounded-full blur-3xl"></div>

                        <div class="relative">
                            <h3 class="font-black text-xl italic uppercase tracking-tighter mb-8 flex justify-between items-center">
                                Resumen de Venta
                                <span class="text-[10px] bg-white/10 px-3 py-1 rounded-full not-italic tracking-widest" x-text="cart.length + ' Items'"></span>
                            </h3>

                            {{-- Errores de Laravel --}}
                            @if ($errors->any())
                            <div class="mb-4 p-4 bg-rose-500/20 border border-rose-500 rounded-2xl text-rose-200 text-[10px] uppercase font-bold tracking-widest">
                                <ul class="list-disc pl-5">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form action="{{ route('ventas.store') }}" method="POST" class="space-y-6">
                                @csrf

                                {{-- Inputs dinámicos para productos --}}
                                <template x-for="(item, index) in cart" :key="'form-'+item.id">
                                    <div>
                                        <input type="hidden" :name="'productos['+index+'][id]'" :value="item.id">
                                        <input type="hidden" :name="'productos['+index+'][cantidad]'" :value="item.cantidad">
                                        <input type="hidden" :name="'productos['+index+'][precio]'" :value="item.precio">
                                    </div>
                                </template>

                                {{-- CAMPOS OCULTOS PARA PUNTOS Y TOTAL --}}
                                <input type="hidden" name="customer_id" id="customer_id" value="1">
                                <input type="hidden" name="descuento_puntos" id="input_descuento_puntos" value="0">
                                <input type="hidden" name="puntos_canjeados" id="input_puntos_canjeados" value="0">
                                <input type="hidden" name="total" id="input_total_final_servidor" :value="total.toFixed(2)">

                                {{-- VISUALIZACIÓN DE TOTALES --}}
                                <div class="py-8 px-6 bg-white/5 rounded-[2rem] border border-white/10 space-y-4 group transition-all hover:bg-white/10">

                                    {{-- Subtotal (Suma de productos) --}}
                                    <div class="flex justify-between items-center border-b border-white/5 pb-2">
                                        <span class="text-white/40 text-[10px] font-black uppercase tracking-widest">Subtotal</span>
                                        <span id="label_subtotal" class="font-bold tabular-nums" x-text="'S/ ' + total.toFixed(2)">S/ 0.00</span>
                                    </div>

                                    {{-- Fila de Descuento (Se activa con JS) --}}
                                    <div id="row_descuento_puntos" class="flex justify-between items-center text-emerald-400 hidden">
                                        <span class="text-[10px] font-black uppercase tracking-widest italic">Descuento Puntos</span>
                                        <span class="font-bold tabular-nums">- S/ <span id="label_descuento_puntos">0.00</span></span>
                                    </div>

                                    {{-- Total Neto Final --}}
                                    <div class="flex flex-col items-center pt-2">
                                        <span class="text-white/40 text-[10px] font-black uppercase tracking-[0.3em] mb-1">Total a Pagar</span>
                                        <span id="label_total" class="text-6xl font-black italic tracking-tighter tabular-nums transition-transform group-hover:scale-105 duration-300" x-text="'S/ ' + total.toFixed(2)">S/ 0.00</span>
                                    </div>
                                </div>

                                {{-- Selección de Pago --}}
                                <div class="space-y-3">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-white/40 ml-4">Método de Pago</label>
                                    <select name="metodo_pago" required class="w-full bg-white/10 border-white/5 focus:border-indigo-500 focus:ring-0 rounded-2xl py-4 px-6 font-bold text-sm text-white appearance-none cursor-pointer">
                                        <option value="efectivo" class="text-slate-900">Pago en Efectivo</option>
                                        <option value="tarjeta" class="text-slate-900">Tarjeta Débito/Crédito</option>
                                        <option value="transferencia" class="text-slate-900">Transferencia / QR</option>
                                    </select>
                                </div>

                                {{-- Buscador de Cliente (Fidelización) --}}
                                <div class="space-y-3">
                                    <label class="block text-[10px] font-black text-white/40 uppercase tracking-widest ml-4">
                                        Cliente / Fidelización
                                    </label>
                                    <div class="flex gap-2">
                                        <div class="relative flex-1">
                                            <input type="text" id="customer_search"
                                                class="w-full bg-white/10 border-white/5 rounded-2xl py-3 px-5 text-sm text-white focus:ring-indigo-500 focus:border-indigo-500 placeholder:text-white/20"
                                                placeholder="DNI o Nombre..." autocomplete="off">

                                            <div id="customer_results" class="absolute z-50 w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl hidden max-h-48 overflow-y-auto mt-2 text-slate-800">
                                                {{-- Resultados vía AJAX --}}
                                            </div>
                                        </div>

                                        <button type="button" onclick="openModalCliente()" class="p-3 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 transition-all shrink-0 active:scale-90">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                {{-- Tarjeta de Info de Puntos (Se activa al buscar cliente) --}}
                                <div id="info_fidelizacion" class="hidden p-4 bg-indigo-500/10 border border-indigo-500/20 rounded-[1.5rem] animate-pulse-subtle">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <p class="text-[9px] font-black text-indigo-400 uppercase tracking-widest">Cliente VIP</p>
                                            <h4 id="display_cliente_nombre" class="text-sm font-bold text-white leading-tight">-</h4>
                                        </div>
                                        <span id="display_cliente_nivel" class="text-[9px] font-black px-2 py-1 rounded-lg uppercase bg-indigo-500 text-white">-</span>
                                    </div>

                                    <div class="flex items-center justify-between bg-black/20 p-3 rounded-xl">
                                        <div class="flex items-center gap-3">
                                            <div class="text-center">
                                                <span id="display_cliente_puntos" class="block text-xl font-black text-indigo-400 leading-none">0</span>
                                                <span class="text-[8px] font-bold text-white/40 uppercase">Puntos</span>
                                            </div>
                                            <div class="h-8 w-[1px] bg-white/10"></div>
                                            <div>
                                                <p class="text-[8px] text-white/40 leading-none uppercase">Crédito</p>
                                                <p class="font-black text-xs text-white">S/ <span id="display_puntos_dinero">0.00</span></p>
                                            </div>
                                        </div>

                                        <div class="flex flex-col gap-2 items-end">
                                            <select id="select_hundreds" class="hidden bg-slate-900 border-slate-600 rounded-lg px-2 py-1 text-xs text-white">
                                            </select>
                                            <button type="button" id="btn_canjear" class="hidden bg-emerald-500 hover:bg-emerald-400 text-white text-[10px] font-black px-4 py-2 rounded-lg transition-all uppercase italic tracking-tighter" disabled>
                                                Canjear
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" :disabled="cart.length === 0"
                                    class="w-full py-5 bg-indigo-600 hover:bg-indigo-500 disabled:opacity-20 disabled:grayscale rounded-[2rem] font-black text-sm uppercase tracking-[0.2em] shadow-xl shadow-indigo-900/40 transition-all active:scale-[0.98]">
                                    Finalizar Operación
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Modal de Confirmación de Canje --}}
                <div id="modalConfirmacionCanje" class="bg-slate-900/60 backdrop-blur-sm z-[100] p-4 transition-all duration-300 modal-closed">
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl max-w-sm w-full overflow-hidden transform transition-all border border-slate-200 dark:border-slate-800">
                        <div class="bg-slate-50 dark:bg-slate-800/50 px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                            <h3 class="text-lg font-black text-slate-800 dark:text-white uppercase tracking-tighter">
                                Confirmar Canje
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="text-center">
                                <p class="text-sm text-slate-600 dark:text-slate-300 mb-2">¿Estás seguro de aplicar este descuento?</p>
                                <div class="bg-slate-100 dark:bg-slate-800 p-4 rounded-lg">
                                    <p class="text-lg font-bold text-slate-800 dark:text-white" id="confirm_puntos">100 puntos</p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400" id="confirm_descuento">S/ 1.00 de descuento</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/30 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3">
                            <button type="button" onclick="cancelarConfirmacionCanje()"
                                class="px-4 py-2 text-sm font-bold text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-colors">
                                Cancelar
                            </button>
                            <button type="button" onclick="confirmarCanje()"
                                class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-emerald-200 dark:shadow-none transition-all active:scale-95 flex items-center gap-2">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Confirmar Canje
                            </button>
                        </div>
                    </div>
                </div>

                <div id="modalCliente" class="bg-slate-900/60 backdrop-blur-sm z-[100] p-4 transition-all duration-300 modal-closed">
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all border border-slate-200 dark:border-slate-800">

                        <div class="bg-slate-50 dark:bg-slate-800/50 px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                            <h3 class="text-lg font-black text-slate-800 dark:text-white uppercase tracking-tighter">
                                Nuevo Cliente
                            </h3>
                            <button type="button" onclick="closeModalCliente()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="p-6 space-y-5">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Nombre Completo</label>
                                <input type="text" id="new_name" placeholder="Ej. Juan Pérez"
                                    class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">DNI o RUC</label>
                                    <input type="text" id="new_doc" placeholder="Número de doc."
                                        class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">WhatsApp / Celular</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                                            </svg>
                                        </span>
                                        <input type="text" id="new_phone" placeholder="987 654 321"
                                            class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl text-sm pl-9 text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/30 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3">
                            <button type="button" onclick="closeModalCliente()"
                                class="px-4 py-2 text-sm font-bold text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-colors">
                                Cancelar
                            </button>
                            <button type="button" onclick="saveCustomer()"
                                class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-indigo-200 dark:shadow-none transition-all active:scale-95 flex items-center gap-2">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Guardar Cliente
                            </button>
                        </div>
                    </div>
                </div>

                <script>
                    /**
                     * STOCK MASTER - Sistema de Punto de Venta (POS)
                     * Integra: Alpine.js (Carrito) + Vanilla JS (Fidelización)
                     */

                    // Configuraciones de Fidelización desde el Backend
                    /* eslint-disable */
                    window.fidelizacionConfig = {!! json_encode([
                        'puntosEquivalencia' => $fidelizacionSettings['puntos_equivalencia'],
                        'puntosMinimoCanje' => $fidelizacionSettings['puntos_minimo_canje'],
                        'puntosFactorGanancia' => $fidelizacionSettings['puntos_factor_ganancia']
                    ]) !!};
                    /* eslint-enable */

                    // Variables Globales de Estado para sincronizar ambos mundos
                    window.totalVentaActual = 0;
                    window.descuentoPorPuntos = 0;
                    window.puntosACanjear = 0;

                    /**
                     * 1. LÓGICA DEL CARRITO (Alpine.js)
                     */
                    function posSystem() {
                        return {
                            cart: [],
                            notifications: [],
                            init() {
                                this.$watch('cart', () => {
                                    this.actualizarTotalFinal();
                                });
                            },
                            get total() {
                                return this.cart.reduce((sum, item) => sum + (item.precio * item.cantidad), 0);
                            },
                            get totalFinal() {
                                return Math.max(this.total - window.descuentoPorPuntos, 0);
                            },
                            actualizarTotalFinal() {
                                // Sincronizar total con window
                                window.totalVentaActual = this.total;

                                // Total visible
                                document.getElementById('label_subtotal').innerText = 'S/ ' + this.total.toFixed(2);
                                document.getElementById('label_total').innerText = 'S/ ' + this.totalFinal.toFixed(2);
                                // Input para envío al servidor
                                document.getElementById('input_total_final_servidor').value = this.totalFinal.toFixed(2);

                                // Mostrar u ocultar fila de descuento
                                if (window.descuentoPorPuntos > 0) {
                                    document.getElementById('row_descuento_puntos').classList.remove('hidden');
                                    document.getElementById('label_descuento_puntos').innerText = window.descuentoPorPuntos.toFixed(2);
                                } else {
                                    document.getElementById('row_descuento_puntos').classList.add('hidden');
                                }
                            },
                            addProduct(product) {
                                const existing = this.cart.find(i => i.id === product.id);
                                if (existing) {
                                    existing.cantidad++;
                                    if (existing.cantidad > existing.stock) {
                                        this.notify(`Stock insuficiente para ${existing.nombre}. Máximo disponible: ${existing.stock}`, 'Stock', 'warning');
                                        existing.cantidad = existing.stock;
                                    } else {
                                        this.notify(`Cantidad de ${existing.nombre} aumentada.`, 'POS', 'info');
                                    }
                                } else {
                                    this.cart.push({
                                        ...product,
                                        cantidad: 1
                                    });
                                    this.notify(`Producto ${product.nombre} agregado al carrito.`, 'POS', 'info');
                                }
                                this.actualizarTotalFinal();
                            },
                            updateQty(item, delta) {
                                item.cantidad += delta;
                                if (item.cantidad < 1) item.cantidad = 1;
                                if (item.cantidad > item.stock) {
                                    this.notify(`Stock insuficiente para ${item.nombre}. Máximo disponible: ${item.stock}`, 'Stock', 'warning');
                                    item.cantidad = item.stock;
                                }
                                this.actualizarTotalFinal();
                            },
                            validateStock(item) {
                                if (item.cantidad > item.stock) item.cantidad = item.stock;
                                if (item.cantidad < 1) item.cantidad = 1;
                                this.actualizarTotalFinal();
                            },
                            removeItem(index) {
                                this.cart.splice(index, 1);
                                this.notify('Producto eliminado.', 'POS', 'info');
                                this.actualizarTotalFinal();
                            },
                            notify(message, title = 'Aviso', type = 'info') {
                                const id = Date.now();
                                this.notifications.push({
                                    id,
                                    message,
                                    title,
                                    type
                                });
                                setTimeout(() => {
                                    this.notifications = this.notifications.filter(n => n.id !== id);
                                }, 3500);
                            }
                        }
                    }


                    /**
                     * 2. LÓGICA DE CLIENTES Y PUNTOS (Vanilla JS)
                     */
                    document.addEventListener('DOMContentLoaded', function() {
                        const searchInput = document.getElementById('customer_search');
                        const resultsDiv = document.getElementById('customer_results');
                        const btnCanjear = document.getElementById('btn_canjear');

                        // Buscador asíncrono
                        if (searchInput) {
                            searchInput.addEventListener('input', async (e) => {
                                const term = e.target.value;
                                if (term.length === 0) {
                                    resetCliente();
                                    return;
                                }
                                if (term.length < 2) {
                                    resultsDiv.classList.add('hidden');
                                    return;
                                }

                                try {
                                    const response = await fetch(`/customers/buscar?q=${term}`);
                                    const clientes = await response.json();

                                    if (clientes.length > 0) {
                                        resultsDiv.innerHTML = '';
                                        clientes.forEach(cliente => {
                                            const div = document.createElement('div');
                                            div.className = 'p-3 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer text-sm border-b border-slate-100 flex justify-between items-center';
                                            div.innerHTML = `
                            <div>
                                <div class="font-bold text-slate-800 dark:text-slate-100">${cliente.name}</div>
                                <div class="text-[10px] text-slate-500 font-mono">${cliente.document_number || 'S/D'}</div>
                            </div>
                            <div class="text-right">
                                <span class="bg-indigo-100 text-indigo-700 text-[10px] px-2 py-1 rounded-full font-bold">${cliente.points || 0} pts</span>
                            </div>`;
                                            div.onclick = () => seleccionarCliente(cliente);
                                            resultsDiv.appendChild(div);
                                        });
                                        resultsDiv.classList.remove('hidden');
                                    }
                                } catch (error) {
                                    console.error('Error al buscar:', error);
                                }
                            });
                        }

                        // Botón Canjear Ahora
                        if (btnCanjear) {
                            btnCanjear.addEventListener('click', function() {
                                const selectHundreds = document.getElementById('select_hundreds');
                                const selectedHundreds = parseInt(selectHundreds.value);
                                const pts = selectedHundreds * 100;
                                // Usar configuración dinámica para calcular el monto del descuento
                                const puntosEquiv = window.fidelizacionConfig.puntosEquivalencia;
                                const monto = (pts / puntosEquiv);

                                if (window.totalVentaActual <= 0) {
                                    alert("Agrega productos para aplicar el canje.");
                                    return;
                                }

                                // Mostrar modal de confirmación
                                document.getElementById('confirm_puntos').innerText = `${pts} puntos`;
                                document.getElementById('confirm_descuento').innerText = `S/ ${monto.toFixed(2)} de descuento`;
                                openModalConfirmacionCanje();
                            });
                        }

                        // Clic fuera del buscador para cerrar resultados
                        document.addEventListener('click', (e) => {
                            if (searchInput && !searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
                                resultsDiv.classList.add('hidden');
                            }
                        });
                    });

                    /**
                     * 3. FUNCIONES GLOBALES DE SOPORTE
                     */
                    function seleccionarCliente(cliente) {
                        cancelarCanje(); // Limpiar canje anterior si existía

                        document.getElementById('customer_search').value = `${cliente.name} (${cliente.document_number || 'S/D'})`;
                        document.getElementById('customer_id').value = cliente.id;
                        document.getElementById('customer_results').classList.add('hidden');

                        const infoPanel = document.getElementById('info_fidelizacion');
                        if (cliente.id != 1) { // No es Público General
                            infoPanel.classList.remove('hidden');
                            document.getElementById('display_cliente_nombre').innerText = cliente.name;
                            document.getElementById('display_cliente_puntos').innerText = cliente.points || 0;

                            const nivelBadge = document.getElementById('display_cliente_nivel');
                            nivelBadge.innerText = cliente.level;
                            nivelBadge.className = `text-[10px] font-black px-2 py-1 rounded-lg uppercase ${
                            cliente.level === 'VIP' ? 'bg-amber-100 text-amber-600' : 
                            cliente.level === 'Frecuente' ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-500'
                        }`;

                            // Usar configuración dinámica para calcular el crédito en dinero
                            const puntosEquiv = window.fidelizacionConfig.puntosEquivalencia;
                            document.getElementById('display_puntos_dinero').innerText = (cliente.points / puntosEquiv).toFixed(2);

                            // Mostrar select y botón de canje si cumple el mínimo configurado
                            const selectHundreds = document.getElementById('select_hundreds');
                            const btn = document.getElementById('btn_canjear');
                            const minimoParaCanje = window.fidelizacionConfig.puntosMinimoCanje;
                            const puedeCanjear = cliente.points >= minimoParaCanje;
                            if (puedeCanjear) {
                                // Limpiar opciones anteriores
                                selectHundreds.innerHTML = '';
                                // Agregar opciones de 100 en 100 hasta el máximo posible
                                const maxHundreds = Math.floor(cliente.points / 100);
                                for (let i = 1; i <= maxHundreds; i++) {
                                    const option = document.createElement('option');
                                    option.value = i;
                                    option.textContent = `${i * 100} pts (S/ ${(i).toFixed(2)})`;
                                    selectHundreds.appendChild(option);
                                }
                                selectHundreds.classList.remove('hidden');
                                btn.classList.remove('hidden');
                                btn.disabled = false;
                            } else {
                                selectHundreds.classList.add('hidden');
                                btn.classList.add('hidden');
                                btn.disabled = true;
                            }
                        } else {
                            infoPanel.classList.add('hidden');
                        }
                    }

                    function actualizarTotalesFinales() {
                        const subtotal = window.totalVentaActual || 0;
                        const descuento = parseFloat(document.getElementById('input_descuento_puntos').value) || 0;

                        // El total final es Subtotal - Descuento (Mínimo 0)
                        const totalNeto = Math.max(0, subtotal - descuento);

                        // Actualizar visualmente el Subtotal y Total Final
                        if (document.getElementById('label_subtotal')) document.getElementById('label_subtotal').innerText = `S/ ${subtotal.toFixed(2)}`;
                        if (document.getElementById('label_total')) document.getElementById('label_total').innerText = `S/ ${totalNeto.toFixed(2)}`;

                        // Sincronizar con el input que Laravel leerá en el request
                        const inputTotal = document.getElementById('input_total_final_servidor');
                        if (inputTotal) inputTotal.value = totalNeto.toFixed(2);
                    }

                    function cancelarCanje() {
                        descuentoPorPuntos = 0;
                        puntosACanjear = 0;
                        document.getElementById('input_descuento_puntos').value = 0;
                        document.getElementById('input_puntos_canjeados').value = 0;
                        document.getElementById('row_descuento_puntos').classList.add('hidden');

                        const btn = document.getElementById('btn_canjear');
                        const selectHundreds = document.getElementById('select_hundreds');
                        if (btn) {
                            btn.disabled = false;
                            btn.innerText = "Canjear";
                            btn.className = "text-[10px] font-black bg-emerald-500 hover:bg-emerald-400 text-white px-4 py-2 rounded-lg transition-all uppercase italic tracking-tighter";
                        }
                        if (selectHundreds) {
                            selectHundreds.disabled = false;
                        }
                    }

                    function resetCliente() {
                        document.getElementById('customer_id').value = "1";
                        document.getElementById('info_fidelizacion').classList.add('hidden');
                        cancelarCanje();
                    }

                    function openModalCliente() {
                        console.log('Abriendo modal de cliente');
                        const modal = document.getElementById('modalCliente');
                        console.log('Modal element:', modal);

                        // Quitamos el modo oculto y añadimos el modo abierto
                        modal.classList.remove('modal-closed');
                        modal.classList.add('modal-visible');
                        console.log('Clases del modal después de abrir:', modal.className);
                    }

                    function closeModalCliente() {
                        const modal = document.getElementById('modalCliente');

                        // Volvemos a ocultar y quitamos el modo abierto
                        modal.classList.add('modal-closed');
                        modal.classList.remove('modal-visible');
                    }

                    function openModalConfirmacionCanje() {
                        const modal = document.getElementById('modalConfirmacionCanje');
                        modal.classList.remove('modal-closed');
                        modal.classList.add('modal-visible');
                    }

                    function cancelarConfirmacionCanje() {
                        const modal = document.getElementById('modalConfirmacionCanje');
                        modal.classList.add('modal-closed');
                        modal.classList.remove('modal-visible');
                    }

                    function confirmarCanje() {
                        const selectHundreds = document.getElementById('select_hundreds');
                        const selectedHundreds = parseInt(selectHundreds.value);
                        const pts = selectedHundreds * 100;
                        // Usar configuración dinámica para calcular el monto del descuento
                        const puntosEquiv = window.fidelizacionConfig.puntosEquivalencia;
                        const monto = (pts / puntosEquiv);

                        // Protegemos que el descuento no sea mayor al total
                        descuentoPorPuntos = Math.min(monto, window.totalVentaActual);
                        puntosACanjear = pts;

                        // Llenar inputs ocultos
                        document.getElementById('input_descuento_puntos').value = descuentoPorPuntos;
                        document.getElementById('input_puntos_canjeados').value = puntosACanjear;

                        // Mostrar fila de descuento en el resumen
                        document.getElementById('row_descuento_puntos').classList.remove('hidden');
                        document.getElementById('label_descuento_puntos').innerText = descuentoPorPuntos.toFixed(2);

                        // Cambiar estado del botón y select
                        const btn = document.getElementById('btn_canjear');
                        btn.disabled = true;
                        selectHundreds.disabled = true;
                        btn.innerText = "CANJE APLICADO";
                        btn.className = "text-[10px] font-black bg-slate-400 text-white px-3 py-2 rounded-lg uppercase italic";

                        // Cerrar modal y actualizar totales
                        cancelarConfirmacionCanje();
                        actualizarTotalesFinales();
                    }

                    /**
                     * Registro de Cliente vía AJAX (Modal)
                     */
                    async function saveCustomer() {
                        const name = document.getElementById('new_name').value;
                        const doc = document.getElementById('new_doc').value;
                        const phone = document.getElementById('new_phone').value;

                        if (!name || !doc) {
                            alert('Nombre y Documento son obligatorios');
                            return;
                        }

                        try {
                            const response = await fetch('/customers/rapido', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    name,
                                    document_number: doc,
                                    phone,
                                    _token: '{{ csrf_token() }}'
                                })
                            });
                            const result = await response.json();
                            if (response.ok) {
                                seleccionarCliente(result);
                                closeModalCliente();
                                // Limpiar campos modal
                                document.getElementById('new_name').value = '';
                                document.getElementById('new_doc').value = '';
                                document.getElementById('new_phone').value = '';
                            } else {
                                alert(result.message || 'Error al guardar');
                            }
                        } catch (e) {
                            console.error(e);
                        }
                    }
                </script>
</x-app-layout>