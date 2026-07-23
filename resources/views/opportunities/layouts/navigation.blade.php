<!-- Top Toolbar -->
<div class="top-toolbar bg-light py-2 border-bottom">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="toolbar-contact d-none d-md-flex">
                <span class="me-3"><i class="fas fa-phone-alt me-1 text-primary" aria-hidden="true"></i> +255 777 123 456</span>
                <span><i class="fas fa-envelope me-1 text-primary" aria-hidden="true"></i> info@weteportal.org</span>
            </div>
            <div class="d-flex align-items-center">
                <!-- Language Switcher -->
                <div class="language-switcher me-3" role="region" aria-label="Language selector">
                    <a href="#" onclick="changeLanguage('en')" class="btn btn-sm {{ app()->getLocale() == 'en' ? 'btn-primary' : 'btn-outline-secondary' }} me-1" aria-pressed="{{ app()->getLocale() == 'en' ? 'true' : 'false' }}">
                        <img src="{{ asset('images/flags/en.png') }}" alt="English" width="16" height="12" class="me-1">EN
                    </a>
                    <a href="#" onclick="changeLanguage('sw')" class="btn btn-sm {{ app()->getLocale() == 'sw' ? 'btn-primary' : 'btn-outline-secondary' }}" aria-pressed="{{ app()->getLocale() == 'sw' ? 'true' : 'false' }}">
                        <img src="{{ asset('images/flags/tanzania.png') }}" alt="Swahili" width="16" height="12" class="me-1">SW
                    </a>
                </div>
                
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <a class="nav-link btn btn-sm btn-link px-2 text-muted" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1" aria-hidden="true"></i>{{ __('Login') }}
                        </a>
                    @endif

                    @if (Route::has('register'))
                        <a class="nav-link btn btn-sm btn-primary text-white ms-2" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1" aria-hidden="true"></i>{{ __('Register') }}
                        </a>
                    @endif
                @else
                    <div class="dropdown">
                        <a class="btn btn-sm btn-link dropdown-toggle text-muted" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                            <i class="fas fa-user-circle me-1" aria-hidden="true"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-label="User menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('opportunities.saved') }}">
                                    <i class="fas fa-user me-2" aria-hidden="true"></i> {{ __('My Profile') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('opportunities.saved') }}">
                                    <i class="fas fa-bookmark me-2" aria-hidden="true"></i> {{ __('Saved Opportunities') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('opportunities.applications') }}">
                                    <i class="fas fa-clipboard-list me-2" aria-hidden="true"></i> {{ __('My Applications') }}
                                </a>
                            </li>
                            
                            @if (Auth::user()->hasRole('admin'))
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2" aria-hidden="true"></i> {{ __('Admin Dashboard') }}
                                    </a>
                                </li>
                            @endif
                            
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2" aria-hidden="true"></i> {{ __('Logout') }}
                                </a>
                            </li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</div>

