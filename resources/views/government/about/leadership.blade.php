@extends('government.layouts.app')

@section('title', __('Leadership'))

@section('styles')
<style>
    .page-hero {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8)), url('/images/government/history-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
    }
    .leadership-hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8));
    }
    
    .leader-card {
        background-color: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .leader-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .leader-image-container {
        height: 200px;
        overflow: hidden;
    }
    
    .leader-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.5s ease;
    }
    
    .leader-card:hover .leader-image {
        transform: scale(1.05);
    }
    
    .leader-info {
        padding: 25px;
    }
    
    .leader-name {
        color: var(--primary);
        margin-bottom: 5px;
    }
    
    .leader-position {
        color: var(--secondary);
        font-weight: 500;
        margin-bottom: 15px;
        font-size: 0.9rem;
    }
    
    .leader-contact {
        font-size: 0.85rem;
        color: var(--dark);
        margin-bottom: 15px;
    }
    
    .leader-contact i {
        color: var(--primary);
        width: 20px;
    }
    
    .leader-bio {
        margin-top: 15px;
        font-size: 0.95rem;
    }
    
    .section-header {
        position: relative;
        margin-bottom: 50px;
        text-align: center;
    }
    
    .section-header:after {
        content: '';
        position: absolute;
        width: 80px;
        height: 3px;
        background-color: var(--primary);
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .card-wrapper {
        position: relative;
    }
    
    .leader-social {
        position: absolute;
        top: 20px;
        right: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        z-index: 1;
    }
    
    .social-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    
    .social-icon:hover {
        transform: scale(1.1);
        background-color: var(--dark);
    }
    
    .org-structure-box {
        border: 2px solid var(--primary);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        position: relative;
        background-color: white;
    }
    
    .org-structure-box h5 {
        margin-bottom: 10px;
        color: var(--primary);
    }
    
    .org-structure-box p {
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    
    .org-line {
        position: absolute;
        background-color: var(--primary);
        z-index: 0;
    }
    
    .org-line-vertical {
        /* width: 2px; */
        height: 20px;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .org-line-horizontal {
        height: 2px;
        top: 50%;
        transform: translateY(-50%);
    }
    
    .org-structure-top {
        background-color: var(--primary);
        color: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
    }
    
    .org-structure-top h4 {
        margin-bottom: 0;
    }
    
    /* New styles for the leader layout */
    .leader-top-row {
        display: flex;
        flex-direction: row;
        margin-bottom: 15px;
    }
    
    .leader-image-wrap {
        width: 180px;
        height: 200px;
        overflow: hidden;
        margin-right: 20px;
        flex-shrink: 0;
        border-radius: 8px;
    }
    
    .leader-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .leader-header-info {
        flex-grow: 1;
    }
    
    .leader-contact-wrap {
        margin-bottom: 15px;
    }
    
    @media (max-width: 767.98px) {
        .leader-top-row {
            flex-direction: column;
        }
        
        .leader-image-wrap {
            width: 100%;
            height: 250px;
            margin-right: 0;
            margin-bottom: 15px;
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
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ url('/government') }}" class="text-white">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/government/about') }}" class="text-white">About</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Leadership</li>
                    </ol>
                </nav>
                
                <h1 class="display-4 fw-bold mb-3">Our District Council</h1>
                <p class="lead mb-4">Under this leadership, the Micheweni District Government is committed to providing efficient and effective services to the people of Micheweni.</p>
            </div>
        </div>
    </div>
</div>
    
    <!-- Top Leadership Section - Commissioner and Secretary in Row -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="section-header">{{ __('District Leadership') }}</h2>
                </div>
            </div>
            
            <div class="row g-4">
                <!-- District Commissioner (Mkuu wa Wilaya) -->
                <div class="col-lg-6">
                    <div class="leader-card h-100">
                        <div class="card-body p-4">
                            <div class="leader-top-row">
                                <div class="leader-image-wrap">
                                    <img src="{{ asset('images/' . ($leadership['commissioner']['image'] ?? 'government/avatar-placeholder.jpg')) }}" alt="{{ $leadership['commissioner']['name'] ?? 'Mkuu wa Wilaya' }}" onerror="this.src='{{ asset('images/government/avatar-placeholder.jpg') }}'">
                                </div>
                                <div class="leader-header-info">
                                    <h3 class="leader-name" translate="no">{{ $leadership['commissioner']['name']}}</h3>
                                    <p class="leader-position text-center fw-bold">{{ $leadership['commissioner']['title']}}</p>
                                    
                                    <div class="leader-contact" style="display: flex; 
                                    flex-direction: column; gap: 10px;">
                                        <a href="mailto:{{ $leadership['commissioner']
                                        ['email'] }}"><i class="fas fa-envelope me-2"></i> {{ 
                                        $leadership['commissioner']['email'] }}</a>
                                        <a href="tel:{{ $leadership['commissioner']['phone'] }}
                                        "><i class="fas fa-phone me-2"></i> {{ $leadership
                                        ['commissioner']['phone'] }}</a>
                                        <p><i class="fas fa-map-marker-alt me-2"></i> {{ 
                                        $leadership['commissioner']['office'] }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="leader-bio">
                                <p>{{ $leadership['commissioner']['bio'] ?? 'The District Commissioner is appointed by the President of Zanzibar and Chairman of the Revolutionary Council. As outlined in the Local Government Act No. 8 of 1998 (as amended in 2014), the Commissioner is the principal representative of the government in the district and oversees all government activities, security matters, and development initiatives.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- District Administrative Secretary (Katibu Tawala Wilaya) -->
                <div class="col-lg-6">
                    <div class="leader-card h-100">
                        <div class="card-body p-4">
                            <div class="leader-top-row">
                                <div class="leader-image-wrap">
                                    <img src="{{ asset('images/' . ($leadership['director']['image'] ?? 'government/avatar-placeholder.jpg')) }}" alt="{{ $leadership['director']['name'] ?? 'District Executive Director' }}" onerror="this.src='{{ asset('images/government/avatar-placeholder.jpg') }}'">
                                </div>
                                <div class="leader-header-info">
                                    <h3 class="leader-name" translate="no">{{ $leadership['director']['name'] }}</h3>
                                    <p class="leader-position text-center fw-bold">{{ $leadership['director']['title'] }}</p>
                                    
                                    <div class="leader-contact" style="display: flex; 
                                    flex-direction: column; gap: 10px;">
                                    <a href="mailto:{{ $leadership['director']['email'] }}
                                        "><i class="fas fa-envelope me-2"></i> {{ $leadership
                                        ['director']['email'] }}</a>
                                        <a href="tel:{{ $leadership['director']['phone'] }}"><i 
                                        class="fas fa-phone me-2"></i> {{ $leadership
                                        ['director']['phone'] }}</a>
                                       <div><i class="fas fa-map-marker-alt me-2"></i> {{ $leadership['secretary']['office'] ?? $leadership['director']['office'] }}</div>
                                </div>
                                    </div>
                            </div>
                            
                            <div class="leader-bio">
                                <p>{{ $leadership['secretary']['bio'] ?? $leadership['director']['bio'] ?? 'The District Administrative Secretary is the main assistant to the District Commissioner. Appointed by the President of Zanzibar and Chairman of the Revolutionary Council, the Secretary is responsible for the day-to-day administration of the district government, coordinating department activities, and ensuring policy implementation.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Department Heads Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="section-header">{{ __('Department Heads') }}</h2>
                </div>
            </div>
            
            <div class="row g-4">
                @php
                    $departments = $departments ?? [];
                @endphp
                @forelse($departments as $department)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="card-wrapper">
                            <div class="leader-card">
                                <div class="leader-image-container">
                                    <img src="{{ asset('images/' . $department->head_image) }}" class="leader-image" alt="{{ $department->head_name }}" onerror="this.src='{{ asset('images/government/avatar-placeholder.jpg') }}'">
                                    <div class="leader-social">
                                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                                    </div>
                                </div>
                                <div class="leader-info">
                                    <h4 class="leader-name" translate="no">{{ $department->head_name }}</h4>
                                    <p class="leader-position">{{ $department->head_title }}</p>
                                    <p class="mb-3">{{ __('Department of') }} {{ $department->name }}</p>
                                    <div class="leader-contact">
                                        <p><i class="fas fa-envelope me-2"></i> {{ $department->contact_email }}</p>
                                        <p><i class="fas fa-phone me-2"></i> {{ $department->contact_phone }}</p>
                                    </div>
                                    <a href="{{ url('/government/departments/' . $department->slug) }}" class="btn btn-outline-primary btn-sm mt-3">{{ __('View Department') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    @php
                        $placeholderDepartments = [                                 
                            [
                                'name' => __('Education'),
                                'head_name' => __('Mr. Hassan Omar'),
                                'head_title' => __('Director of Education'),
                                'head_image' => 'images/government/leaders/education.jpg',
                                'contact_email' => 'education@micheweni.go.tz',
                                'contact_phone' => '+255 777 111 222',
                                'slug' => 'education'
                            ],
                            [
                                'name' => __('Health'),
                                'head_name' => __('Dr. Amina Juma'),
                                'head_title' => __('Director of Health Services'),
                                'head_image' => 'images/government/leaders/health.jpg',
                                'contact_email' => 'health@micheweni.go.tz',
                                'contact_phone' => '+255 777 333 444',
                                'slug' => 'health'
                            ],
                            [
                                'name' => __('Infrastructure'),
                                'head_name' => __('Eng. Ali Khamis'),
                                'head_title' => __('Director of Infrastructure'),
                                'head_image' => 'images/government/leaders/infrastructure.jpg',
                                'contact_email' => 'infrastructure@micheweni.go.tz',
                                'contact_phone' => '+255 777 555 666',
                                'slug' => 'infrastructure'
                            ]
                        ];
                    @endphp
                    
                    @foreach($placeholderDepartments as $index => $department)
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                            <div class="card-wrapper">
                                <div class="leader-card">
                                    <div class="leader-image-container">
                                        <img src="{{ asset($department['head_image']) }}" class="leader-image" alt="{{ $department['head_name'] }}">
                                        <div class="leader-social">
                                            <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                                            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                                        </div>
                                    </div>
                                    <div class="leader-info">
                                        <h4 class="leader-name" translate="no">{{ $department['head_name'] }}</h4>
                                        <p class="leader-position">{{ $department['head_title'] }}</p>
                                        <p class="mb-3">{{ __('Department of') }} {{ $department['name'] }}</p>
                                        <div class="leader-contact">
                                            <p><i class="fas fa-envelope me-2"></i> {{ $department['contact_email'] }}</p>
                                            <p><i class="fas fa-phone me-2"></i> {{ $department['contact_phone'] }}</p>
                                        </div>
                                        <a href="{{ url('/government/departments/' . $department['slug']) }}" class="btn btn-outline-primary btn-sm mt-3">{{ __('View Department') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>
    
    <!-- Organization Structure Section -->
    <!-- <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="section-header">{{ __('Organization Structure') }}</h2>
                    <p class="mt-4">{{ __('The Micheweni District Government operates under a structured hierarchy to ensure efficient service delivery and clear lines of accountability.') }}</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="org-structure-top text-center mb-4">
                        <h4>{{ __('District Commissioner') }}</h4>
                    </div>
                    
                    <div class="org-line org-line-vertical top-line" style="top: 150px; height: 30px;"></div>
                    
                    <div class="row justify-content-center mb-4">
                        <div class="col-lg-8">
                            <div class="org-structure-box text-center">
                                <h5>{{ __('District Administrative Secretary') }}</h5>
                                <p>{{ __('Oversees all departmental operations and reports to the District Commissioner') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="org-line org-line-vertical" style="top: 265px; height: 30px;"></div>
                    
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-4">
                            <div class="org-structure-box text-center">
                                <h5>{{ __('Administration') }}</h5>
                                <p>{{ __('Human resources, legal affairs, and general administration') }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="org-structure-box text-center">
                                <h5>{{ __('Finance') }}</h5>
                                <p>{{ __('Budget, accounting, revenue collection, and procurement') }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="org-structure-box text-center">
                                <h5>{{ __('Planning') }}</h5>
                                <p>{{ __('Strategic planning, monitoring, evaluation, and statistics') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-4 mt-2">
                        <div class="col-md-3">
                            <div class="org-structure-box text-center">
                                <h5>{{ __('Education') }}</h5>
                                <p>{{ __('Schools, libraries, and educational programs') }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="org-structure-box text-center">
                                <h5>{{ __('Health') }}</h5>
                                <p>{{ __('Healthcare facilities and public health programs') }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="org-structure-box text-center">
                                <h5>{{ __('Infrastructure') }}</h5>
                                <p>{{ __('Roads, public works, and transportation') }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="org-structure-box text-center">
                                <h5>{{ __('Agriculture') }}</h5>
                                <p>{{ __('Farming, livestock, and extension services') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-4 mt-2">
                        <div class="col-md-4">
                            <div class="org-structure-box text-center">
                                <h5>{{ __('Environment') }}</h5>
                                <p>{{ __('Environmental protection, waste management, and conservation') }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="org-structure-box text-center">
                                <h5>{{ __('Community Development') }}</h5>
                                <p>{{ __('Social welfare, youth programs, and community services') }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="org-structure-box text-center">
                                <h5>{{ __('Water & Sanitation') }}</h5>
                                <p>{{ __('Water supply, sewerage, and sanitation services') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-5">
                        <a href="{{ url('/government/about/organizational-structure') }}" class="btn btn-primary">{{ __('View Detailed Structure') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
@endsection 