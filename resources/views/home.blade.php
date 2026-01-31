<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>StockMaster - Gestión de Inventario Pro</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <link rel="icon" type="image/png" href="{{ asset('storage/images/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes reveal {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-reveal { animation: reveal 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
    </style>
</head>

<body class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased selection:bg-indigo-500/30 font-['Figtree']">

    <header class="sticky top-0 z-50 w-full border-b border-slate-200/60 dark:border-slate-800/60 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-2 group cursor-pointer">
                    <div class="p-2 bg-indigo-600 rounded-lg group-hover:rotate-12 transition-transform shadow-indigo-500/20 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m7.5 4.27 9 5.15" /><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" /><path d="m3.3 7 8.7 5 8.7-5" /><path d="M12 22V12" />
                        </svg>
                    </div>
                    <span class="text-xl font-black uppercase tracking-tighter bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-indigo-600 dark:from-white dark:to-indigo-400">
                        StockMaster
                    </span>
                </div>

                <nav class="hidden sm:flex items-center gap-6">
                    <a href="#features" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-indigo-600 transition-colors">Funciones</a>
                    <a href="{{ route('login') }}" class="text-xs font-black uppercase tracking-widest hover:text-indigo-600 transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-2.5 text-xs font-black uppercase tracking-widest text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-500/20 transition-all active:scale-95">
                        Registrarse
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <section class="relative overflow-hidden pt-20 pb-16 md:pt-32 md:pb-24">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 -z-10 w-full h-full max-w-7xl">
                <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-indigo-200/30 dark:bg-indigo-900/20 blur-[100px]"></div>
                <div class="absolute bottom-[10%] right-[-5%] w-[30%] h-[30%] rounded-full bg-purple-200/30 dark:bg-purple-900/20 blur-[100px]"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center opacity-0 animate-reveal">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-8 bg-indigo-50 dark:bg-indigo-900/30 rounded-full border border-indigo-100 dark:border-indigo-800">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    <span class="text-[10px] font-black tracking-[0.2em] text-indigo-600 dark:text-indigo-300 uppercase">
                        Monitoreo en Tiempo Real v12.10
                    </span>
                </div>
                
                <h2 class="text-6xl md:text-8xl font-black text-slate-900 dark:text-white mb-8 leading-[0.9] tracking-tighter italic uppercase">
                    Control total de tu <br>
                    <span class="text-indigo-600 not-italic">Inventario.</span>
                </h2>
                
                <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 mb-12 max-w-3xl mx-auto leading-relaxed font-medium italic">
                    Plataforma robusta con trazabilidad inmutable, Punto de Venta (POS) integrado 
                    y sistema de fidelización VIP. Auditoría precisa en cada movimiento.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('login') }}" class="group px-10 py-5 bg-slate-900 dark:bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 transition shadow-2xl shadow-indigo-500/25 font-black uppercase text-xs tracking-widest italic flex items-center gap-3">
                        Acceder al Dashboard
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                    <a href="#tech" class="px-10 py-5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-800 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800 transition font-black uppercase text-xs tracking-widest italic">
                        Explorar Stack
                    </a>
                </div>
            </div>
        </section>

        <section id="features" class="py-24 bg-white dark:bg-slate-900/50 border-y border-slate-200 dark:border-slate-800">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    
                    <div class="group p-8 rounded-[2.5rem] bg-slate-50/50 dark:bg-slate-800/30 border border-transparent hover:border-indigo-500/20 transition-all opacity-0 animate-reveal stagger-1">
                        <div class="w-12 h-12 flex items-center justify-center rounded-2xl bg-indigo-600 text-white mb-6 shadow-lg shadow-indigo-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="3" width="20" height="14" rx="2" stroke-width="2.5"/><line x1="8" y1="21" x2="16" y2="21" stroke-width="2.5"/><line x1="12" y1="17" x2="12" y2="21" stroke-width="2.5"/>
                            </svg>
                        </div>
                        <h4 class="text-sm font-black uppercase tracking-tighter italic mb-3">Punto de Venta (POS)</h4>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400 leading-relaxed">Carrito interactivo, búsqueda en tiempo real y validación de stock automática.</p>
                    </div>

                    <div class="group p-8 rounded-[2.5rem] bg-slate-50/50 dark:bg-slate-800/30 border border-transparent hover:border-emerald-500/20 transition-all opacity-0 animate-reveal stagger-2">
                        <div class="w-12 h-12 flex items-center justify-center rounded-2xl bg-emerald-600 text-white mb-6 shadow-lg shadow-emerald-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke-width="2.5"/>
                            </svg>
                        </div>
                        <h4 class="text-sm font-black uppercase tracking-tighter italic mb-3">Log Inmutable</h4>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400 leading-relaxed">Auditoría segura: los nombres de productos se congelan en el historial para evitar pérdida de datos.</p>
                    </div>

                    <div class="group p-8 rounded-[2.5rem] bg-slate-50/50 dark:bg-slate-800/30 border border-transparent hover:border-amber-500/20 transition-all opacity-0 animate-reveal stagger-3">
                        <div class="w-12 h-12 flex items-center justify-center rounded-2xl bg-amber-500 text-white mb-6 shadow-lg shadow-amber-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke-width="2.5"/>
                            </svg>
                        </div>
                        <h4 class="text-sm font-black uppercase tracking-tighter italic mb-3">Fidelización VIP</h4>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400 leading-relaxed">Gestión de clientes con niveles de socio, canje de puntos y descuentos exclusivos.</p>
                    </div>

                    <div class="group p-8 rounded-[2.5rem] bg-slate-50/50 dark:bg-slate-800/30 border border-transparent hover:border-indigo-500/20 transition-all opacity-0 animate-reveal stagger-4">
                        <div class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-900 text-white mb-6 shadow-lg shadow-slate-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21.21 15.89A10 10 0 1 1 8 2.83" stroke-width="2.5"/><path d="M22 12A10 10 0 0 0 12 2v10z" stroke-width="2.5"/>
                            </svg>
                        </div>
                        <h4 class="text-sm font-black uppercase tracking-tighter italic mb-3">Métricas Vivas</h4>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400 leading-relaxed">Dashboard dinámico con indicadores de stock bajo y gráficos de movimientos.</p>
                    </div>

                </div>
            </div>
        </section>

        <section id="tech" class="py-20 bg-slate-50 dark:bg-slate-950">
            <div class="max-w-4xl mx-auto px-4 text-center opacity-0 animate-reveal">
                <h3 class="text-xs font-black uppercase tracking-[0.4em] text-slate-400 mb-10 italic">Powered By Modern Stack</h3>
                <div class="flex flex-wrap justify-center gap-4">
                    <span class="px-5 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-red-500"></span> Laravel 12.10
                    </span>
                    <span class="px-5 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span> PHP 8.5
                    </span>
                    <span class="px-5 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-cyan-400"></span> Tailwind 3.1
                    </span>
                    <span class="px-5 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span> Alpine.js 3.4
                    </span>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 py-12">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-indigo-600 rounded flex items-center justify-center text-white font-black italic">S</div>
                <span class="text-sm font-black uppercase tracking-tighter italic">StockMaster <span class="text-slate-400">Audit_System</span></span>
            </div>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                © {{ date('Y') }} MIT LICENSE - TRAZABILIDAD E INMUTABILIDAD DE DATOS
            </p>
        </div>
    </footer>

</body>
</html>