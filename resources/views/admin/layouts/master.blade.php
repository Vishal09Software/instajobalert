<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title> {{ config('app.name') }} - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ config('app.name') }} - Admin & Dashboard Template" name="description" />
    <meta content="{{ config('app.name') }}" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('admin_theme/assets/images/favicon.ico') }}">

    @include('admin.layouts.header')

</head>

<body>
    <div id="layout-wrapper">
        @include('admin.layouts.topbar')
        @include('admin.layouts.sidebar')
        <div class="main-content">

            @yield('main-container')

        </div>
        @include('admin.layouts.footer')
        @include('admin.layouts.script')
    </div>

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

</body>

</html>
