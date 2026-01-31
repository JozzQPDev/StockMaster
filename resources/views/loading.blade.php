<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cargando StockMaster...</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

     <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/images/icon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/images/icon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/images/icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Simulación de carga y redirección
        setTimeout(() => {
            window.location.href = "{{ route('dashboard') }}";
        }, 2500); 
    </script>
</head>
<body class="antialiased bg-slate-50 dark:bg-slate-950 font-sans">
    
    <div class="fixed inset-0 z-[100] flex items-center justify-center bg-white/50 dark:bg-slate-950/50 backdrop-blur-md">
        <div class="flex flex-col items-center">
            
            <div class="relative flex items-center justify-center">
                <div class="absolute w-24 h-24 border-4 border-indigo-600/20 border-t-indigo-600 rounded-full animate-spin"></div>
                
                <div class="bg-indigo-600 p-5 rounded-[2rem] shadow-2xl shadow-indigo-500/40 animate-pulse relative z-10">
                    <x-application-logo class="w-10 h-10 fill-current text-white" />
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-indigo-600 dark:text-indigo-400 font-black uppercase tracking-[0.3em] text-xs animate-pulse">
                    Iniciando Sesión
                </p>
                <div class="flex gap-1 justify-center mt-2">
                    <span class="w-1.5 h-1.5 bg-indigo-600 rounded-full animate-bounce [animation-delay:-0.3s]"></span>
                    <span class="w-1.5 h-1.5 bg-indigo-600 rounded-full animate-bounce [animation-delay:-0.15s]"></span>
                    <span class="w-1.5 h-1.5 bg-indigo-600 rounded-full animate-bounce"></span>
                </div>
            </div>
        </div>
    </div>

</body>
</html>