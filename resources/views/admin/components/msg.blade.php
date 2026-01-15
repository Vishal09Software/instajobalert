@props([
    'type' => session('alert-type', 'info'), // success, error, warning, info
    'message' => session('message'),
    'icon' => null,
    'close' => true,
    'id' => 'alert-' . uniqid(),
])

@php
    $alertTypes = [
        'success' => ['class' => 'alert-success', 'icon' => 'fas fa-check-circle'],
        'error' => ['class' => 'alert-danger', 'icon' => 'fas fa-times-circle'],
        'danger' => ['class' => 'alert-danger', 'icon' => 'fas fa-times-circle'],
        'warning' => ['class' => 'alert-warning', 'icon' => 'fas fa-exclamation-triangle'],
        'info' => ['class' => 'alert-info', 'icon' => 'fas fa-info-circle'],
    ];

    $type = $type === 'error' ? 'danger' : $type;
    $alert = $alertTypes[$type] ?? $alertTypes['info'];
    $iconClass = $icon ?? $alert['icon'];
@endphp

@if($message || session('message'))
    <div
        id="{{ $id }}"
        class="alert {{ $alert['class'] }} alert-dismissible fade show d-flex align-items-center"
        role="alert"
        style="transition: opacity 0.5s;"
    >
        <i class="{{ $iconClass }} mr-2" style="font-size: 1.3em;"></i>
        <div>
            {{ $message ?? session('message') }}
        </div>
        @if($close)
            <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close" style="outline: none;">
                <span aria-hidden="true">&times;</span>
            </button>
        @endif
    </div>
    <script>
        setTimeout(function() {
            var alert = document.getElementById(@json($id));
            if(alert){
                alert.classList.remove('show');
                alert.classList.add('hide');
                setTimeout(function() {
                    if(alert.parentNode){
                        alert.parentNode.removeChild(alert);
                    }
                }, 500);
            }
        }, 3000);
    </script>
@endif

@if ($errors && $errors->any())
    <div
        id="{{ $id }}-errors"
        class="alert alert-danger alert-dismissible fade show d-flex align-items-center"
        role="alert"
        style="transition: opacity 0.5s;"
    >
        <i class="fas fa-times-circle mr-2" style="font-size: 1.3em;"></i>
        <div>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @if($close)
            <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close" style="outline: none;">
                <span aria-hidden="true">&times;</span>
            </button>
        @endif
    </div>
    <script>
        setTimeout(function() {
            var alert = document.getElementById(@json($id . '-errors'));
            if(alert){
                alert.classList.remove('show');
                alert.classList.add('hide');
                setTimeout(function() {
                    if(alert.parentNode){
                        alert.parentNode.removeChild(alert);
                    }
                }, 500);
            }
        }, 3000);
    </script>
@endif
