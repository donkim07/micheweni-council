<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Micheweni Waste Portal') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Google Translate CSS Fixes -->
    <style>
        /* Fix body positioning overrides by Google Translate */
        body {
            top: 0px !important;
            padding-top: 0 !important;
        }
        
        /* Hide Google Translate Banner */
        .goog-te-banner-frame {
            display: none !important;
        }
        
        .skiptranslate > iframe {
            height: 0 !important;
            border-style: none !important;
            box-shadow: none !important;
        }
    </style>
    
    {{ $styles ?? '' }}
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    <div class="flex-grow-1">
        @include('opportunities.circular-economy.layouts.navigation')

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    
    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-auto">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="fw-bold mb-3">{{ config('app.name', 'Micheweni Waste Portal') }}</h5>
                    <p class="mb-3">{{ __('Leading the way towards sustainable waste management in Pemba, Zanzibar through innovative solutions and community engagement.') }}</p>
                    <div class="social-links">
                        <a href="#" class="social-link me-2" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link me-2" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link me-2" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-3">{{ __('Quick Links') }}</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="https://www.ikuluzanzibar.go.tz/">State House Zanzibar</a></li>
                        <li><a href="https://tamisemi.go.tz">TAMISEMI</a></li>
                        <li><a href="https://www.egaz.go.tz/">Zanzibar e-Government Authority (eGAZ)</a></li>
                        <li><a href="https://www.zec.go.tz/">Zanzibar Electoral Commission (ZEC)</a></li>
                        <li><a href="https://www.zanzibarassembly.go.tz/laws">Laws & Policies</a></li>
                        <li><a href="https://www.chuochamafunzohq.go.tz/">Mafunzo</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-3">{{ __('Services') }}</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="{{ route('opportunities.circular-economy.waste.collection') }}" class="footer-link">{{ __('Waste Collection') }}</a></li>
                        <li class="mb-2"><a href="{{ route('opportunities.circular-economy.waste.recycling') }}" class="footer-link">{{ __('Recycling') }}</a></li>
                        <li class="mb-2"><a href="{{ route('opportunities.circular-economy.waste.directory') }}" class="footer-link">{{ __('Service Directory') }}</a></li>
                        <li><a href="{{ route('opportunities.circular-economy.data.dashboard') }}" class="footer-link">{{ __('Data Dashboard') }}</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 col-md-4">
                    <h5 class="fw-bold mb-3">{{ __('Newsletter') }}</h5>
                    <p class="mb-3">{{ __('Subscribe to our newsletter for the latest updates and information.') }}</p>
                    <form action="{{ route('opportunities.circular-economy.newsletter.subscribe') }}" method="POST" class="mb-3">
                        @csrf
                        <div class="input-group">
                            <input type="email" name="email" class="form-control" placeholder="{{ __('Your Email Address') }}" required>
                            <button class="btn btn-success" type="submit">{{ __('Subscribe') }}</button>
                        </div>
                    </form>
                    <p class="small">{{ __('By subscribing, you agree to our') }} <a href="{{ route('opportunities.circular-economy.privacy') }}" class="text-white text-decoration-underline">{{ __('Privacy Policy') }}</a></p>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Micheweni Waste Portal') }}. {{ __('All rights reserved.') }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="{{ route('opportunities.circular-economy.privacy') }}" class="footer-link small">{{ __('Privacy Policy') }}</a></li>
                        <li class="list-inline-item"><a href="{{ route('opportunities.circular-economy.terms') }}" class="footer-link small">{{ __('Terms of Service') }}</a></li>
                        <li class="list-inline-item"><a href="{{ route('opportunities.circular-economy.accessibility') }}" class="footer-link small">{{ __('Accessibility') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Hidden Google Translate Element -->
    <div id="google_translate_element" style="display:none;"></div>
    
    <!-- Google Translate Script -->
    <script type="text/javascript">
        var googleTranslateElementInit = function() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,sw',
                autoDisplay: false
            }, 'google_translate_element');
        };
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    
    <script>
    function changeLanguage(lang) {
        localStorage.setItem('selectedLanguage', lang);

        if (lang === 'en') {
            // Aggressively delete all googtrans cookies
            ['','.' + window.location.hostname].forEach(domain => {
                document.cookie = 'googtrans=; Max-Age=0; path=/;';
                document.cookie = `googtrans=; Max-Age=0; path=/; domain=${domain};`;
            });

            console.log("Switched to EN - Cookies cleared");
        } else if (lang === 'sw') {
            document.cookie = 'googtrans=/en/sw; path=/;';
            document.cookie = `googtrans=/en/sw; path=/; domain=${window.location.hostname}`;
            console.log("Switched to SW - Cookie set");
        }

        // Reload once after language change
        location.reload();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const lang = localStorage.getItem('selectedLanguage') || 'en';
        const cookieLang = getCookieValue('googtrans');
        console.log('LocalStorage:', lang, '| Cookie:', cookieLang);

        // Just log mismatch, no reload
        if (lang === 'en' && cookieLang && cookieLang !== '/en/en') {
            console.warn("Mismatch: Google cookie still says Swahili, but we're in EN. Manual reload will fix.");
        }
    });

    function getCookieValue(name) {
        const match = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
        return match ? decodeURIComponent(match.pop()) : '';
    }

    // Optional debug tool
    function clearTranslation() {
        localStorage.removeItem('selectedLanguage');
        ['','.' + window.location.hostname].forEach(domain => {
            document.cookie = 'googtrans=; Max-Age=0; path=/;';
            document.cookie = `googtrans=; Max-Age=0; path=/; domain=${domain};`;
        });
        console.log("Cleared all translation cookies & localStorage.");
        location.reload();
    }
    </script>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    {{ $scripts ?? '' }}
    @stack('scripts')
    
    <style>
        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }
        
        .social-link:hover {
            background: #28a745;
            color: white;
            transform: translateY(-3px);
        }
        
        .footer-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer-link:hover {
            color: #28a745;
            transform: translateX(5px);
        }
        
        .footer-links li {
            display: flex;
            align-items: center;
        }
        
        .footer-links li::before {
            content: '›';
            color: #28a745;
            margin-right: 5px;
            font-size: 1.2rem;
            line-height: 1;
        }
    </style>
</body>
</html> 