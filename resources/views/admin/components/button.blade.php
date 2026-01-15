@props([
    'type' => 'button', // button, submit, reset
    'tag' => 'button', // button, a, link (for anchor tags)
    'color' => 'primary', // primary, secondary, success, danger, warning, info, light, dark, link
    'size' => 'md', // sm, md, lg
    'outline' => false,
    'block' => false,
    'icon' => null,
    'iconPosition' => 'left', // left, right, only
    'disabled' => false,
    'href' => null,
    'target' => null,
    'class' => '',
    'rounded' => false, // rounded-pill
])

@php
    $btnClass = 'btn';

    // Handle outline and color classes
    if ($outline) {
        $btnClass .= ' btn-outline-' . $color;
    } else {
        $btnClass .= ' btn-' . $color;
    }

    // Size classes
    if ($size === 'sm') {
        $btnClass .= ' btn-sm';
    } elseif ($size === 'lg') {
        $btnClass .= ' btn-lg';
    }

    // Block button
    if ($block) {
        $btnClass .= ' btn-block d-block w-100';
    }

    // Rounded pill
    if ($rounded) {
        $btnClass .= ' rounded-pill';
    }

    // Disabled state
    if ($disabled) {
        $btnClass .= ' disabled';
    }

    $btnClass .= ' ' . $class;
    
    // Determine if it's a link button
    $isLink = $tag === 'a' || $tag === 'link' || $href !== null;
    $tag = $isLink ? 'a' : 'button';
@endphp

@if($isLink)
    <{{ $tag }}
        href="{{ $href ?? '#' }}"
        @if($target) target="{{ $target }}" @endif
        @if($disabled) aria-disabled="true" tabindex="-1" @endif
        {{ $attributes->merge(['class' => trim($btnClass)]) }}
    >
        @if($icon && ($iconPosition === 'left' || $iconPosition === 'only'))
            <i class="{{ $icon }} {{ $iconPosition !== 'only' ? 'me-1' : '' }}"></i>
        @endif
        @if($iconPosition !== 'only')
            {{ $slot }}
        @endif
        @if($icon && $iconPosition === 'right')
            <i class="{{ $icon }} ms-1"></i>
        @endif
    </{{ $tag }}>
@else
    <{{ $tag }}
        type="{{ $type }}"
        @if($disabled) disabled @endif
        {{ $attributes->merge(['class' => trim($btnClass)]) }}
    >
        @if($icon && ($iconPosition === 'left' || $iconPosition === 'only'))
            <i class="{{ $icon }} {{ $iconPosition !== 'only' ? 'me-1' : '' }}"></i>
        @endif
        @if($iconPosition !== 'only')
            {{ $slot }}
        @endif
        @if($icon && $iconPosition === 'right')
            <i class="{{ $icon }} ms-1"></i>
        @endif
    </{{ $tag }}>
@endif
