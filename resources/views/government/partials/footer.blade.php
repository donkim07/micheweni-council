<footer class="footer bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <h5 class="text-white mb-3">{{ __('About Us') }}</h5>
                <p class="text-muted small">{{ __('The Micheweni Government Portal is the official website of the Micheweni District Council in Pemba, Zanzibar. We are committed to serving our citizens with transparency and efficiency.') }}</p>
                
            
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-white mb-3">{{ __('Quick Links') }}</h5>
                <ul class="list-unstyled">
                        <li><a href="https://www.ikuluzanzibar.go.tz/">State House Zanzibar</a></li>
                        <li><a href="https://tamisemi.go.tz">TAMISEMI</a></li>
                        <li><a href="https://www.egaz.go.tz/">Zanzibar e-Government Authority (eGAZ)</a></li>
                        <li><a href="https://www.zec.go.tz/">Zanzibar Electoral Commission (ZEC)</a></li>
                        <li><a href="https://www.zanzibarassembly.go.tz/laws">Laws & Policies</a></li>
                        <li><a href="https://www.chuochamafunzohq.go.tz/">Mafunzo</a></li>
                    </ul>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-white mb-3">{{ __('Resources') }}</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ url('/government/news-new') }}" class="text-muted text-decoration-none"><i class="fas fa-chevron-right me-2 small"></i>{{ __('News') }}</a></li>
                    <li class="mb-2"><a href="{{ url('/government/publications') }}" class="text-muted text-decoration-none"><i class="fas fa-chevron-right me-2 small"></i>{{ __('Publications') }}</a></li>
                    <li class="mb-2"><a href="{{ url('/government/media/gallery') }}" class="text-muted text-decoration-none"><i class="fas fa-chevron-right me-2 small"></i>{{ __('Gallery') }}</a></li>
                    <li class="mb-2"><a href="{{ url('/waste') }}" class="text-muted text-decoration-none"><i class="fas fa-chevron-right me-2 small"></i>{{ __('Waste Management') }}</a></li>
                    <li class="mb-2"><a href="{{ url('/government/circular-economy') }}" class="text-muted text-decoration-none"><i class="fas fa-chevron-right me-2 small"></i>{{ __('Circular Economy') }}</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-white mb-3">{{ __('Contact Us') }}</h5>
                <address class="text-muted small mb-4">
                    <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i> {{ __('Micheweni District Council') }}</p>
                    <p class="mb-1">{{ __('P.O. Box 150') }}</p>
                    <p class="mb-1">{{ __('Micheweni, Pemba, Zanzibar') }}</p>
                    <p class="mb-1"><i class="fas fa-phone me-2"></i> +255 24 245 2003</p>
                    <p class="mb-1"><i class="fas fa-envelope me-2"></i> <a href="mailto:info@micheweni.go.tz" class="text-muted">info@micheweni.go.tz</a></p>
                </address>
                
                <h6 class="text-white mb-3">{{ __('Follow Us') }}</h6>
                <div class="social-icons">
                    <a href="#" class="text-muted me-2" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-muted me-2" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-muted me-2" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-muted" title="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="footer-bottom bg-dark-accent py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                <p class="text-muted small mb-0">{{ __('© 2025 Micheweni District Council. All rights reserved.') }}</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <ul class="list-inline mb-0 small">
                    <li class="list-inline-item"><a href="{{ url('/privacy-policy') }}" class="text-muted">{{ __('Privacy Policy') }}</a></li>
                    <li class="list-inline-item"><span class="text-muted">|</span></li>
                    <li class="list-inline-item"><a href="{{ url('/terms-of-use') }}" class="text-muted">{{ __('Terms of Use') }}</a></li>
                    <li class="list-inline-item"><span class="text-muted">|</span></li>
                    <li class="list-inline-item"><a href="{{ url('/accessibility') }}" class="text-muted">{{ __('Accessibility') }}</a></li>
                    <li class="list-inline-item"><span class="text-muted">|</span></li>
                    <li class="list-inline-item"><a href="{{ url('/sitemap') }}" class="text-muted">{{ __('Sitemap') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.bg-dark-accent {
    background-color: #111;
}
.social-icons a {
    display: inline-block;
    width: 32px;
    height: 32px;
    line-height: 32px;
    text-align: center;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}
.social-icons a:hover {
    background-color: var(--primary);
    color: white !important;
}
</style>

@php
// Simple page view counter using session
if (!session()->has('pageVisited')) {
    session(['pageVisited' => true]);
    
    // Today's visits (simulate with session for demo)
    $todayVisits = session('todayVisits', 0) + 1;
    session(['todayVisits' => $todayVisits]);
    
    // Month visits
    $monthVisits = session('monthVisits', 0) + 1;
    session(['monthVisits' => $monthVisits]);
    
    // Total visits
    $totalVisits = session('totalVisits', 0) + 1;
    session(['totalVisits' => $totalVisits]);
}
@endphp
