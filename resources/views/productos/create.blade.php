<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-medium uppercase tracking-widest">
                        <li class="inline-flex items-center text-slate-400">
                            <a href="{{ route('productos.index') }}" class="hover:text-indigo-600 transition-colors">Productos</a>
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
                <a href="{{ route('productos.index') }}"
                    class="group inline-flex items-center px-8 py-4 bg-white dark:bg-slate-800 text-slate-500 border border-slate-200 dark:border-slate-700 rounded-3xl font-black text-[10px] uppercase tracking-widest hover:text-indigo-600 transition-all shadow-sm hover:shadow-md active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6" x-data="{ 
        imageUrl: '',
        pCompra: 0,
        pVenta: 0,
        skuStatus: 'idle',
        get ganancia() { return (this.pVenta - this.pCompra).toFixed(2) },
        get margen() { return this.pCompra > 0 ? ((this.pVenta - this.pCompra) / this.pCompra * 100).toFixed(1) : 0 }
    }">

        @if ($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 1rem; margin-bottom: 1rem; border-radius: 0.5rem;">
            <strong>¡Hay errores en el formulario!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="max-w-7xl mx-auto px-4">
            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                @csrf

                {{-- COLUMNA IZQUIERDA (33%) --}}
                <div class="lg:col-span-4 space-y-6">
                    {{-- Imagen Compacta --}}
                    <div class="bg-white dark:bg-slate-900 p-2 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800">
                        <div class="relative aspect-square rounded-[1.8rem] overflow-hidden bg-slate-50 dark:bg-slate-950 group">
                            <template x-if="imageUrl">
                                <img :src="imageUrl" class="h-full w-full object-cover">
                            </template>
                            <template x-if="!imageUrl">
                                <div class="flex flex-col items-center justify-center h-full">
                                    <svg class="h-8 w-8 text-slate-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="1.5" />
                                    </svg>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Imagen del producto</p>
                                </div>
                            </template>
                            <label class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer flex items-center justify-center backdrop-blur-[2px]">
                                <input type="file" name="imagen" class="hidden" @change="const file = $event.target.files[0]; if(file){ const reader = new FileReader(); reader.onload = (e) => { imageUrl = e.target.result }; reader.readAsDataURL(file) }">
                                <span class="bg-white text-slate-900 px-4 py-2 rounded-lg text-[9px] font-black uppercase tracking-widest">Subir Foto</span>
                            </label>
                        </div>
                    </div>

                    {{-- Widget Rentabilidad Estilizado --}}
                    <div
                        :class="(pVenta <= pCompra && pVenta > 0)
        ? 'bg-rose-600'
        : 'bg-slate-900'"
                        class="relative group overflow-hidden rounded-[2.5rem] p-8 shadow-2xl transition-all duration-500 text-white">
                        <div class="relative z-10">
                            {{-- Header --}}
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white/60">
                                    Análisis de Retorno
                                </span>

                                <span
                                    class="px-3 py-1 rounded-full text-[9px] font-black"
                                    :class="(pVenta <= pCompra && pVenta > 0)
                    ? 'bg-white/20'
                    : 'bg-white/10'"
                                    x-text="margen + '%'"></span>
                            </div>

                            {{-- Contenido --}}
                            <div class="flex flex-col">
                                <span class="text-xs font-bold uppercase mb-1"
                                    :class="(pVenta <= pCompra && pVenta > 0)
                      ? 'text-white/70'
                      : 'text-indigo-400'">
                                    Margen Neto
                                </span>

                                <div class="flex items-baseline space-x-2">
                                    <span class="text-sm font-bold opacity-50">S/</span>
                                    <span class="text-4xl font-black tracking-tighter"
                                        x-text="ganancia">
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Decoración de fondo --}}
                        <div
                            class="absolute -right-6 -bottom-6 opacity-10 transition-transform duration-700
               group-hover:scale-125 group-hover:-rotate-12">
                            <svg class="h-32 w-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>

                </div>

                {{-- COLUMNA DERECHA (66%) --}}
                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-white dark:bg-slate-900 p-8 md:p-10 rounded-[2.8rem] shadow-sm border border-slate-100 dark:border-slate-800 relative overflow-hidden">

                        {{-- Marca de agua sutil --}}
                        <div class="absolute top-0 right-0 p-6 text-slate-50 dark:text-slate-800/30 pointer-events-none">
                            <svg class="h-16 w-16 md:h-20 md:w-20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8 relative z-10"
                            x-data="{ skuStatus: 'idle' }">

                            {{-- SKU con Validación --}}
                            <div class="space-y-3">
                                <div class="flex justify-between items-end min-h-[20px] px-1">
                                    <label class="text-[13px] font-black uppercase tracking-[0.2em] text-slate-400">Referencia SKU</label>

                                    {{-- Contenedor de estados con altura fija para evitar saltos --}}
                                    <div class="flex items-center h-4">
                                        <template x-if="skuStatus === 'checking'">
                                            <span class="text-[10px] font-black text-slate-400 animate-pulse text-right">VERIFICANDO...</span>
                                        </template>
                                        <template x-if="skuStatus === 'taken'">
                                            <span class="text-[10px] font-black text-rose-500 animate-pulse text-right">NO DISPONIBLE</span>
                                        </template>
                                        <template x-if="skuStatus === 'available'">
                                            <span class="text-[10px] font-black text-emerald-500 text-right">DISPONIBLE</span>
                                        </template>
                                    </div>
                                </div>

                                <input type="text" name="codigo"
                                    class="w-full px-6 py-4 rounded-2xl border-2 border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 font-bold text-slate-700 dark:text-white focus:border-indigo-500 focus:ring-0 text-base transition-all"
                                    x-bind:class="skuStatus === 'taken' ? 'border-rose-500 bg-rose-50/30' : (skuStatus === 'available' ? 'border-emerald-400/50' : '')"
                                    @input.debounce.500ms="if($el.value.length < 3) { skuStatus = 'idle'; return; } skuStatus = 'checking'; fetch(`{{ route('productos.validar-sku') }}?codigo=${$el.value}`).then(res => res.json()).then(data => { skuStatus = data.exists ? 'taken' : 'available' })"
                                    placeholder="ART-000" required>
                            </div>

                            {{-- Nombre --}}
                            <div class="space-y-3">
                                <div class="flex justify-between items-end min-h-[20px] px-1">
                                    <label class="text-[13px] font-black uppercase tracking-[0.2em] text-slate-400">Denominación del Producto</label>
                                    {{-- Espacio vacío invisible para mantener la misma altura que el div del SKU --}}
                                    <div class="h-4"></div>
                                </div>

                                <input type="text" name="nombre"
                                    class="w-full px-6 py-4 rounded-2xl border-2 border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 font-bold text-slate-700 dark:text-white focus:border-indigo-500 focus:ring-0 text-base transition-all"
                                    placeholder="Ej. Laptop Pro" required>
                            </div>

                            {{-- Clasificación (Campos Faltantes) --}}
                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8">
                                {{-- Categoría --}}
                                <div class="space-y-3">
                                    <label class="text-[13px] font-black uppercase tracking-[0.2em] text-slate-400 px-1">Categoría</label>
                                    <select name="categoria_id" required
                                        class="w-full px-6 py-4 rounded-2xl border-2 border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 font-bold text-slate-700 dark:text-white focus:border-indigo-500 focus:ring-0 text-base transition-all">
                                        <option value="">Seleccionar Categoría</option>
                                        @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Proveedor --}}
                                <div class="space-y-3">
                                    <label class="text-[13px] font-black uppercase tracking-[0.2em] text-slate-400 px-1">Proveedor</label>
                                    <select name="proveedor_id" required
                                        class="w-full px-6 py-4 rounded-2xl border-2 border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 font-bold text-slate-700 dark:text-white focus:border-indigo-500 focus:ring-0 text-base transition-all">
                                        <option value="">Seleccionar Proveedor</option>
                                        @foreach($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Sección de Costos Refinada --}}
                            <div class="md:col-span-2 p-1 bg-slate-50 dark:bg-slate-950 rounded-[2rem] border border-slate-100 dark:border-slate-800">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-1">
                                    <div class="bg-white dark:bg-slate-900 p-5 rounded-[1.8rem] border border-slate-50 dark:border-slate-800 shadow-sm">
                                        <label class="text-emerald-500 uppercase text-[15px] tracking-[0.2em] mb-2 block px-1">Costo de Adquisición</label>
                                        <div class="flex items-center">
                                            <span class="text-lg font-black text-slate-300 mr-2">S/</span>
                                            <input type="number" step="0.01" name="precio_compra" x-model.number="pCompra"
                                                class="w-full p-0 border-none focus:ring-0 font-black text-2xl text-slate-800 dark:text-white bg-transparent">
                                        </div>
                                    </div>
                                    <div class="bg-white dark:bg-slate-900 p-5 rounded-[1.8rem] border border-slate-50 dark:border-slate-800 shadow-sm">
                                        <label class="text-indigo-500 uppercase text-[15px] tracking-[0.2em] mb-2 block px-1">Precio de Salida</label>
                                        <div class="flex items-center">
                                            <span class="text-lg font-black text-slate-300 mr-2">S/</span>
                                            <input type="number" step="0.01" name="precio_venta" x-model.number="pVenta"
                                                class="w-full p-0 border-none focus:ring-0 font-black text-2xl text-slate-800 dark:text-white bg-transparent">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Disponibilidad --}}
                            <div class="space-y-2">
                                <label class="text-[13px] uppercase tracking-[0.2em] text-slate-400 px-1">DISPONIBILIDAD REAL</label>
                                <div class="relative">
                                    <input type="number" name="stock_actual"
                                        class="text-[17px]  w-full px-5 py-3 rounded-xl border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 font-bold text-sm focus:ring-2 focus:ring-indigo-500/10"
                                        value="0" required>
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase tracking-tighter">UNIDADES</span>
                                </div>
                            </div>

                            {{-- Umbral Alerta --}}
                            <div class="space-y-2">
                                <label class="text-[13px]  uppercase tracking-[0.2em] text-rose-400 px-1">STOCK DE ALERTA</label>
                                <input type="number" name="stock_minimo"
                                    class="text-[17px] w-full px-5 py-3 rounded-xl border-rose-100 dark:border-rose-900/20 bg-rose-50/20 dark:bg-rose-950/20 focus:bg-white text-rose-700 dark:text-rose-400 font-black text-sm focus:ring-2 focus:ring-rose-500/10"
                                    value="5" required>
                            </div>
                        </div>

                        {{-- Footer del Formulario --}}
                        <div class="mt-10 flex flex-col md:flex-row items-center justify-between gap-6 pt-6 border-t border-slate-50 dark:border-slate-800">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-[12px] text-slate-400 font-bold uppercase tracking-tight">
                                    Verifica los <span class="text-slate-900 dark:text-white">márgenes</span> antes de guardar.
                                </p>
                            </div>

                            <button type="submit"
                                x-bind:disabled="skuStatus === 'taken'"
                                class="w-full md:w-auto px-10 py-4 bg-slate-900 dark:bg-indigo-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:bg-indigo-700 hover:-translate-y-1 hover:shadow-xl active:scale-95 disabled:opacity-30 disabled:pointer-events-none">
                                Guardar Registro
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- 5. PIE DE PÁGINA --}}
    <div class="mt-12 text-center">
        <p class="text-slate-400 dark:text-slate-500 text-[10px] font-medium uppercase tracking-[0.4em]">
            StockMaster v1.0 • {{ now()->year }}
        </p>
    </div>
</x-app-layout>