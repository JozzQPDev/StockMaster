<x-guest-layout>

    <div class="mb-10 text-center">
        <h2 class="text-3xl md:text-4xl font-black tracking-tight text-slate-900 dark:text-white">
            Bienvenido <span class="animate-pulse inline-block">👋</span>
        </h2>
        <p class="mt-3 text-slate-500 dark:text-slate-400 font-medium">
            Accede a tu panel de inventario
        </p>
    </div>

    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div class="group">
            <x-input-label for="email" value="Correo Electrónico"
                class="text-xs uppercase tracking-widest font-bold text-slate-500 dark:text-slate-400 mb-2 ml-1" />

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9" />
                    </svg>
                </div>

                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                    placeholder="nombre@empresa.com"
                    class="block w-full pl-12 pr-4 py-3.5 bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 ml-1" />
        </div>

        <div class="group" x-data="{ show: false }">
            <div class="flex items-center justify-between mb-2 ml-1">
                <x-input-label for="password" value="Contraseña"
                    class="text-xs uppercase tracking-widest font-bold text-slate-500 dark:text-slate-400" />

                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 transition-colors">
                    ¿Olvidaste tu contraseña?
                </a>
                @endif
            </div>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>

                <x-text-input id="password"
                    x-bind:type="show ? 'text' : 'password'"
                    name="password"
                    required
                    placeholder="••••••••"
                    class="block w-full pl-12 pr-12 py-3.5 bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" />

                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-indigo-500 transition-colors">
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 ml-1" />
        </div>

        <div class="flex items-center">
            <input type="checkbox" id="remember" name="remember"
                class="w-5 h-5 rounded-lg border-slate-300 dark:border-slate-700 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer">
            <label for="remember" class="ml-3 text-sm font-semibold text-slate-600 dark:text-slate-400 cursor-pointer select-none">Recordarme</label>
        </div>

        <button type="submit" id="submit-btn" class="relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-2xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/50 transition-all duration-200 shadow-lg shadow-indigo-200">
            <span id="btn-text">Iniciar sesión</span>

            <svg id="btn-spinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </button>

        <div class="text-center pt-4">
            <p class="text-slate-500 dark:text-slate-400 font-medium">
                ¿No tienes una cuenta?
                <a href="{{ route('register') }}" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline underline-offset-4">
                    Regístrate gratis
                </a>
            </p>
        </div>
    </form>

</x-guest-layout>
<script>
    const form = document.querySelector('form');
    const btn = document.getElementById('submit-btn');
    const text = document.getElementById('btn-text');
    const spinner = document.getElementById('btn-spinner');

    form.addEventListener('submit', () => {
        btn.disabled = true;
        btn.classList.add('opacity-80', 'cursor-not-allowed');
        text.classList.add('hidden');
        spinner.classList.remove('hidden');
    });
</script>