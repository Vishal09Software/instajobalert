<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name', 'InstaJobPortal') }}</title>
    <meta name="description" content="@yield('meta_description', 'Find your dream job and build your future with ' . config('app.name', 'InstaJobPortal') . '. Thousands of verified listings.')">
    @include('frontend.layouts.header')

    {{-- Dynamic SEO Meta Tags --}}
    <meta name="description" content="@yield('meta_description', 'Find your dream job and build your future with ' . config('app.name', 'InstaJobPortal') . '. Thousands of verified listings.')">
    <meta name="keywords" content="@yield('meta_keywords', 'jobs, job portal, careers, employment, hiring, companies, openings, job search, recruitment, dream job, job board')">

    {{-- Open Graph / Facebook Meta Tags --}}
    <meta property="og:title" content="@yield('og_title', (trim($__env->yieldContent('title')) ? $__env->yieldContent('title').' - ' : '') . config('app.name', 'InstaJobPortal'))">
    <meta property="og:description" content="@yield('og_description', $__env->yieldContent('meta_description', 'Find your dream job and build your future with ' . config('app.name', 'InstaJobPortal') . '. Thousands of verified listings.'))">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('frontend/images/og-default.jpg'))">

    {{-- Twitter Card Meta --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', (trim($__env->yieldContent('title')) ? $__env->yieldContent('title').' - ' : '') . config('app.name', 'InstaJobPortal'))">
    <meta name="twitter:description" content="@yield('twitter_description', $__env->yieldContent('meta_description', 'Find your dream job and build your future with ' . config('app.name', 'InstaJobPortal') . '. Thousands of verified listings.'))">
    <meta name="twitter:image" content="@yield('twitter_image', asset('frontend/images/og-default.jpg'))">

    @stack('meta')

</head>
<body>

    @include('frontend.layouts.topbar')

    @yield('main-container')

    @include('frontend.layouts.footer')
    @include('frontend.layouts.script')
</body>

</html>
