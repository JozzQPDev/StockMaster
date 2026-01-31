<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="font-black text-2xl text-slate-800 dark:text-white flex items-center tracking-tight">
                Configuración del <span class="text-indigo-600 ml-2 text-3xl italic">Sistema</span>
                <span class="relative flex h-3 w-3 ml-4">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                </span>
            </h2>
        </div>
    </x-slot>

    <div class="py-2" x-data="{ activeTab: '{{ $settings->keys()->first() }}' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                
                {{-- NAVEGACIÓN LATERAL --}}
                <aside class="lg:col-span-3 mb-6 lg:mb-0">
                    <nav class="space-y-2 sticky top-6">
                        @foreach($settings as $group => $items)
                        <button @click="activeTab = '{{ $group }}'"
                            :class="activeTab === '{{ $group }}' 
                                        ? 'bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 border-indigo-500 shadow-md transform scale-105' 
                                        : 'text-gray-500 dark:text-gray-400 hover:bg-white/50 dark:hover:bg-gray-800/50 border-transparent'"
                            class="group flex items-center px-5 py-4 text-xs font-black border-l-4 w-full transition-all duration-200 uppercase tracking-[0.2em] rounded-r-lg">
                            {{ $group }}
                        </button>
                        @endforeach
                    </nav>
                </aside>

                {{-- CONTENIDO DE CONFIGURACIÓN --}}
                <div class="lg:col-span-9">
                    @foreach($settings as $group => $items)
                        {{-- CADA GRUPO ES UN FORMULARIO INDEPENDIENTE --}}
                        <form action="{{ route('settings.update') }}" method="POST" 
                              x-show="activeTab === '{{ $group }}'"
                              x-transition:enter="transition ease-out duration-300"
                              x-transition:enter-start="opacity-0 scale-95"
                              x-transition:enter-end="opacity-100 scale-100"
                              class="bg-white dark:bg-gray-800 shadow-2xl shadow-slate-200/50 dark:shadow-none rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden mb-8">
                            
                            @csrf
                            @method('PUT')

                            {{-- Encabezado de Sección --}}
                            <div class="p-8 border-b border-gray-50 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/20 flex justify-between items-center">
                                <div>
                                    <h3 class="text-2xl font-black text-slate-800 dark:text-white italic">
                                        <span class="text-indigo-500">#</span> {{ strtoupper($group) }}
                                    </h3>
                                    <p class="text-gray-500 text-sm mt-1">Actualice solo los parámetros de {{ $group }}.</p>
                                </div>
                                
                                {{-- BOTÓN DE GUARDADO PARA ESTA SECCIÓN --}}
                                <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-indigo-500/30 transition-all active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    Guardar {{ $group }}
                                </button>
                            </div>

                            {{-- Inputs --}}
                            <div class="p-10">
                                <div class="grid grid-cols-1 gap-y-10 gap-x-8 sm:grid-cols-2">
                                    @foreach($items as $setting)
                                    <div class="space-y-3">
                                        <label class="text-[11px] font-black uppercase tracking-tighter text-slate-400 dark:text-gray-500">
                                            {{ $setting->description }}
                                        </label>

                                        <div class="relative">
                                            {{-- Lógica de Toggle para Fidelización/Booleano --}}
                                            @if($setting->type === 'boolean' || str_contains($setting->key, 'enable'))
                                                <div x-data="{ enabled: {{ $setting->value ? 'true' : 'false' }} }" class="flex items-center">
                                                    <button type="button" @click="enabled = !enabled"
                                                        :class="enabled ? 'bg-indigo-600' : 'bg-slate-300 dark:bg-gray-700'"
                                                        class="relative inline-flex h-7 w-14 rounded-full transition-colors duration-200 focus:outline-none">
                                                        <span :class="enabled ? 'translate-x-7' : 'translate-x-0'" class="inline-block h-6 w-6 transform rounded-full bg-white shadow transition duration-200 mt-0.5 ml-0.5"></span>
                                                        <input type="hidden" name="{{ $setting->key }}" :value="enabled ? '1' : '0'">
                                                    </button>
                                                </div>
                                            @else
                                                <input type="{{ $setting->type === 'number' ? 'number' : 'text' }}"
                                                    name="{{ $setting->key }}"
                                                    value="{{ $setting->value }}"
                                                    class="w-full bg-slate-50 dark:bg-gray-900 border-slate-200 dark:border-gray-700 rounded-xl py-3.5 px-4 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all dark:text-gray-200 font-medium">
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                    @endforeach

                    {{-- FOOTER DE ACCIONES GLOBALES --}}
                    <div class="mt-8 px-10 py-6 bg-slate-900 dark:bg-gray-800 rounded-2xl shadow-xl flex justify-center items-center border border-white/5">
                        <form action="{{ route('settings.reset') }}" method="POST" onsubmit="return confirm('¿Restablecer todo a fábrica?');">
                            @csrf
                            <button type="submit" class="text-xs font-black text-slate-500 hover:text-red-400 transition-colors uppercase tracking-[0.2em]">
                                [ Restablecer Configuración Global ]
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>