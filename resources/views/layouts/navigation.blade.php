<!-- Top Toolbar -->
<div class="top-toolbar bg-light py-2 border-bottom">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="toolbar-contact d-none d-md-flex">
                <span class="me-3"><i class="fas fa-phone-alt me-1 text-success"></i> +255 777 123 456</span>
                <span><i class="fas fa-envelope me-1 text-success"></i> info@wetewasteportal.org</span>
            </div>
            <div class="d-flex align-items-center">
                <!-- Language Switcher -->
                @include('opportunities.circular-economy.components.language-switcher')
                
                <!-- Authentication Links -->
                @guest
                   
                @else
                    <div class="dropdown">
                        <a class="btn btn-sm btn-link dropdown-toggle text-muted" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> {{ __('Logout') }}
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
</style>

<!-- Main Header with Government Layout Style -->
<header class="main-header logo-header">
    <!-- Background elements -->
    <div class="logo-header-bg"></div>
    <div class="logo-header-flag"></div>
    <div class="logo-header-pemba"></div>
    
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-3 d-flex align-items-center justify-content-start">
                <div>
                    <img src="{{ asset('images/logo.png') }}" alt="Micheweni Government" height="70">
                </div>
            </div>
            
            <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
                <h6 class="mb-1">Revolutionary Government of Zanzibar</h6>
                <h1 class="government-title">MICHEWENI - PEMBA WASTE MANAGEMENT</h1>
                <div class="government-subtitle">Sustainable Waste Solutions for a Cleaner Tomorrow</div>
            </div>
            
            <div class="col-md-3 d-none d-md-flex justify-content-end align-items-center">
                <img src="{{ asset('images/zanzibar-logo.png') }}" alt="Zanzibar Coat of Arms" height="70">
            </div>
        </div>
    </div>
</header>

<!-- Main Navigation - Sticky -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-navbar" id="main-navbar">
    <div class="container">
        <a class="navbar-brand d-lg-none" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Micheweni Waste Portal') }}" height="40" class="d-inline-block align-text-top me-2">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Main Menu -->
            <ul class="navbar-nav mx-auto">
                <!-- Home Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }} dropdown-toggle" href="{{ route('home') }}" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-home me-1"></i>{{ __('Home') }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('home') }}">{{ __('Homepage') }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.news.index') }}">{{ __('News & Updates') }}</a></li>
                    </ul>
                </li>
                
                <!-- About Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link {{ request()->routeIs('opportunities.circular-economy.about') ? 'active' : '' }} dropdown-toggle" href="{{ route('opportunities.circular-economy.about') }}" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-info-circle me-1"></i>{{ __('About') }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.about') }}">{{ __('About Us') }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.about') }}#mission">{{ __('Our Mission') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.about') }}#team">{{ __('Our Team') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.about') }}#achievements">{{ __('Achievements') }}</a></li>
                    </ul>
                </li>
                
                <!-- Services Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link {{ request()->routeIs('services') || request()->routeIs('waste.*') ? 'active' : '' }} dropdown-toggle" href="{{ route('opportunities.circular-economy.services') }}" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-recycle me-1"></i>{{ __('Services') }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.services') }}">{{ __('All Services') }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.waste.collection') }}">{{ __('Waste Collection') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.waste.recycling') }}">{{ __('Recycling') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.waste.map') }}">{{ __('Interactive Waste Map') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.waste.marketplace') }}">{{ __('Waste Trading Marketplace') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.waste.directory') }}">{{ __('Service Directory') }}</a></li>
                    </ul>
                </li>
                
                <!-- Assessment -->
                <li class="nav-item dropdown">
                    <a class="nav-link {{ request()->routeIs('opportunities.circular-economy.assessment.*') ? 'active' : '' }} dropdown-toggle" href="{{ route('opportunities.circular-economy.assessment.index') }}" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-clipboard-check me-1"></i>{{ __('Assessment') }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.assessment.index') }}">{{ __('Assessment Overview') }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.assessment.section', 'waste_collection') }}">{{ __('Waste Collection Assessment') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.assessment.section', 'recycling') }}">{{ __('Recycling Assessment') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.assessment.section', 'circular_design') }}">{{ __('Circular Design Assessment') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.assessment.section', 'policy') }}">{{ __('Policy Assessment') }}</a></li>
                    </ul>
                </li>
                
                <!-- Data Dashboard -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('data.*') ? 'active' : '' }}" href="{{ route('opportunities.circular-economy.data.dashboard') }}">
                        <i class="fas fa-chart-bar me-1"></i>{{ __('Data Dashboard') }}
                    </a>
                </li>
                
                <!-- Resources -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('resources') ? 'active' : '' }}" href="{{ route('opportunities.circular-economy.resources') }}">
                        <i class="fas fa-book me-1"></i>{{ __('Resources') }}
                    </a>
                </li>
                
                <!-- Contact -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('opportunities.circular-economy.contact') }}">
                        <i class="fas fa-envelope me-1"></i>{{ __('Contact') }}
                    </a>
                </li>
                
                <!-- Dynamic CMS Pages -->
                @php
                    try {
                        $navigationPages = \App\Http\Controllers\Opportunities\CircularEconomy\PageController::getNavigationPages();
                    } catch (\Exception $e) {
                        $navigationPages = collect([]);
                    }
                @endphp
                
                @if(isset($navigationPages) && $navigationPages->count() > 0)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-file-alt me-1"></i>{{ __('More') }}
                        </a>
                        <ul class="dropdown-menu">
                    @foreach($navigationPages as $navPage)
                                <li>
                                    <a class="dropdown-item {{ request()->is('page/' . $navPage->slug) ? 'active' : '' }}" 
                           href="{{ route('opportunities.circular-economy.page.show', $navPage->slug) }}">
                            {{ $navPage->title }}
                        </a>
                    </li>
                    @endforeach
            </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav> 

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
        background-color: #198754;
    }
    
    /* Mega menu hover effect */
    @media (min-width: 992px) {
        .navbar-nav .dropdown:hover > .dropdown-menu {
            display: block;
            animation: fadeInUp 0.3s ease forwards;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    }
    
    /* Sticky header effect */
    .sticky {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        animation: slideDown 0.5s ease forwards;
    }
    
    @keyframes slideDown {
        from {
            transform: translateY(-100%);
        }
        to {
            transform: translateY(0);
        }
    }
    
    body.has-sticky-navbar {
        padding-top: 56px;
    }
</style>

<!-- JavaScript for Sticky Header -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.getElementById('main-navbar');
        const mainHeader = document.querySelector('.main-header');
        const sticky = navbar.offsetTop;
        
        function handleScroll() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add('sticky');
                document.body.classList.add('has-sticky-navbar');
                mainHeader.style.display = 'none';
            } else {
                navbar.classList.remove('sticky');
                document.body.classList.remove('has-sticky-navbar');
                mainHeader.style.display = 'block';
            }
        }
        
        window.addEventListener('scroll', handleScroll);
    });
</script>
@endpush 