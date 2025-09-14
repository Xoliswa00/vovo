<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Nobela Enterprises'))</title>
    <meta name="description" content="@yield('meta_description', 'Professional logistics and boilermaking services.')">

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}">
        <link rel="icon" href="{{ asset('assets/img/favicon-16x16.png') }}">

    <link rel="apple-touch-icon" href="{{ asset('assets/img/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@400;600;700&family=Raleway:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon-180x180.png">
<link rel="apple-touch-icon" sizes="167x167" href="assets/img/apple-touch-icon-167x167.png">
<link rel="apple-touch-icon" sizes="152x152" href="assets/img/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="120x120" href="assets/img/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="57x57" href="assets/img/apple-touch-icon-57x57.png">

<!-- Precomposed versions (no iOS effects) -->
<link rel="apple-touch-icon-precomposed" sizes="180x180" href="assets/img/apple-touch-icon-180x180-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="167x167" href="assets/img/apple-touch-icon-167x167-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="assets/img/apple-touch-icon-152x152-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="assets/img/apple-touch-icon-120x120-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="assets/img/apple-touch-icon-76x76-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="assets/img/apple-touch-icon-57x57-precomposed.png">

<!-- Safari Pinned Tab -->
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <!-- Vendor CSS Files -->
             @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/drift-zoom/drift-basic.css') }}" rel="stylesheet">

    <!-- Main CSS -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="font-sans antialiased">

    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>

    <footer id="footer" class="footer position-relative bg-dark text-light py-5">

  <div class="container">
    <div class="row gy-4">

      <!-- Company Info -->
      <div class="col-lg-4">
        <a href="{{ url('/') }}" class="logo d-flex align-items-center mb-3 text-decoration-none">
          <span class="sitename text-white fw-bold">Nobela Enterprises</span>
        </a>
        <p class="mb-3">
          Reliable logistics and precision boilermaking solutions tailored for your business. 
          From small parcels to bulk freight, and from steel fabrication to complex projects — 
          we deliver with quality and trust.
        </p>

        <div class="social-links mt-3">
          <a href="#"><i class="bi bi-facebook"></i></a>
          <a href="#"><i class="bi bi-twitter-x"></i></a>
          <a href="#"><i class="bi bi-linkedin"></i></a>
          <a href="#"><i class="bi bi-youtube"></i></a>
        </div>
      </div>

      <!-- Services -->
      <div class="col-lg-2 col-6">
        <h5 class="text-white mb-3">Services</h5>
        <ul class="list-unstyled">
          <li><a href="{{ url('/services.public') }}" class="text-light"><i class="bi bi-chevron-right"></i> Logistics</a></li>          
                    <li><a href="{{ url('/services.public') }}"class="text-light"><i class="bi bi-chevron-right"></i> Boilermaking</a></li>
        </ul>
      </div>

      <!-- Quick Links -->
      <div class="col-lg-2 col-6">
        <h5 class="text-white mb-3">Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-light"><i class="bi bi-chevron-right"></i> About Us</a></li>
          <li><a href="#" class="text-light"><i class="bi bi-chevron-right"></i> Contact</a></li>
          <li><a href="#" class="text-light"><i class="bi bi-chevron-right"></i> Careers</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="col-lg-4">
        <h5 class="text-white mb-3">Get in Touch</h5>
        <ul class="list-unstyled">
          <li><i class="bi bi-geo-alt me-2"></i> 57 8th St, La Rochelle, Johannesburg South, 2190</li>
          <li><i class="bi bi-telephone me-2"></i> +27 82 123 4567</li>
          <li><i class="bi bi-envelope me-2"></i> info@nobelaenterprises.co.za</li>
        </ul>
      </div>

    </div>
  </div>

  <div class="footer-bottom text-center mt-4 border-top pt-3">
    <p class="mb-0">
      © {{ date('Y') }} <strong class="sitename">Nobela Enterprises</strong>. All Rights Reserved.
    </p>
  </div>

</footer>


    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/drift-zoom/Drift.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @stack('scripts')
</body>
</html>
