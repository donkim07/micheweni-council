@extends('government.layouts.app')

@section('title', __('About Us'))

@section('styles')
<style>
    .page-hero {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8)), url('/images/government/about-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
        margin-bottom: 3rem;
    }
    
    .timeline {
        position: relative;
        padding: 2rem 0;
    }
    
    .timeline:before {
        content: '';
        position: absolute;
        height: 100%;
        width: 2px;
        background-color: var(--primary);
        left: 50%;
        transform: translateX(-50%);
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 50px;
    }
    
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    
    .timeline-badge {
        width: 50px;
        height: 50px;
        background-color: var(--primary);
        color: white;
        border-radius: 50%;
        position: absolute;
        left: 50%;
        top: 0;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
    }
    
    .timeline-content {
        position: relative;
        width: calc(50% - 50px);
        background-color: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }
    
    .timeline-item:nth-child(odd) .timeline-content {
        margin-left: auto;
    }
    
    .timeline-item:nth-child(even) .timeline-content {
        margin-right: auto;
    }
    
    .timeline-content:before {
        content: '';
        position: absolute;
        top: 20px;
        width: 30px;
        height: 2px;
        background-color: var(--primary);
    }
    
    .timeline-item:nth-child(odd) .timeline-content:before {
        left: -30px;
    }
    
    .timeline-item:nth-child(even) .timeline-content:before {
        right: -30px;
    }
    
    .timeline-date {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .values-card {
        padding: 30px;
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        height: 100%;
    }
    
    .values-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary), var(--light-blue));
        color: white;
        font-size: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto 20px;
    }
    
    @media (max-width: 767.98px) {
        .timeline:before {
            left: 40px;
        }
        
        .timeline-badge {
            left: 40px;
        }
        
        .timeline-content {
            width: calc(100% - 90px);
            margin-left: 90px !important;
        }
        
        .timeline-content:before {
            left: -30px !important;
        }
    }
</style>
@endsection

