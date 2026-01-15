@props([
    'name',
    'label' => null,
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'autofocus' => false,
    'rows' => 4,
    'cols' => null,
    'class' => '',
    'id' => null,
    'help' => null,
    'error' => null,
    'maxlength' => null,
])

@php
    $textareaId = $id ?? $name;
    $textareaClass = 'form-control ' . $class . ($error ? ' is-invalid' : '');
@endphp

<div class="mb-3">
    @if($label)
        <label for="{{ $textareaId }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <textarea
        name="{{ $name }}"
        id="{{ $textareaId }}"
        class="{{ $textareaClass }}"
        placeholder="{{ $placeholder }}"
        rows="{{ $rows }}"
        @if($cols) cols="{{ $cols }}" @endif
        @if($required) required @endif
        @if($readonly) readonly @endif
        @if($disabled) disabled @endif
        @if($autofocus) autofocus @endif
        @if($maxlength) maxlength="{{ $maxlength }}" @endif
        {{ $attributes }}
    >{{ old($name, $value) }}</textarea>

    @if($help)
        <small class="form-text text-muted">{{ $help }}</small>
    @endif

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

