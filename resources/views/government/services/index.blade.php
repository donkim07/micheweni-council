@extends('government.layouts.app')

@section('title', __('Government Services'))

@section('styles')
<style>
    .service-card {
        height: 100%;
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .service-icon {
        width: 64px;
        height: 64px;
        margin-bottom: 15px;
        object-fit: contain;
    }
    
    .service-card .card-img-top {
        height: 180px;
        object-fit: cover;
    }
    
    .service-title {
        color: var(--primary);
        font-weight: 600;
    }
    
    .service-description {
        color: #666;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .page-hero {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8)), url('/images/government/services-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
    }
    
    .filters {
        background-color: var(--light);
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
    }
    
    .service-badge {
        background-color: rgba(20, 78, 115, 0.1);
        color: var(--primary);
        font-size: 0.8rem;
        padding: 5px 10px;
        border-radius: 50px;
    }
    
    .featured-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: var(--accent);
        color: var(--dark);
        font-size: 0.7rem;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 50px;
        z-index: 1;
    }
</style>
@endsection

@section('content')
<!-- Page Hero -->
<div class="page-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Government Services</h1>
                <p class="lead mb-4">Access a wide range of services provided by the Micheweni District Council to support our citizens and businesses.</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <!-- Services Filters -->
    <div class="filters">
        <form action="{{ url('/government/services') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="department" class="form-label">Department</label>
                    <select class="form-select" name="department" id="department">
                        <option value="">All Departments</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" name="search" id="search" placeholder="Search services..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Featured Services - Only show when no filters are applied -->
    @if(isset($featuredServices) && $featuredServices->count() > 0 && !request('department') && !request('search'))
    <div class="mb-5">
        <h2 class="section-title mb-4">Featured Services</h2>
        <div class="row g-4">
            @foreach($featuredServices as $service)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card service-card h-100">
                    <span class="featured-badge">
                        <i class="fas fa-star me-1"></i> Featured
                    </span>
                    @if($service->featured_image)
                        <img src="{{ asset('images/' . $service->featured_image) }}" class="card-img-top" alt="{{ $service->title }}">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                            <i class="fas fa-hands-helping fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            @if($service->icon)
                                <div class="service-icon d-flex align-items-center justify-content-center bg-light rounded-circle me-3">
                                    <i class="fas {{ $service->icon }} fa-2x text-primary"></i>
                                </div>
                            @else
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
                                    
                                    $deptSlug = $service->department ? strtolower(str_replace(' ', '-', $service->department->slug)) : '';
                                    $icon = 'fa-cogs'; // Default fallback
                                    
                                    // Try to match department name with default icons
                                    foreach($defaultIcons as $key => $value) {
                                        if(strpos($deptSlug, $key) !== false) {
                                            $icon = $value;
                                            break;
                                        }
                                    }
                                @endphp
                                <div class="service-icon d-flex align-items-center justify-content-center bg-light rounded-circle me-3">
                                    <i class="fas {{ $icon }} fa-2x text-primary"></i>
                                </div>
                            @endif
                            <h5 class="card-title service-title mb-0">{{ $service->title }}</h5>
                        </div>
                        
                        @if($service->department)
                            <span class="service-badge mb-2 d-inline-block">
                                <i class="fas fa-building me-1"></i> {{ $service->department->name }}
                            </span>
                        @endif
                        
                        <p class="card-text service-description">{{ $service->short_description ?? Str::limit($service->description, 150) }}</p>
                        <a href="{{ url('government/services/' . $service->id) }}" class="btn btn-outline-primary mt-2">
                            Learn More <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- All Services -->
    <h2 class="section-title mb-4">All Services</h2>
    
    @if($services->count() > 0)
        <div class="row g-4">
            @foreach($services as $service)
            <div class="col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card service-card h-100">
                    @if($service->is_featured)
                        <span class="featured-badge">
                            <i class="fas fa-star me-1"></i> Featured
                        </span>
                    @endif
                    
                    <div class="card-body text-center">
                        @if($service->icon)
                            <div class="service-icon d-flex align-items-center justify-content-center bg-light rounded-circle mx-auto mb-3">
                                <i class="fas {{ $service->icon }} fa-2x text-primary"></i>
                            </div>
                        @else
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
                                
                                $deptSlug = $service->department ? strtolower(str_replace(' ', '-', $service->department->slug)) : '';
                                $icon = 'fa-cogs'; // Default fallback
                                
                                // Try to match department name with default icons
                                foreach($defaultIcons as $key => $value) {
                                    if(strpos($deptSlug, $key) !== false) {
                                        $icon = $value;
                                        break;
                                    }
                                }
                            @endphp
                            <div class="service-icon d-flex align-items-center justify-content-center bg-light rounded-circle mx-auto mb-3">
                                <i class="fas {{ $icon }} fa-2x text-primary"></i>
                            </div>
                        @endif
                        
                        <h5 class="card-title service-title">{{ $service->title }}</h5>
                        
                        @if($service->department)
                            <span class="service-badge mb-2 d-inline-block">
                                {{ $service->department->name }}
                            </span>
                        @endif
                        
                        <p class="card-text service-description">{{ $service->short_description ?? Str::limit($service->description, 100) }}</p>
                        <a href="{{ route('government.services.show', $service->id) }}" class="btn btn-sm btn-outline-primary mt-2">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="d-flex justify-content-center mt-5">
            {{ $services->links() }}
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle me-2"></i> No services found matching your criteria. Please try a different search or browse all available services.
        </div>
    @endif

    <!-- Service Categories -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 bg-light">
                <div class="card-body p-4">
                    <h3 class="mb-4">Browse Services by Category</h3>
                    <div class="row g-3">
                        @if(isset($servicesByCategory) && $servicesByCategory->count() > 0)
                            @foreach($servicesByCategory as $department)
                                <div class="col-md-3">
                                    <a href="{{ url('government/services?department=' . $department->id) }}" class="btn btn-outline-primary w-100 text-start">
                                        <i class="fas fa-folder me-2"></i> {{ $department->name }}
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <p class="text-muted">No service categories available.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto submit form when department filter changes
        document.getElementById('department').addEventListener('change', function() {
            this.form.submit();
        });
    });
</script>
@endsection 