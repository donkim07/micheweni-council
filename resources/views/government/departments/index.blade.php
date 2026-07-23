@extends('government.layouts.app')

@section('title', __('Departments'))

@section('styles')
<style>
    .page-hero {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8)), url('/images/government/departments-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
    }
    
    .department-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        height: 100%;
        transition: transform 0.3s ease;
        border: none;
    }
    
    .department-card:hover {
        transform: translateY(-5px);
    }
    
    .department-card .card-img-top {
        height: 180px;
        object-fit: cover;
    }
    
    .department-card .card-body {
        padding: 1.5rem;
    }
    
    .department-title {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 10px;
    }
    
    .department-desc {
        color: var(--dark);
        margin-bottom: 15px;
    }
    
    .department-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        color: var(--gray);
        margin-bottom: 15px;
    }
    
    .department-meta div {
        display: flex;
        align-items: center;
    }
    
    .department-meta i {
        margin-right: 5px;
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
                        <li class="breadcrumb-item active text-white" aria-current="page">Departments</li>
                    </ol>
                </nav>
                
                <h1 class="display-4 fw-bold mb-3">Our Departments</h1>
                <p class="lead mb-4">Meet the specialized teams that make our district government function efficiently, each dedicated to specific aspects of public service.</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto">
            <h2 class="section-title text-center mb-4">Departments at Micheweni District Council</h2>
            <p class="text-center mb-5">
                Our departments work together to ensure that all aspects of governance and service delivery in Micheweni District are handled effectively and efficiently.
                Each department focuses on specific sectors and services, with dedicated staff and specialized expertise.
            </p>
        </div>
    </div>
    
    <!-- Departments Grid -->
    <div class="row g-4">
        @if(count($departments) > 0)
            @foreach($departments as $department)
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 % 300 }}">
                    <div class="card department-card">
                        @php
                            $imagePath = null;
                            if ($department->featured_image) {
                                // Check if the image path already contains 'departments/'
                                if (strpos($department->featured_image, 'departments/') !== false) {
                                    $imagePath = 'images/' . $department->featured_image;
                                } else {
                                    $imagePath = 'images/departments/' . $department->featured_image;
                                }
                            }
                            $defaultImage = 'images/government/departments/default-dept.jpg';
                        @endphp
                        
                        <img src="{{ $imagePath ? asset($imagePath) : asset($defaultImage) }}" 
                             class="card-img-top" 
                             alt="{{ $department->name }}" 
                             onerror="this.onerror=null; this.src='{{ asset($defaultImage) }}'">
                        
                        <div class="card-body">
                            <h3 class="department-title">{{ $department->name }}</h3>
                            <div class="mb-2">
                                <span class="badge bg-light text-primary">{{ ucfirst($department->category ?? 'Department') }}</span>
                            </div>
                            <div class="department-meta">
                                @if($department->head_name)
                                    <div>
                                        <i class="fas fa-user-tie"></i> {{ $department->head_name }}
                                    </div>
                                @endif
                                @if(isset($department->staff_count))
                                    <div>
                                        <i class="fas fa-users"></i> {{ $department->staff_count }} Staff
                                    </div>
                                @endif
                            </div>
                            <p class="department-desc">
                                {{ Str::limit($department->description, 120) }}
                            </p>
                            <a href="{{ url('/government/departments/' . $department->slug) }}" class="btn btn-primary">
                                <i class="fas fa-info-circle me-2"></i> Learn More
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No departments found at this time.
                </div>
            </div>
        @endif
    </div>
    
    <!-- Contact Section -->
    <div class="row mt-5">
        <div class="col-lg-8 mx-auto text-center">
            <h3 class="mb-4">Need More Information?</h3>
            <p>
                If you have specific questions about any of our departments or the services they provide, please don't hesitate to contact us.
                Our staff are ready to assist you and provide the information you need.
            </p>
            <a href="{{ url('/government/contact') }}" class="btn btn-primary mt-3">
                <i class="fas fa-envelope me-2"></i> Contact Us
            </a>
        </div>
    </div>
</div>
@endsection 