@props(['active' => false])

@php
$classes = $active
            ? 'flex items-center px-3 py-2 rounded-md text-sm font-medium bg-acep-light/20 text-white'
            : 'flex items-center px-3 py-2 rounded-md text-sm font-medium text-white/70 hover:bg-white/10 hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>