@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">
    {{-- VISTA MÓVIL --}}
    <div class="flex gap-2 items-center justify-between sm:hidden">
        @if ($paginator->onFirstPage())
        <span class="inline-flex items-center px-4 py-2 text-xs font-black uppercase tracking-widest text-slate-400 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 cursor-not-allowed rounded-2xl shadow-sm">
            {!! __('Anterior') !!}
        </span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center px-4 py-2 text-xs font-black uppercase tracking-widest text-indigo-600 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-all active:scale-95">
            {!! __('Anterior') !!}
        </a>
        @endif

        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center px-4 py-2 text-xs font-black uppercase tracking-widest text-indigo-600 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-all active:scale-95">
            {!! __('Siguiente') !!}
        </a>
        @else
        <span class="inline-flex items-center px-4 py-2 text-xs font-black uppercase tracking-widest text-slate-400 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 cursor-not-allowed rounded-2xl shadow-sm">
            {!! __('Siguiente') !!}
        </span>
        @endif
    </div>

    {{-- VISTA ESCRITORIO --}}
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-slate-600 dark:text-slate-400 italic">
                Mostrando
                <span class="font-black text-slate-900 dark:text-white">{{ $paginator->firstItem() }}</span>
                a
                <span class="font-black text-slate-900 dark:text-white">{{ $paginator->lastItem() }}</span>
                de
                <span class="font-black text-indigo-600">{{ $paginator->total() }}</span>
                resultados
            </p>
        </div>

        <div>
            <span class="relative z-0 inline-flex shadow-sm rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700">
                {{-- Botón Anterior --}}
                @if ($paginator->onFirstPage())
                <span aria-disabled="true">
                    <span class="relative inline-flex items-center px-3 py-2 bg-white dark:bg-slate-800 text-slate-300 dark:text-slate-600 cursor-not-allowed">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </span>
                @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 py-2 bg-white dark:bg-slate-800 text-slate-500 hover:text-indigo-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
                @endif

                {{-- Números --}}
                @foreach ($elements as $element)
                @if (is_string($element))
                <span aria-disabled="true">
                    <span class="relative inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 text-slate-400 font-bold tracking-tighter">{{ $element }}</span>
                </span>
                @endif

                @if (is_array($element))
                @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <span aria-current="page">
                    <span class="relative inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-black italic">{{ $page }}</span>
                </span>
                @else
                <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    {{ $page }}
                </a>
                @endif
                @endforeach
                @endif
                @endforeach

                {{-- Botón Siguiente --}}
                @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 py-2 bg-white dark:bg-slate-800 text-slate-500 hover:text-indigo-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
                @else
                <span aria-disabled="true">
                    <span class="relative inline-flex items-center px-3 py-2 bg-white dark:bg-slate-800 text-slate-300 dark:text-slate-600 cursor-not-allowed">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </span>
                @endif
            </span>
        </div>
    </div>
</nav>
@endif