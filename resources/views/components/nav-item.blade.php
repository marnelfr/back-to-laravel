@props(['route'])

@php
    $class = 'text-base font-medium text-gray-500 hover:text-gray-900';
    if (request()->routeIs($route)) {
        $class .= ' text-blue-600';
    }
@endphp

<a href="{{ route($route) }}" {{ $attributes(['class' => $class]) }}>
    {{ ucwords(str_replace('.', ' ', $route)) }}
</a>
