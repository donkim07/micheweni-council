<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Official government portal for Pemba')">
    <!-- WCAG Compliance -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="{{ config('app.name', 'Micheweni-Portal Pemba') }}">

    <title>@yield('title', 'Home') - {{ config('app.name', 'Micheweni-Portal Pemba') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    
    <!-- Animation Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #3498db;
            --secondary: #248c3c;
            --accent: #e5b700;
            --light: #f5f8fa;
            --dark: #2c3e50;
            --light-blue: #1e88e5;
            --success: #27ae60;
            --warning: #e67e22;
            --danger: #d91e18;
            --transition-speed: 0.3s;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            line-height: 1.6;
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
            background: var(--dark);
            color: white;
            padding: 8px;
            z-index: 100;
            transition: top 0.3s;
        }
        
        .skip-link:focus {
            top: 0;
            outline: 2px solid var(--primary);
        }
        
        /* Focus indication for accessibility */
        a:focus, button:focus, input:focus, select:focus, textarea:focus {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }
        
        /* Header & Navigation */
        .top-bar {
            background-color: var(--primary);
            color: white;
            font-size: 0.85rem;
            padding: 8px 0;
        }
        
        .top-bar a {
            /* color: rgba(255, 255, 255, 0.8); */
            text-decoration: none;
            transition: var(--transition-speed);
            margin-right: 15px;
        }
        
        .top-bar a:hover {
            color: white;
        }
        
        /* Language and Auth Dropdowns */
        .top-bar .dropdown-toggle {
            text-decoration: none;
        }
        
        .top-bar .dropdown-toggle::after {
            display: none;
        }
        
        .top-bar .dropdown-menu {
            margin-top: 0.5rem;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            padding: 0.5rem 0;
            min-width: 10rem;
            animation: fadeIn 0.2s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .top-bar .dropdown-item {
            padding: 0.5rem 1rem;
            transition: var(--transition-speed);
        }
        
        .top-bar .dropdown-item:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .top-bar .dropdown-item.active {
            background-color: var(--primary);
            color: white;
        }
        
        .language-switcher img {
            vertical-align: -0.125em;
        }
        
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
        
        @media (max-width: 576px) {
            .logo-section-bg {
                background-image: linear-gradient(90deg, 
                    rgba(0, 70, 140, 0.1) 0%, 
                    rgba(255, 255, 255, 1) 50%, 
                    rgba(0, 127, 0, 0.1) 100%
                );
            }
        }
        
        .logo-section-flag {
            position: absolute;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            background: url("{{ asset('images/tanzania-flag.png') }}") left center no-repeat;
            background-size: cover;
            /* opacity: 0.4; */
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
            /* opacity: 0.4; */
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
        
        /* Make logos responsive */
        .logo-section img.img-fluid {
            max-height: 90px;
            width: auto;
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
        
        .navbar-main {
            background-color: var(--primary);
            padding: 0;
        }
        
        .navbar-main .nav-link {
            color: white;
            padding: 1rem 1.2rem;
            font-weight: 500;
            transition: var(--transition-speed);
        }
        
        .navbar-main .nav-link:hover,
        .navbar-main .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .navbar-main .dropdown-menu {
            border: none;
            border-radius: 0 0 4px 4px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-top: 0;
        }
        
        .navbar-main .dropdown-item {
            padding: 0.6rem 1.2rem;
            transition: var(--transition-speed);
        }
        
        .navbar-main .dropdown-item:hover {
            background-color: rgba(20, 78, 115, 0.05);
            color: var(--primary);
        }
        
        /* Hero Section */
        .hero-section {
            background: url('/images/government/hero-bg.jpg') no-repeat center center;
            background-size: cover;
            padding: 100px 0;
            position: relative;
            color: white;
        }
        
        .hero-title {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        /* Footer */
        .footer {
            background-color: var(--primary);
            color: white;
            padding: 50px 0 0;
        }
        
        .footer h5 {
            color: white;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer h5:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background-color: var(--accent);
        }
        
        .footer ul {
            list-style: none;
            padding: 0;
        }
        
        .footer ul li {
            margin-bottom: 10px;
        }
        
        .footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: var(--transition-speed);
        }
        
        .footer a:hover {
            color: white;
            padding-left: 5px;
        }
        
        .footer-contact-item {
            display: flex;
            align-items: start;
            margin-bottom: 15px;
        }
        
        .footer-contact-icon {
            width: 30px;
            height: 30px;
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .footer-bottom {
            background-color: rgba(0, 0, 0, 0.2);
            padding: 15px 0;
            margin-top: 30px;
        }
        
        .social-icons a {
            width: 36px;
            height: 36px;
            background-color: rgba(255, 255, 255, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 10px;
            transition: var(--transition-speed);
        }
        
        .social-icons a:hover {
            background-color: var(--accent);
            transform: translateY(-3px);
        }
        
        /* Buttons */
        .btn {
            padding: 0.6rem 1.5rem;
            border-radius: 4px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background-color: #0f3e5e;
            border-color: #0f3e5e;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(20, 78, 115, 0.3);
        }
        
        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary);
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(20, 78, 115, 0.3);
        }
        
        .btn-accent {
            background-color: var(--accent);
            border-color: var(--accent);
            color: var(--dark);
        }
        
        .btn-accent:hover {
            background-color: #e0b607;
            border-color: #e0b607;
            color: var(--dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(241, 196, 15, 0.3);
        }
        
        /* Section Styles */
        .section-title {
            position: relative;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 2rem;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -10px;
            width: 50px;
            height: 3px;
            background-color: var(--accent);
        }
        
        .section-title.text-center:after {
            left: 50%;
            transform: translateX(-50%);
        }
        
        /* General Spacing & Backgrounds */
        .bg-light {
            background-color: var(--light) !important;
        }
        
        .bg-primary {
            background-color: var(--primary) !important;
        }

        /* Visitor Stats Card */
        .visitor-stats-card {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 10px;
        }
        
        .visitor-stats-card .small-title {
            font-size: 0.95rem;
            margin-bottom: 8px;
        }
        
        .visitor-stats {
            display: flex;
            flex-wrap: wrap;
            margin-top: 5px;
        }
        
        .visitor-stat-item {
            flex: 1;
            min-width: 60px;
            text-align: center;
            padding: 5px;
        }
        
        .visitor-stat-value {
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
        }
        
        .visitor-stat-label {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 3px;
        }
        
        /* World Visitors Map */
        #visitor-world-map {
            width: 100%;
            height: 220px;
            border-radius: 5px;
            overflow: hidden;
            position: relative;
        }
        
        /* Micheweni Map */
        #north-pemba-map {
            width: 100%;
            height: 150px;
            border-radius: 5px;
            overflow: hidden;
        }
        
        /* Custom styling for the language switcher */
        .translate-wrapper {
            display: flex;
            align-items: center;
        }
        
        .custom-translator-select {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            border-radius: 4px !important;
            padding: 2px 8px !important;
            font-size: 0.85rem !important;
            height: auto !important;
            cursor: pointer !important;
            width: auto !important;
            min-width: 120px;
        }
        
        .custom-translator-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.2) !important;
            border-color: rgba(255, 255, 255, 0.5) !important;
        }
        
        .custom-translator-select option {
            background-color: white;
            color: #333;
            padding: 5px;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .navbar-main .nav-link {
                padding: 0.7rem 1rem;
            }
            
            .social-icons {
                margin-top: 20px;
                text-align: center;
            }
            
            .copyright {
                text-align: center;
                margin-bottom: 10px;
            }
            
            /* Mobile logo section adjustments */
            .logo-section {
                padding: 10px 0;
            }
            
            .government-title {
                font-size: 1.3rem;
                margin-top: 8px;
            }
            
            .government-subtitle {
                font-size: 0.9rem;
            }
            
            /* Make sure both logos are visible but smaller on mobile */
            .col-md-3.d-none.d-md-block {
                display: block !important;
            }
            
            /* Adjust logo sizes and layout */
            .logo-section .row {
                flex-direction: row;
                justify-content: space-between;
            }
            
            .logo-section img {
                height: 60px;
                max-width: 100%;
            }
        }
        
        /* Extra small screens */
        @media (max-width: 576px) {
            .government-title {
                font-size: 1.1rem;
                margin: 0;
            }
            
            .logo-section {
                padding: 8px 0;
            }
            
            .logo-section img.img-fluid {
                max-height: 50px;
            }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Skip link for accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>
    
    <!-- Top Bar -->
    <header role="banner">
        <div class="top-bar">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-none d-md-flex" ">
                        <!-- <a href="mailto:info@micheweni.go.tz" style="color: white !important;"><i class="fas fa-envelope me-1"></i> info@micheweni.go.tz</a>
                        <a href="tel:+255777123456" style="color: white !important;"><i class="fas fa-phone me-1"></i> +255 777 123 456</a>
                     -->
                     @if(isset($siteContactInfo['emails']) && count($siteContactInfo['emails']) > 0)
                        <a href="mailto:{{ $siteContactInfo['emails'][0] }}" style="color: white !important;">
                            {{ $siteContactInfo['emails'][0] }}
                        </a><br>
                    @endif

                    @if(isset($siteContactInfo['phones']) && count($siteContactInfo['phones']) > 0)
                        <a href="tel:{{ $siteContactInfo['phones'][0] }}" style="color: white !important;">
                            {{ $siteContactInfo['phones'][0] }}
                        </a><br>
                    @endif
                    </div>
                    <div class="d-flex align-items-center">
                        <!-- Search bar -->
                        <form action="{{ route('government.search') }}" method="GET" class="me-3">
                            <div class="input-group input-group-sm">
                                <input type="text" name="query" class="form-control" placeholder="{{ __('Search...') }}" aria-label="Search" required>
                                <button class="btn btn-light" type="submit" aria-label="Search">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                        
                        <!-- Language switcher -->
                        <div class="language-switcher me-3">
                            <div class="translate-wrapper">
                                <select id="language-select" class="form-select form-select-sm custom-translator-select" onchange="changeLanguage(this.value)">
                                    <option value="en">English</option>
                                    <option value="sw">Kiswahili</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <!--<a class="btn btn-sm btn-link text-white px-2 py-1" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt me-1"></i>{{ __('Login') }}
                                </a>-->
                            @endif

                            @if (Route::has('register'))
                                <!--<a class="btn btn-sm btn-success text-white ms-2" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus me-1"></i>{{ __('Register') }}
                                </a>-->
                            @endif
                        @else
                            <div class="dropdown">
                                <a class="btn btn-sm btn-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    @if (Auth::user()->hasRole('admin'))
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.government.dashboard') }}">
                                                <i class="fas fa-tachometer-alt me-2"></i> {{ __('Admin Dashboard') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.home-config-guide') }}">
                                                <i class="fas fa-home me-2"></i> {{ __('Home Config Guide') }}
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                    @endif
                                    
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('gov-logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i> {{ __('Logout') }}
                                        </a>
                                    </li>

                                    <form id="gov-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </ul>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Logo Section -->
    <div class="logo-section">
        <div class="logo-section-bg"></div>
        <div class="logo-section-flag"></div>
        <div class="logo-section-pemba"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-4 col-md-3 d-flex align-items-center justify-content-start">
                    <div>
                        <img src="{{ asset('images/logo.png') }}" alt="Micheweni Government" height="90" class="img-fluid">
                    </div>
                </div>
                <div class="col-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                    <h6 class="d-none d-sm-block">Revolutionary Government of Zanzibar</h6>
                    <h1 class="government-title">Micheweni District Council</h1>
                    <div class="government-subtitle d-none d-sm-block">Pemba, Zanzibar - Tanzania</div>
                </div>
                <div class="col-4 col-md-3 d-flex align-items-center justify-content-end">
                    <div class="coat-of-arms">
                        <img src="{{ asset('images/zanzibar-logo.png') }}" alt="Zanzibar Coat of Arms" height="90" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Navigation -->
    @include('government.partials.navigation')
    
    <!-- News Ticker -->
    @include('government.partials.news-ticker')
    
    <!-- Main Content -->
    <main id="main-content" role="main">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-logo mb-4">
                        <img src="{{ asset('images/logo-white.png') }}" alt="Micheweni District Council" height="70">
                    </div>
                    <p class="mb-4">{{ __('Micheweni District Council is committed to providing quality services to all citizens and visitors. We strive for transparency, efficiency and community empowerment.') }}</p>
                    
                    <div class="social-icons">
                        @if(isset($socialLinks) && is_array($socialLinks))
                            @foreach($socialLinks as $platform => $url)
                                @if(!empty($url))
                                    <a href="{{ $url }}" aria-label="{{ ucfirst($platform) }}">
                                        <i class="fab fa-{{ $platform }}"></i>
                                    </a>
                                @endif
                            @endforeach
                        @else
                            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        @endif
                    </div>
                    
                    @if(isset($visitorStats))
                    <div class="visitor-stats-card mt-3">
                        <h5 class="small-title"><i class="fas fa-chart-line me-2"></i> Site Visitors</h5>
                        <div class="visitor-stats">
                            <div class="visitor-stat-item">
                                <div class="visitor-stat-value">{{ number_format($visitorStats['total']) }}</div>
                                <div class="visitor-stat-label">Total</div>
                            </div>
                            <div class="visitor-stat-item">
                                <div class="visitor-stat-value">{{ number_format($visitorStats['unique']) }}</div>
                                <div class="visitor-stat-label">Unique</div>
                            </div>
                            <div class="visitor-stat-item">
                                <div class="visitor-stat-value">{{ number_format($visitorStats['today']) }}</div>
                                <div class="visitor-stat-label">Today</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div id="visitor-world-map"></div>
                    </div>
                    @endif
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5>Quick Links</h5>
                    <ul>
                        <li><a href="https://www.ikuluzanzibar.go.tz/">State House Zanzibar</a></li>
                        <li><a href="https://tamisemi.go.tz">TAMISEMI</a></li>
                        <li><a href="https://www.egaz.go.tz/">Zanzibar e-Government Authority (eGAZ)</a></li>
                        <li><a href="https://www.zec.go.tz/">Zanzibar Electoral Commission (ZEC)</a></li>
                        <li><a href="https://www.zanzibarassembly.go.tz/laws">Laws & Policies</a></li>
                        <li><a href="https://www.chuochamafunzohq.go.tz/">Mafunzo</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 mb-4">
                    <h5>Government Resources</h5>
                    <ul>
                        <li><a href="{{ url('/government/publications') }}">Publications</a></li>
                        <li><a href="{{ url('/government/news-new') }}">News & Updates</a></li>
                        <!-- <li><a href="{{ url('/government/circular-economy') }}">Circular Economy</a></li> -->
                        <li><a href="{{ url('/government/media/gallery') }}">Photo Gallery</a></li>
                        <!-- <li><a href="{{ url('/waste') }}">Waste Management</a></li> -->
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 mb-4">
                    <h5>Contact Information</h5>
                    <!-- Micheweni Map -->
                    <div id="north-pemba-map" class="mb-3"></div>
                    <div class="footer-contact">
                        <div class="footer-contact-item">
                            <div class="footer-contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                {{ $siteContactInfo['address']}}
                            </div>
                        </div>
                        <div class="footer-contact-item">
                            <div class="footer-contact-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                @if(isset($siteContactInfo['phones']) && count($siteContactInfo['phones']) > 0)
                                    @foreach($siteContactInfo['phones'] as $phone)
                                        <a href="tel:{{ $phone }}" style="color: white !important;">{{ $phone }}</a><br>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="footer-contact-item">
                            <div class="footer-contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                @if(isset($siteContactInfo['emails']) && count($siteContactInfo['emails']) > 0)
                                    @foreach($siteContactInfo['emails'] as $email)
                                        <a href="mailto:{{ $email }}" style="color: white !important;">{{ $email }}</a><br>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 copyright">
                        <p class="mb-0">&copy; {{ date('Y') }} Micheweni District Council. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                                        <!-- <a href="{{ url('/privacy-policy') }}">Privacy Policy</a> | 
                        <a href="{{ url('/terms-of-use') }}">Terms of Use</a> | 
                        <a href="{{ url('/accessibility') }}">Accessibility</a> | -->
                        <a href="{{ url('/sitemap') }}">Sitemap</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Google Translate Integration (hidden) -->
    <div id="google_translate_element" style="display: none;"></div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
    <!-- AOS JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=places"></script>
    
    <!-- Custom Map Scripts -->
    <script src="{{ asset('js/maps/worldMap.js') }}"></script>
    
     <!-- Google Translate Script -->
     <script type="text/javascript">
        var googleTranslateElementInit = function() {
            new google.translate.TranslateElement({
                pageLanguage: 'auto',
                includedLanguages: 'en,sw',
                autoDisplay: false
            }, 'google_translate_element');
            
            // Auto-translate on first load
            setTimeout(function() {
                // Check if we need to translate
                if (!localStorage.getItem('selectedLanguage') || localStorage.getItem('selectedLanguage') === 'sw') {
                    document.cookie = 'googtrans=/auto/sw; path=/;';
                    document.cookie = `googtrans=/auto/sw; path=/; domain=${window.location.hostname}`;
                } else if (localStorage.getItem('selectedLanguage') === 'en') {
                    document.cookie = 'googtrans=/auto/en; path=/;';
                    document.cookie = `googtrans=/auto/en; path=/; domain=${window.location.hostname}`;
                }
            }, 500);
        };
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    
    <!-- Main JS -->
    <script>
    // Initialize AOS animations
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });
    
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // Sticky Navigation
    window.addEventListener('scroll', function() {
        var navbar = document.querySelector('.navbar-main');
        if (window.scrollY > 200) {
            navbar.classList.add('sticky-top');
            navbar.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.1)';
        } else {
            navbar.classList.remove('sticky-top');
            navbar.style.boxShadow = 'none';
        }
    });
    
    // Initialize maps when document is ready
    $(document).ready(function(){
        // Initialize North Pemba Map with Google Maps
        if ($('#north-pemba-map').length) {
            // Micheweni coordinates
            const micheweniCoords = {lat: -4.9667, lng: 39.8333};
            
            // Create map
            const micheweniMap = new google.maps.Map(document.getElementById("north-pemba-map"), {
                center: micheweniCoords,
                zoom: 11,                
                disableDefaultUI: false,
                zoomControl: true,
                draggable: false
            });
            
            // Add a marker for Micheweni
            new google.maps.Marker({
                position: weteCoords,
                map: micheweniMap,
                title: "Micheweni District"
            });
        }
        
        // World Map is initialized in worldMap.js
    });

    </script>
      
<script>
    function changeLanguage(lang) {
        localStorage.setItem('selectedLanguage', lang);

        if (lang === 'en') {
            // Set translation to English
            document.cookie = 'googtrans=/auto/en; path=/;';
            document.cookie = `googtrans=/auto/en; path=/; domain=${window.location.hostname}`;
            console.log("Switched to EN - Cookie set to auto detect and translate to English");
        } else if (lang === 'sw') {
            // Set translation to Swahili
            document.cookie = 'googtrans=/auto/sw; path=/;';
            document.cookie = `googtrans=/auto/sw; path=/; domain=${window.location.hostname}`;
            console.log("Switched to SW - Cookie set to auto detect and translate to Swahili");
        }

        // Reload once after language change
        location.reload();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const lang = localStorage.getItem('selectedLanguage') || 'en';
        const select = document.getElementById('language-select');
        if (select) select.value = lang;
        
        const cookieLang = getCookieValue('googtrans');
        console.log('LocalStorage:', lang, '| Cookie:', cookieLang);
        
        // Check if translator needs to be initialized
        if (lang === 'en' && (!cookieLang || !cookieLang.endsWith('/en'))) {
            document.cookie = 'googtrans=/auto/en; path=/;';
            document.cookie = `googtrans=/auto/en; path=/; domain=${window.location.hostname}`;
        } else if (lang === 'sw' && (!cookieLang || !cookieLang.endsWith('/sw'))) {
            document.cookie = 'googtrans=/auto/sw; path=/;';
            document.cookie = `googtrans=/auto/sw; path=/; domain=${window.location.hostname}`;
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

    <!-- Page-specific scripts -->
    @stack('scripts')
</body>
</html>