<x-app-layout>
    <!-- Services Header -->
    <section class="bg-gradient-to-r from-green-800 to-green-600 text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-3">{{ __('Our Services') }}</h1>
                    <p class="lead mb-4">{{ __('Comprehensive waste management solutions for a cleaner Pemba') }}</p>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('images/services-hero.svg') }}" alt="Waste Management Services" class="img-fluid rounded-4 shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Services Overview -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="h1 mb-4">{{ __('Our Waste Management Services') }}</h2>
                    <p class="lead">{{ __('We provide end-to-end waste management solutions that promote sustainability and circular economy principles.') }}</p>
                </div>
            </div>
            
            <div class="row g-4">
                <!-- Waste Collection Service -->
                <div class="col-md-6 col-lg-4 fade-in-up">
                    <div class="card border-0 shadow-sm rounded-4 h-100 service-card">
                        <div class="service-icon-wrapper">
                            <div class="service-icon bg-primary-subtle text-primary">
                                <i class="fas fa-trash-alt"></i>
                            </div>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h3 class="h4 mb-3">{{ __('Waste Collection') }}</h3>
                            <p class="mb-4">{{ __('Regular collection services for households and businesses, with scheduled pickups and special waste handling.') }}</p>
                            <ul class="list-unstyled text-start">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('Residential collection') }}</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('Commercial collection') }}</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('Bulk waste removal') }}</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>{{ __('Special waste handling') }}</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-4">
                            <a href="{{ route('opportunities.circular-economy.contact') }}" class="btn btn-outline-primary w-100">
                                {{ __('Learn More') }} <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Recycling Service -->
                <div class="col-md-6 col-lg-4 fade-in-up delay-200">
                    <div class="card border-0 shadow-sm rounded-4 h-100 service-card">
                        <div class="service-icon-wrapper">
                            <div class="service-icon bg-success-subtle text-success">
                                <i class="fas fa-recycle"></i>
                            </div>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h3 class="h4 mb-3">{{ __('Recycling Services') }}</h3>
                            <p class="mb-4">{{ __('Comprehensive recycling programs for various materials, helping reduce landfill waste and promote resource recovery.') }}</p>
                            <ul class="list-unstyled text-start">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('Material sorting') }}</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('Recyclables collection') }}</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('Drop-off centers') }}</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>{{ __('Recycling education') }}</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-4">
                            <a href="{{ route('opportunities.circular-economy.contact') }}" class="btn btn-outline-success w-100">
                                {{ __('Learn More') }} <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Composting Service -->
                <div class="col-md-6 col-lg-4 fade-in-up delay-400">
                    <div class="card border-0 shadow-sm rounded-4 h-100 service-card">
                        <div class="service-icon-wrapper">
                            <div class="service-icon bg-warning-subtle text-warning">
                                <i class="fas fa-leaf"></i>
                            </div>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h3 class="h4 mb-3">{{ __('Organic Waste & Composting') }}</h3>
                            <p class="mb-4">{{ __('Specialized organic waste collection and composting services to create nutrient-rich soil for local agriculture.') }}</p>
                            <ul class="list-unstyled text-start">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('Food waste collection') }}</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('Composting facilities') }}</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('Community gardens') }}</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>{{ __('Compost distribution') }}</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-4">
                            <a href="{{ route('opportunities.circular-economy.contact') }}" class="btn btn-outline-warning w-100">
                                {{ __('Learn More') }} <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Consulting Service -->
                <div class="col-md-6 col-lg-4 fade-in-up">
                    <div class="card border-0 shadow-sm rounded-4 h-100 service-card">
                        <div class="service-icon-wrapper">
                            <div class="service-icon bg-info-subtle text-info">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h3 class="h4 mb-3">{{ __('Consulting & Assessment') }}</h3>
                            <p class="mb-4">{{ __('Expert consulting services to help organizations develop effective waste management strategies.') }}</p>
                            <ul class="list-unstyled text-start">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('Waste audits') }}</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('Strategy development') }}</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('Process optimization') }}</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>{{ __('Compliance guidance') }}</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-4">
                            <a href="{{ route('opportunities.circular-economy.contact') }}" class="btn btn-outline-info w-100">
                                {{ __('Learn More') }} <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Education Service -->
                <div class="col-md-6 col-lg-4 fade-in-up delay-200">
                    <div class="card border-0 shadow-sm rounded-4 h-100 service-card">
                        <div class="service-icon-wrapper">
                            <div class="service-icon bg-danger-subtle text-danger">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h3 class="h4 mb-3">{{ __('Education & Training') }}</h3>
                            <p class="mb-4">{{ __('Educational programs and workshops to promote waste reduction, recycling, and sustainable practices.') }}</p>
                            <ul class="list-unstyled text-start">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('School programs') }}</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('Community workshops') }}</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('Business training') }}</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>{{ __('Educational materials') }}</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-4">
                            <a href="{{ route('opportunities.circular-economy.contact') }}" class="btn btn-outline-danger w-100">
                                {{ __('Learn More') }} <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Special Events Service -->
                <div class="col-md-6 col-lg-4 fade-in-up delay-400">
                    <div class="card border-0 shadow-sm rounded-4 h-100 service-card">
                        <div class="service-icon-wrapper">
                            <div class="service-icon bg-secondary-subtle text-secondary">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h3 class="h4 mb-3">{{ __('Special Events & Cleanup') }}</h3>
                            <p class="mb-4">{{ __('Waste management services for events and community cleanup initiatives to maintain a clean environment.') }}</p>
                            <ul class="list-unstyled text-start">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('Event waste management') }}</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('Beach cleanups') }}</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('Community action days') }}</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>{{ __('Volunteer coordination') }}</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-4">
                            <a href="{{ route('opportunities.circular-economy.contact') }}" class="btn btn-outline-secondary w-100">
                                {{ __('Learn More') }} <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="h1 mb-4">{{ __('Our Process') }}</h2>
                    <p class="lead">{{ __('How we manage waste from collection to final processing') }}</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="process-timeline">
                        <div class="process-step">
                            <div class="process-icon bg-primary text-white">
                                <i class="fas fa-trash-alt"></i>
                            </div>
                            <div class="process-content">
                                <h3 class="h5">{{ __('Collection') }}</h3>
                                <p>{{ __('Scheduled waste collection from homes, businesses, and public areas using our modern fleet of vehicles.') }}</p>
                            </div>
                        </div>
                        
                        <div class="process-step">
                            <div class="process-icon bg-success text-white">
                                <i class="fas fa-sort-amount-down"></i>
                            </div>
                            <div class="process-content">
                                <h3 class="h5">{{ __('Sorting') }}</h3>
                                <p>{{ __('Waste is sorted at our facility to separate recyclables, organic waste, and non-recyclable materials.') }}</p>
                            </div>
                        </div>
                        
                        <div class="process-step">
                            <div class="process-icon bg-warning text-white">
                                <i class="fas fa-recycle"></i>
                            </div>
                            <div class="process-content">
                                <h3 class="h5">{{ __('Processing') }}</h3>
                                <p>{{ __('Recyclable materials are processed for reuse, and organic waste is composted into nutrient-rich soil.') }}</p>
                            </div>
                        </div>
                        
                        <div class="process-step">
                            <div class="process-icon bg-info text-white">
                                <i class="fas fa-exchange-alt"></i>
                            </div>
                            <div class="process-content">
                                <h3 class="h5">{{ __('Distribution') }}</h3>
                                <p>{{ __('Processed materials are distributed to manufacturing partners, and compost is provided to local farmers.') }}</p>
                            </div>
                        </div>
                        
                        <div class="process-step">
                            <div class="process-icon bg-danger text-white">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="process-content">
                                <h3 class="h5">{{ __('Monitoring') }}</h3>
                                <p>{{ __('We continuously monitor and report on waste diversion rates, environmental impacts, and service quality.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="h1 mb-4">{{ __('Service Plans') }}</h2>
                    <p class="lead">{{ __('Choose the waste management plan that best fits your needs') }}</p>
                </div>
            </div>
            
            <div class="row g-4">
                <!-- Residential Plan -->
                <div class="col-md-4 fade-in-up">
                    <div class="card border-0 shadow-sm rounded-4 h-100 pricing-card">
                        <div class="card-header bg-transparent border-0 pt-4 pb-0">
                            <h3 class="h4 text-center mb-0">{{ __('Residential') }}</h3>
                        </div>
                        <div class="card-body p-4 text-center">
                            <div class="price-value">
                                <h4 class="display-6 mb-0">{{ __('25,000') }}</h4>
                                <p class="text-muted">{{ __('TZS/month') }}</p>
                            </div>
                            <ul class="list-unstyled mt-4 mb-4">
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>{{ __('Weekly waste collection') }}</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>{{ __('Recycling collection') }}</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>{{ __('Basic sorting bins') }}</li>
                                <li class="mb-3 text-muted"><i class="fas fa-times text-danger me-2"></i>{{ __('Bulk waste collection') }}</li>
                                <li class="mb-3 text-muted"><i class="fas fa-times text-danger me-2"></i>{{ __('Compost return') }}</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-4 text-center">
                            <a href="{{ route('opportunities.circular-economy.contact') }}" class="btn btn-outline-primary">
                                {{ __('Get Started') }}
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Premium Residential Plan -->
                <div class="col-md-4 fade-in-up delay-200">
                    <div class="card border-0 shadow-lg rounded-4 h-100 pricing-card popular">
                        <div class="popular-badge">{{ __('Most Popular') }}</div>
                        <div class="card-header bg-transparent border-0 pt-4 pb-0">
                            <h3 class="h4 text-center mb-0">{{ __('Premium Residential') }}</h3>
                        </div>
                        <div class="card-body p-4 text-center">
                            <div class="price-value">
                                <h4 class="display-6 mb-0">{{ __('45,000') }}</h4>
                                <p class="text-muted">{{ __('TZS/month') }}</p>
                            </div>
                            <ul class="list-unstyled mt-4 mb-4">
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>{{ __('Twice weekly collection') }}</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>{{ __('Recycling collection') }}</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>{{ __('Premium sorting bins') }}</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>{{ __('Quarterly bulk waste pickup') }}</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>{{ __('Monthly compost return') }}</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-4 text-center">
                            <a href="{{ route('opportunities.circular-economy.contact') }}" class="btn btn-primary">
                                {{ __('Get Started') }}
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Business Plan -->
                <div class="col-md-4 fade-in-up delay-400">
                    <div class="card border-0 shadow-sm rounded-4 h-100 pricing-card">
                        <div class="card-header bg-transparent border-0 pt-4 pb-0">
                            <h3 class="h4 text-center mb-0">{{ __('Business') }}</h3>
                        </div>
                        <div class="card-body p-4 text-center">
                            <div class="price-value">
                                <h4 class="display-6 mb-0">{{ __('Custom') }}</h4>
                                <p class="text-muted">{{ __('Based on needs') }}</p>
                            </div>
                            <ul class="list-unstyled mt-4 mb-4">
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>{{ __('Customized collection schedule') }}</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>{{ __('Commercial recycling program') }}</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>{{ __('Waste audit & consulting') }}</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>{{ __('Bulk waste management') }}</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>{{ __('Compliance reporting') }}</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-4 text-center">
                            <a href="{{ route('opportunities.circular-economy.contact') }}" class="btn btn-outline-primary">
                                {{ __('Get Quote') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5 bg-gradient-to-r from-green-800 to-green-600 text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="h1 mb-4">{{ __('Ready to Get Started?') }}</h2>
                    <p class="lead mb-4">{{ __('Contact us today to discuss your waste management needs and find the right solution for you.') }}</p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="{{ route('opportunities.circular-economy.contact') }}" class="btn btn-light btn-lg shadow-sm">
                            <i class="fas fa-envelope me-2"></i> {{ __('Contact Us') }}
                        </a>
                        <a href="{{ route('opportunities.circular-economy.assessment.index') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-clipboard-check me-2"></i> {{ __('Take Assessment') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <style>
        .service-card {
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }
        
        .service-icon-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        
        .service-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        
        .process-timeline {
            position: relative;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px 0;
        }
        
        .process-timeline::before {
            content: '';
            position: absolute;
            height: 100%;
            width: 4px;
            background: #e9ecef;
            left: 30px;
            top: 0;
        }
        
        .process-step {
            position: relative;
            padding-left: 80px;
            margin-bottom: 50px;
        }
        
        .process-step:last-child {
            margin-bottom: 0;
        }
        
        .process-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            position: absolute;
            left: 0;
            top: 0;
            z-index: 2;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .pricing-card {
            transition: all 0.3s ease;
            position: relative;
        }
        
        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }
        
        .pricing-card.popular {
            transform: scale(1.05);
            z-index: 2;
            border: 2px solid #28a745;
        }
        
        .pricing-card.popular:hover {
            transform: scale(1.05) translateY(-10px);
        }
        
        .popular-badge {
            position: absolute;
            top: 0;
            right: 20px;
            background-color: #28a745;
            color: white;
            padding: 5px 15px;
            border-radius: 0 0 15px 15px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .price-value {
            padding: 20px 0;
        }
        
        .bg-primary-subtle {
            background-color: rgba(13, 110, 253, 0.1) !important;
        }
        
        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }
        
        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }
        
        .bg-info-subtle {
            background-color: rgba(13, 202, 240, 0.1) !important;
        }
        
        .bg-danger-subtle {
            background-color: rgba(220, 53, 69, 0.1) !important;
        }
        
        .bg-secondary-subtle {
            background-color: rgba(108, 117, 125, 0.1) !important;
        }
        
        .rounded-4 {
            border-radius: 0.75rem !important;
        }
        
        @media (max-width: 768px) {
            .process-timeline::before {
                left: 20px;
            }
            
            .process-step {
                padding-left: 60px;
            }
            
            .process-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }
    </style>
    @endpush
</x-app-layout> 