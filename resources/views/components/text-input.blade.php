@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge([
        'class' => 'border-slate-700 text-black placeholder-slate-400 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm'
    ]) }}
>