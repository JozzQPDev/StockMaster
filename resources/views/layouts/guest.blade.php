<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

     <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/images/icon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/images/icon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/images/icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">


    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-slate-50 dark:bg-slate-950">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="flex flex-col md:flex-row w-full max-w-5xl bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl overflow-hidden min-h-[600px]">

            <div class="hidden md:flex md:w-1/2 bg-indigo-50 dark:bg-slate-800 flex-col p-12 relative overflow-hidden">

                <div class="absolute top-10 left-10 w-20 h-20 bg-indigo-200/30 rounded-full blur-2xl z-0"></div>
                <div class="absolute bottom-10 right-10 w-32 h-32 bg-purple-200/30 rounded-full blur-3xl z-0"></div>

                <div class="relative z-20 flex items-center gap-3 group cursor-pointer self-start">
                    <a href="/">
                        <div class="bg-indigo-600 p-2.5 rounded-2xl shadow-xl shadow-indigo-500/20 group-hover:rotate-6 transition-all duration-300">
                            <x-application-logo class="w-6 h-6 fill-current text-white" />
                        </div>
                    </a>
                    <span class="text-2xl font-black tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-indigo-600 dark:from-white dark:to-indigo-400 uppercase">
                        StockMaster
                    </span>
                </div>

                <div class="relative z-10 flex-grow flex flex-col items-center justify-center text-center mt-6">
                    <div class="mb-6 w-full">
                        <img src="{{ asset('storage/images/fondh.png') }}"
                            alt="StockMaster Illustration"
                            class="max-w-[80%] h-auto mx-auto drop-shadow-[0_20px_35px_rgba(79,70,229,0.2)] animate-float">
                    </div>

                    <div class="mt-4">
                        <h3 class="text-4xl font-black text-slate-800 dark:text-white leading-tight">
                            Optimiza tu
                            <span class="text-indigo-600 relative inline-block">
                                Inventario
                                <div class="absolute -bottom-1 left-0 w-full h-1.5 bg-indigo-600/20 rounded-full"></div>
                            </span>
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 mt-4 text-lg font-medium max-w-sm mx-auto leading-relaxed">
                            La herramienta más potente para el control de tu stock.
                        </p>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-8 md:p-16">
                <div class="w-full max-w-sm">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>