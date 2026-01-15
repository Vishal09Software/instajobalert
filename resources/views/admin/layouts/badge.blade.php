@if (session('success'))
    <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show auto-hide-badge" role="alert">
        <i class="ri-notification-off-line label-icon"></i>
        <strong>Success</strong> - {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show auto-hide-badge" role="alert">
        <i class="ri-error-warning-line label-icon"></i>
        <strong>Error</strong> - {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show auto-hide-badge" role="alert">
        <i class="ri-alert-line label-icon"></i>
        <strong>Warning</strong> - {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show auto-hide-badge" role="alert">
        <i class="ri-airplay-line label-icon"></i>
        <strong>Info</strong> - {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show auto-hide-badge" role="alert">
        <i class="ri-error-warning-line label-icon"></i>
        <strong>Validation Error</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            document.querySelectorAll('.auto-hide-badge').forEach(function(el) {
                // Bootstrap 5's .alert has a built-in close method (if using Bootstrap JS)
                if (window.bootstrap && bootstrap.Alert) {
                    try {
                        let alertInstance = bootstrap.Alert.getOrCreateInstance(el);
                        alertInstance.close();
                    } catch (e) {
                        el.parentNode.removeChild(el);
                    }
                } else {
                    // fallback removal if Bootstrap not available
                    el.parentNode.removeChild(el);
                }
            });
        }, 2000);
    });
</script>
@endpush
