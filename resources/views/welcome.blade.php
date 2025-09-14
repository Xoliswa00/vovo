<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Nobela Enterprises</title>
  <meta name="description" content="">
  <meta name="keywords" content="">
      <!-- Favicons -->
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}">
        <link rel="icon" href="{{ asset('assets/img/favicon-16x16.png') }}">

    <link rel="apple-touch-icon" href="{{ asset('assets/img/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
<link rel="apple-touch-icon" sizes="167x167" href="/apple-touch-icon-167x167.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">

<!-- Precomposed versions (no iOS effects) -->
<link rel="apple-touch-icon-precomposed" sizes="180x180" href="/apple-touch-icon-180x180-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="167x167" href="/apple-touch-icon-167x167-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="/apple-touch-icon-152x152-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="/apple-touch-icon-120x120-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="/apple-touch-icon-76x76-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="/apple-touch-icon-57x57-precomposed.png">

<!-- Safari Pinned Tab -->
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/drift-zoom/drift-basic.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: TheProperty
  * Template URL: https://bootstrapmade.com/theproperty-bootstrap-real-estate-template/
  * Updated: Aug 05 2025 with Bootstrap v5.3.7
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="/" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{ asset('assets/img/favicon.png') }}"alt=""> 


        <h1 class="sitename">Nobela Enterprises</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="/" class="active">Home</a></li>
          <li><a href="{{ url('/about') }}" >About</a></li>
          <li><a href="{{ url('/listing') }}">Properties</a></li>
          <li><a href="{{ url('/our-services') }}">Services</a></li>
        
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      

    </div>
  </header>

  <main class="main">
    <br>


    <!-- Hero Section -->
<!--    <section id="hero" class="hero section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="hero-content">
          <div class="row align-items-center">

            <div class="col-lg-6 hero-text" data-aos="fade-right" data-aos-delay="200">
              <div class="hero-badge">
                <i class="bi bi-star-fill"></i>
                <span>Premium Properties</span>
              </div>
              <h1>Discover Your Perfect Home in the Heart of the City</h1>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Browse thousands of verified listings from trusted agents.</p>

              <div class="search-form" data-aos="fade-up" data-aos-delay="300">
                <form action="">
                  <div class="row g-3">
                    <div class="col-12">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="location" name="location" required="">
                        <label for="location">Location</label>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating">
                        <select class="form-select" id="property-type" name="property_type" required="">
                          <option value="">Select Type</option>
                          <option value="house">House</option>
                          <option value="apartment">Apartment</option>
                          <option value="condo">Condo</option>
                          <option value="townhouse">Townhouse</option>
                          <option value="land">Land</option>
                        </select>
                        <label for="property-type">Property Type</label>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating">
                        <select class="form-select" id="price-range" name="price_range" required="">
                          <option value="">Price Range</option>
                          <option value="0-200000">Under $200K</option>
                          <option value="200000-500000">$200K - $500K</option>
                          <option value="500000-800000">$500K - $800K</option>
                          <option value="800000-1200000">$800K - $1.2M</option>
                          <option value="1200000+">Above $1.2M</option>
                        </select>
                        <label for="price-range">Price Range</label>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating">
                        <select class="form-select" id="bedrooms" name="bedrooms">
                          <option value="">Bedrooms</option>
                          <option value="1">1 Bedroom</option>
                          <option value="2">2 Bedrooms</option>
                          <option value="3">3 Bedrooms</option>
                          <option value="4">4 Bedrooms</option>
                          <option value="5+">5+ Bedrooms</option>
                        </select>
                        <label for="bedrooms">Bedrooms</label>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating">
                        <select class="form-select" id="bathrooms" name="bathrooms">
                          <option value="">Bathrooms</option>
                          <option value="1">1 Bathroom</option>
                          <option value="2">2 Bathrooms</option>
                          <option value="3">3 Bathrooms</option>
                          <option value="4+">4+ Bathrooms</option>
                        </select>
                        <label for="bathrooms">Bathrooms</label>
                      </div>
                    </div>

                    <div class="col-12">
                      <button type="submit" class="btn btn-search w-100">
                        <i class="bi bi-search"></i>
                        Search Properties
                      </button>
                    </div>
                  </div>
                </form>
              </div>

              <div class="hero-stats" data-aos="fade-up" data-aos-delay="400">
                <div class="row">
                  <div class="col-4">
                    <div class="stat-item">
                      <h3><span data-purecounter-start="0" data-purecounter-end="2847" data-purecounter-duration="1" class="purecounter"></span>+</h3>
                      <p>Properties Listed</p>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="stat-item">
                      <h3><span data-purecounter-start="0" data-purecounter-end="156" data-purecounter-duration="1" class="purecounter"></span>+</h3>
                      <p>Verified Agents</p>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="stat-item">
                      <h3><span data-purecounter-start="0" data-purecounter-end="98" data-purecounter-duration="1" class="purecounter"></span>%</h3>
                      <p>Client Satisfaction</p>
                    </div>
                  </div>
                </div>
              </div>

            </div> End Hero Text --

            <div class="col-lg-6 hero-images" data-aos="fade-left" data-aos-delay="400">
              <div class="image-stack">
                <div class="main-image">
                  <img src="assets/img/real-estate/property-exterior-3.webp" alt="Luxury Property" class="img-fluid">
                  <div class="property-tag">
                    <span class="price">$850,000</span>
                    <span class="type">Featured</span>
                  </div>
                </div>

                <div class="secondary-image">
                  <img src="assets/img/real-estate/property-interior-7.webp" alt="Property Interior" class="img-fluid">
                </div>

                <div class="floating-card">
                  <div class="agent-info">
                    <img src="assets/img/real-estate/agent-4.webp" alt="Agent" class="agent-avatar">
                    <div class="agent-details">
                      <h5>Sarah Johnson</h5>
                      <p>Top Real Estate Agent</p>
                      <div class="rating">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <span>4.9 (127 reviews)</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Hero Images --

          </div>
        </div>

      </div>

    </section> /Hero Section -->

