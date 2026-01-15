@props([
    'name',
    'label' => null,
    'value' => 1,
    'checked' => false,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'class' => '',
    'id' => null,
    'help' => null,
    'error' => null,
    'inline' => false,
    'switch' => false,
])

@php
    $checkboxId = $id ?? $name;
    $checkboxClass = 'form-check-input ' . $class . ($error ? ' is-invalid' : '');

    if ($switch) {
        $checkboxClass .= ' form-switch';
    }

    $wrapperClass = $inline ? 'form-check form-check-inline' : 'form-check';

    // Handle checked state
    $isChecked = old($name) !== null ? old($name) == $value : $checked;
@endphp

<div class="{{ $wrapperClass }} mb-3">
    <input
        type="checkbox"
        name="{{ $name }}"
        id="{{ $checkboxId }}"
        value="{{ $value }}"
        class="{{ $checkboxClass }}"
        @if($isChecked) checked @endif
        @if($required) required @endif
        @if($disabled) disabled @endif
        @if($readonly) readonly @endif
        {{ $attributes }}
    />

    @if($label)
        <label class="form-check-label" for="{{ $checkboxId }}">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    @if($help)
        <small class="form-text text-muted d-block">{{ $help }}</small>
    @endif

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