<!-- CSS for Header with Logo Section -->
<style>
    /* Logo Section */
    .logo-header {
        padding: 20px 0;
        position: relative;
        overflow: hidden;
    }
    
    .logo-header-bg {
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
    
    .logo-header-flag {
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
    
    .logo-header-pemba {
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
    
    .logo-header .container {
        position: relative;
        z-index: 1;
    }
    
    /* Logo image styling */
    .logo-header img.img-fluid {
        max-height: 70px;
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
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .logo-header {
            padding: 10px 0;
        }
        
        .government-title {
            font-size: 1.3rem;
            margin-top: 8px;
        }
        
        .government-subtitle {
            font-size: 0.9rem;
        }
        
        .logo-header img.img-fluid {
            max-height: 60px;
        }
    }
    
    /* Extra small screens */
    @media (max-width: 576px) {
        .government-title {
            font-size: 1.1rem;
            margin: 0;
        }
        
        .logo-header {
            padding: 8px 0;
        }
        
        .logo-header img.img-fluid {
            max-height: 50px;
        }
        
        .logo-header-bg {
            background-image: linear-gradient(90deg, 
                rgba(0, 70, 140, 0.1) 0%, 
                rgba(255, 255, 255, 1) 50%, 
                rgba(0, 127, 0, 0.1) 100%
            );
        }
    }
</style>

<!-- Main Header with Government Layout Style -->
<header class="main-header logo-header">
    <!-- Background elements -->
    <div class="logo-header-bg"></div>
    <div class="logo-header-flag"></div>
    <div class="logo-header-pemba"></div>
    
    <div class="container">
        <div class="row align-items-center">
            <div class="col-4 col-md-3 d-flex align-items-center justify-content-start">
                <div>
                    <img src="{{ asset('images/logo.png') }}" alt="Micheweni Government" class="img-fluid">
                </div>
            </div>
            
            <div class="col-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                <h6 class="mb-1 d-none d-sm-block">Revolutionary Government of Zanzibar</h6>
                <h1 class="government-title">MICHEWENI OPPORTUNITIES</h1>
                <div class="government-subtitle d-none d-sm-block">Connecting People with Opportunities</div>
            </div>
            
            <div class="col-4 col-md-3 d-flex justify-content-end align-items-center">
                <img src="{{ asset('images/zanzibar-logo.png') }}" alt="Zanzibar Coat of Arms" class="img-fluid">
            </div>
        </div>
    </div>
</header>

<!-- Main Navigation - Sticky -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-navbar" id="main-navbar" role="navigation" aria-label="Main Navigation">
    <div class="container">
        <a class="navbar-brand d-lg-none" href="{{ route('opportunities.index') }}">
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Opportunities Portal') }}" height="40" class="d-inline-block align-text-top me-2">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Main Menu -->
            <ul class="navbar-nav mx-auto">
                <!-- Home -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('opportunities.index') ? 'active' : '' }}" href="{{ route('opportunities.index') }}" aria-current="{{ request()->routeIs('opportunities.index') ? 'page' : 'false' }}">
                        <i class="fas fa-home me-1" aria-hidden="true"></i>{{ __('Home') }}
                    </a>
                </li>
                
                <!-- Circular Economy Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link {{ request()->routeIs('opportunities.circular-economy.*') ? 'active' : '' }} dropdown-toggle" href="{{ route('opportunities.circular-economy.waste.home') }}" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-recycle me-1"></i>{{ __('Circular Economy') }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.home') }}">{{ __('Overview') }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.waste.home') }}">{{ __('Waste Management') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.assessment.index') }}">{{ __('Assessment Tools') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.data.dashboard') }}">{{ __('Data Dashboard') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.news.index') }}">{{ __('News & Updates') }}</a></li>
                    </ul>
                </li>
                
                <!-- Business Opportunities -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('opportunities.business.*') ? 'active' : '' }}" href="{{ route('opportunities.index') }}#business">
                        <i class="fas fa-briefcase me-1"></i>{{ __('Business') }}
                    </a>
                </li>
                
                <!-- Agricultural Opportunities -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('opportunities.agriculture.*') ? 'active' : '' }}" href="{{ route('opportunities.index') }}#agriculture">
                        <i class="fas fa-leaf me-1"></i>{{ __('Agriculture') }}
                    </a>
                </li>
                
                <!-- Tourism & Culture -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('opportunities.tourism.*') ? 'active' : '' }}" href="{{ route('opportunities.index') }}#tourism">
                        <i class="fas fa-umbrella-beach me-1"></i>{{ __('Tourism & Culture') }}
                    </a>
                </li>
                
                <!-- Contact -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('opportunities.contact') ? 'active' : '' }}" href="{{ route('opportunities.contact') }}">
                        <i class="fas fa-envelope me-1"></i>{{ __('Contact') }}
                    </a>
                </li>
                
                <!-- Search -->
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="fas fa-search me-1"></i>{{ __('Search') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">{{ __('Search Opportunities') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('opportunities.search') }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="q" placeholder="{{ __('Search for opportunities...') }}" aria-label="Search">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Category') }}</label>
                        <select class="form-select" name="category">
                            <option value="">{{ __('All Categories') }}</option>
                            <option value="circular-economy">{{ __('Circular Economy') }}</option>
                            <option value="business">{{ __('Business') }}</option>
                            <option value="agriculture">{{ __('Agriculture') }}</option>
                            <option value="tourism">{{ __('Tourism & Culture') }}</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- CSS for Sticky Header -->
<style>
    .top-toolbar {
        font-size: 0.85rem;
    }
    
    .main-header {
        transition: all 0.3s ease;
    }
    
    .sticky-navbar {
        transition: all 0.3s ease;
    }
    
    .navbar-dark .navbar-nav .nav-link {
        color: rgba(255, 255, 255, 0.85);
        font-weight: 500;
        padding: 0.8rem 1rem;
        transition: all 0.3s ease;
    }
    
    .navbar-dark .navbar-nav .nav-link:hover,
    .navbar-dark .navbar-nav .nav-link:focus,
    .navbar-dark .navbar-nav .nav-link.active {
        color: #fff;
        background-color: rgba(255, 255, 255, 0.1);
    }
    
    .dropdown-menu {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    
    .dropdown-item.active, 
    .dropdown-item:active {
        background-color: #0d6efd;
    }
    
    /* Mega menu hover effect */
    @media (min-width: 992px) {
        .navbar-nav .dropdown:hover > .dropdown-menu {
            display: block;
            animation: fadeInUp 0.3s ease forwards;
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translate3d(0, 10px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sticky navbar on scroll
        const navbar = document.getElementById('main-navbar');
        const sticky = navbar.offsetTop;
        
        window.onscroll = function() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add('fixed-top');
                document.body.style.paddingTop = navbar.offsetHeight + 'px';
            } else {
                navbar.classList.remove('fixed-top');
                document.body.style.paddingTop = '0';
            }
        };
    });
</script> 