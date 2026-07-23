@extends('government.layouts.app')

@section('title', __('Home'))

@section('styles')
<style>
    /* Hero Section */
    .hero-section {
        position: relative;
        background: url('{{ asset('images/government/hero-bg.jpg') }}') no-repeat center center;
        background-size: cover;
        padding: 70px 0;
        margin-top: 0;
    }
    
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8));
    }
    
    /* Leadership Card Styling - Reduced size */
    .leader-card {
        background-color: white;
        border-radius: 5px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid #eaeaea;
        display: flex;
        margin-bottom: 15px;
    }
    
    .leader-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .leader-info {
        padding: 10px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .leader-name {
        font-weight: 600;
        margin-bottom: 0;
        font-size: 0.95rem;
    }
    
    .leader-position {
        color: #555;
        font-size: 0.8rem;
        margin-bottom: 0;
    }
    
    .leader-image-container {
        width: 140px;
        flex-shrink: 0;
    }
    
    .leader-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        object-position: top;
    }
    
    /* Compact leader links */
    .leader-links {
        margin-top: 5px;
    }
    
    .leader-links a {
        font-size: 0.8rem;
        padding: 2px 8px;
    }
    
    /* Headers styling */
    .government-header {
        font-size: 1.2rem;
        text-align: center;
        color: #003366;
        text-transform: uppercase;
        font-weight: 600;
    }
    
    /* Stats Counter */
    .counter-box {
        padding: 30px 20px;
        text-align: center;
        border-radius: 15px;
        background: white;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .counter-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .counter-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: var(--primary);
    }
    
    .counter-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 5px;
        line-height: 1;
    }
    
    .counter-text {
        color: var(--secondary);
        font-weight: 500;
    }
    
    /* Services Section */
    .service-card {
        text-align: center;
        padding: 30px 20px;
        border-radius: 15px;
        background: white;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .service-icon {
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
    
    /* News Section */
    .news-date {
        font-size: 0.85rem;
        color: var(--secondary);
    }
    
    .news-tag {
        background-color: rgba(20, 78, 115, 0.1);
        color: var(--primary);
        font-size: 0.75rem;
        padding: 3px 10px;
        border-radius: 20px;
        display: inline-block;
    }
    
    /* Projects Section */
    .projects-section {
        background-color: var(--light);
    }
    
    .project-card {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        height: 250px;
    }
    
    .project-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.5s ease;
    }
    
    .project-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        color: white;
        padding: 20px;
        transform: translateY(0);
        transition: all 0.3s ease;
    }
    
    .project-card:hover .project-image {
        transform: scale(1.1);
    }
    
    .project-card:hover .project-overlay {
        transform: translateY(-10px);
    }
    
    /* Announcements Section */
    .announcement-badge {
        position: absolute;
        top: -10px;
        right: 20px;
        background-color: var(--accent);
        color: var(--dark);
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 500;
        box-shadow: 0 5px 15px rgba(241, 196, 15, 0.3);
    }
    
    /* Testimonials */
    .testimonial-card {
        background-color: white;
        border-radius: 15px;
        padding: 30px;
        margin: 30px 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        position: relative;
    }
    
    .testimonial-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        position: absolute;
        top: -40px;
        left: 30px;
        border: 5px solid white;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }
    
    .testimonial-quote {
        font-size: 4rem;
        position: absolute;
        top: 10px;
        right: 20px;
        color: rgba(20, 78, 115, 0.1);
    }
    
    .testimonial-text {
        margin-top: 30px;
        font-style: italic;
    }
    
    .testimonial-name {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 0;
    }
    
    .testimonial-position {
        color: var(--secondary);
        font-size: 0.85rem;
    }
    
    /* Swiper customization */
    .swiper-pagination-bullet {
        width: 12px;
        height: 12px;
        background-color: var(--primary);
        opacity: 0.5;
    }
    
    .swiper-pagination-bullet-active {
        opacity: 1;
        background-color: var(--primary);
    }
    
    .swiper-button-next, .swiper-button-prev {
        color: var(--primary);
    }
    
    /* Animation for banner text */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .hero-title {
        animation: fadeInUp 0.8s ease-out forwards;
    }
    
    .hero-subtitle {
        animation: fadeInUp 0.8s ease-out 0.3s forwards;
        opacity: 0;
    }
    
    .hero-btns {
        animation: fadeInUp 0.8s ease-out 0.6s forwards;
        opacity: 0;
    }
    
    /* Government logo and name section */
    .govt-logo-section {
        margin-bottom: 20px;
        text-align: center;
    }
    
    .govt-logo {
        max-height: 90px;
        margin-bottom: 10px;
    }
    
    /* Center content when there are few items */
    .center-few-items .col-centered-1 {
        max-width: 600px;
        margin: 0 auto;
        float: none;
    }
    
    .center-few-items .col-centered-2 {
        max-width: 450px;
        margin-left: 10px;
        margin-right: 10px;
    }
    
    /* Make sure images maintain aspect ratio */
    .project-card img {
        width: 100%;
        height: auto;
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="row">
                <!-- Left side with leadership profiles -->
                <div class="col-lg-5">
                    <div class="bg-white p-3 rounded shadow-sm h-100 d-flex flex-column justify-content-between" data-aos="fade-right" data-aos-delay="100">
                        <!-- First leader -->
                        <div class="leader-card">
                            <div class="leader-image-container">
                                <img src="{{ asset('images/' . ($leadership['commissioner']['image'] ?? 'government/avatar-placeholder.jpg')) }}" alt="{{ $leadership['commissioner']['name'] ?? 'Region Commissioner' }}" class="leader-image" onerror="this.src='{{ asset('images/government/avatar-placeholder.jpg') }}'">
                            </div>
                            <div class="leader-info" >
                                <p class="leader-name" style="color: #555; font-size: 0.7rem;" translate="no">{{ $leadership['commissioner']['name']}}</p>
                                <p class="leader-position fw-bold">{{ $leadership['commissioner']['title']}}</p>
                                <div class="d-flex justify-content-start leader-links">
                                    <a href="{{ url('/government/about/leadership') }}" class="text-primary me-2">{{ __('Profile') }}</a>
                                    <!-- <a href="{{ url('/government/about/leadership') }}" class="text-primary">{{ __('Welcome') }}</a> -->
                                </div>
                            </div>
                        </div>
                        
                        <!-- Second leader -->
                        <div class="leader-card">
                            <div class="leader-image-container">
                                <img src="{{ asset('images/' . ($leadership['director']['image'] ?? 'government/avatar-placeholder.jpg')) }}" alt="{{ $leadership['director']['name'] ?? 'Region Director' }}" class="leader-image" onerror="this.src='{{ asset('images/government/avatar-placeholder.jpg') }}'">
                            </div>
                            <div class="leader-info">
                                <p class="leader-name" style="color: #555; font-size: 0.7rem;" translate="no">{{ $leadership['director']['name']}}</p>
                                <p class="leader-position fw-bold">{{ $leadership['director']['title']}}</p>
                                <div class="d-flex justify-content-start leader-links">
                                    <a href="{{ url('/government/about/leadership') }}" class="text-primary me-2">{{ __('Profile') }}</a>
                                    <!-- <a href="{{ url('/government/about/leadership') }}" class="text-primary">{{ __('Welcome') }}</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right side with banner image/carousel -->
                <div class="col-lg-7">
                    <div class="position-relative rounded shadow-sm overflow-hidden" data-aos="fade-left" data-aos-delay="200">
                        <div class="govt-logo-section position-absolute top-0 end-0 p-3">
                            <img src="{{ asset('images/logo-right.png') }}" alt="Government Logo" class="govt-logo">
                            <h5 class="text-white mb-0"></h5>
                        </div>
                        
                        <!-- Image Slider with original functionality -->
                        <div class="swiper hero-swiper">
                            <div class="swiper-wrapper">
                                @forelse($mediaGallery as $media)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('images/' . $media->file_path) }}" 
                                             alt="{{ $media->title }}" 
                                             class="img-fluid w-100" 
                                             style="height: 440px; object-fit: cover;"
                                             loading="eager"
                                             fetchpriority="high"
                                             onerror="this.src='{{ asset('images/government/pemba-landscape.jpg') }}'">
                                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 p-3 text-white">
                                            <h5 class="mb-0">{{ $media->title }}</h5>
                                        </div>
                                    </div>
                                @empty
                                    <div class="swiper-slide">
                                        <img src="{{ asset('images/government/pemba-landscape.jpg') }}" 
                                             alt="North Pemba Pemba"
                                             class="img-fluid w-100" 
                                             style="height: 440px; object-fit: cover;"
                                             loading="eager"
                                             fetchpriority="high">
                                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 p-3 text-white">
                                            <h5 class="mb-0">{{ __('Welcome to North Pemba-Pemba') }}</h5>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            <!-- Add Navigation -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </section>
    
    <!-- Statistics Counter Section -->
    <section class="py-5 bg-white">
        <div class="container">
            @php
                $statsCount = isset($stats) && !empty($stats) && is_array($stats) ? min(count($stats), 4) : 1;
                $centerFewItems = $statsCount <= 2;
            @endphp
            <div class="row g-4 justify-content-center {{ $centerFewItems ? 'center-few-items' : '' }}">
                @if(isset($stats) && !empty($stats) && is_array($stats))
                    @php
                        // Define default icons for common stat keys
                        $defaultIcons = [
                            'population' => 'fa-users',
                            'businesses' => 'fa-building',
                            'schools' => 'fa-school',
                            'health_centers' => 'fa-hospital',
                            'visitors' => 'fa-chart-line',
                            'projects' => 'fa-project-diagram',
                            'services' => 'fa-concierge-bell',
                            'area' => 'fa-map-marked-alt'
                        ];
                        
                        $counter = 0;
                    @endphp
                    
                    @foreach($stats as $key => $value)
                        @php
                            $counter++;
                            $delay = $counter * 100;
                            $displayName = isset($statsNames[$key]) ? $statsNames[$key] : ucwords(str_replace('_', ' ', $key));
                            $icon = isset($statsIcons[$key]) ? $statsIcons[$key] : ($defaultIcons[$key] ?? 'fa-chart-line');
                            
                            // Only show up to 4 stats
                            if($counter > 4) break;
                            
                            // Apply special classes for 1 or 2 items
                            $columnClass = $statsCount > 2 ? 'col-md-3 col-6' : ($statsCount == 2 ? 'col-md-6 col-6 col-centered-2' : 'col-md-6 col-10 col-centered-1');
                        @endphp
                        
                        <div class="{{ $columnClass }}" data-aos="fade-up" data-aos-delay="{{ $delay }}">
                            <div class="counter-box">
                                <div class="counter-icon">
                                    <i class="fas {{ $icon }}"></i>
                                </div>
                                <div class="counter-number" data-count="{{ $value }}">0</div>
                                <div class="counter-text">{{ __($displayName) }}</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Display default stats if none are configured -->
                    <div class="col-md-6 col-10 col-centered-1" data-aos="fade-up" data-aos-delay="100">
                        <div class="counter-box">
                            <div class="counter-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="counter-number" data-count="95000">0</div>
                            <div class="counter-text">{{ __('Population') }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center mb-5" data-aos="fade-up">{{ __('Our Services') }}</h2>
            
            @php
                $servicesCount = $services->count() > 0 ? $services->count() : 3; // Default to 3 for placeholder
                $centerFewItems = $servicesCount <= 2;
            @endphp
            <div class="row g-4 justify-content-center {{ $centerFewItems ? 'center-few-items' : '' }}">
                @forelse($services as $service)
                    @php
                        // Apply special classes for 1 or 2 items
                        $columnClass = $servicesCount > 2 ? 'col-lg-4 col-md-6' : ($servicesCount == 2 ? 'col-lg-5 col-md-6 col-centered-2' : 'col-lg-8 col-md-10 col-centered-1');
                    @endphp
                    
                    <div class="{{ $columnClass }}" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="service-card">
                            <div class="service-icon">
                                @php
                                    // Default icons based on department
                                    $defaultIcons = [
                                        'health' => 'fa-heartbeat',
                                        'education' => 'fa-graduation-cap',
                                        'finance' => 'fa-money-bill-wave',
                                        'infrastructure' => 'fa-road',
                                        'environment' => 'fa-leaf',
                                        'water' => 'fa-tint',
                                        'agriculture' => 'fa-seedling',
                                        'social' => 'fa-users',
                                        'tourism' => 'fa-umbrella-beach',
                                    ];
                                    
                                    $icon = 'fa-cog'; // Default fallback
                                    
                                    if ($service->icon) {
                                        $icon = $service->icon;
                                    } elseif ($service->department) {
                                        $deptSlug = strtolower(str_replace(' ', '-', $service->department->slug));
                                        // Try to match department name with default icons
                                        foreach($defaultIcons as $key => $value) {
                                            if(strpos($deptSlug, $key) !== false) {
                                                $icon = $value;
                                                break;
                                            }
                                        }
                                    }
                                @endphp
                                <i class="fas {{ $icon }}"></i>
                            </div>
                            <h4 class="mt-4 mb-3">{{ $service->title }}</h4>
                            <p>{{ $service->short_description ?? Str::limit(strip_tags($service->description), 100) }}</p>
                            <a href="{{ url('/government/services/' . $service->id) }}" class="btn btn-outline-primary mt-3">{{ __('Learn More') }}</a>
                        </div>
                    </div>
                @empty
                    @php
                        $placeholderServices = [
                            ['icon' => 'fa-id-card', 'title' => __('Business Permits'), 'slug' => 'business-permits', 'description' => __('Apply for business permits and licenses for your commercial activities in North Pemba district.')],
                            ['icon' => 'fa-home', 'title' => __('Building Permits'), 'slug' => 'building-permits', 'description' => __('Get approvals for construction, renovation, and development projects in our district.')],
                            ['icon' => 'fa-recycle', 'title' => __('Waste Management'), 'slug' => 'waste-management', 'description' => __('Access our comprehensive waste management and circular economy services.')]
                        ];
                        
                        $placeholderCount = count($placeholderServices);
                        $centerPlaceholders = $placeholderCount <= 2;
                    @endphp
                    
                    @foreach($placeholderServices as $index => $service)
                        @php
                            $placeholderColumnClass = $placeholderCount > 2 ? 'col-lg-4 col-md-6' : ($placeholderCount == 2 ? 'col-lg-5 col-md-6 col-centered-2' : 'col-lg-8 col-md-10 col-centered-1');
                        @endphp
                        
                        <div class="{{ $placeholderColumnClass }}" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                            <div class="service-card">
                                <div class="service-icon">
                                    <i class="fas {{ $service['icon'] }}"></i>
                                </div>
                                <h4 class="mt-4 mb-3">{{ $service['title'] }}</h4>
                                <p>{{ $service['description'] }}</p>
                                <a href="{{ url('/government/services/' . $service['slug']) }}" class="btn btn-outline-primary mt-3">{{ __('Learn More') }}</a>
                            </div>
                        </div>
                    @endforeach
                @endforelse
            </div>
            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ url('/government/services') }}" class="btn btn-primary">{{ __('View All Services') }}</a>
            </div>
        </div>
    </section>
    
    <!-- News Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h2 class="section-title mb-0" data-aos="fade-right">{{ __('Latest News') }}</h2>
                <a href="{{ url('/government/news-new') }}" class="btn btn-outline-primary" data-aos="fade-left">{{ __('View All News') }}</a>
            </div>
            
            <div class="row g-4">
                @forelse($newsArticles as $article)
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="card h-100">
                            <div style="height: 270px; overflow: hidden;">
                                <img src="{{ asset('images/' . $article->featured_image) }}" class="card-img-top" alt="{{ $article->title }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='/images/government/news/default-news.jpg'">
                            </div>
                            <div class="card-body">
                                <span class="news-tag mb-2">{{ $article->category->name ?? __('News') }}</span>
                                <h5 class="card-title">{{ $article->title }}</h5>
                                <p class="news-date"><i class="far fa-calendar-alt me-1"></i> {{ $article->created_at->format('F d, Y') }}</p>
                                <p class="card-text">{{ Str::limit($article->excerpt, 100) }}</p>
                                <a href="{{ url('/government/news-new/' . $article->id) }}" class="btn btn-link px-0">{{ __('Read More') }} <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                @empty
                    @php
                        $placeholderNews = [
                            ['image' => 'images/government/news-1.jpg', 'category' => __('Announcement'), 'title' => __('New Water Supply System Launched in North Pemba Region'), 'date' => 'June 10, 2025', 'excerpt' => __('The North Pemba Region  has launched a new water supply system that will benefit over 20,000 residents...')],
                            ['image' => 'images/government/news-2.jpg', 'category' => __('Event'), 'title' => __('Annual Cultural Festival to be Held Next Month'), 'date' => 'June 8, 2025', 'excerpt' => __('The annual North Pemba Cultural Festival will take place from July 15-18, featuring traditional dances, music...')],
                            ['image' => 'images/government/news-3.jpg', 'category' => __('Development'), 'title' => __('New Road Construction Project Begins'), 'date' => 'June 5, 2025', 'excerpt' => __('A major road construction project has begun in North Pemba Region, aimed at improving transportation infrastructure...')]
                        ];
                    @endphp
                    
                    @foreach($placeholderNews as $index => $news)
                        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                            <div class="card h-100">
                                <div style="height: 270px; overflow: hidden;">
                                    <img src="{{ asset($news['image']) }}" class="card-img-top" alt="{{ $news['title'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div class="card-body">
                                    <span class="news-tag mb-2">{{ $news['category'] }}</span>
                                    <h5 class="card-title">{{ $news['title'] }}</h5>
                                    <p class="news-date"><i class="far fa-calendar-alt me-1"></i> {{ $news['date'] }}</p>
                                    <p class="card-text">{{ $news['excerpt'] }}</p>
                                    <a href="{{ url('/government/news-new/' . ($index + 1)) }}" class="btn btn-link px-0">{{ __('Read More') }} <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>
    
    <!-- Projects Section -->
    <section class="projects-section py-5">
        <div class="container">
            <h2 class="section-title text-center mb-5" data-aos="fade-up">{{ __('Featured Projects') }}</h2>
            
            @php
                $projectsCount = $projects->count() > 0 ? $projects->count() : 4; // Default to 4 for placeholder
                $centerFewItems = $projectsCount <= 2;
            @endphp
            <div class="row g-4 justify-content-center {{ $centerFewItems ? 'center-few-items' : '' }}">
                @forelse($projects as $project)
                    @php
                        // Apply special classes for 1 or 2 items
                        $columnClass = $projectsCount > 3 ? 'col-lg-3 col-md-6' : ($projectsCount == 3 ? 'col-lg-4 col-md-6' : ($projectsCount == 2 ? 'col-lg-5 col-md-6 col-centered-2' : 'col-lg-6 col-md-8 col-centered-1'));
                    @endphp
                    
                    <div class="{{ $columnClass }}" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="project-card">
                            <img src="{{ asset('images/' . $project->featured_image) }}" class="project-image" alt="{{ $project->title }}" onerror="this.src='/images/government/projects/default-project.jpg'">
                            <div class="project-overlay">
                                <h5>{{ $project->title }}</h5>
                                <p class="small mb-0">{{ __('Status') }}: {{ $project->status }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    @php
                        $placeholderProjects = [
                            ['image' => 'images/government/project-1.jpg', 'title' => __('Road Infrastructure Improvement'), 'status' => __('In Progress')],
                            ['image' => 'images/government/project-2.jpg', 'title' => __('School Renovation Program'), 'status' => __('Completed')],
                            ['image' => 'images/government/project-3.jpg', 'title' => __('Water Supply Expansion'), 'status' => __('In Progress')],
                            ['image' => 'images/government/project-4.jpg', 'title' => __('Healthcare Center Modernization'), 'status' => __('Planning')]
                        ];
                        
                        $placeholderCount = count($placeholderProjects);
                        $centerPlaceholders = $placeholderCount <= 2;
                    @endphp
                    
                    @foreach($placeholderProjects as $index => $project)
                        @php
                            $placeholderColumnClass = $placeholderCount > 3 ? 'col-lg-3 col-md-6' : ($placeholderCount == 3 ? 'col-lg-4 col-md-6' : ($placeholderCount == 2 ? 'col-lg-5 col-md-6 col-centered-2' : 'col-lg-6 col-md-8 col-centered-1'));
                        @endphp
                        
                        <div class="{{ $placeholderColumnClass }}" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                            <div class="project-card">
                                <img src="{{ asset($project['image']) }}" class="project-image" alt="{{ $project['title'] }}">
                                <div class="project-overlay">
                                    <h5>{{ $project['title'] }}</h5>
                                    <p class="small mb-0">{{ __('Status') }}: {{ $project['status'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforelse
            </div>
            
            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ url('/government/projects') }}" class="btn btn-primary">{{ __('View All Projects') }}</a>
            </div>
        </div>
    </section>
    
    <!-- Important Announcements -->
    <section class="py-5 bg-white">
        <div class="container">
            <h2 class="section-title text-center mb-5" data-aos="fade-up">{{ __('Important Announcements') }}</h2>
            
            @php
                $announcementsCount = $announcementNews->count() > 0 ? $announcementNews->count() : 2; // Default to 2 for placeholder
                $centerFewItems = $announcementsCount <= 1;
            @endphp
            <div class="row g-4 justify-content-center {{ $centerFewItems ? 'center-few-items' : '' }}">
                @forelse($announcementNews as $news)
                    @php
                        // Apply special classes for 1 item
                        $columnClass = $announcementsCount > 1 ? 'col-lg-6' : 'col-lg-8 col-md-10 col-centered-1';
                    @endphp
                    
                    <div class="{{ $columnClass }}" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="card h-100 border-0 shadow position-relative">
                            @if($news->is_critical)
                                <span class="announcement-badge">{{ __('Urgent') }}</span>
                            @endif
                            <div class="card-body p-4">
                                <h4>{{ $news->title }}</h4>
                                <p class="news-date mb-3"><i class="far fa-calendar-alt me-1"></i> {{ $news->published_at ? $news->published_at->format('F d, Y') : $news->created_at->format('F d, Y') }}</p>
                                <p>{{ Str::limit(strip_tags($news->excerpt ?: $news->content), 150) }}</p>
                                <a href="{{ url('/government/news-new/' . $news->id) }}" class="btn btn-outline-primary mt-2">{{ __('Read Details') }}</a>
                            </div>
                        </div>
                    </div>
                @empty
                    @php
                        $placeholderAnnouncements = [
                            ['title' => __('Public Health Notice'), 'date' => 'June 12, 2025', 'content' => __('Due to recent weather conditions, residents are advised to boil drinking water as a precautionary measure. This advisory will remain in effect until further notice.'), 'is_urgent' => true],
                            ['title' => __('Town Hall Meeting'), 'date' => 'June 20, 2025', 'content' => __('All residents are invited to attend the quarterly Town Hall Meeting on June 20, 2025, at 3:00 PM. The meeting will address community concerns and upcoming projects.'), 'is_urgent' => false]
                        ];
                        
                        $placeholderCount = count($placeholderAnnouncements);
                        $centerPlaceholders = $placeholderCount <= 1;
                    @endphp
                    
                    @foreach($placeholderAnnouncements as $index => $announcement)
                        @php
                            $placeholderColumnClass = $placeholderCount > 1 ? 'col-lg-6' : 'col-lg-8 col-md-10 col-centered-1';
                        @endphp
                        
                        <div class="{{ $placeholderColumnClass }}" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                            <div class="card h-100 border-0 shadow position-relative">
                                @if($announcement['is_urgent'])
                                    <span class="announcement-badge">{{ __('Urgent') }}</span>
                                @endif
                                <div class="card-body p-4">
                                    <h4>{{ $announcement['title'] }}</h4>
                                    <p class="news-date mb-3"><i class="far fa-calendar-alt me-1"></i> {{ $announcement['date'] }}</p>
                                    <p>{{ $announcement['content'] }}</p>
                                    <a href="{{ route('government.news.show', $index + 1) }}" class="btn btn-outline-primary mt-2">{{ __('Read Details') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center mb-5" data-aos="fade-up">{{ __('What People Say') }}</h2>
            
            <div class="testimonial-swiper">
                <div class="swiper-wrapper">
                    @forelse($testimonials as $testimonial)
                        <div class="swiper-slide">
                            <div class="testimonial-card">
                                @if($testimonial->avatar)
                                    <img src="{{ asset('images/' . $testimonial->avatar) }}" alt="{{ $testimonial->name }}" class="testimonial-avatar">
                                @else
                                    <div class="testimonial-avatar-placeholder">
                                        <i class="fas fa-user"></i>
                                </div>
                                @endif
                                <span class="testimonial-quote">&ldquo;</span>
                                <p class="testimonial-text">{{ $testimonial->content }}</p>
                                <h5 class="testimonial-name" translate="no">{{ $testimonial->name }}</h5>
                                <p class="testimonial-position">{{ $testimonial->position }}</p>
                            </div>
                        </div>
                    @empty
                        @php
                            $placeholderTestimonials = [
                                ['name' => __('John Doe'), 'position' => __('Business Owner'), 'content' => __('The new online permit application system has made it so much easier to start my business in North Pemba. What used to take weeks now takes just days!')],
                                ['name' => __('Maria Hassan'), 'position' => __('Teacher'), 'content' => __('The education department\'s new digital resources have been a game-changer for our school. Students are more engaged and learning outcomes have improved.')],
                                ['name' => __('Ali Khamis'), 'position' => __('Community Leader'), 'content' => __('The transparency portal has made it easier for us to understand how district resources are being allocated. This is true accountability in action.')]
                            ];
                        @endphp
                        
                        @foreach($placeholderTestimonials as $testimonial)
                            <div class="swiper-slide">
                                <div class="testimonial-card">
                                    <div class="testimonial-avatar-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <span class="testimonial-quote">&ldquo;</span>
                                    <p class="testimonial-text">{{ $testimonial['content'] }}</p>
                                    <h5 class="testimonial-name" translate="no">{{ $testimonial['name'] }}</h5>
                                    <p class="testimonial-position">{{ $testimonial['position'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endforelse
                </div>
                
                <!-- Add pagination -->
                <div class="swiper-pagination"></div>
                
                <!-- Add navigation buttons -->
                <!-- <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div> -->
            </div>
        </div>
    </section>
    
    <!-- Call to Action -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0" data-aos="fade-right">
                    <h2 class="mb-2">{{ __('Stay Connected with North Pemba Government') }}</h2>
                    <p class="mb-0">{{ __('Subscribe to our newsletter to receive updates on news, events, and important announcements.') }}</p>
                </div>
                <div class="col-lg-4" data-aos="fade-left">
                    <form action="" method="" class="d-flex">
                        @csrf
                        <input type="email" class="form-control me-2" placeholder="{{ __('Your Email') }}" name="email" required>
                        <button type="submit" class="btn btn-accent">{{ __('Subscribe') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the hero swiper
        new Swiper('.hero-swiper', {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            }
        });
        
        // Initialize the announcement swiper
        new Swiper('.announcement-swiper', {
            direction: 'horizontal',
            loop: true,
            autoHeight: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            }
        });
        
        // Initialize the testimonial swiper
        new Swiper('.testimonial-swiper', {
            direction: 'horizontal',
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            pagination: {
                el: '.testimonial-swiper-pagination',
                clickable: true
            },
            navigation: {
                nextEl: '.testimonial-swiper-button-next',
                prevEl: '.testimonial-swiper-button-prev'
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                992: {
                    slidesPerView: 3,
                    spaceBetween: 30
                }
            }
        });
        
        // Counter animation for statistics
        const counters = document.querySelectorAll('.counter-number');
        const speed = 200;
        
        counters.forEach(counter => {
            const animate = () => {
                const value = +counter.getAttribute('data-count');
                const data = +counter.innerText;
                
                const time = value / speed;
                if (data < value) {
                    counter.innerText = Math.ceil(data + time);
                    setTimeout(animate, 1);
                } else {
                    counter.innerText = value;
                }
            };
            
            animate();
        });
    });
</script>
@endsection