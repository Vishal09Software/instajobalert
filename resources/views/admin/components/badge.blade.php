@props([
    'type' => 'primary', // badge color: primary, secondary, success, danger, warning, info, light, dark
    'pill' => false,
    'class' => '',
    'value' => null,
])

@php
    $badgeClass = 'badge badge-' . $type;
    if ($pill) {
        $badgeClass .= ' rounded-pill';
    }
    $badgeClass .= ' ' . $class;
@endphp

<span {{ $attributes->merge(['class' => $badgeClass]) }}>
    {{ $value ?? $slot }}
</span>