<br>
    <!-- Featured Properties Section -->
<section id="featured-properties" class="featured-properties section">
<br>

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Featured Properties</h2>
    <p>Explore our premium listings – from luxury villas to cozy townhouses.</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="grid-featured" data-aos="zoom-in" data-aos-delay="150">

      <!-- Highlight Property -->
      @foreach($properties as $property)
      <article class="highlight-card">
        <div class="media">
          <div class="badge-set">
            <span class="flag featured">Featured</span>
            <span class="flag premium">Premium</span>
          </div>
          <a href="{{ route('Guest.show', $property->id) }}" class="image-link">
            <img  src="{{ asset('storage/'.$property->images->first()->image_path) }}"
                 alt="{{ $property->title }}" class="img-fluid">
          </a>
          <div class="quick-specs">
            <span><i class="bi bi-door-open"></i> {{ $property->bedrooms }} Beds</span>
            <span><i class="bi bi-droplet"></i> {{ $property->bathrooms }} Baths</span>
            <span><i class="bi bi-aspect-ratio"></i> {{ number_format(rand(1500,5000)) }} sq ft</span>
          </div>
        </div>
        <div class="content">
          <div class="top">
            <div>
              <h3><a href="{{ route('Guest.show', $property->id) }}">{{ $property->title }}</a></h3>
              <div class="loc"><i class="bi bi-geo-alt-fill"></i> {{ $property->city }}, {{ $property->state }}</div>
            </div>
            <div class="price">R{{ number_format($property->price, 2) }}</div>
          </div>
          <p class="excerpt">{{ Str::limit($property->description, 120) }}</p>
          <div class="cta">
            <a href="{{ route('Guest.show', $property->id) }}" class="btn-main">Arrange Visit</a>
            <a href="{{ route('Guest.show', $property->id) }}" class="btn-soft">More Photos</a>
            <div class="meta">
              <span class="status for-sale">{{ $property->status }}</span>
              <span class="listed">Listed {{ $property->created_at->diffForHumans() }}</span>
            </div>
          </div>
        </div>
      </article>
      @endforeach

        <!-- Mini List -->
    <div class="mini-list">
      @foreach($mini as $item)
