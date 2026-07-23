<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - MICHEWENI WASTE PORTAL</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <style>
        /* Responsive styles for logo section */
        .gov-logo {
            max-height: 70px;
            width: auto;
        }
        
        .portal-title {
            font-size: 1.6rem;
            font-weight: 700;
        }
        
        @media (max-width: 768px) {
            .gov-logo {
                max-height: 55px;
            }
            .portal-title {
                font-size: 1.3rem;
            }
        }
        
        @media (max-width: 576px) {
            .gov-logo {
                max-height: 45px;
            }
            .portal-title {
                font-size: 1.1rem;
            }
            .gov-header {
                padding-top: 10px;
                padding-bottom: 10px;
            }
        }
    </style>

    <!-- Page-specific styles -->
    @yield('styles')
</head>
<body>
    <div id="app">
        <!-- Top Government Header Bar -->
        <div class="gov-header bg-light py-2">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-4 col-md-4 text-start">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/logo-left.png') }}" alt="Government of Tanzania Logo" class="gov-logo img-fluid">
                        </a>
                    </div>
                    <div class="col-4 col-md-4 text-center">
                        <h1 class="portal-title">MICHEWENI PORTAL</h1>
                    </div>
                    <div class="col-4 col-md-4 text-end">
                        <img src="{{ asset('images/logo-right.png') }}" alt="Micheweni District Council Logo" class="gov-logo img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top shadow-sm">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about*') ? 'active' : '' }}" href="{{ route('opportunities.circular-economy.about') }}">About</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('waste*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Waste Management
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.waste.map') }}">Waste Map</a></li>
                                <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.waste.collection') }}">Collection Points</a></li>
                                <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.waste.recycling') }}">Recycling Centers</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.waste.directory') }}">Service Providers</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('assessment*') ? 'active' : '' }}" href="{{ route('opportunities.circular-economy.assessment') }}">Assessment Tools</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('data*') ? 'active' : '' }}" href="{{ route('opportunities.circular-economy.data.dashboard') }}">Data & Reports</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('resources*') ? 'active' : '' }}" href="{{ route('opportunities.circular-economy.resources') }}">Resources</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('news*') ? 'active' : '' }}" href="{{ route('opportunities.circular-economy.news.index') }}">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('opportunities.circular-economy.contact') }}">Contact</a>
                        </li>
                    </ul>
                    
                    <div class="d-flex">
                        @guest
                        @else
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @if(Auth::user()->hasRole('admin'))
                                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.admin.dashboard') }}">Admin Dashboard</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                    @endif
                                    <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.profile') }}">My Profile</a></li>
                                    <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.profile.assessments') }}">My Assessments</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}" 
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-4">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-dark text-white pt-5 pb-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <h5 class="text-uppercase mb-4">MICHEWENI-WASTE PORTAL</h5>
                        <p>A comprehensive platform for waste management and circular economy information for Micheweni District Council.</p>
                        <div class="mt-4">
                            <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <h5 class="text-uppercase mb-4">Quick Links</h5>
                        <ul class="list-unstyled">
                        <li><a href="https://www.ikuluzanzibar.go.tz/">State House Zanzibar</a></li>
                        <li><a href="https://tamisemi.go.tz">TAMISEMI</a></li>
                        <li><a href="https://www.egaz.go.tz/">Zanzibar e-Government Authority (eGAZ)</a></li>
                        <li><a href="https://www.zec.go.tz/">Zanzibar Electoral Commission (ZEC)</a></li>
                        <li><a href="https://www.zanzibarassembly.go.tz/laws">Laws & Policies</a></li>
                        <li><a href="https://www.chuochamafunzohq.go.tz/">Mafunzo</a></li>
                    </ul>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <h5 class="text-uppercase mb-4">Contact</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Micheweni District Council, Pemba Island, Tanzania</li>
                            <li class="mb-2"><i class="fas fa-phone me-2"></i> +255 XXX XXX XXX</li>
                            <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@wetewasteportal.go.tz</li>
                        </ul>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <h5 class="text-uppercase mb-4">Subscribe</h5>
                        <p>Stay updated with our latest news and updates.</p>
                        <form action="{{ route('opportunities.circular-economy.newsletter.subscribe') }}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="Your Email" name="email" required>
                                <button class="btn btn-success" type="submit">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <hr class="mt-4">
                
                <div class="row">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-0">&copy; {{ date('Y') }} MICHEWENI WASTE PORTAL. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <a href="{{ route('opportunities.circular-economy.privacy') }}" class="text-white text-decoration-none me-3">Privacy Policy</a>
                        <a href="{{ route('opportunities.circular-economy.terms') }}" class="text-white text-decoration-none me-3">Terms of Use</a>
                        <a href="{{ route('opportunities.circular-economy.accessibility') }}" class="text-white text-decoration-none">Accessibility</a>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <button id="back-to-top" class="btn btn-sm btn-success rounded-circle">
                        <i class="fas fa-arrow-up"></i>
                    </button>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <!-- Custom JavaScript -->
        <script src="{{ asset('js/app.js') }}"></script>
        
        <!-- Back to top script -->
        <script>
            $(document).ready(function() {
                $(window).scroll(function() {
                    if ($(this).scrollTop() > 100) {
                        $('#back-to-top').fadeIn();
                    } else {
                        $('#back-to-top').fadeOut();
                    }
                });
                
                $('#back-to-top').click(function() {
                    $('html, body').animate({scrollTop: 0}, 300);
                    return false;
                });
            });
        </script>
        
        <!-- Page-specific scripts -->
        @yield('scripts')
    </div>
</body>
</html> 