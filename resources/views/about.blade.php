<x-guest-layout>
    <section class="py-5 container">
        <div class="row gy-4">
            {{-- LEFT COLUMN --}}
            <div class="col-md-6">
                <h5 class="mb-3">Who We Are</h5>
                <p>
                    Nobela Enterprise is located in the heart of Gauteng. We assist clients in buying,
                    selling, and managing their properties. Before starting the process, we provide
                    counseling to ensure our clients make the right decisions.
                </p>
                <p>
                    We also help boost credit scores, assess affordability based on property value,
                    and assist in finding reliable tenants if you plan to use your property for business.
                </p>

                <h5 class="mb-3">Mission & Vision</h5>
                <p><strong>Mission:</strong> To guide clients in making informed property and business decisions while providing trusted support services.</p>
                <p><strong>Vision:</strong> To be the go-to enterprise in Gauteng for property, logistics, and business solutions that uplift individuals and communities.</p>

                {{-- Carousel --}}
                <div id="aboutCarousel" class="carousel slide mt-3" data-bs-ride="carousel">
                    <div class="carousel-inner rounded overflow-hidden">
                        <div class="carousel-item active">
                            <img src="{{ asset('assets/img/property-1.jpg') }}" class="d-block w-100 carousel-img" alt="Business Meeting" loading="lazy"/>
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('assets/img/property-3.jpg') }}" class="d-block w-100 carousel-img" alt="Property Management" loading="lazy"/>
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('assets/img/property-4.jpg') }}" class="d-block w-100 carousel-img" alt="Logistics" loading="lazy"/>
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('assets/img/property-2.jpg') }}" class="d-block w-100 carousel-img" alt="Boilermaking & Fabrication" loading="lazy"/>
                        </div>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#aboutCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#aboutCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>

                    {{-- Indicators --}}
                    <div class="carousel-indicators position-static mt-3">
                        <button type="button" data-bs-target="#aboutCarousel" data-bs-slide-to="0" class="active"></button>
                        <button type="button" data-bs-target="#aboutCarousel" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#aboutCarousel" data-bs-slide-to="2"></button>
                        <button type="button" data-bs-target="#aboutCarousel" data-bs-slide-to="3"></button>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN --}}
            <div class="col-md-6">
                <h5 class="mb-3">Our Services</h5>
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <strong>🏠 Property Sales & Rentals</strong><br>
                        <small>Helping you buy, sell, and rent properties with confidence.</small>
                        <ul class="mt-2 small text-muted">
                            <li>Market analysis & pricing strategy</li>
                            <li>Buyer pre-qualification guidance</li>
                            <li>Rental listing & tenant screening</li>
                        </ul>
                    </li>
                    <li class="mb-3">
                        <strong>👥 Property Management</strong><br>
                        <small>Managing your property and securing reliable tenants.</small>
                        <ul class="mt-2 small text-muted">
                            <li>Rent collection & statements</li>
                            <li>Maintenance coordination</li>
                            <li>Inspection & compliance checks</li>
                        </ul>
                    </li>
                    <li class="mb-3">
                        <strong>💳 Credit Score Assistance</strong><br>
                        <small>Boost your credit score and check affordability before investing.</small>
                        <ul class="mt-2 small text-muted">
                            <li>Credit health assessment</li>
                            <li>Bond readiness checks</li>
                            <li>Action plan to improve score</li>
                        </ul>
                    </li>
                    <li class="mb-3">
                        <strong>🚚 Logistics & Transportation</strong><br>
                        <small>Reliable freight and parcel delivery solutions.</small>
                        <ul class="mt-2 small text-muted">
                            <li>Local & regional deliveries</li>
                            <li>Real-time status updates</li>
                            <li>Route optimization</li>
                        </ul>
                    </li>
                    <li class="mb-3">
                        <strong>⚙️ Boilermaking & Fabrication</strong><br>
                        <small>High-quality industrial fabrication with precision.</small>
                        <ul class="mt-2 small text-muted">
                            <li>Custom steel work & repairs</li>
                            <li>On-site assessment & quotes</li>
                            <li>Quality control & safety first</li>
                        </ul>
                    </li>
                </ul>
       
                <h5 class="mb-3 mt-4">Contact Information</h5>
                <p><strong>📞 Phone:</strong> <a href="tel:+1234567890" class="link-primary">0100 2328 09</a></p>
                <p><strong>📧 Email:</strong> <a href="mailto:info@nobela.com" class="link-primary"> info@nobelaenterprises.co.za</a></p>
                <p><strong>📍 Address:</strong> <a href="https://www.google.com/maps/place/57+8th+St,+La+Rochelle,+Johannesburg+South,+2190" target="_blank" class="link-primary">57 8th St, La Rochelle, Johannesburg South, 2190</a></p>
                <p><strong>🕒 Hours:</strong> Mon–Fri 09:00 – 17:00</p>
            </div>
        </div>
    </section>

    {{-- Page-specific CSS --}}
    @push('styles')
    <style>
        /* Force carousel images to be uniform */
        .carousel-img {
            height: 300px; /* adjust as needed */
            object-fit: cover;
            object-position: center;
        }

        @media (max-width: 768px) {
            .carousel-img {
                height: 200px; /* smaller height for tablets/phones */
            }
        }
    </style>
    @endpush
</x-guest-layout>