<article class="mini-card" data-aos="fade-up" data-aos-delay="150">
    <a href="{{ route('Guest.show', $item->id) }}" class="thumb">
        @if($item->images->count() > 0)
            <img src="{{ asset('storage/'.$item->images->first()->image_path) }}" 
                 alt="{{ $item->title }}" 
                 class="img-fluid" loading="lazy">
        @else
            {{-- fallback placeholder --}}
            <img src="{{ asset('images/placeholder.jpg') }}" 
                 alt="No image available" 
                 class="img-fluid" loading="lazy">
        @endif

        <span class="label hot"><i class="bi bi-lightning-charge-fill"></i> Hot</span>
    </a>

    <div class="mini">

          <h4><a href="{{ route('Guest.show', $item->id) }}">{{ $item->title }}</a></h4>
          <div class="mini-loc"><i class="bi bi-geo"></i> {{ $item->city }}, {{ $item->state }}</div>
          <div class="mini-specs">
            <span><i class="bi bi-door-open"></i> {{ $item->bedrooms }}</span>
            <span><i class="bi bi-droplet"></i> {{ $item->bathrooms }}</span>
            <span><i class="bi bi-rulers"></i> {{ number_format($item->size) }} sq ft</span>
          </div>
          <div class="mini-foot">
            <div class="mini-price">R{{ number_format($item->price, 2) }}</div>
            <a href="{{ route('Guest.show', $item->id) }}" class="mini-btn">Details</a>
          </div>
        </div>
      </article>
      @endforeach
    </div>
    </div>

  

    <!-- Exclusive Properties -->
    <div class="row gy-4 mt-4">
      @foreach($exclusive as $ex)
      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
        <article class="stack-card">
          <figure class="stack-media">
            <img src="{{ asset('storage/'.$ex->images->first()->image_path ) }}" 
                 alt="{{ $ex->title }}" class="img-fluid" loading="lazy">
            <figcaption>
              <span class="chip exclusive">Exclusive</span>
            </figcaption>
          </figure>
          <div class="stack-body">
            <h5><a href="{{ route('Guest.show', $ex->id) }}">{{ $ex->title }}</a></h5>
            <div class="stack-loc"><i class="bi bi-geo-alt"></i> {{ $ex->city }}, {{ $ex->state }}</div>
            <ul class="stack-specs">
              <li><i class="bi bi-door-open"></i> {{ $ex->bedrooms }}</li>
              <li><i class="bi bi-droplet"></i> {{ $ex->bathrooms }}</li>
              <li><i class="bi bi-aspect-ratio"></i> {{ number_format(rand(1000,3500)) }} sq ft</li>
            </ul>
            <div class="stack-foot">
              <span class="stack-price">R{{ number_format($ex->price, 2) }}</span>
              <a href="{{ route('Guest.show', $ex->id) }}" class="stack-link">View</a>
            </div>
          </div>
        </article>
      </div>
      @endforeach
    </div>

  </div>
</section>

    <!-- Featured Services Section -->
<section id="featured-services" class="featured-services section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Featured Services</h2>
        <p>Solutions crafted for efficiency, reliability, and innovation</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4 justify-content-center">

            <!-- Service 1: Logistics -->
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="service-card featured">
                    <div class="service-header">
                        <div class="service-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div class="service-number">01</div>
                    </div>
                    <div class="service-content">
                        <h3><a href="#logistics">Logistics</a></h3>
                        <p>Reliable transport solutions for parcels of any size, from small packages to bulk shipments.</p>
                        <ul class="service-features">
                            <li><i class="bi bi-check2"></i> Local parcel delivery with fast turnaround</li>
                            <li><i class="bi bi-check2"></i> Cross-border transport and freight solutions</li>
                            <li><i class="bi bi-check2"></i> Bulk and large-item shipments handled securely</li>
                            <li><i class="bi bi-check2"></i> Fleet gallery showcasing our vehicles and transport capabilities</li>
                            <li><i class="bi bi-check2"></i> Future-ready tracking portal integration for real-time monitoring</li>
                        </ul>
                    </div>
                    <div class="service-action">
                        <a href="{{ url('/our-services') }}" class="service-btn">
                            <span>Learn More</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Service 2: Boilermaking -->
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                <div class="service-card">
                    <div class="service-header">
                        <div class="service-icon">
                            <i class="bi bi-hammer"></i>
                        </div>
                        <div class="service-number">02</div>
                    </div>
                    <div class="service-content">
                        <h3><a href="#boilermaking">Boilermaking</a></h3>
                        <p>Precision fabrication for industrial and commercial projects, crafted to exact specifications.</p>
                        <ul class="service-features">
                            <li><i class="bi bi-check2"></i> Custom metalwork and structural fabrication</li>
                            <li><i class="bi bi-check2"></i> Portfolio showcasing past projects and specialized designs</li>
                            <li><i class="bi bi-check2"></i> Compliance with technical specifications and certifications</li>
                            <li><i class="bi bi-check2"></i> Innovative solutions for complex boilermaking challenges</li>
                        </ul>
                    </div>
                    <div class="service-action">
                        <a href="{{ url('/our-services') }}" class="service-btn">
                            <span>View Portfolio</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>



