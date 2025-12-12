@props(['active' => false])


@php
$classes = $active
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-red-500 text-sm font-medium text-red-400 focus:outline-none focus:border-red-600 transition'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-slate-300 hover:text-red-300 hover:border-red-500 focus:outline-none focus:text-red-200 focus:border-red-500 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
