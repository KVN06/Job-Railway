@props([
    'variant' => 'default',
    'hover' => true,
    'padding' => 'p-6'
])

@php
    $variantClasses = [
        'default' => 'bg-white shadow-soft',
        'enhanced' => 'card-enhanced',
        'glassmorphism' => 'glassmorphism',
        'gradient' => 'gradient-primary text-white',
    ];

    $baseClasses = 'rounded-2xl ' . $padding . ' transition-all duration-300 ' . ($variantClasses[$variant] ?? $variantClasses['default']);
    $hoverClasses = $hover ? 'hover-lift' : '';
@endphp

<div {{ $attributes->merge(['class' => $baseClasses . ' ' . $hoverClasses]) }}>
    {{ $slot }}
</div>
