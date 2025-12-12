@props(['active' => false])


@php
$classes = $active
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-red-500 text-base font-medium text-red-400 bg-slate-900 focus:outline-none focus:text-red-300 focus:bg-slate-800 focus:border-red-600 transition'
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-slate-300 hover:text-red-300 hover:bg-slate-900 hover:border-red-500 focus:outline-none focus:text-red-200 focus:bg-slate-900 focus:border-red-500 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
