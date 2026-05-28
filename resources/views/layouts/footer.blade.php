<footer id="footer" class="footer position-relative bg-dark text-light py-5">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4">
                <a href="{{ url('/') }}" class="logo d-flex align-items-center mb-3 text-decoration-none">
                    <span class="sitename text-white fw-bold">Nobela Enterprises</span>
                </a>
                <p class="mb-3">Reliable logistics and precision boilermaking solutions tailored for your business. From small parcels to bulk freight — we deliver with quality and trust.</p>
                <div class="social-links mt-3">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-twitter-x"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <h5 class="text-white mb-3">Services</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('services.public') }}" class="text-light"><i class="bi bi-chevron-right"></i> All Services</a></li>
                    <li><a href="{{ route('marketplace.index') }}" class="text-light"><i class="bi bi-chevron-right"></i> Marketplace</a></li>
                    <li><a href="{{ route('quote.create') }}" class="text-light"><i class="bi bi-chevron-right"></i> Get a Quote</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6">
                <h5 class="text-white mb-3">Company</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('about') }}" class="text-light"><i class="bi bi-chevron-right"></i> About Us</a></li>
                    <li><a href="#contact" class="text-light"><i class="bi bi-chevron-right"></i> Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h5 class="text-white mb-3">Get in Touch</h5>
                <ul class="list-unstyled">
                    <li class="mb-1"><i class="bi bi-geo-alt me-2"></i> 120 Rietfontein Road, Germiston</li>
                    <li class="mb-1"><i class="bi bi-telephone me-2"></i> +27 82 123 4567</li>
                    <li class="mb-1"><i class="bi bi-envelope me-2"></i> info@nobelaenterprises.co.za</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bottom text-center mt-4 border-top pt-3">
        <p class="mb-0">© {{ date('Y') }} <strong>Nobela Enterprises</strong>. All Rights Reserved.</p>
    </div>
</footer>
