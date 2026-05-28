<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Nobela Enterprises')</title>
    <meta name="description" content="@yield('meta_description', 'Professional logistics and marketplace services.')">
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        /* ── Card Hover Effects ─────────────────────────────────── */
        .card { transition: transform .25s ease, box-shadow .25s ease; }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0,0,0,.12) !important;
        }
        .card .card-img-top {
            transition: transform .4s ease;
            overflow: hidden;
        }
        .card:hover .card-img-top { transform: scale(1.04); }

        /* ── Navbar refinement ──────────────────────────────────── */
        #header { backdrop-filter: blur(8px); background: rgba(255,255,255,.95); box-shadow: 0 1px 12px rgba(0,0,0,.08); }

        /* ── Smooth section transitions ─────────────────────────── */
        section { scroll-margin-top: 80px; }

        /* ── Button hover lift ──────────────────────────────────── */
        .btn { transition: transform .15s ease, box-shadow .15s ease; }
        .btn:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.15); }

        /* ── Empty state ────────────────────────────────────────── */
        .empty-state { padding: 4rem 2rem; text-align: center; color: #9ca3af; }
        .empty-state .empty-icon { font-size: 3.5rem; margin-bottom: 1rem; opacity: .5; }
        .empty-state h5 { color: #6b7280; font-weight: 600; }

        /* ── Image overflow guard ───────────────────────────────── */
        .card { overflow: hidden; }

        /* ── Badge polish ───────────────────────────────────────── */
        .badge { letter-spacing: .03em; }

        /* ── Review stars ───────────────────────────────────────── */
        .stars { color: #f59e0b; letter-spacing: 2px; }
    </style>
</head>
<body>

{{-- Public Navbar --}}
<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
        <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
            <span class="sitename fw-bold">Nobela Enterprises</span>
        </a>
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('services.public') }}">Services</a></li>
                <li><a href="{{ route('marketplace.index') }}">Marketplace</a></li>
                <li><a href="{{ route('quote.create') }}">Get a Quote</a></li>
                <li><a href="{{ route('about') }}">About</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary ms-3">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary ms-3">Login</a>
        @endauth
    </div>
</header>

@yield('content')

{{-- Global UI Components --}}
<x-toast />
<x-confirm-modal />

@include('layouts.footer')

<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>

<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
@stack('scripts')
</body>
</html>
