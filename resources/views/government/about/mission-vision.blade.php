@extends('government.layouts.app')

@section('title', __('Mission & Vision'))

@section('styles')
<style>
    .page-hero {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8)), url('/images/government/mission-vision-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
    }
    
    .mission-vision-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        height: 100%;
        transition: transform 0.3s ease;
        border: none;
    }
    
    .mission-vision-card:hover {
        transform: translateY(-5px);
    }
    
    .mission-vision-card .card-header {
        padding: 20px;
        border-bottom: none;
    }
    
    .mission-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        background-color: rgba(20, 78, 115, 0.1);
        color: var(--primary);
        font-size: 2rem;
    }
    
    .mission-vision-card .card-body {
        padding: 30px;
    }
    
    .mission-vision-title {
        text-align: center;
        margin-bottom: 20px;
        color: var(--primary);
        font-weight: 700;
    }
    
    .mission-vision-text {
        text-align: center;
        font-size: 1.1rem;
        line-height: 1.7;
    }
    
    .value-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }
    
    .value-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .value-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        color: var(--primary);
        font-size: 1.8rem;
    }
    
    .value-title {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 10px;
    }
    
    .objectives-list {
        padding-left: 0;
        list-style: none;
    }
    
    .objectives-list li {
        position: relative;
        padding-left: 30px;
        margin-bottom: 15px;
    }
    
    .objectives-list li:before {
        content: "\f058";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        left: 0;
        top: 2px;
        color: var(--primary);
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
                        <li class="breadcrumb-item active text-white" aria-current="page">Mission & Vision</li>
                    </ol>
                </nav>
                
                <h1 class="display-4 fw-bold mb-3">Our Mission & Vision</h1>
                <p class="lead mb-4">Guiding principles that drive our commitment to serving the people of Micheweni District and building a sustainable future.</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <!-- Mission & Vision Section -->
    <div class="row g-4 mb-5">
        <div class="col-lg-6" data-aos="fade-up">
            <div class="card mission-vision-card">
                <div class="card-header bg-white">
                    <div class="mission-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h2 class="mission-vision-title">Our Mission</h2>
                </div>
                <div class="card-body">
                    <p class="mission-vision-text">
                        {!! \App\Models\Government\SiteConfig::getConfig('mission_statement', 'To ensure that the community in our area of jurisdiction receives quality social services and economic development activities are fostered to ensure sustainable development. We are committed to providing high-quality services and sustainable infrastructure that improves the quality of life for all residents while preserving our cultural heritage and natural environment for future generations.') !!}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="card mission-vision-card">
                <div class="card-header bg-white">
                    <div class="mission-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h2 class="mission-vision-title">Our Vision</h2>
                </div>
                <div class="card-body">
                    <p class="mission-vision-text">
                        {!! \App\Models\Government\SiteConfig::getConfig('vision_statement', __('To become a model district government that is inclusive, transparent, and innovative in its approach to governance, fostering economic growth, social well-being, and environmental sustainability for all community members.')) !!}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Council Mandate Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm" data-aos="fade-up">
                <div class="card-body p-4">
                    <h3 class="text-center text-primary mb-4">Council Mandate</h3>
                    <p class="lead text-center">
                        Micheweni District Council was established under Local Government Act No. 7 of 2014 with the following key mandates:
                    </p>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-success fa-2x me-3"></i>
                                </div>
                                <div>
                                    <h5>Quality Social Services</h5>
                                    <p>Ensure community access to high-quality social services</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-success fa-2x me-3"></i>
                                </div>
                                <div>
                                    <h5>Economic Development</h5>
                                    <p>Foster sustainable economic development activities</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-success fa-2x me-3"></i>
                                </div>
                                <div>
                                    <h5>Peace & Security</h5>
                                    <p>Ensure peace and security in the area</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Core Values Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="section-title text-center mb-5">Our Core Values</h2>
        </div>
        
        @php
            $coreValues = \App\Models\Government\SiteConfig::getConfig('core_values', [], true);
        @endphp
        
        @if(count($coreValues) > 0)
            @foreach($coreValues as $index => $value)
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 % 300 }}">
                    <div class="card value-card">
                        <div class="card-body">
                            <div class="value-icon">
                                <i class="fas {{ $value['icon'] ?? 'fa-star' }}"></i>
                            </div>
                            <h3 class="value-title">{{ $value['title'] }}</h3>
                            <p>{{ $value['description'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-4 mb-4" data-aos="fade-up">
                <div class="card value-card">
                    <div class="card-body">
                        <div class="value-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3 class="value-title">Integrity</h3>
                        <p>
                            We are committed to honesty, transparency, and ethical conduct in all our interactions with the public and among our staff.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card value-card">
                    <div class="card-body">
                        <div class="value-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="value-title">Inclusivity</h3>
                    <p>
                        We value diversity and ensure that all residents have equal access to services and opportunities, regardless of background or circumstances.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card value-card">
                <div class="card-body">
                    <div class="value-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3 class="value-title">Innovation</h3>
                    <p>
                        We continuously seek new and better ways to deliver services, solve problems, and create value for our community.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card value-card">
                <div class="card-body">
                    <div class="value-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3 class="value-title">Sustainability</h3>
                    <p>
                        We are committed to environmental stewardship and sustainable development practices that protect our natural resources for future generations.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="400">
            <div class="card value-card">
                <div class="card-body">
                    <div class="value-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3 class="value-title">Service Excellence</h3>
                    <p>
                        We strive to provide the highest quality services that meet or exceed the expectations of our community members.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="500">
            <div class="card value-card">
                <div class="card-body">
                    <div class="value-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <h3 class="value-title">Accountability</h3>
                    <p>
                        We take responsibility for our actions, decisions, and the effective use of public resources entrusted to us.
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <!-- Strategic Objectives -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="section-title text-center mb-4">Strategic Objectives</h2>
                    <p class="text-center mb-4">
                        To fulfill our mission and work toward our vision, we have established the following strategic objectives for the next five years:
                    </p>
                    
                    <ul class="objectives-list">
                        <li>Improve infrastructure and basic services, including water supply, waste management, roads, and public facilities.</li>
                        <li>Promote sustainable economic development and create opportunities for local businesses and entrepreneurs.</li>
                        <li>Enhance healthcare services and facilities to improve the health and well-being of all residents.</li>
                        <li>Strengthen educational institutions and programs to provide quality education for children and lifelong learning opportunities for adults.</li>
                        <li>Implement environmental conservation initiatives and promote sustainable resource management practices.</li>
                        <li>Foster community engagement and participation in local governance and decision-making processes.</li>
                        <li>Enhance administrative efficiency and effectiveness through technology adoption and staff development.</li>
                        <li>Preserve and promote local culture, heritage, and traditions while embracing positive change and innovation.</li>
                    </ul>
                    
                    <div class="text-center mt-4">
                        <a href="{{ url('/government/departments') }}" class="btn btn-primary">
                            <i class="fas fa-building me-2"></i> Learn About Our Departments
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 