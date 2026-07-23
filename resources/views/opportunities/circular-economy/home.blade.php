@extends('opportunities.layouts.app')

@section('title', __('Welcome to Micheweni Waste Portal'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/custom-animations.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jvectormap@2.0.4/jquery-jvectormap.min.css">
<link rel="stylesheet" href="{{ asset('css/particles.css') }}">
<style>
    /* Custom styles for home page */
    /* .hero-section {
        position: relative;
        overflow: hidden;
        min-height: 600px;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    } */
    
    /* .hero-section {
        position: relative;
        overflow: hidden;
        min-height: 600px;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    } */
    
    /* .hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }
    
    .hero-content {
        position: relative;
        z-index: 1;
    } */
    
    .circular-economy-container {
        position: relative;
        width: 100%;
        height: 400px;
    }
    
    .circular-economy-step {
        position: absolute;
        width: 80px;
        height: 80px;
        background-color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        z-index: 2;
        cursor: pointer;
    }
    
    .circular-economy-step i {
        font-size: 2rem;
        color: #28a745;
    }
    
    .circular-economy-path {
        position: absolute;
        width: 80%;
        height: 80%;
        top: 10%;
        left: 10%;
        border-radius: 50%;
        border: 2px dashed rgba(255,255,255,0.5);
        z-index: 1;
    }
    
    .circular-economy-icon {
        transition: transform 0.5s ease, box-shadow 0.5s ease;
    }
    
    .circular-economy-icon:hover {
        transform: scale(1.1);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    
    /* .progress-leaderboard {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    } */
    
    .progress-leaderboard {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .country-progress-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .country-progress-item:hover {
        background: rgba(255,255,255,0.2);
        transform: translateX(5px);
    }
    
    .country-flag {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 10px;
        object-fit: cover;
    }
    
    .progress-bar-custom {
        height: 8px;
        border-radius: 4px;
        background: rgba(255,255,255,0.2);
    }
    
    .progress-value {
        height: 100%;
        border-radius: 4px;
        background: #ffffff;
        position: relative;
    }
    
    .achievement-banner {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        border-radius: 10px;
        padding: 15px;
        margin-top: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .achievement-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0) 70%);
        animation: shimmer 3s infinite;
    }
    
    .globe-snapshot {
        position: relative;
        width: 100%;
        height: 400px;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 15px;
        color: #333; /* Ensure visible text color */
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: #28a745;
        transition: width 0.3s ease;
    }
    
    .section-title:hover::after {
        width: 100%;
    }
    
    .service-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .service-card:hover {
        transform: translateY(-10px);
    }
    
    .service-card-icon {
        width: 60px;
        height: 60px;
        background-color: rgba(40, 167, 69, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    
    .service-card:hover .service-card-icon {
        background-color: #28a745;
        color: white;
        transform: rotate(10deg);
    }

    .step-tooltip {
        position: absolute;
        background: rgba(0,0,0,0.8);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.8rem;
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
        width: max-content;
        max-width: 150px;
        text-align: center;
        z-index: 10;
        bottom: 90px;
    }

    .circular-economy-step:hover .step-tooltip {
        opacity: 1;
    }

    .how-it-works-icon {
        width: 80px;
        height: 80px;
        background-color: rgba(25, 135, 84, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .stat-item.compact {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        margin-bottom: 10px;
    }
    
    .stat-item.compact .stat-icon {
        margin-right: 15px;
    }
    
    .stat-item.compact .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1.2;
    }
    
    .stat-item.compact .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    .custom-marker {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 32px !important;
        height: 32px !important;
        background-color: #fff;
        border-radius: 50%;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }
    
    .custom-marker i {
        font-size: 16px;
    }
    
    .custom-marker {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 32px !important;
        height: 32px !important;
        background-color: #fff;
        border-radius: 50%;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }
    
    .custom-marker i {
        font-size: 16px;
    }
</style>
@endsection

@section('content')
    <!-- Hero Section with Animated Circular Economy -->
    <section class="hero-section py-5 text-white">
        <div class="hero-particles" id="particles-js"></div>
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-6 animate-fade-in-left">
                    <h1 class="display-4 fw-bold mb-4">
                       
                            {{ __('Building Circular Economy Solutions') }}
                           
                    </h1>
                    <p class="lead mb-4">
                        
                            {{ __('Assess, monitor, and improve waste management practices for a sustainable future.') }}
                        
                    </p>
                    <div class="d-flex flex-wrap gap-3 mb-5">
                        <a href="{{ route('opportunities.circular-economy.assessment.index') }}" class="btn btn-light btn-lg btn-ripple">
                            <i class="fas fa-clipboard-check me-2"></i> {{ __('Start Assessment') }}
                        </a>
                        <a href="{{ route('opportunities.circular-economy.waste.map') }}" class="btn btn-outline-light btn-lg btn-hover-effect">
                            <i class="fas fa-map-marker-alt me-2"></i> {{ __('Explore Waste Map') }}
                        </a>
                    </div>
                    
                    <!-- Achievement Banner -->
                    <div class="achievement-banner animate-fade-in mt-4">
                        <div class="d-flex align-items-center">
                            <div class="achievement-badge me-3">
                                <i class="fas fa-award fa-2x text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 text-white">{{ __('Pemba reached 72% Circularity this year!') }} 🎉</h5>
                                <p class="mb-0 text-white-50">{{ __('Setting a new benchmark for East Africa') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0">
                    <!-- Circular Economy Animation -->
                    <div class="circular-economy-container animate-fade-in-right">
                        <div class="circular-economy-path animate-circular"></div>
                        
                        <!-- Extraction -->
                        <div class="circular-economy-step circular-economy-icon animate-float" style="top: 10%; left: 45%;">
                            <i class="fas fa-leaf"></i>
                            <div class="step-tooltip">{{ __('Resource Extraction') }}</div>
                        </div>
                        
                        <!-- Production -->
                        <div class="circular-economy-step circular-economy-icon animate-float delay-200" style="top: 30%; left: 80%;">
                            <i class="fas fa-industry"></i>
                            <div class="step-tooltip">{{ __('Production & Manufacturing') }}</div>
                        </div>
                        
                        <!-- Consumption -->
                        <div class="circular-economy-step circular-economy-icon animate-float delay-400" style="top: 70%; left: 80%;">
                            <i class="fas fa-shopping-cart"></i>
                            <div class="step-tooltip">{{ __('Consumption & Use') }}</div>
                        </div>
                        
                        <!-- Waste -->
                        <div class="circular-economy-step circular-economy-icon animate-float delay-600" style="top: 90%; left: 45%;">
                            <i class="fas fa-trash-alt"></i>
                            <div class="step-tooltip">{{ __('Waste Collection') }}</div>
                        </div>
                        
                        <!-- Recycling -->
                        <div class="circular-economy-step circular-economy-icon animate-float delay-800" style="top: 70%; left: 10%;">
                            <i class="fas fa-recycle"></i>
                            <div class="step-tooltip">{{ __('Recycling & Recovery') }}</div>
                        </div>
                        
                        <!-- Reuse -->
                        <div class="circular-economy-step circular-economy-icon animate-float delay-1000" style="top: 30%; left: 10%;">
                            <i class="fas fa-sync-alt"></i>
                            <div class="step-tooltip">{{ __('Reuse & Refurbishment') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Scroll indicator -->
        <div class="text-center mt-4">
            <a href="#global-snapshot" class="scroll-indicator text-white animate-bounce d-inline-block">
                <i class="fas fa-chevron-down fa-2x"></i>
            </a>
        </div>
    </section>

    <!-- Micheweni District Government Section -->
    <section class="py-5 bg-white section-transition">
        <div class="container">
            <div class="text-center mb-5 animate-fade-in-up">
                <h2 class="section-title">{{ __('Micheweni District Government') }}</h2>
                <p class="section-subtitle">{{ __('Serving the citizens of Micheweni with dedication and vision') }}</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-6 animate-fade-in-left">
                    <div class="card border-0 shadow h-100">
                        <div class="card-body p-4">
                            <h4 class="card-title text-success mb-4">{{ __('About Micheweni District Council') }}</h4>
                            <p>{{ __('The Micheweni District Council is committed to providing quality services to residents and businesses while promoting sustainable development in our community.') }}</p>
                            <p>{{ __('Our initiatives focus on infrastructure development, environmental conservation, and improving the quality of life for all citizens.') }}</p>
                            
                            <div class="mt-4">
                                <h5>{{ __('Our Vision') }}</h5>
                                <p>{{ __('To transform Micheweni into a model sustainable municipality with efficient service delivery and high quality of life for all residents.') }}</p>
                                
                                <h5>{{ __('Our Mission') }}</h5>
                                <p>{{ __('To provide high-quality municipal services through efficient resource management, community engagement, and environmental stewardship.') }}</p>
                            </div>
                            
                            <div class="mt-4 text-center">
                                <a href="{{ route('opportunities.circular-economy.about') }}" class="btn btn-outline-success">
                                    <i class="fas fa-info-circle me-2"></i>{{ __('Learn More About Municipal Government') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 animate-fade-in-right">
                    <div class="row g-4 h-100">
                        <div class="col-sm-6">
                            <div class="card border-0 shadow h-100 service-card">
                                <div class="card-body p-4 text-center">
                                    <div class="service-card-icon mx-auto">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <h5>{{ __('Municipal Services') }}</h5>
                                    <p class="small">{{ __('Access information about permits, licenses, and other municipal services.') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="card border-0 shadow h-100 service-card">
                                <div class="card-body p-4 text-center">
                                    <div class="service-card-icon mx-auto">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <h5>{{ __('Events & Programs') }}</h5>
                                    <p class="small">{{ __('Discover community events, workshops, and environmental programs.') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="card border-0 shadow h-100 service-card">
                                <div class="card-body p-4 text-center">
                                    <div class="service-card-icon mx-auto">
                                        <i class="fas fa-hands-helping"></i>
                                    </div>
                                    <h5>{{ __('Community Engagement') }}</h5>
                                    <p class="small">{{ __('Participate in community decision-making and volunteer opportunities.') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="card border-0 shadow h-100 service-card">
                                <div class="card-body p-4 text-center">
                                    <div class="service-card-icon mx-auto">
                                        <i class="fas fa-leaf"></i>
                                    </div>
                                    <h5>{{ __('Sustainability Initiatives') }}</h5>
                                    <p class="small">{{ __('Learn about our environmental projects and circular economy efforts.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Global Snapshot Section (replacing map) -->
    <section id="global-snapshot" class="py-5 bg-light section-transition">
        <div class="container">
            <div class="text-center mb-5 animate-fade-in-up">
                <h2 class="section-title">{{ __('Global Circular Economy Snapshot') }}</h2>
                <p class="section-subtitle">{{ __('Explore countries\' progress toward circular economy goals') }}</p>
            </div>
            
            <div class="row">
                <div class="col-lg-8 mb-4 mb-lg-0 animate-fade-in-left">
                    <div class="card shadow border-0 h-100">
                        <div class="card-body p-4">
                            <h4 class="card-title text-success mb-4">{{ __('Circular Economy Progress by Country') }}</h4>
                            <div class="circular-stats">
                                <!-- Finland -->
                                <div class="country-stat-item mb-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ asset('images/flags/finland.png') }}" alt="Finland" class="country-flag me-2">
                                        <h5 class="mb-0">{{ __('Finland') }}</h5>
                                        <span class="ms-auto fw-bold">87%</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 87%;" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="small text-muted mt-1">{{ __('Leading in sustainable material management and circular design') }}</p>
                                </div>
                                
                                <!-- Netherlands -->
                                <div class="country-stat-item mb-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ asset('images/flags/netherlands.png') }}" alt="Netherlands" class="country-flag me-2">
                                        <h5 class="mb-0">{{ __('Netherlands') }}</h5>
                                        <span class="ms-auto fw-bold">85%</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="small text-muted mt-1">{{ __('Pioneer in circular agriculture and waste reduction') }}</p>
                                </div>
                                
                                <!-- Germany -->
                                <div class="country-stat-item mb-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ asset('images/flags/germany.png') }}" alt="Germany" class="country-flag me-2">
                                        <h5 class="mb-0">{{ __('Germany') }}</h5>
                                        <span class="ms-auto fw-bold">81%</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 81%;" aria-valuenow="81" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="small text-muted mt-1">{{ __('Strong policies on producer responsibility and recycling') }}</p>
                                </div>
                                
                                <!-- Kenya -->
                                <div class="country-stat-item mb-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ asset('images/flags/kenya.png') }}" alt="Kenya" class="country-flag me-2">
                                        <h5 class="mb-0">{{ __('Kenya') }}</h5>
                                        <span class="ms-auto fw-bold">72%</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 72%;" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="small text-muted mt-1">{{ __('Leading African nation in plastic waste management') }}</p>
                                </div>
                                
                                <!-- Tanzania -->
                                <div class="country-stat-item">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ asset('images/flags/tanzania.png') }}" alt="Tanzania" class="country-flag me-2">
                                        <h5 class="mb-0">{{ __('Tanzania') }}</h5>
                                        <span class="ms-auto fw-bold">65%</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="small text-muted mt-1">{{ __('Growing focus on community-based waste management') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 text-center p-3">
                            <a href="{{ route('opportunities.circular-economy.data.dashboard') }}" class="btn btn-outline-success btn-sm">
                                {{ __('View Full Rankings') }} <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 animate-fade-in-right">
                    <div class="card shadow border-0 bg-gradient-to-r from-green-800 to-green-600 text-white h-100">
                        <div class="card-body p-4">
                            <h4 class="card-title mb-4">{{ __('Circular Economy Benefits') }}</h4>
                            <div class="circular-benefits">
                                <div class="benefit-item d-flex align-items-center mb-4">
                                    <div class="benefit-icon me-3">
                                        <i class="fas fa-leaf fa-2x"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ __('Environmental Impact') }}</h5>
                                        <p class="mb-0 small">{{ __('Reduced waste and lower carbon emissions') }}</p>
                                    </div>
                                </div>
                                
                                <div class="benefit-item d-flex align-items-center mb-4">
                                    <div class="benefit-icon me-3">
                                        <i class="fas fa-coins fa-2x"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ __('Economic Growth') }}</h5>
                                        <p class="mb-0 small">{{ __('New business opportunities and job creation') }}</p>
                                    </div>
                                </div>
                                
                                <div class="benefit-item d-flex align-items-center mb-4">
                                    <div class="benefit-icon me-3">
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ __('Social Well-being') }}</h5>
                                        <p class="mb-0 small">{{ __('Healthier communities and better quality of life') }}</p>
                                    </div>
                                </div>
                                
                                <div class="benefit-item d-flex align-items-center">
                                    <div class="benefit-icon me-3">
                                        <i class="fas fa-sync-alt fa-2x"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ __('Resource Efficiency') }}</h5>
                                        <p class="mb-0 small">{{ __('Maximizing value from limited resources') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

    <!-- Waste Management Section (replacing map) -->
    <section id="waste-management" class="py-5 bg-light section-transition">
        <div class="container">
            <div class="text-center mb-5 animate-fade-in-up">
                <h2 class="section-title">{{ __('Waste Management Infrastructure') }}</h2>
                <p class="section-subtitle">{{ __('Explore our network of waste management facilities across Micheweni') }}</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 animate-fade-in-left">
                    <div class="card h-100 border-0 shadow">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-trash-alt me-2"></i>{{ __('Collection Points') }}</h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @if($wasteLocations->where('type', 'collection_point')->count() > 0)
                                    @foreach($wasteLocations->where('type', 'collection_point')->take(5) as $location)
                                    <li class="list-group-item d-flex align-items-center p-3">
                                        <div class="location-icon me-3 bg-primary-subtle text-primary rounded-circle p-2">
                                            <i class="fas fa-trash-alt"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $location->name }}</h6>
                                            <p class="small text-muted mb-0">{{ $location->address }}</p>
                                        </div>
                                    </li>
                                    @endforeach
                                @else
                                    <li class="list-group-item d-flex align-items-center p-3">
                                        <div class="location-icon me-3 bg-primary-subtle text-primary rounded-circle p-2">
                                            <i class="fas fa-trash-alt"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ __('Micheweni Central Collection Point') }}</h6>
                                            <p class="small text-muted mb-0">{{ __('Main Street, Micheweni') }}</p>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center p-3">
                                        <div class="location-icon me-3 bg-primary-subtle text-primary rounded-circle p-2">
                                            <i class="fas fa-trash-alt"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ __('Northern District Collection') }}</h6>
                                            <p class="small text-muted mb-0">{{ __('North Region, Micheweni') }}</p>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center p-3">
                                        <div class="location-icon me-3 bg-primary-subtle text-primary rounded-circle p-2">
                                            <i class="fas fa-trash-alt"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ __('Southern Community Collection') }}</h6>
                                            <p class="small text-muted mb-0">{{ __('South Area, Micheweni') }}</p>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="card-footer text-center border-0 bg-white py-3">
                            <a href="{{ route('opportunities.circular-economy.waste.locations') }}?type=collection_point" class="btn btn-outline-primary btn-sm">
                                {{ __('View All Collection Points') }} <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 animate-fade-in-up">
                    <div class="card h-100 border-0 shadow">
                        <div class="card-header bg-success text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-recycle me-2"></i>{{ __('Recycling Centers') }}</h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @if($wasteLocations->where('type', 'recycling_center')->count() > 0)
                                    @foreach($wasteLocations->where('type', 'recycling_center')->take(5) as $location)
                                    <li class="list-group-item d-flex align-items-center p-3">
                                        <div class="location-icon me-3 bg-success-subtle text-success rounded-circle p-2">
                                            <i class="fas fa-recycle"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $location->name }}</h6>
                                            <p class="small text-muted mb-0">{{ $location->address }}</p>
                                        </div>
                                    </li>
                                    @endforeach
                                @else
                                    <li class="list-group-item d-flex align-items-center p-3">
                                        <div class="location-icon me-3 bg-success-subtle text-success rounded-circle p-2">
                                            <i class="fas fa-recycle"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ __('Micheweni Main Recycling Facility') }}</h6>
                                            <p class="small text-muted mb-0">{{ __('Industrial Zone, Micheweni') }}</p>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center p-3">
                                        <div class="location-icon me-3 bg-success-subtle text-success rounded-circle p-2">
                                            <i class="fas fa-recycle"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ __('East Micheweni Recycling Center') }}</h6>
                                            <p class="small text-muted mb-0">{{ __('Eastern District, Micheweni') }}</p>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center p-3">
                                        <div class="location-icon me-3 bg-success-subtle text-success rounded-circle p-2">
                                            <i class="fas fa-recycle"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ __('Community Recycling Hub') }}</h6>
                                            <p class="small text-muted mb-0">{{ __('Central Market Area, Micheweni') }}</p>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="card-footer text-center border-0 bg-white py-3">
                            <a href="{{ route('opportunities.circular-economy.waste.locations') }}?type=recycling_center" class="btn btn-outline-success btn-sm">
                                {{ __('View All Recycling Centers') }} <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 animate-fade-in-right">
                    <div class="card h-100 border-0 shadow">
                        <div class="card-header bg-warning text-dark py-3">
                            <h5 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>{{ __('Transfer Stations') }}</h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @if($wasteLocations->where('type', 'transfer_station')->count() > 0)
                                    @foreach($wasteLocations->where('type', 'transfer_station')->take(5) as $location)
                                    <li class="list-group-item d-flex align-items-center p-3">
                                        <div class="location-icon me-3 bg-warning-subtle text-warning rounded-circle p-2">
                                            <i class="fas fa-exchange-alt"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $location->name }}</h6>
                                            <p class="small text-muted mb-0">{{ $location->address }}</p>
                                        </div>
                                    </li>
                                    @endforeach
                                @else
                                    <li class="list-group-item d-flex align-items-center p-3">
                                        <div class="location-icon me-3 bg-warning-subtle text-warning rounded-circle p-2">
                                            <i class="fas fa-exchange-alt"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ __('Micheweni Central Transfer Station') }}</h6>
                                            <p class="small text-muted mb-0">{{ __('Industrial Area, Micheweni') }}</p>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center p-3">
                                        <div class="location-icon me-3 bg-warning-subtle text-warning rounded-circle p-2">
                                            <i class="fas fa-exchange-alt"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ __('Western Transfer Facility') }}</h6>
                                            <p class="small text-muted mb-0">{{ __('West District, Micheweni') }}</p>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center p-3">
                                        <div class="location-icon me-3 bg-warning-subtle text-warning rounded-circle p-2">
                                            <i class="fas fa-exchange-alt"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ __('Harbor Area Transfer Station') }}</h6>
                                            <p class="small text-muted mb-0">{{ __('Port District, Micheweni') }}</p>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="card-footer text-center border-0 bg-white py-3">
                            <a href="{{ route('opportunities.circular-economy.waste.locations') }}?type=transfer_station" class="btn btn-outline-warning btn-sm">
                                {{ __('View All Transfer Stations') }} <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('opportunities.circular-economy.waste.map') }}" class="btn btn-success btn-lg btn-ripple">
                    <i class="fas fa-map-marked-alt me-2"></i> {{ __('View Waste Management Overview') }}
                </a>
            </div>
        </div>
    </section>

    <!-- Achievements Section -->
    <section id="achievements" class="py-5 bg-gradient-to-r from-green-800 to-green-600 text-white">
        <div class="container">
            <h2 class="section-title text-center text-white mb-5">{{ __('Our Achievements') }}</h2>
            
            <div class="row">
                <div class="col-md-8 mx-auto animate-fade-in-up">
                    <div class="achievement-card mb-4">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="achievement-icon">
                                    <i class="fas fa-trophy fa-2x"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h3 class="mb-2">{{ __('Tanzania reached 72% Circularity this year!') }}</h3>
                                <p class="mb-0">{{ __('A significant improvement from 58% last year, moving us closer to our 2030 goals.') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="achievement-card mb-4">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="achievement-icon">
                                    <i class="fas fa-recycle fa-2x"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h3 class="mb-2">{{ __('Doubled recycling capacity in Micheweni') }}</h3>
                                <p class="mb-0">{{ __('New infrastructure and community engagement have significantly increased our recycling capacity.') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="achievement-card mb-4">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="achievement-icon">
                                    <i class="fas fa-leaf fa-2x"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h3 class="mb-2">{{ __('Reduced landfill waste by 35%') }}</h3>
                                <p class="mb-0">{{ __('Through better sorting and waste diversion programs, we have significantly reduced landfill waste.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Services Section -->
    <section id="services" class="py-5 bg-gradient-to-r from-green-100 to-green-50 animate-when-visible">
        <div class="container">
            <div class="text-center mb-5 animate-fade-in-up">
                @if($servicesSection)
                    <h2 class="section-title">{{ $servicesSection->translated_title }}</h2>
                    <p class="section-subtitle">{!! $servicesSection->translated_content !!}</p>
                @else
                    <h2 class="section-title">{{ __('Our Services') }}</h2>
                    <p class="section-subtitle">{{ __('Comprehensive circular economy solutions for sustainable waste management') }}</p>
                @endif
            </div>
            
            <div class="feature-grid">
                @forelse($featuredContent as $index => $content)
                <div class="feature-item card-grid-item delay-{{ ($index * 200) }}">
                    @if($content->type == 'image' && !empty($content->content))
                    <div class="img-hover-zoom">
                        <img src="{{ asset('images/' . $content->content) }}" class="img-fluid w-100" alt="{{ $content->translated_title }}">
                    </div>
                    @endif
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas {{ json_decode($content->meta_data, true)['icon'] ?? 'fa-recycle' }}"></i>
                        </div>
                        <h4>{{ $content->translated_title }}</h4>
                        <p>{!! $content->translated_content !!}</p>
                        
                        @if($content->meta_data && isset(json_decode($content->meta_data, true)['link']))
                            <a href="{{ json_decode($content->meta_data, true)['link'] }}" class="btn btn-outline-success btn-ripple mt-3">
                                {{ json_decode($content->meta_data, true)['button_text'] ?? __('Learn More') }} 
                                <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        @else
                            <a href="#" class="btn btn-outline-success btn-ripple mt-3">{{ __('Learn More') }} <i class="fas fa-arrow-right ms-1"></i></a>
                        @endif
                    </div>
                </div>
                @empty
                <!-- Default Featured Content -->
                <div class="feature-item card-grid-item">
                    <div class="img-hover-zoom">
                        <img src="{{ asset('images/collection.svg') }}" class="img-fluid w-100" alt="{{ __('Waste Collection') }}">
                    </div>
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-trash-alt"></i>
                        </div>
                        <h4>{{ __('Waste Collection') }}</h4>
                        <p>{{ __('Regular and reliable waste collection services throughout Micheweni district.') }}</p>
                        <a href="{{ route('opportunities.circular-economy.waste.collection') }}" class="btn btn-outline-success btn-ripple mt-3">{{ __('Learn More') }} <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
                
                <div class="feature-item card-grid-item delay-200">
                    <div class="img-hover-zoom">
                        <img src="{{ asset('images/recycling.svg') }}" class="img-fluid w-100" alt="{{ __('Recycling') }}">
                    </div>
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-recycle"></i>
                        </div>
                        <h4>{{ __('Recycling') }}</h4>
                        <p>{{ __('Sustainable recycling initiatives to reduce waste and protect our environment.') }}</p>
                        <a href="{{ route('opportunities.circular-economy.waste.recycling') }}" class="btn btn-outline-success btn-ripple mt-3">{{ __('Learn More') }} <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
                
                <div class="feature-item card-grid-item delay-400">
                    <div class="img-hover-zoom">
                        <img src="{{ asset('images/education.svg') }}" class="img-fluid w-100" alt="{{ __('Education') }}">
                    </div>
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h4>{{ __('Education') }}</h4>
                        <p>{{ __('Community education programs on proper waste management practices.') }}</p>
                        <a href="{{ route('opportunities.circular-economy.resources') }}" class="btn btn-outline-success btn-ripple mt-3">{{ __('Learn More') }} <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    <section id="latest-news" class="py-5 bg-gradient-to-r from-green-50 to-white animate-when-visible">
        <div class="container">
        <div class="text-center mb-5 animate-fade-in-up">
                @if($newsSection)
                    <h2 class="section-title">{{ $newsSection->translated_title }}</h2>
                    <p class="section-subtitle">{!! $newsSection->translated_content !!}</p>
                @else
                    <h2 class="section-title">{{ __('Latest News') }}</h2>
                    <p class="section-subtitle">{{ __('Stay updated with the latest waste management initiatives') }}</p>
                @endif
        </div>
        <div class="row">
                @forelse($latestNews as $index => $news)
                <div class="col-md-4 mb-4">
                    <div class="news-item card-grid-item delay-{{ ($index * 200) }} h-100">
                        @if($news->featured_image)
                        <div class="news-image">
                            <img src="{{ asset('images/' . $news->featured_image) }}" alt="{{ $news->translated_title }}">
                        </div>
                        @endif
                        <div class="news-content d-flex flex-column">
                            <div class="news-meta">
                                <span class="news-category">{{ $news->category ? $news->category->name : __('News') }}</span>
                                <span class="news-date">{{ $news->published_at->format('M d, Y') }}</span>
                            </div>
                            <h4 class="mt-3">{{ $news->translated_title }}</h4>
                            <p class="flex-grow-1">{{ $news->translated_excerpt }}</p>
                            <a href="{{ route('opportunities.circular-economy.news.show', $news->slug) }}" class="btn btn-outline-success btn-ripple mt-3">
                                {{ __('Read More') }} <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center animate-fade-in">
                    <div class="empty-state">
                        <div class="empty-icon animate-float mb-4">
                            <i class="fas fa-newspaper fa-4x text-muted"></i>
                        </div>
                        <h4>{{ __('No news articles available') }}</h4>
                        <p class="text-muted">{{ __('Check back soon for updates on our waste management initiatives.') }}</p>
                    </div>
                </div>
                @endforelse
            </div>
            
            <div class="text-center mt-5 animate-fade-in">
                <a href="{{ route('opportunities.circular-economy.news.index') }}" class="btn btn-success btn-ripple">
                    <i class="fas fa-newspaper me-2"></i> {{ __('View All News') }}
                </a>

            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5 bg-light section-transition">
        <div class="container">
            <div class="split-section">
                <div class="split-section-content order-lg-2 animate-fade-in-left">
                    <h2 class="section-title">
                        @if($aboutSection)
                            {{ $aboutSection->translated_title }}
                        @else
                            {{ __('About Micheweni Waste Portal') }}
                        @endif
                    </h2>
                    
                    <div class="mb-4">
                        @if($aboutSection)
                            {!! $aboutSection->translated_content !!}
                        @else
                            <p>{{ __('The Micheweni Waste Portal is a comprehensive platform designed to improve waste management in the Micheweni district of Pemba Island, Tanzania.') }}</p>
                            <p>{{ __('Our mission is to create a cleaner, healthier environment through proper waste management, recycling initiatives, and community education.') }}</p>
                        @endif
                    </div>
                    
                    <div class="d-flex gap-3 mb-4">
                        <div class="eco-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <div class="eco-icon">
                            <i class="fas fa-recycle"></i>
                        </div>
                        <div class="eco-icon">
                            <i class="fas fa-globe-africa"></i>
                        </div>
                    </div>
                    
                    <a href="{{ route('opportunities.circular-economy.about') }}" class="btn btn-success btn-ripple">
                        <i class="fas fa-info-circle me-2"></i> {{ __('Learn More About Us') }}
                    </a>
                </div>
                
                <div class="animate-fade-in-right">
                    <div class="img-tilt">
                        @if($aboutSection && $aboutSection->type == 'image' && !empty($aboutSection->content))
                            <img src="{{ asset('images/' . $aboutSection->content) }}" alt="{{ $aboutSection->title }}" class="img-fluid rounded shadow">
                        @else
                            <img src="{{ asset('images/about-image.svg') }}" alt="{{ __('About Us') }}" class="img-fluid rounded shadow">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jvectormap@2.0.4/jquery-jvectormap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jvectormap@2.0.4/jquery-jvectormap-world-mill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="{{ asset('js/particlesInit.js') }}"></script>
<script src="{{ asset('js/maps/worldMap.js') }}"></script>
<script src="{{ asset('js/maps/wasteMap.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Make all sections visible by default for older browsers
        document.querySelectorAll('.section-transition').forEach(section => {
            section.classList.add('visible');
        });
        
        document.querySelectorAll('.card-grid-item').forEach(card => {
            card.classList.add('visible');
        });
        
        // Intersection Observer for section transitions
        if ('IntersectionObserver' in window) {
            const sections = document.querySelectorAll('.section-transition');
            const cards = document.querySelectorAll('.card-grid-item');
            
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };
            
            const sectionObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            
            sections.forEach(section => {
                sectionObserver.observe(section);
            });
            
            cards.forEach(card => {
                sectionObserver.observe(card);
            });
        }
        
        // Add ripple effect to buttons
        const rippleButtons = document.querySelectorAll('.btn-ripple');
        rippleButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                this.appendChild(ripple);
                
                const x = e.clientX - e.target.getBoundingClientRect().left;
                const y = e.clientY - e.target.getBoundingClientRect().top;
                
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
        
        // Smooth scroll to sections
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>
@endsection 