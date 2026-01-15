@props([
    'type' => 'info', // primary, secondary, success, danger, warning, info, light, dark
    'dismissible' => false,
    'icon' => null,
    'title' => null,
    'class' => '',
])

@php
    $alertClass = 'alert alert-' . $type;
    if ($dismissible) {
        $alertClass .= ' alert-dismissible fade show';
    }
    $alertClass .= ' ' . $class;
    
    // Default icons based on type
    $defaultIcons = [
        'primary' => 'bi-info-circle',
        'secondary' => 'bi-info-circle',
        'success' => 'bi-check-circle',
        'danger' => 'bi-exclamation-triangle',
        'warning' => 'bi-exclamation-triangle',
        'info' => 'bi-info-circle',
        'light' => 'bi-lightbulb',
        'dark' => 'bi-info-circle',
    ];
    
    $displayIcon = $icon ?? ($defaultIcons[$type] ?? 'bi-info-circle');
@endphp

<div {{ $attributes->merge(['class' => trim($alertClass)]) }} role="alert">
    <div class="d-flex align-items-center">
        @if($displayIcon)
            <i class="{{ $displayIcon }} me-2 fs-5"></i>
        @endif
        <div class="flex-grow-1">
            @if($title)
                <h5 class="alert-heading mb-1">{{ $title }}</h5>
            @endif
            <div>
                {{ $slot }}
            </div>
        </div>
    </div>
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>