<!-- Why Us Section -->
<section id="why-us" class="why-us section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Why Choose Us</h2>
    <p>Delivering excellence in logistics and precision in fabrication</p>
  </div><!-- End Section Title -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row align-items-center gy-5">

      <!-- Left Image / Showcase -->
      <div class="col-lg-5" data-aos="fade-right" data-aos-delay="200">
        <div class="image-showcase">
          <div class="main-image-wrapper">
            <img src="assets/img/lB.png" alt="Our Services" class="img-fluid main-image">
            <div class="image-overlay">
            
            </div>
          </div>

          <div class="floating-stats">
            <div class="stat-badge">
              <span class="stat-number">3+</span>
              <span class="stat-text">Years Experience</span>
            </div>
            <div class="stat-badge">
              <span class="stat-number">285</span>
              <span class="stat-text">Satisfied Clients</span>
            </div>
          </div>

          <div class="experience-card">
            <div class="card-icon">
              <i class="bi bi-award"></i>
            </div>
            <div class="card-content">
              <h5>Trusted Excellence</h5>
              <p>Proven record in logistics and boilermaking across industries</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Content -->
      <div class="col-lg-7" data-aos="fade-left" data-aos-delay="300">
        <div class="content-wrapper">
          <div class="section-badge">
            <i class="bi bi-star-fill me-2"></i>
            Why Choose Us
          </div>

          <h2>Reliable Logistics & Expert Boilermaking</h2>
          <p class="lead-text">From transporting parcels of any size to fabricating high-quality industrial components, we combine precision, reliability, and innovation to deliver outstanding solutions for our clients.</p>

          <div class="benefits-grid">
            <div class="benefit-item" data-aos="fade-up" data-aos-delay="400">
              <div class="benefit-icon">
                <i class="bi bi-truck"></i>
              </div>
              <div class="benefit-content">
                <h4>Efficient Logistics</h4>
                <p>Secure local and cross-border transport, bulk freight handling, and future-ready tracking solutions.</p>
              </div>
            </div>

            <div class="benefit-item" data-aos="fade-up" data-aos-delay="450">
              <div class="benefit-icon">
                <i class="bi bi-hammer"></i>
              </div>
              <div class="benefit-content">
                <h4>Expert Boilermaking</h4>
                <p>Custom fabrication, adherence to technical specs, and a portfolio of completed projects.</p>
              </div>
            </div>

            <div class="benefit-item" data-aos="fade-up" data-aos-delay="500">
              <div class="benefit-icon">
                <i class="bi bi-clock-fill"></i>
              </div>
              <div class="benefit-content">
                <h4>Timely Delivery</h4>
                <p>We respect your deadlines and ensure on-time delivery for both logistics and fabrication projects.</p>
              </div>
            </div>

            <div class="benefit-item" data-aos="fade-up" data-aos-delay="550">
              <div class="benefit-icon">
                <i class="bi bi-people-fill"></i>
              </div>
              <div class="benefit-content">
                <h4>Professional Team</h4>
                <p>Skilled specialists in transport logistics and metal fabrication with years of hands-on experience.</p>
              </div>
            </div>
          </div>

       <!--   <div class="achievement-highlights" data-aos="fade-up" data-aos-delay="600">
            <div class="highlight-item">
              <span class="highlight-number purecounter" data-purecounter-start="0" data-purecounter-end="98" data-purecounter-duration="2"></span>%
              <span class="highlight-label">Client Satisfaction</span>
            </div>
            <div class="highlight-divider"></div>
            <div class="highlight-item">
              <span class="highlight-number purecounter" data-purecounter-start="0" data-purecounter-end="1200" data-purecounter-duration="2"></span>+
              <span class="highlight-label">Projects Completed</span>
            </div>
            <div class="highlight-divider"></div>
            <div class="highlight-item">
              <span class="highlight-number purecounter" data-purecounter-start="0" data-purecounter-end="24" data-purecounter-duration="2"></span>/7
              <span class="highlight-label">Support Available</span>
            </div>
          </div>

          <div class="action-buttons" data-aos="fade-up" data-aos-delay="650">
            <a href="#featured-services" class="btn btn-primary">Our Services</a>
            <a href="#contact" class="btn btn-outline">Get in Touch</a>
          </div>
        </div> -->
      </div>

    </div>
  </div>

</section><!-- /Why Us Section -->



  </main>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer position-relative bg-dark text-light py-5 mt-auto">
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
                        <li><a href="#" class="text-light"><i class="bi bi-chevron-right"></i> Logistics</a></li>
                        <li><a href="#" class="text-light"><i class="bi bi-chevron-right"></i> Boilermaking</a></li>
                    </ul>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-6">
                    <h5 class="text-white mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/about') }}" class="text-light"><i class="bi bi-chevron-right"></i> About Us</a></li>
                        <li><a href="#" class="text-light"><i class="bi bi-chevron-right"></i> Contact</a></li>
                        <li><a href="#" class="text-light"><i class="bi bi-chevron-right"></i> Careers</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-lg-4">
                    <h5 class="text-white mb-3">Get in Touch</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-geo-alt me-2"></i> 57 8th St, La Rochelle, Johannesburg South, 2190</li>
                        <li><i class="bi bi-telephone me-2"></i>0100 2328 09</li>
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
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/drift-zoom/Drift.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>