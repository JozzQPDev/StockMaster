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
                                <span class="text-indigo-600">Etidar</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="font-black text-2xl text-slate-800 dark:text-white leading-tight">
                    {{ $producto->nombre }}
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

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                @csrf
                @method('PUT')

                {{-- Columna Izquierda: Multimedia y Ganancia --}}
                <div class="lg:col-span-4 space-y-6">
                    {{-- Imagen del Producto (Estilo Compacto Pro) --}}
                    <div
                        x-data="{ imageUrl: '{{ $producto->imagen ? asset('storage/' . $producto->imagen) : '' }}' }"
                        class="bg-white dark:bg-slate-900 p-2 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 text-center">
                            Identidad Visual
                        </label>

                        <div class="relative aspect-square rounded-[1.8rem] overflow-hidden bg-slate-50 dark:bg-slate-950 group">

                            {{-- Imagen --}}
                            <template x-if="imageUrl">
                                <img :src="imageUrl" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                            </template>

                            {{-- Placeholder --}}
                            <template x-if="!imageUrl">
                                <div class="flex flex-col items-center justify-center h-full">
                                    <svg class="h-8 w-8 text-slate-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="1.5" />
                                    </svg>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">
                                        Sin Imagen
                                    </p>
                                </div>
                            </template>

                            {{-- Overlay Upload --}}
                            <label class="absolute inset-0 bg-indigo-600/40 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer flex items-center justify-center backdrop-blur-[2px]">
                                <input
                                    type="file"
                                    name="imagen"
                                    class="hidden"
                                    @change="const file = $event.target.files[0];if (file) { const reader = new FileReader(); reader.onload = e => imageUrl = e.target.result;reader.readAsDataURL(file); } ">
                                <span class="bg-white text-slate-900 px-4 py-2 rounded-lg text-[9px] font-black uppercase tracking-widest shadow">
                                    Reemplazar Imagen
                                </span>
                            </label>

                        </div>
                    </div>


                    {{-- Widget de Ganancia Estilizado --}}
                    <div id="widget_ganancia" class="relative group overflow-hidden rounded-[2.5rem] p-8 shadow-2xl transition-all duration-500 bg-slate-900">
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <span id="label_titulo" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Análisis de Retorno</span>
                                <span id="porcentaje_ganancia" class="px-3 py-1 bg-white/10 rounded-full text-[9px] font-black">0%</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-indigo-400 uppercase mb-1">Margen Neto</span>
                                <span class="text-4xl font-black text-white tracking-tighter" id="label_ganancia">S/ 0.00</span>
                            </div>
                        </div>

                        {{-- Decoración de fondo --}}
                        <div class="absolute -right-6 -bottom-6 opacity-10 transition-transform duration-700 group-hover:scale-125 group-hover:-rotate-12">
                            <svg id="icon_warning" class="h-32 w-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Columna Derecha: Formulario (Estilo Premium Expandido) --}}
                <div class="lg:col-span-8 space-y-8">
                    <div class="bg-white dark:bg-slate-900 p-10 md:p-12 rounded-[3.5rem] shadow-sm border border-slate-100 dark:border-slate-800 relative overflow-hidden">

                        {{-- Marca de agua sutil --}}
                        <div class="absolute top-0 right-0 p-8 text-slate-50 dark:text-slate-800/50 pointer-events-none">
                            <svg class="h-24 w-24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-10 relative z-10" x-data="{ skuStatus: 'idle' }">

                            {{-- SKU con Validación --}}
                            <div class="space-y-3">
                                <div class="flex justify-between items-end min-h-[24px] px-2">
                                    <label class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-400">Referencia SKU</label>
                                    <div class="flex items-center h-4">
                                        <template x-if="skuStatus === 'checking'">
                                            <span class="text-[10px] font-black text-slate-400 animate-pulse">VERIFICANDO...</span>
                                        </template>
                                        <template x-if="skuStatus === 'taken'">
                                            <span class="text-[10px] font-black text-rose-500 animate-pulse">NO DISPONIBLE</span>
                                        </template>
                                        <template x-if="skuStatus === 'available'">
                                            <span class="text-[10px] font-black text-emerald-500">DISPONIBLE</span>
                                        </template>
                                    </div>
                                </div>
                                <input type="text" name="codigo"
                                    class="w-full px-6 py-4 rounded-2xl border-2 border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 font-bold text-slate-700 dark:text-white focus:border-indigo-500 focus:ring-0 text-base transition-all"
                                    x-bind:class="skuStatus === 'taken' ? 'border-rose-500 bg-rose-50/30' : (skuStatus === 'available' ? 'border-emerald-400/50' : '')"
                                    @input.debounce.500ms="if($el.value.length < 3) { skuStatus = 'idle'; return; } skuStatus = 'checking'; fetch(`{{ route('productos.validar-sku') }}?codigo=${$el.value}`).then(res => res.json()).then(data => { skuStatus = data.exists ? 'taken' : 'available' })"
                                    value="{{ old('codigo', $producto->codigo) }}" required>
                            </div>

                            {{-- Nombre Comercial --}}
                            <div class="space-y-3">
                                <div class="flex justify-between items-end min-h-[24px] px-2">
                                    <label class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-400">Denominación del Producto</label>
                                    <div class="h-4"></div> {{-- Espaciador simétrico --}}
                                </div>
                                <input type="text" name="nombre"
                                    class="w-full px-6 py-4 rounded-2xl border-2 border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 font-bold text-slate-700 dark:text-white focus:border-indigo-500 focus:ring-0 text-base transition-all"
                                    value="{{ old('nombre', $producto->nombre) }}" required>
                            </div>

                            {{-- Selección de Clasificación --}}
                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-10">
                                {{-- Categoría --}}
                                <div class="space-y-3">
                                    <label class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-400 px-2 block">Categoría</label>
                                    <select name="categoria_id" required
                                        class="w-full px-6 py-4 rounded-2xl border-2 border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 font-bold text-slate-700 dark:text-white focus:border-indigo-500 focus:ring-0 text-base transition-all">
                                        <option value="">Seleccionar Categoría</option>
                                        @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ (old('categoria_id', $producto->categoria_id) == $categoria->id) ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Proveedor --}}
                                <div class="space-y-3">
                                    <label class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-400 px-2 block">Proveedor</label>
                                    <select name="proveedor_id" required
                                        class="w-full px-6 py-4 rounded-2xl border-2 border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 font-bold text-slate-700 dark:text-white focus:border-indigo-500 focus:ring-0 text-base transition-all">
                                        <option value="">Seleccionar Proveedor</option>
                                        @foreach($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}" {{ (old('proveedor_id', $producto->proveedor_id) == $proveedor->id) ? 'selected' : '' }}>
                                            {{ $proveedor->nombre }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Sección de Costos Refinada --}}
                            <div class="md:col-span-2 p-1.5 bg-slate-50 dark:bg-slate-950 rounded-[2.8rem] border border-slate-100 dark:border-slate-800">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-1.5">
                                    {{-- Precio Compra --}}
                                    <div class="bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] border border-slate-50 dark:border-slate-800 shadow-sm transition-all hover:shadow-md">
                                        <label class="text-emerald-500 font-black uppercase text-[11px] tracking-[0.2em] mb-4 block px-1">Costo de Adquisición</label>
                                        <div class="flex items-center">
                                            <span class="text-xl font-black text-slate-300 mr-3">S/</span>
                                            <input type="number" step="0.01" name="precio_compra" id="precio_compra"
                                                class="w-full p-0 border-none focus:ring-0 font-black text-3xl text-slate-800 dark:text-white bg-transparent"
                                                value="{{ old('precio_compra', $producto->precio_compra) }}" required>
                                        </div>
                                    </div>
                                    {{-- Precio Venta --}}
                                    <div class="bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] border border-slate-50 dark:border-slate-800 shadow-sm transition-all hover:shadow-md">
                                        <label class="text-indigo-500 font-black uppercase text-[11px] tracking-[0.2em] mb-4 block px-1">Precio de Salida</label>
                                        <div class="flex items-center">
                                            <span class="text-xl font-black text-slate-300 mr-3">S/</span>
                                            <input type="number" step="0.01" name="precio_venta" id="precio_venta"
                                                class="w-full p-0 border-none focus:ring-0 font-black text-3xl text-slate-800 dark:text-white bg-transparent"
                                                value="{{ old('precio_venta', $producto->precio_venta) }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Stock Actual --}}
                            <div class="space-y-3">
                                <label class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-400 px-2 block">Disponibilidad Real</label>
                                <div class="relative">
                                    <input type="number" name="stock_actual" id="stock_actual"
                                        class="w-full px-6 py-4 rounded-2xl border-2 border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 font-bold text-base focus:border-indigo-500 focus:ring-0 transition-all"
                                        value="{{ old('stock_actual', $producto->stock_actual) }}" required>
                                    <span class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase tracking-widest">Unidades</span>
                                </div>
                            </div>

                            {{-- Stock Mínimo --}}
                            <div class="space-y-3">
                                <label class="text-[11px] font-black uppercase tracking-[0.2em] text-rose-400 px-2 block">Umbral de Alerta</label>
                                <input type="number" name="stock_minimo" id="stock_minimo"
                                    class="w-full px-6 py-4 rounded-2xl border-2 border-rose-100 dark:border-rose-900/20 bg-rose-50/30 dark:bg-rose-950/20 text-rose-700 dark:text-rose-400 font-black text-base focus:border-rose-500 focus:ring-0 transition-all"
                                    value="{{ old('stock_minimo', $producto->stock_minimo) }}" required>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="mt-10 flex flex-col md:flex-row items-center justify-between">
                            <p class="text-[13px] text-slate-400 font-medium">
                                <span class="text-indigo-500 font-black text-lg">●</span> Verifica los márgenes antes de actualizar.
                            </p>
                            <button type="submit"
                                x-bind:disabled="skuStatus === 'taken'"
                                class="w-full md:w-auto px-12 py-5 bg-indigo-600 text-white rounded-[1.5rem] text-[11px] font-black uppercase tracking-[0.3em] transition-all hover:bg-slate-900 hover:-translate-y-1 shadow-2xl shadow-indigo-200 dark:shadow-none active:scale-95 disabled:opacity-30">
                                Confirmar Cambios
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pCompra = document.getElementById('precio_compra');
            const pVenta = document.getElementById('precio_venta');
            const widget = document.getElementById('widget_ganancia');
            const labelGanancia = document.getElementById('label_ganancia');
            const labelPorcentaje = document.getElementById('porcentaje_ganancia');
            const labelTitulo = document.getElementById('label_titulo');
            const iconWarning = document.getElementById('icon_warning');

            function calcular() {
                const compra = parseFloat(pCompra.value) || 0;
                const venta = parseFloat(pVenta.value) || 0;
                const ganancia = venta - compra;

                labelGanancia.innerText = `S/ ${ganancia.toLocaleString('es-PE', {minimumFractionDigits: 2})}`;

                if (venta <= compra && venta > 0) {
                    widget.className = 'relative group overflow-hidden rounded-[2.5rem] p-8 shadow-2xl transition-all duration-500 bg-rose-500 animate-pulse text-white';
                    labelTitulo.innerText = '⚠️ Riesgo de Pérdida';
                    labelTitulo.classList.replace('text-slate-400', 'text-rose-100');
                } else if (ganancia > 0) {
                    widget.className = 'relative group overflow-hidden rounded-[2.5rem] p-8 shadow-2xl transition-all duration-500 bg-slate-900 text-white';
                    labelTitulo.innerText = 'Análisis de Retorno';
                    labelTitulo.classList.replace('text-rose-100', 'text-slate-400');
                }

                if (compra > 0) {
                    const porcentaje = (ganancia / compra) * 100;
                    labelPorcentaje.innerText = `${porcentaje > 0 ? '+' : ''}${porcentaje.toFixed(1)}%`;
                } else {
                    labelPorcentaje.innerText = '0%';
                }
            }

            pCompra.addEventListener('input', calcular);
            pVenta.addEventListener('input', calcular);
            calcular();
        });
    </script>
</x-app-layout>