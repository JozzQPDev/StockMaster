@props(['active', 'href', 'icon'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 px-4 py-3 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-sm shadow-indigo-100 dark:shadow-none'
            : 'flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-indigo-600 rounded-xl font-bold text-xs uppercase tracking-widest transition-all';
@endphp

<a {{ $attributes->merge(['class' => $classes, 'href' => $href]) }}>
    @if(isset($icon))
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
        </svg>
    @endif
    <span>{{ $slot }}</span>
</a>