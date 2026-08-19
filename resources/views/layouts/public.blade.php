<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Nobela Enterprises')</title>
    <meta name="description" content="@yield('meta_description', 'Professional logistics and marketplace services.')">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Nobela Enterprises">
    <meta property="og:title" content="@yield('title', 'Nobela Enterprises')">
    <meta property="og:description" content="@yield('meta_description', 'Professional logistics and marketplace services.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('assets/img/nobela-mark.png'))">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Nobela Enterprises')">
    <meta name="twitter:description" content="@yield('meta_description', 'Professional logistics and marketplace services.')">
    <meta name="twitter:image" content="@yield('og_image', asset('assets/img/nobela-mark.png'))">

    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-body text-[#3A4759] antialiased">

<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[100] focus:rounded-lg focus:bg-navy focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-white">Skip to content</a>

{{-- Public Navbar --}}
<x-public.navbar />

<main id="main-content">
    @yield('content')
</main>

{{-- Global UI Components --}}
<x-toast />
<x-confirm-modal />

@include('layouts.footer')

<a href="#" id="scroll-top" class="scroll-top" aria-label="Scroll to top"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>

<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
@stack('scripts')
</body>
</html>
