@props([
    'name',
    'label' => null,
    'value' => '',
    'required' => false,
    'placeholder' => 'Start typing...',
    'height' => 300,
    'class' => '',
    'id' => null,
    'help' => null,
])

@php
    $editorId = $id ?? $name . '_editor';
    $editorClass = 'form-control ' . $class;
@endphp

<div class="mb-3">
    @if($label)
        <label for="{{ $editorId }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <textarea
        name="{{ $name }}"
        id="{{ $editorId }}"
        class="{{ $editorClass }} @error($name) is-invalid @enderror"
        style="height: {{ $height }}px;"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
    >{{ old($name, $value) }}</textarea>

    @if($help)
        <small class="form-text text-muted">{{ $help }}</small>
    @endif

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
