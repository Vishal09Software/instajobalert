@props([
    'id',
    'title' => '',
    'size' => 'md', // sm, md, lg, xl, fullscreen
    'centered' => true,
    'scrollable' => false,
    'staticBackdrop' => false,
    'showFooter' => true,
    'closeButton' => true,
    'class' => '',
    'show' => false, // For Livewire conditional display
    'wireIgnore' => false, // For Livewire wire:ignore.self
    'backdrop' => null, // For Livewire backdrop click action
    'closeAction' => null, // For Livewire close button action
])

@php
    $modalClass = 'modal fade';
    if ($show) {
        $modalClass .= ' show';
    }
    if ($class) {
        $modalClass .= ' ' . $class;
    }

    $dialogClass = 'modal-dialog';
    if ($size !== 'md') {
        if ($size === 'sm') {
            $dialogClass .= ' modal-sm';
        } elseif ($size === 'lg') {
            $dialogClass .= ' modal-lg';
        } elseif ($size === 'xl') {
            $dialogClass .= ' modal-xl';
        } elseif ($size === 'fullscreen') {
            $dialogClass .= ' modal-fullscreen';
        }
    }

    if ($centered) {
        $dialogClass .= ' modal-dialog-centered';
    }

    if ($scrollable) {
        $dialogClass .= ' modal-dialog-scrollable';
    }
@endphp

<div
    class="{{ $modalClass }}"
    id="{{ $id }}"
    tabindex="-1"
    aria-labelledby="{{ $id }}Label"
    aria-hidden="true"
    @if($show) style="display: block;" @endif
    @if($wireIgnore) wire:ignore.self @endif
    @if($staticBackdrop) data-bs-backdrop="static" data-bs-keyboard="false" @endif
>
    <div class="{{ $dialogClass }}">
        <div class="modal-content">
            <div class="modal-header">
                @if($title)
                    <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                @endif
                @if($closeButton)
                    @if(isset($closeAction))
                        <button type="button" class="btn-close" wire:click="{{ $closeAction }}" aria-label="Close"></button>
                    @else
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    @endif
                @endif
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            @if($showFooter)
                <div class="modal-footer">
                    @if(isset($footer))
                        {{ $footer }}
                    @else
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

@if($show && isset($backdrop))
    <div class="modal-backdrop fade show" wire:click="{{ $backdrop }}"></div>
@endif