@section('content')
    <!-- Page Hero -->
    <div class="page-hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">{{ __('About Micheweni District Council ') }}</h1>
                    <p class="lead mb-4">{{ __('Learn about our history, leadership, and our commitment to serving the people of Micheweni District Council.') }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Introduction Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <h2 class="section-title mb-4">{{ __('Welcome to Micheweni District Council') }}</h2>
                    <p>{{ __('Micheweni district is located in the Northern part of Pemba Island with 241 sq. Kilometers and lies between Latitude 455 and 6°30\' South of Equator, and Longitude 39° 55° East of Greenwich.') }}</p>
                    <p>{{ __('It is bordered by Wete district from Southern side and Indian Ocean in both Eastern and Western parts so it the Northern part. Being surrounded by Indian Ocean on its three cardinal points, Micheweni district is endowed with number of small Islands such as Kisiwa Ng\'ombe, Kisiwa Mbale, Usubi, Kamate, Mwimo, NjiaUze, Kwa Kombo, Sinawe, Hamisi, and Kijiwa huu.') }}</p>
                    <p>{{ __('The Micheweni District Council Council was established under Local Government Act No. 7 of 2014 that emphasizes that local people should participate in the planning processes. The Council is mandated to ensure that the community in its area of jurisdiction receives quality social services and economic development activities are fostered to ensure sustainable development.') }}</p>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="text-center">
                        <img src="{{ asset('images/government/about-intro.jpg') }}" alt="{{ __('Micheweni District Council') }}" class="img-fluid rounded shadow" style="max-height: 500px;">
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Mission & Vision Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="section-title">{{ __('Our Mission & Vision') }}</h2>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-up">
                    <div class="card h-100 border-0 shadow">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="d-inline-block rounded-circle bg-primary p-3">
                                    <i class="fas fa-bullseye text-white fa-3x"></i>
                                </div>
                            </div>
                            <h3 class="card-title text-center mb-4">{{ __('Our Mission') }}</h3>
                            <div class="card-text">{!! \App\Models\Government\SiteConfig::getConfig('mission_statement', __('To deliver high-quality services to the citizens of Micheweni District through efficient resource utilization, transparent governance, and community participation, thereby enhancing the socio-economic well-being of all residents.')) !!}</div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="d-inline-block rounded-circle bg-primary p-3">
                                    <i class="fas fa-eye text-white fa-3x"></i>
                                </div>
                            </div>
                            <h3 class="card-title text-center mb-4">{{ __('Our Vision') }}</h3>
                            <div class="card-text">{!! \App\Models\Government\SiteConfig::getConfig('vision_statement', __('To transform Micheweni District into a prosperous, environmentally sustainable, and socially inclusive community where all citizens enjoy high quality of life through access to excellent services, economic opportunities, and a clean environment.')) !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Core Values Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="section-title">{{ __('Our Core Values') }}</h2>
                    <p>{{ __('These principles guide our actions and decisions as we serve the community.') }}</p>
                </div>
            </div>
            
             <div class="row g-4">
                @php
                    $coreValues = \App\Models\Government\SiteConfig::getConfig('core_values', [], true);
                @endphp
                
                @if(count($coreValues) > 0)
                    @foreach($coreValues as $index => $value)
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 % 300 }}">
                            <div class="values-card text-center">
                                <div class="values-icon">
                                    <i class="{{ $value['icon'] ?? 'fas fa-star' }}"></i>
                                </div>
                                <h4>{{ $value['title'] }}</h4>
                                <p>{{ $value['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-lg-4 col-md-6" data-aos="fade-up">
                        <div class="values-card text-center">
                            <div class="values-icon">
                                <i class="fas fa-balance-scale"></i>
                            </div>
                            <h4>{{ __('Integrity') }}</h4>
                            <p>{{ __('We uphold the highest ethical standards in all our actions and decisions, ensuring honesty, accountability, and transparency in our service delivery.') }}</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="values-card text-center">
                            <div class="values-icon">
                                <i class="fas fa-hands-helping"></i>
                            </div>
                            <h4>{{ __('Service Excellence') }}</h4>
                            <p>{{ __('We are committed to providing timely, responsive, and high-quality services to meet the needs and exceed the expectations of our citizens.') }}</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="values-card text-center">
                            <div class="values-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4>{{ __('Inclusivity') }}</h4>
                            <p>{{ __('We embrace diversity and ensure that all citizens, regardless of their background or circumstances, have equal access to services and opportunities.') }}</p>
                        </div>
                    </div>
                @endif
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="values-card text-center">
                        <div class="values-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h4>{{ __('Innovation') }}</h4>
                        <p>{{ __('We continuously seek new and better ways to deliver services, solve problems, and create value for our citizens through creativity and forward thinking.') }}</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="values-card text-center">
                        <div class="values-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4>{{ __('Collaboration') }}</h4>
                        <p>{{ __('We believe in the power of partnerships and work closely with community members, businesses, and other stakeholders to achieve our common goals.') }}</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="values-card text-center">
                        <div class="values-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h4>{{ __('Sustainability') }}</h4>
                        <p>{{ __('We are committed to managing our resources responsibly and implementing practices that ensure environmental protection and long-term prosperity.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- History Timeline Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="section-title">{{ __('Our History') }}</h2>
                    <p>{{ __('Key milestones in the development of Micheweni District Council government.') }}</p>
                </div>
            </div>
            
            <div class="timeline">
                <div class="timeline-item" data-aos="fade-up">
                    <div class="timeline-badge">
                        <i class="fas fa-flag"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-date">1964</div>
                        <h4>{{ __('Independence and Formation') }}</h4>
                        <p>{{ __('Following the Zanzibar Revolution, Micheweni became part of the newly formed government structure in Pemba Island.') }}</p>
                    </div>
                </div>
                
                <div class="timeline-item" data-aos="fade-up">
                    <div class="timeline-badge">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-date">1972</div>
                        <h4>{{ __('District Formation') }}</h4>
                        <p>{{ __('Micheweni was officially designated as a district with its own administrative structure to better serve the local population.') }}</p>
                    </div>
                </div>
                
                <div class="timeline-item" data-aos="fade-up">
                    <div class="timeline-badge">
                        <i class="fas fa-water"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-date">1985</div>
                        <h4>{{ __('First Water Project') }}</h4>
                        <p>{{ __('The district government implemented its first major water supply project, providing clean water to thousands of residents.') }}</p>
                    </div>
                </div>
                
                <div class="timeline-item" data-aos="fade-up">
                    <div class="timeline-badge">
                        <i class="fas fa-road"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-date">1995</div>
                        <h4>{{ __('Infrastructure Development') }}</h4>
                        <p>{{ __('Major road construction projects were initiated, significantly improving transportation within the district.') }}</p>
                    </div>
                </div>
                
                <div class="timeline-item" data-aos="fade-up">
                    <div class="timeline-badge">
                        <i class="fas fa-school"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-date">2005</div>
                        <h4>{{ __('Education Reform') }}</h4>
                        <p>{{ __('The district implemented comprehensive education reforms, building new schools and improving the quality of education.') }}</p>
                    </div>
                </div>
                
                <div class="timeline-item" data-aos="fade-up">
                    <div class="timeline-badge">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-date">2015</div>
                        <h4>{{ __('Digital Government Initiative') }}</h4>
                        <p>{{ __('Micheweni District Council launched its digital government initiative to improve service delivery and citizen engagement.') }}</p>
                    </div>
                </div>
                
                <div class="timeline-item" data-aos="fade-up">
                    <div class="timeline-badge">
                        <i class="fas fa-recycle"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-date">2023</div>
                        <h4>{{ __('Circular Economy Program') }}</h4>
                        <p>{{ __('Launch of the comprehensive waste management and circular economy program to create a cleaner, more sustainable district.') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ url('/government/about/history') }}" class="btn btn-primary">{{ __('Learn More About Our History') }}</a>
            </div>
        </div>
    </section>
    
    <!-- Call to Action -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0" data-aos="fade-right">
                    <h2 class="mb-2">{{ __('Meet Our Leadership Team') }}</h2>
                    <p class="mb-0">{{ __('Learn more about the dedicated officials who lead our district government.') }}</p>
                </div>
                <div class="col-lg-4 text-lg-end" data-aos="fade-left">
                    <a href="{{ url('/government/about/leadership') }}" class="btn btn-light">{{ __('View Leadership Team') }}</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Social and Cultural Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8 text-center">
                    <h2 class="section-title position-relative mb-5">{{ __('Social and Cultural Overview') }}</h2>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="text-center mb-3">
                                <div class="d-inline-block rounded-circle bg-primary bg-opacity-10 p-3">
                                    <i class="fas fa-users text-primary fa-2x"></i>
                                </div>
                            </div>
                            <h4 class="card-title text-center mb-3" translate="no">{{ __('Ethnic Groups') }}</h4>
                            <p class="card-text">{{ __('Mainly Swahili-speaking Bantu, including Shirazi groups with a rich cultural heritage dating back centuries.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="text-center mb-3">
                                <div class="d-inline-block rounded-circle bg-primary bg-opacity-10 p-3">
                                    <i class="fas fa-language text-primary fa-2x"></i>
                                </div>
                            </div>
                            <h4 class="card-title text-center mb-3">{{ __('Language & Religion') }}</h4>
                            <p class="card-text">{{ __('Kiswahili is the main language spoken by residents. Nearly 100% Sunni Muslim; Islam deeply influences daily life, customs, and festivals.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="text-center mb-3">
                                <div class="d-inline-block rounded-circle bg-primary bg-opacity-10 p-3">
                                    <i class="fas fa-home text-primary fa-2x"></i>
                                </div>
                            </div>
                            <h4 class="card-title text-center mb-3">{{ __('Family Structure') }}</h4>
                            <p class="card-text">{{ __('Predominantly extended families, patriarchal, with some polygamy. Family bonds and community ties are exceptionally strong.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mt-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="text-center mb-3">
                                <div class="d-inline-block rounded-circle bg-primary bg-opacity-10 p-3">
                                    <i class="fas fa-music text-primary fa-2x"></i>
                                </div>
                            </div>
                            <h4 class="card-title text-center mb-3">{{ __('Cultural Practices') }}</h4>
                            <p class="card-text">{{ __('The district is known for its vibrant cultural expressions including Msewe traditional dance, Taarab music, and bullfighting (unique to Pemba). Historical sites such as ancient Swahili settlements like Tumbe and Msuka Mjini show a rich Islamic heritage spanning centuries.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mt-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="text-center mb-3">
                                <div class="d-inline-block rounded-circle bg-primary bg-opacity-10 p-3">
                                    <i class="fas fa-hand-holding-water text-primary fa-2x"></i>
                                </div>
                            </div>
                            <h4 class="card-title text-center mb-3">{{ __('Livelihoods') }}</h4>
                            <p class="card-text">{{ __('The main livelihoods are fishing, clove farming, and traditional dhow building, all tied to the Indian Ocean maritime culture. These occupations have shaped the community\'s way of life for generations and continue to be vital economic activities.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Economic Overview Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8 text-center">
                    <h2 class="section-title position-relative mb-5">{{ __('Economic Overview') }}</h2>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-7" data-aos="fade-right">
                    <h4 class="mb-4 text-primary">{{ __('Key Economic Sectors') }}</h4>
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="fas fa-seedling text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-4">
                            <h5>{{ __('Agriculture') }}</h5>
                            <p>{{ __('Main economic activity (~94% of households); crops include cassava, rice, and cloves.') }}</p>
                        </div>
                    </div>
                    
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="fas fa-fish text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-4">
                            <h5>{{ __('Fisheries') }}</h5>
                            <p>{{ __('Thousands rely on fishing; part of the growing blue economy.') }}</p>
                        </div>
                    </div>
                    
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="fas fa-water text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-4">
                            <h5>{{ __('Seaweed Farming') }}</h5>
                            <p>{{ __('Involves ~13% of households, mostly women.') }}</p>
                        </div>
                    </div>
                    
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="fas fa-hotel text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-4">
                            <h5>{{ __('Tourism & Mining') }}</h5>
                            <p>{{ __('Tourism is underdeveloped but emerging, based on beaches and historical sites. Small-scale mining includes sand extraction.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-5 mt-4 mt-lg-0" data-aos="fade-left">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white py-3">
                            <h4 class="mb-0">{{ __('Employment Overview') }}</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('Agriculture & Fishing') }}
                                    <span class="badge bg-primary rounded-pill">Major Employer</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('Tourism Sector') }}
                                    <span class="badge bg-primary rounded-pill">~6%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('Free Economic Zone') }}
                                    <span class="badge bg-success rounded-pill">Emerging</span>
                                </li>
                            </ul>
                            
                            <div class="mt-4">
                                <h5>{{ __('Investment Opportunities') }}</h5>
                                <p class="mb-2">{{ __('The district offers promising investment opportunities in:') }}</p>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-angle-right text-primary me-2"></i>{{ __('Fisheries & Blue Economy: Fish processing, landing sites, and marine services.') }}</li>
                                    <li class="mb-2"><i class="fas fa-angle-right text-primary me-2"></i>{{ __('Agriculture & Agribusiness: Spice processing (clove, nutmeg), organic farming, irrigation projects.') }}</li>
                                    <li class="mb-2"><i class="fas fa-angle-right text-primary me-2"></i>{{ __('Tourism: Eco-resorts, cultural heritage tours, marine tourism.') }}</li>
                                    <li><i class="fas fa-angle-right text-primary me-2"></i>{{ __('Renewable Energy: Solar and wind power projects.') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Tourism Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="section-title position-relative mb-5">{{ __('Tourism Sites & Attractions') }}</h2>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="{{ asset('images/government/tumbe-ruins.jpg') }}" class="card-img-top" alt="{{ __('Tumbe Archaeological Site') }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body p-4">
                            <h4 class="card-title mb-3" translate="no">{{ __('Tumbe Archaeological Site') }}</h4>
                            <p class="card-text">{{ __('Historic ruins of an ancient Swahili town dating from the 6th to 17th centuries. Tumbe provides insight into early Islamic civilization and the Indian Ocean trade on Pemba Island.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="{{ asset('images/government/shumba-bay.jpg') }}" class="card-img-top" alt="{{ __('Shumba Bay and Mangrove Forests') }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body p-4">
                            <h4 class="card-title mb-3" translate="no">{{ __('Shumba Bay and Mangrove Forests') }}</h4>
                            <p class="card-text">{{ __('Coastal mangrove ecosystems near Shumba village in Micheweni, ideal for eco-tourism, birdwatching, and boat tours.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="{{ asset('images/government/vumawimbi-beach.jpg') }}" class="card-img-top" alt="{{ __('Vumawimbi Beach') }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body p-4">
                            <h4 class="card-title mb-3" translate="no">{{ __('Vumawimbi Beach') }}</h4>
                            <p class="card-text">{{ __('A beautiful sandy beach in Micheweni District Council, offering a serene getaway and local fishing community experiences.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection 