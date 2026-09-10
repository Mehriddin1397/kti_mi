@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 w-full px-4 py-2.5 rounded-xl text-sm font-semibold text-indigo-700 bg-indigo-50 border-l-4 border-indigo-600 transition duration-150 ease-in-out'
            : 'flex items-center gap-3 w-full px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
