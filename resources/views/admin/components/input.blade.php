@props([
    'type' => 'text',
    'name',
    'label' => null,
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'autofocus' => false,
    'autocomplete' => null,
    'class' => '',
    'id' => null,
    'help' => null,
    'error' => null,
    'min' => null,
    'max' => null,
    'step' => null,
    'rows' => null,
    'cols' => null,
    'pro' => null, // added 'pro' property
])

@php
    $inputId = $id ?? $name;
    $inputClass = 'form-control ' . $class . ($error ? ' is-invalid' : '');
@endphp

@if($label)
    <label for="{{ $inputId }}" class="form-label">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
@endif

@if($type === 'textarea')
    <textarea
        name="{{ $name }}"
        id="{{ $inputId }}"
        class="{{ $inputClass }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        @if($readonly) readonly @endif
        @if($disabled) disabled @endif
        @if($autofocus) autofocus @endif
        @if($rows) rows="{{ $rows }}" @endif
        @if($cols) cols="{{ $cols }}" @endif
        @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if($pro) pro="{{ $pro }}" @endif
        {{ $attributes }}
    >{{ old($name, $value) }}</textarea>
@else
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $inputId }}"
        value="{{ old($name, $value) }}"
        class="{{ $inputClass }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        @if($readonly) readonly @endif
        @if($disabled) disabled @endif
        @if($autofocus) autofocus @endif
        @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if($min !== null) min="{{ $min }}" @endif
        @if($max !== null) max="{{ $max }}" @endif
        @if($step !== null) step="{{ $step }}" @endif
        @if($pro) pro="{{ $pro }}" @endif
        {{ $attributes }}
    />
@endif

@if($help)
    <small class="form-text text-muted">{{ $help }}</small>
@endif

@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
