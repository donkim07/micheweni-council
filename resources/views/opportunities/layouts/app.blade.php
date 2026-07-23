<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Explore various opportunities for business, collaboration, sustainability initiatives in Pemba')">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title', config('app.name', 'Opportunities Portal'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        
        /* Accessibility - Skip to main content link */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 0;
            background: #343a40;
            color: white;
            padding: 8px;
            z-index: 100;
            transition: top 0.3s;
        }
        
        .skip-link:focus {
            top: 0;
            outline: 2px solid #0d6efd;
        }
        
        /* Focus indication for accessibility */
        a:focus, button:focus, input:focus, select:focus, textarea:focus {
            outline: 2px solid #0d6efd;
            outline-offset: 2px;
        }
        
        /* Logo Section Styles */
        .logo-section {
            padding: 20px 0;
            position: relative;
            overflow: hidden;
        }
        
        .logo-section-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: linear-gradient(90deg, 
                rgba(0, 70, 140, 0.3) 0%, 
                rgba(255, 255, 255, 0.9) 50%, 
                rgba(0, 127, 0, 0.3) 100%
            );
            z-index: 0;
        }
        
        .logo-section-flag {
            position: absolute;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            background: url("{{ asset('images/tanzania-flag.png') }}") left center no-repeat;
            background-size: cover;
            z-index: -1;
            mask-image: linear-gradient(to right, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 100%);
            -webkit-mask-image: linear-gradient(to right, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 100%);
        }
        
        .logo-section-pemba {
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background: url("{{ asset('images/pemba-bg.png') }}") right center no-repeat;
            background-size: cover;
            z-index: -1;
            mask-image: linear-gradient(to left, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 100%);
            -webkit-mask-image: linear-gradient(to left, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 100%);
        }
        
        .logo-section .container {
            position: relative;
            z-index: 1;
        }
        
        .coat-of-arms {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            height: 100%;
        }
        
        .government-title {
            font-weight: 700;
            margin-bottom: 0;
            font-size: 1.6rem;
            color: #000;
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.8);
            text-align: center;
        }
        
        .government-subtitle {
            color: #000;
            font-size: 1rem;
            text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.8);
            text-align: center;
        }

        /* Social links accessibility */
        .social-link {
            color: white;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .social-link:hover, .social-link:focus {
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
        }
    </style>
    
    @yield('styles')
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    <!-- Skip link for accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <div class="flex-grow-1">
       
        <header role="banner">
            @include('opportunities.layouts.navigation')
        </header>

        <!-- Page Heading -->
        @if (isset($header))
            <div class="bg-white shadow">
                <div class="container py-4">
                    {{ $header }}
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <main id="main-content" role="main">
            @yield('content')
            @isset($slot)
                {{ $slot }}
            @endisset
        </main>
    </div>
    
    <!-- Footer -->
    <footer role="contentinfo" class="bg-dark text-white py-5 mt-auto">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="fw-bold mb-3">{{ config('app.name', 'Opportunities Portal') }}</h5>
                    <p class="mb-3">{{ __('Explore various opportunities for business, collaboration, sustainability initiatives, and more.') }}</p>
                    <div class="social-links">
                        <a href="#" class="social-link me-2" aria-label="Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                        <a href="#" class="social-link me-2" aria-label="Twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                        <a href="#" class="social-link me-2" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                        <a href="#" class="social-link" aria-label="LinkedIn"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-3">{{ __('Quick Links') }}</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="https://www.ikuluzanzibar.go.tz/">State House Zanzibar</a></li>
                        <li class="mb-2"><a href="https://tamisemi.go.tz">TAMISEMI</a></li>
                        <li class="mb-2"><a href="https://www.egaz.go.tz/">Zanzibar e-Government Authority (eGAZ)</a></li>
                        <li class="mb-2"><a href="https://www.zec.go.tz/">Zanzibar Electoral Commission (ZEC)</a></li>
                        <li class="mb-2"><a href="https://www.zanzibarassembly.go.tz/laws">Laws & Policies</a></li>
                        <li><a href="https://www.chuochamafunzohq.go.tz/">Mafunzo</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-3">{{ __('Opportunity Types') }}</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="{{ route('opportunities.circular-economy.home') }}" class="footer-link">{{ __('Circular Economy') }}</a></li>
                        <li class="mb-2"><a href="{{ route('opportunities.index') }}#business" class="footer-link">{{ __('Business') }}</a></li>
                        <li class="mb-2"><a href="{{ route('opportunities.index') }}#agriculture" class="footer-link">{{ __('Agriculture') }}</a></li>
                        <li><a href="{{ route('opportunities.index') }}#tourism" class="footer-link">{{ __('Tourism & Culture') }}</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 col-md-4">
                    <h5 class="fw-bold mb-3">{{ __('Newsletter') }}</h5>
                    <p class="mb-3">{{ __('Subscribe to our newsletter for the latest updates and information.') }}</p>
                    <form action="{{ route('opportunities.circular-economy.newsletter.subscribe') }}" method="POST" class="mb-3">
                        @csrf
                        @if(Auth::check())
                            <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                        @endif
                        <div class="input-group">
                            <label for="newsletter-email" class="visually-hidden">{{ __('Your Email Address') }}</label>
                            <input type="email" name="email" id="newsletter-email" class="form-control" placeholder="{{ __('Your Email Address') }}" required>
                            <button class="btn btn-primary" type="submit">{{ __('Subscribe') }}</button>
                        </div>
                    </form>
                    <p class="small">{{ __('By subscribing, you agree to our') }} <a href="{{ route('opportunities.circular-economy.privacy') }}" class="text-white text-decoration-underline">{{ __('Privacy Policy') }}</a></p>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Opportunities Portal') }}. {{ __('All rights reserved.') }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="{{ route('opportunities.circular-economy.privacy') }}" class="footer-link small">{{ __('Privacy Policy') }}</a></li>
                        <li class="list-inline-item"><a href="{{ route('opportunities.circular-economy.terms') }}" class="footer-link small">{{ __('Terms of Service') }}</a></li>
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
            
            // Auto-translate to Swahili on first load
            setTimeout(function() {
                // Check if we need to translate
                if (!localStorage.getItem('selectedLanguage') || localStorage.getItem('selectedLanguage') === 'sw') {
                    document.cookie = 'googtrans=/en/sw; path=/;';
                    document.cookie = `googtrans=/en/sw; path=/; domain=${window.location.hostname}`;
                }
            }, 500);
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
        
        // Reload to apply changes
        location.reload();
    }
    </script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <!-- CSRF Token for AJAX Requests -->
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Save Opportunity Function
        document.addEventListener('DOMContentLoaded', function() {
            const saveButtons = document.querySelectorAll('.save-opportunity');
            
            saveButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const opportunityId = this.dataset.id;
                    const isSaved = this.dataset.saved === 'true';
                    
                    fetch('/opportunities/' + opportunityId + '/save', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            saved: !isSaved
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const icon = this.querySelector('i');
                            
                            if (data.saved) {
                                icon.classList.remove('fa-bookmark-o');
                                icon.classList.add('fa-bookmark');
                                this.textContent = ' Saved';
                                this.prepend(icon);
                                this.dataset.saved = 'true';
                            } else {
                                icon.classList.remove('fa-bookmark');
                                icon.classList.add('fa-bookmark-o');
                                this.textContent = ' Save';
                                this.prepend(icon);
                                this.dataset.saved = 'false';
                            }
                        }
                    });
                });
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html> 