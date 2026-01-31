<x-app-layout>
    <div class="p-6 bg-slate-50 dark:bg-slate-950 min-h-screen">
        <div class="max-w-[1600px] mx-auto space-y-6">
            <x-slot name="header">
                {{-- HEADER DINÁMICO --}}
                <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                            Sistema <span class="text-indigo-600 italic">Core</span>
                        </h1>
                        <p class="text-slate-500 font-medium">Análisis operativo en tiempo real</p>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <div class="bg-white dark:bg-slate-900 shadow-sm border dark:border-slate-800 px-4 py-2 rounded-2xl flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                            <span class="text-sm font-bold dark:text-slate-300">{{ now()->translatedFormat('d M, Y • H:i') }}</span>
                        </div>
                    </div>
                </header>
            </x-slot>

            {{-- GRID DE MÉTRICAS PRINCIPALES --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                {{-- Card de Ingresos Hoy --}}
                <div class="bg-indigo-600 rounded-[2rem] p-6 text-white shadow-xl shadow-indigo-200 dark:shadow-none relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-indigo-100 text-sm font-bold uppercase tracking-wider">Ingresos Hoy</p>
                        <h3 class="text-4xl font-black mt-2">S/ {{ number_format($ingresosHoy, 2) }}</h3>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="px-2 py-1 bg-white/20 rounded-lg text-xs font-bold">
                                {{ $tendenciaHoy >= 0 ? '↑' : '↓' }} {{ abs(round($tendenciaHoy, 1)) }}%
                            </span>
                            <span class="text-indigo-100 text-xs italic">vs. ayer</span>
                        </div>
                    </div>
                    <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-white/10 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                    </svg>
                </div>

                {{-- Valor Inventario --}}
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-6 border dark:border-slate-800 shadow-sm">
                    <p class="text-slate-500 text-sm font-bold uppercase">Patrimonio en Stock</p>
                    <h3 class="text-3xl font-black mt-2 text-slate-800 dark:text-white">S/ {{ number_format($valorInventario->total_venta, 0) }}</h3>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-xs text-slate-400 font-bold uppercase">Margen Est.</span>
                        <span class="text-emerald-500 font-black text-sm">S/ {{ number_format($valorInventario->total_venta - $valorInventario->total_costo, 0) }}</span>
                    </div>
                </div>

                {{-- Productos Críticos (Status) --}}
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-6 border dark:border-slate-800 shadow-sm">
                    <p class="text-slate-500 text-sm font-bold uppercase">Estado de Stock</p>
                    <div class="mt-2 flex items-end justify-between">
                        <h3 class="text-3xl font-black {{ $stockCriticoCount > 0 ? 'text-red-500' : 'text-emerald-500' }}">
                            {{ $stockCriticoCount }} <span class="text-lg font-medium text-slate-400">Alertas</span>
                        </h3>
                    </div>

                    {{-- Barra de progreso corregida --}}
                    <div class="mt-4 w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                        @php
                        // Calculamos el porcentaje en una variable para limpiar el HTML
                        $totalBase = $productos > 0 ? $productos : 1;
                        $porcentajeCritico = ($stockCriticoCount / $totalBase) * 100;
                        @endphp
                        <div class="bg-red-500 h-full" style="--p: {{ $porcentajeCritico }}%; width: var(--p)"></div>
                    </div>
                </div>

                {{-- Clientes Totales --}}
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-6 border dark:border-slate-800 shadow-sm">
                    <p class="text-slate-500 text-sm font-bold uppercase">Clientes Registrados</p>
                    <h3 class="text-3xl font-black mt-2 text-slate-800 dark:text-white">{{ number_format($clientes) }}</h3>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-xs text-slate-400 font-bold uppercase">Activos</span>
                        <span class="text-emerald-500 font-black text-sm">{{ $clientes }}</span>
                    </div>
                </div>

                {{-- Acceso Rápido --}}
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('ventas.create') }}" class="bg-emerald-500 hover:bg-emerald-600 transition rounded-3xl flex flex-col items-center justify-center text-white shadow-lg shadow-emerald-100 dark:shadow-none">
                        <span class="text-xl font-bold">+</span>
                        <span class="text-[10px] font-black uppercase">Nueva Venta</span>
                    </a>
                    <a href="{{ route('productos.create') }}" class="bg-slate-800 hover:bg-slate-900 transition rounded-3xl flex flex-col items-center justify-center text-white">
                        <span class="text-xl font-bold">+</span>
                        <span class="text-[10px] font-black uppercase">Producto</span>
                    </a>
                </div>
            </div>

            {{-- ÁREA CENTRAL: GRÁFICO Y STOCK --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Gráfico Principal --}}
                <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 border dark:border-slate-800 shadow-sm">
                    <div class="flex justify-between items-center mb-8">
                        <h4 class="text-lg font-black text-slate-800 dark:text-white uppercase tracking-tighter">Rendimiento Semanal</h4>
                        <div class="flex gap-2">
                            <span class="flex items-center gap-1 text-xs font-bold text-slate-400">
                                <span class="w-3 h-3 bg-indigo-600 rounded-full"></span> Ventas
                            </span>
                        </div>
                    </div>
                    <div class="h-[350px]">
                        <canvas id="mainChart" data-values="{{ $ventasChart->pluck('total') }}" data-labels="{{ $ventasChart->pluck('label') }}"></canvas>
                    </div>
                </div>

                {{-- Lista Stock Crítico --}}
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 border dark:border-slate-800 shadow-sm">
                    <h4 class="text-lg font-black text-slate-800 dark:text-white uppercase tracking-tighter mb-6">Reposición Urgente</h4>
                    <div class="space-y-4">
                        @foreach($productosCriticos as $p)
                        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-transparent hover:border-red-200 transition">
                            <div class="flex flex-col">
                                <span class="font-black text-slate-800 dark:text-slate-200 text-sm">{{ $p->nombre }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase">Stock: {{ $p->stock_actual }} / Min: {{ $p->stock_minimo }}</span>
                            </div>
                            <div class="bg-red-100 text-red-600 p-2 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ route('productos.index') }}" class="mt-6 block text-center py-3 bg-slate-100 dark:bg-slate-800 rounded-2xl text-xs font-black text-slate-600 dark:text-slate-400 uppercase hover:bg-indigo-600 hover:text-white transition">Ver Inventario Completo</a>
                </div>
            </div>

            {{-- ÚLTIMA FILA: RANKINGS Y ACTIVIDAD --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Top Productos --}}
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 border dark:border-slate-800 shadow-sm">
                    <h4 class="text-sm font-black text-slate-400 uppercase mb-6 tracking-widest text-center">Más Vendidos</h4>
                    <div class="h-[250px]">
                        <canvas id="topProductsChart" data-names="{{ $productosMasVendidos->pluck('nombre') }}" data-quantities="{{ $productosMasVendidos->pluck('cant') }}"></canvas>
                    </div>
                </div>

                {{-- Ventas Recientes --}}
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 border dark:border-slate-800 shadow-sm lg:col-span-2">
                    <h4 class="text-sm font-black text-slate-400 uppercase mb-6 tracking-widest">Últimas Transacciones</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] text-slate-400 uppercase border-b dark:border-slate-800">
                                    <th class="pb-3 pr-4">Cliente</th>
                                    <th class="pb-3 pr-4">Fecha</th>
                                    <th class="pb-3 pr-4">Responsable</th>
                                    <th class="pb-3 text-right">Monto</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-slate-800">
                                @foreach($ventasRecientes as $v)
                                <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                                    <td class="py-4 pr-4 font-bold text-sm text-slate-700 dark:text-slate-200">{{ $v->customer->name ?? 'Gral' }}</td>
                                    <td class="py-4 pr-4 text-xs text-slate-500">{{ $v->created_at->diffForHumans() }}</td>
                                    <td class="py-4 pr-4">
                                        <span class="px-3 py-1 bg-slate-100 dark:bg-slate-800 rounded-full text-[10px] font-black uppercase text-slate-600 dark:text-slate-400">{{ $v->user->name }}</span>
                                    </td>
                                    <td class="py-4 text-right font-black text-indigo-600">S/ {{ number_format($v->total, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- FILA ADICIONAL: CLIENTES MÁS ACTIVOS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Clientes Más Activos --}}
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 border dark:border-slate-800 shadow-sm">
                    <h4 class="text-sm font-black text-slate-400 uppercase mb-6 tracking-widest text-center">Clientes Más Activos</h4>
                    <div class="space-y-4">
                        @foreach($clientesMasActivos as $idx => $c)
                        <div class="flex items-center gap-4">
                            <span class="text-2xl font-black text-slate-200 dark:text-slate-800">0{{ $idx+1 }}</span>
                            <div class="flex-1 border-b dark:border-slate-800 pb-2">
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ $c->name }}</p>
                                <p class="text-xs text-emerald-500 font-bold">S/ {{ number_format($c->total, 2) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Movimientos Recientes --}}
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 border dark:border-slate-800 shadow-sm">
                    <h4 class="text-sm font-black text-slate-400 uppercase mb-6 tracking-widest text-center">Movimientos Recientes</h4>
                    <div class="space-y-4">
                        @foreach($movimientos as $m)
                        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-800 dark:text-slate-200 text-sm">{{ $m->producto_nombre }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase">{{ $m->accion }} - {{ $m->user->name }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-bold {{ $m->cantidad > 0 ? 'text-emerald-500' : 'text-red-500' }}">{{ $m->cantidad > 0 ? '+' : '' }}{{ $m->cantidad }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('mainChart').getContext('2d');
            const data = JSON.parse(document.getElementById('mainChart').dataset.values);
            const labels = JSON.parse(document.getElementById('mainChart').dataset.labels);

            // Gradiente para el gráfico
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.4)');
            gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Ventas',
                        data: data,
                        borderColor: '#4f46e5',
                        borderWidth: 4,
                        fill: true,
                        backgroundColor: gradient,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#4f46e5',
                        pointHoverBorderWidth: 3,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.05)',
                                borderDash: [5, 5]
                            },
                            ticks: {
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });

        // Gráfico de barras para productos más vendidos
        const ctx2 = document.getElementById('topProductsChart').getContext('2d');
        const names = JSON.parse(document.getElementById('topProductsChart').dataset.names);
        const quantities = JSON.parse(document.getElementById('topProductsChart').dataset.quantities);

        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: names,
                datasets: [{
                    label: 'Unidades Vendidas',
                    data: quantities,
                    backgroundColor: 'rgba(79, 70, 229, 0.6)',
                    borderColor: '#4f46e5',
                    borderWidth: 1,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)',
                        },
                        ticks: {
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                weight: 'bold'
                            },
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>