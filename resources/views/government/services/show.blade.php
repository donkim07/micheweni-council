@extends('government.layouts.app')

@section('title', $service->name)

@section('styles')
<style>
    .service-header {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8)), 
                    url('/images/government/service-detail-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
    }
    
    .service-icon {
        width: 84px;
        height: 84px;
        object-fit: contain;
        margin-bottom: 20px;
    }
    
    .service-image {
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        max-height: 400px;
        object-fit: cover;
        width: 100%;
    }
    
    .department-badge {
        background-color: rgba(20, 78, 115, 0.1);
        color: var(--primary);
        font-size: 0.85rem;
        padding: 6px 12px;
        border-radius: 50px;
        display: inline-block;
        margin-bottom: 15px;
    }
    
    /* Fix for cards appearing on top of footer */
    .service-details-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        height: 100%;
        position: relative;
        z-index: 1;
        background-color: #fff;
        margin-bottom: 20px;
    }
    
    /* Ensure the main content pushes down the footer */
    main {
        position: relative;
        z-index: 2;
        background-color: #fff;
    }
    
    .container {
        position: relative;
        z-index: 2;
    }
    
    .service-details-header {
        background-color: var(--primary);
        color: white;
        padding: 15px 20px;
    }
    
    .service-section {
        margin-bottom: 40px;
    }
    
    .service-section-title {
        color: var(--primary);
        border-bottom: 2px solid var(--accent);
        padding-bottom: 10px;
        margin-bottom: 20px;
        display: inline-block;
    }
    
    .contact-info-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
    }
    
    .contact-info-icon {
        width: 40px;
        height: 40px;
        background-color: rgba(20, 78, 115, 0.1);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .requirements-list, .process-list {
        padding-left: 20px;
    }
    
    .requirements-list li, .process-list li {
        margin-bottom: 10px;
        position: relative;
        padding-left: 5px;
    }
    
    .process-step {
        display: flex;
        margin-bottom: 20px;
    }
    
    .process-step-number {
        width: 36px;
        height: 36px;
        background-color: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    /* Fix for footer */
    .footer {
        position: relative;
        z-index: 1;
    }
</style>
@endsection

@section('content')
<!-- Service Header -->
<div class="service-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ url('/government') }}" class="text-white">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/government/services') }}" class="text-white">Services</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ $service->name }}</li>
                    </ol>
                </nav>
                
                <h1 class="display-4 fw-bold mb-3">{{ $service->name }}</h1>
                <p class="lead mb-0">{{ $service->short_description }}</p>
                
                @if($service->department)
                <div class="mt-4">
                    <span class="department-badge">
                        <i class="fas fa-building me-1"></i> {{ $service->department->name }}
                    </span>
                </div>
                @endif
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                @if($service->icon)
                    <img src="{{ asset('images/' . $service->icon) }}" class="service-icon" alt="{{ $service->name }} icon">
                @else
                    <div class="service-icon-placeholder mx-auto">
                        <i class="fas fa-cogs fa-4x text-white opacity-75"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row">
        <!-- Main Service Information -->
        <div class="col-lg-8">
            @if($service->featured_image)
            <div class="mb-4">
                <img src="{{ asset('images/' . $service->featured_image) }}" class="service-image" alt="{{ $service->name }}">
            </div>
            @endif
            
            <div class="service-section">
                <h2 class="service-section-title">About this Service</h2>
                <div class="service-description">
                    {!! nl2br(e($service->description)) !!}
                </div>
            </div>
            
            @if($service->requirements)
            <div class="service-section">
                <h2 class="service-section-title">Requirements</h2>
                <div class="card service-details-card">
                    <div class="card-body">
                        <ul class="requirements-list">
                            @foreach(explode("\n", $service->requirements) as $requirement)
                                @if(trim($requirement))
                                    <li>{{ $requirement }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            
            @if($service->process)
            <div class="service-section">
                <h2 class="service-section-title">Service Process</h2>
                <div class="card service-details-card">
                    <div class="card-body">
                        @php
                            $steps = explode("\n", $service->process);
                            $stepNumber = 1;
                        @endphp
                        
                        @foreach($steps as $step)
                            @if(trim($step))
                                <div class="process-step">
                                    <div class="process-step-number">{{ $stepNumber }}</div>
                                    <div class="process-step-content">
                                        {{ $step }}
                                    </div>
                                </div>
                                @php $stepNumber++; @endphp
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Contact Information -->
            <div class="card service-details-card mb-4">
                <div class="service-details-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Service Information</h5>
                </div>
                <div class="card-body">
                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <strong>Location:</strong><br>
                            {{ $service->location ?? 'Micheweni District Council Office' }}
                        </div>
                    </div>
                    
                    @if($service->contact_person)
                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <strong>Contact Person:</strong><br>
                            {{ $service->contact_person }}
                        </div>
                    </div>
                    @endif
                    
                    @if($service->contact_email)
                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <strong>Email:</strong><br>
                            <a href="mailto:{{ $service->contact_email }}">{{ $service->contact_email }}</a>
                        </div>
                    </div>
                    @endif
                    
                    @if($service->contact_phone)
                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <strong>Phone:</strong><br>
                            <a href="tel:{{ $service->contact_phone }}">{{ $service->contact_phone }}</a>
                        </div>
                    </div>
                    @endif
                    
                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <strong>Working Hours:</strong><br>
                            Monday - Friday: 8:00 AM - 3:30 PM
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Services -->
            @if(isset($relatedServices) && $relatedServices->count() > 0)
            <div class="card service-details-card mb-4">
                <div class="service-details-header">
                    <h5 class="mb-0"><i class="fas fa-link me-2"></i> Related Services</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($relatedServices as $relatedService)
                        <li class="list-group-item">
                            <a href="{{ route('government.services.show', $relatedService->id) }}" class="text-decoration-none">
                                {{ $relatedService->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            
            <!-- Department Information -->
            <!-- @if($service->department)
            <div class="card service-details-card">
                <div class="service-details-header">
                    <h5 class="mb-0"><i class="fas fa-building me-2"></i> Providing Department</h5>
                </div>
                <div class="card-body">
                    <h5>{{ $service->department->name }}</h5>
                    <p>{{ $service->department->description ?? 'The department responsible for providing this service.' }}</p>
                    <a href="{{ url('/government/departments/' . $service->department->id) }}" class="btn btn-outline-primary">
                        Visit Department <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            @endif -->
        </div>
    </div>
    
    <!-- Call to Action -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card bg-light border-0">
                <div class="card-body p-4 text-center">
                    <h3 class="mb-3">Need more information?</h3>
                    <p class="mb-4">Contact our service desk for any inquiries or assistance regarding this service.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ url('/government/contact') }}" class="btn btn-primary">
                            <i class="fas fa-envelope me-2"></i> Contact Us
                        </a>
                        <a href="{{ url('/government/services') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i> Back to Services
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 