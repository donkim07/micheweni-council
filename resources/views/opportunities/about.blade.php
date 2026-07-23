<x-app-layout>
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-green-800 to-green-600 text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-3">{{ __('About Micheweni Waste Portal') }}</h1>
                    <p class="lead mb-4">{{ __('Leading the way towards sustainable waste management in Pemba, Zanzibar') }}</p>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('images/about-hero.svg') }}" alt="About Micheweni Portal" class="img-fluid rounded-4 shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Our Mission Section -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="h1 mb-4">{{ __('Our Mission') }}</h2>
                    <p class="lead">{{ __('To create a sustainable waste management ecosystem that transforms waste into resources, empowers communities, and preserves the natural beauty of Pemba Island.') }}</p>
                </div>
            </div>
            
            <div class="row g-4 mb-5">
                <div class="col-md-4 fade-in-up">
                    <div class="card h-100 border-0 shadow-sm rounded-4 mission-card">
                        <div class="card-body p-4 text-center">
                            <div class="mission-icon bg-primary-subtle text-primary rounded-circle mx-auto mb-4">
                                <i class="fas fa-recycle"></i>
                            </div>
                            <h3 class="h5 mb-3">{{ __('Reduce & Recycle') }}</h3>
                            <p class="mb-0">{{ __('Implementing effective waste collection systems and recycling infrastructure to minimize waste sent to landfills.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 fade-in-up delay-200">
                    <div class="card h-100 border-0 shadow-sm rounded-4 mission-card">
                        <div class="card-body p-4 text-center">
                            <div class="mission-icon bg-success-subtle text-success rounded-circle mx-auto mb-4">
                                <i class="fas fa-users"></i>
                                    </div>
                            <h3 class="h5 mb-3">{{ __('Community Engagement') }}</h3>
                            <p class="mb-0">{{ __('Educating and empowering local communities to participate in waste reduction and circular economy practices.') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                <div class="col-md-4 fade-in-up delay-400">
                    <div class="card h-100 border-0 shadow-sm rounded-4 mission-card">
                        <div class="card-body p-4 text-center">
                            <div class="mission-icon bg-warning-subtle text-warning rounded-circle mx-auto mb-4">
                                <i class="fas fa-seedling"></i>
                            </div>
                            <h3 class="h5 mb-3">{{ __('Environmental Preservation') }}</h3>
                            <p class="mb-0">{{ __('Protecting Pemba\'s pristine ecosystems through sustainable waste management and innovative solutions.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="position-relative">
                        <img src="{{ asset('images/about-story.jpg') }}" alt="Our Story" class="img-fluid rounded-4 shadow">
                        <div class="story-experience position-absolute bg-success text-white p-3 rounded-4 shadow">
                            <h4 class="h2 mb-0">5+</h4>
                            <p class="mb-0">{{ __('Years of Experience') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <h2 class="h1 mb-4">{{ __('Our Story') }}</h2>
                    <p class="lead mb-4">{{ __('The Micheweni Waste Management Portal was established in 2019 as a response to the growing waste management challenges in Pemba Island.') }}</p>
                    
                    <p class="mb-4">{{ __('Facing increasing tourist visits and changing consumption patterns, Pemba needed a comprehensive approach to manage waste sustainably. Our initiative began as a collaboration between local government, environmental experts, and community leaders.') }}</p>
                    
                    <p class="mb-4">{{ __('Over the years, we have grown from a small waste collection operation to a comprehensive waste management ecosystem that incorporates data-driven decision making, community education, and circular economy principles.') }}</p>
                    
                    <div class="row g-4 mt-4">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-primary-subtle text-primary rounded-circle me-3">
                                    <i class="fas fa-trophy"></i>
                                            </div>
                                            <div>
                                    <h4 class="h5 mb-0">{{ __('Award-Winning Initiative') }}</h4>
                                    <p class="small text-muted mb-0">{{ __('Recognized for excellence in sustainable development') }}</p>
                                            </div>
                                        </div>
                                    </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-success-subtle text-success rounded-circle me-3">
                                    <i class="fas fa-handshake"></i>
                                            </div>
                                            <div>
                                    <h4 class="h5 mb-0">{{ __('Community Partnerships') }}</h4>
                                    <p class="small text-muted mb-0">{{ __('Working together with over 15 local organizations') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Team Section -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="h1 mb-4">{{ __('Our Leadership Team') }}</h2>
                    <p class="lead">{{ __('Meet the dedicated professionals working to transform waste management in Pemba.') }}</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4 col-lg-3 fade-in-up">
                    <div class="card team-card border-0 shadow-sm rounded-4 h-100">
                        <img src="{{ asset('images/team/team-1.jpg') }}" class="card-img-top rounded-top-4" alt="Team Member">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1">Mohammed Ali</h5>
                            <p class="text-muted small mb-3">{{ __('Program Director') }}</p>
                            <p class="card-text small">{{ __('Environmental scientist with 15+ years of experience in sustainable waste management.') }}</p>
                            <div class="social-links">
                                <a href="#" class="text-secondary me-2"><i class="fab fa-linkedin"></i></a>
                                <a href="#" class="text-secondary me-2"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-secondary"><i class="fas fa-envelope"></i></a>
                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                <div class="col-md-4 col-lg-3 fade-in-up delay-200">
                    <div class="card team-card border-0 shadow-sm rounded-4 h-100">
                        <img src="{{ asset('images/team/team-2.jpg') }}" class="card-img-top rounded-top-4" alt="Team Member">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1">Fatma Hassan</h5>
                            <p class="text-muted small mb-3">{{ __('Community Engagement Lead') }}</p>
                            <p class="card-text small">{{ __('Specialist in community-based waste management and public education programs.') }}</p>
                            <div class="social-links">
                                <a href="#" class="text-secondary me-2"><i class="fab fa-linkedin"></i></a>
                                <a href="#" class="text-secondary me-2"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-secondary"><i class="fas fa-envelope"></i></a>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                <div class="col-md-4 col-lg-3 fade-in-up delay-400">
                    <div class="card team-card border-0 shadow-sm rounded-4 h-100">
                        <img src="{{ asset('images/team/team-3.jpg') }}" class="card-img-top rounded-top-4" alt="Team Member">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1">Omar Juma</h5>
                            <p class="text-muted small mb-3">{{ __('Operations Manager') }}</p>
                            <p class="card-text small">{{ __('Expert in logistics and waste collection system optimization.') }}</p>
                            <div class="social-links">
                                <a href="#" class="text-secondary me-2"><i class="fab fa-linkedin"></i></a>
                                <a href="#" class="text-secondary me-2"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-secondary"><i class="fas fa-envelope"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                <div class="col-md-4 col-lg-3 fade-in-up delay-500">
                    <div class="card team-card border-0 shadow-sm rounded-4 h-100">
                        <img src="{{ asset('images/team/team-4.jpg') }}" class="card-img-top rounded-top-4" alt="Team Member">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1">Amina Said</h5>
                            <p class="text-muted small mb-3">{{ __('Data & Technology Officer') }}</p>
                            <p class="card-text small">{{ __('Specialist in waste management information systems and data analytics.') }}</p>
                            <div class="social-links">
                                <a href="#" class="text-secondary me-2"><i class="fab fa-linkedin"></i></a>
                                <a href="#" class="text-secondary me-2"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-secondary"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Partners Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="h1 mb-4">{{ __('Our Partners') }}</h2>
                    <p class="lead">{{ __('We collaborate with organizations that share our commitment to sustainable waste management.') }}</p>
                </div>
            </div>
            
            <div class="row align-items-center justify-content-center g-5">
                <div class="col-6 col-md-3 text-center">
                    <img src="{{ asset('images/partners/partner-1.png') }}" alt="Partner" class="img-fluid grayscale partner-logo">
                </div>
                <div class="col-6 col-md-3 text-center">
                    <img src="{{ asset('images/partners/partner-2.png') }}" alt="Partner" class="img-fluid grayscale partner-logo">
                </div>
                <div class="col-6 col-md-3 text-center">
                    <img src="{{ asset('images/partners/partner-3.png') }}" alt="Partner" class="img-fluid grayscale partner-logo">
                </div>
                <div class="col-6 col-md-3 text-center">
                    <img src="{{ asset('images/partners/partner-4.png') }}" alt="Partner" class="img-fluid grayscale partner-logo">
                </div>
            </div>
        </div>
    </section>

    <!-- Impact Section -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="h1 mb-4">{{ __('Our Impact') }}</h2>
                    <p class="lead">{{ __('We\'re making measurable progress towards a cleaner, more sustainable Pemba.') }}</p>
                </div>
            </div>
            
            <div class="row g-4 align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="impact-metrics">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm rounded-4 text-center p-4 impact-card">
                                    <h3 class="display-4 fw-bold text-success mb-2 counter-value" data-target="1240">0</h3>
                                    <p class="mb-0">{{ __('Tons of Waste Collected') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm rounded-4 text-center p-4 impact-card">
                                    <h3 class="display-4 fw-bold text-primary mb-2 counter-value" data-target="420">0</h3>
                                    <p class="mb-0">{{ __('Tons of Waste Recycled') }}</p>
                                    </div>
                                    </div>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm rounded-4 text-center p-4 impact-card">
                                    <h3 class="display-4 fw-bold text-warning mb-2 counter-value" data-target="28">0</h3>
                                    <p class="mb-0">{{ __('Collection Points Established') }}</p>
                                    </div>
                                    </div>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm rounded-4 text-center p-4 impact-card">
                                    <h3 class="display-4 fw-bold text-info mb-2 counter-value" data-target="5000">0</h3>
                                    <p class="mb-0">{{ __('Community Members Engaged') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="p-4 bg-light rounded-4 shadow-sm">
                        <h3 class="h4 mb-4">{{ __('Success Stories') }}</h3>
                        
                        <div class="success-story mb-4">
                            <h4 class="h5 mb-3">{{ __('Coastal Cleanup Initiative') }}</h4>
                            <p>{{ __('Our coastal cleanup program has removed over 5 tons of plastic waste from beaches, protecting marine life and preserving tourism value.') }}</p>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span>{{ __('Progress: 85%') }}</span>
                                <span>{{ __('Target: 100%') }}</span>
                            </div>
                        </div>
                        
                        <div class="success-story mb-4">
                            <h4 class="h5 mb-3">{{ __('School Recycling Program') }}</h4>
                            <p>{{ __('Implemented in 12 schools, teaching students about waste separation and recycling while creating school gardens from compost.') }}</p>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 92%" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span>{{ __('Progress: 92%') }}</span>
                                <span>{{ __('Target: 100%') }}</span>
                            </div>
                        </div>
                        
                        <div class="success-story">
                            <h4 class="h5 mb-3">{{ __('Plastic-to-Products Initiative') }}</h4>
                            <p>{{ __('Local craftspeople trained to create products from recycled plastic, generating income and reducing plastic waste.') }}</p>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span>{{ __('Progress: 70%') }}</span>
                                <span>{{ __('Target: 100%') }}</span>
                            </div>
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
                    <h2 class="h1 mb-4">{{ __('Join Our Journey Towards a Cleaner Pemba') }}</h2>
                    <p class="lead mb-4">{{ __('Be part of our mission to create a sustainable waste management system for future generations.') }}</p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="{{ route('opportunities.circular-economy.assessment.index') }}" class="btn btn-light btn-lg shadow-sm">
                            <i class="fas fa-clipboard-check me-2"></i> {{ __('Take Assessment') }}
                        </a>
                        <a href="{{ route('opportunities.circular-economy.contact') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-handshake me-2"></i> {{ __('Partner With Us') }}
                        </a>
                </div>
            </div>
        </div>
    </div>
    </section>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Counter animation
            const counterElements = document.querySelectorAll('.counter-value');
            counterElements.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const duration = 2000; // 2 seconds
                const step = Math.ceil(target / (duration / 20)); // Update every 20ms
                let current = 0;
                
                const updateCounter = () => {
                    current += step;
                    if (current > target) current = target;
                    counter.textContent = current;
                    
                    if (current < target) {
                        setTimeout(updateCounter, 20);
                    }
                };
                
                updateCounter();
            });
        });
    </script>
    <style>
        .mission-icon, .stat-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
        }
        
        .mission-card {
            transition: all 0.3s ease;
        }
        
        .mission-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }
        
        .team-card {
            transition: all 0.3s ease;
        }
        
        .team-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }
        
        .story-experience {
            bottom: -20px;
            right: -20px;
        }
        
        .partner-logo {
            max-height: 80px;
            transition: all 0.3s ease;
            filter: grayscale(100%);
        }
        
        .partner-logo:hover {
            filter: grayscale(0%);
            transform: scale(1.1);
        }
        
        .impact-card {
            transition: all 0.3s ease;
        }
        
        .impact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
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
        
        .rounded-4 {
            border-radius: 0.75rem !important;
        }
    </style>
    @endpush
</x-app-layout> 