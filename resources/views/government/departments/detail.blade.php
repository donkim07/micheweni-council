@extends('government.layouts.app')

@section('title', __('Department Detail'))

@section('styles')
<style>
    .page-hero {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8)), url('/images/government/department-detail-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
    }
    
    .department-leader {
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .leader-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        margin-bottom: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .leader-info {
        text-align: center;
    }
    
    .leader-name {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 5px;
    }
    
    .leader-position {
        color: var(--primary);
        font-weight: 500;
        margin-bottom: 10px;
    }
    
    .leader-contact {
        font-size: 0.9rem;
        color: var(--gray);
    }
    
    .department-stat {
        padding: 20px;
        border-radius: 8px;
        background-color: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        text-align: center;
        transition: transform 0.3s ease;
        height: 100%;
    }
    
    .department-stat:hover {
        transform: translateY(-5px);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: rgba(20, 78, 115, 0.1);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 15px;
    }
    
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 5px;
    }
    
    .stat-label {
        color: var(--dark);
        font-weight: 500;
    }
    
    .service-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
        border: none;
        height: 100%;
    }
    
    .service-card:hover {
        transform: translateY(-5px);
    }
    
    .service-card .card-body {
        padding: 1.5rem;
    }
    
    .service-title {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 10px;
    }
    
    .service-desc {
        color: var(--dark);
        margin-bottom: 15px;
    }
    
    .project-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
        border: none;
        height: 100%;
    }
    
    .project-card:hover {
        transform: translateY(-5px);
    }
    
    .project-card .card-img-top {
        height: 180px;
        object-fit: cover;
    }
    
    .project-card .card-body {
        padding: 1.5rem;
    }
    
    .project-title {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 10px;
    }
    
    .project-desc {
        color: var(--dark);
        margin-bottom: 15px;
    }
    
    .project-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        color: var(--gray);
        margin-bottom: 15px;
    }
    
    .project-meta div {
        display: flex;
        align-items: center;
    }
    
    .project-meta i {
        margin-right: 5px;
    }
    
    .status-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .status-badge.ongoing {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
    }
    
    .status-badge.completed {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }
    
    .status-badge.planned {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
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
                        <li class="breadcrumb-item"><a href="{{ url('/government/departments') }}" class="text-white">Departments</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ $department->name ?? 'Department Details' }}</li>
                    </ol>
                </nav>
                
                <h1 class="display-4 fw-bold mb-3">{{ $department->name ?? 'Works Department' }}</h1>
                <div class="mb-2">
                    <span class="badge bg-light text-primary">{{ ucfirst($department->category ?? 'Department') }}</span>
                </div>
                <p class="lead mb-4">{{ $department->description ?? 'Building and maintaining the infrastructure that supports our community.' }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <!-- Department Overview -->
    <div class="row mb-5">
        <div class="col-lg-8">
            <h2 class="section-title mb-4">Department Overview</h2>
            @if($department->detail && $department->detail->overview)
                {!! $department->detail->overview !!}
            @else
                <p>
                    The {{ $department->name }} is responsible for the planning, design, construction, and maintenance of public infrastructure in Micheweni District. 
                    This includes roads, bridges, government buildings, drainage systems, and waste management facilities. The department ensures that 
                    infrastructure development meets quality standards, serves community needs, and contributes to the overall development of the district.
                </p>
                <p>
                    Our team consists of engineers, technicians, project managers, and support staff who work together to deliver high-quality infrastructure 
                    projects and services. We collaborate closely with other departments, community stakeholders, and development partners to ensure that 
                    infrastructure development is aligned with the district's strategic goals and priorities.
                </p>
            @endif
            
            <h3 class="h5 mt-4 mb-3">Key Responsibilities:</h3>
            @if($department->detail && $department->detail->responsibilities)
                {!! $department->detail->responsibilities !!}
            @else
                <ul class="mb-4">
                    <li>Design and construction of roads, bridges, and drainage systems</li>
                    <li>Maintenance and repair of government buildings and facilities</li>
                    <li>Implementation of waste management infrastructure</li>
                    <li>Technical supervision of construction projects</li>
                    <li>Development of infrastructure maintenance plans and schedules</li>
                    <li>Provision of technical advice on infrastructure projects</li>
                    <li>Coordination with contractors and service providers</li>
                    <li>Ensuring compliance with construction standards and regulations</li>
                </ul>
            @endif
        </div>
        <div class="col-lg-4">
            <div class="department-leader p-4 bg-light rounded shadow-sm">
                <div class="leader-info">
                    @if($department->head_image)
                        <img src="{{ asset('images/' . $department->head_image) }}" alt="{{ $department->head_name }}" class="leader-image">
                    @else
                        <img src="/images/government/avatar-placeholder.jpg" alt="Department Head" class="leader-image">
                    @endif
                    <h3 class="leader-name" translate="no">{{ $department->head_name ?? 'Department Head' }}</h3>
                    <p class="leader-position">{{ $department->head_title ?? 'Head of Department' }}</p>
                    <div class="leader-contact">
                        @if($department->contact_email)
                            <p><i class="fas fa-envelope me-2"></i> {{ $department->contact_email }}</p>
                        @endif
                        @if($department->contact_phone)
                            <p><i class="fas fa-phone me-2"></i> {{ $department->contact_phone }}</p>
                        @endif
                        @if(!$department->contact_email && !$department->contact_phone)
                            <p><i class="fas fa-envelope me-2"></i> contact@micheweni.go.tz</p>
                            <p><i class="fas fa-phone me-2"></i> +255 777 123 456</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Department Statistics -->
    <div class="row mb-5 g-4">
        <div class="col-12">
            <h2 class="section-title text-center mb-4">Department Statistics</h2>
        </div>
        
        @php
            $statisticsItems = [];
            
            // Add custom statistics from the database
            if($department->detail && $department->detail->statistics && count($department->detail->statistics) > 0) {
                $statisticsItems = $department->detail->statistics;
            }
            
            // Add services count if enabled
            if($department->detail && $department->detail->include_services_count) {
                $servicesCount = $services->count();
                $statisticsItems[] = [
                    'label' => 'Services Offered',
                    'value' => $servicesCount,
                    'icon' => 'fa-hands-helping'
                ];
            }
            
            // Add projects count if enabled
            if($department->detail && $department->detail->include_projects_count) {
                $projectsCount = $projects->count();
                $statisticsItems[] = [
                    'label' => 'Active Projects',
                    'value' => $projectsCount,
                    'icon' => 'fa-project-diagram'
                ];
            }
        @endphp
        
        @if(count($statisticsItems) > 0)
            @foreach($statisticsItems as $index => $stat)
                <div class="col-md-4" data-aos="fade-up" @if($index > 0) data-aos-delay="{{ ($index % 3) * 100 }}" @endif>
                    <div class="department-stat">
                        <div class="stat-icon">
                            <i class="fas {{ $stat['icon'] ?? 'fa-chart-bar' }}"></i>
                        </div>
                        <div class="stat-value">{{ $stat['value'] }}</div>
                        <div class="stat-label">{{ $stat['label'] }}</div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-4" data-aos="fade-up">
                <div class="department-stat">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-value">18</div>
                    <div class="stat-label">Staff Members</div>
                </div>
            </div>
            
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="department-stat">
                    <div class="stat-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <div class="stat-value">12</div>
                    <div class="stat-label">Active Projects</div>
                </div>
            </div>
            
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="department-stat">
                    <div class="stat-icon">
                        <i class="fas fa-road"></i>
                    </div>
                    <div class="stat-value">65</div>
                    <div class="stat-label">Km Roads Maintained</div>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Services Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="section-title text-center mb-4">Services Provided</h2>
            <p class="text-center mb-5">
                The {{ $department->name }} offers a range of services to support the community in Micheweni District.
            </p>
        </div>
        
        @if($services && $services->count() > 0)
            @foreach($services as $service)
                <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" @if(!$loop->first) data-aos-delay="{{ ($loop->index % 3) * 100 }}" @endif>
                    <div class="card service-card">
                        @if($service->featured_image)
                            <img src="{{ asset('images/' . $service->featured_image) }}" class="card-img-top" alt="{{ $service->title }}">
                        @endif
                        <div class="card-body">
                            <h3 class="service-title">{{ $service->title }}</h3>
                            <p class="service-desc">
                                {{ $service->short_description ?? Str::limit(strip_tags($service->description), 150) }}
                            </p>
                            <a href="{{ url('/government/services/' . $service->id) }}" class="btn btn-outline-primary">
                                <i class="fas fa-info-circle me-2"></i> More Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No services are currently listed for this department.
                </div>
            </div>
        @endif
    </div>
    
    <!-- Projects Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title mb-0">Current Projects</h2>
                <a href="{{ url('/government/projects?department=' . $department->id) }}" class="btn btn-outline-primary">
                    <i class="fas fa-th-list me-2"></i> View All Projects
                </a>
            </div>
        </div>
        
        @if($projects && $projects->count() > 0)
            @foreach($projects as $project)
                <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" @if(!$loop->first) data-aos-delay="{{ ($loop->index % 3) * 100 }}" @endif>
                    <div class="card project-card">
                        <span class="status-badge {{ $project->status }}">{{ ucfirst($project->status) }}</span>
                        @if($project->featured_image)
                            <img src="{{ asset('images/' . $project->featured_image) }}" class="card-img-top" alt="{{ $project->title }}">
                        @else
                            <img src="/images/government/projects/default-project.jpg" class="card-img-top" alt="{{ $project->title }}">
                        @endif
                        <div class="card-body">
                            <h3 class="project-title">{{ $project->title }}</h3>
                            <div class="project-meta">
                                <div>
                                    <i class="fas fa-calendar"></i> {{ $project->start_date ? date('Y', strtotime($project->start_date)) : '' }}{{ $project->end_date ? '-' . date('Y', strtotime($project->end_date)) : '' }}
                                </div>
                                <div>
                                    @if($project->budget)
                                        <i class="fas fa-dollar-sign"></i> {{ $project->budget }}
                                    @endif
                                </div>
                            </div>
                            <div class="progress mb-3" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $project->completion_percentage ?? 0 }}%;" aria-valuenow="{{ $project->completion_percentage ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="project-desc">{{ Str::limit(strip_tags($project->description), 100) }}</p>
                            <a href="{{ url('/government/projects/' . $project->id) }}" class="btn btn-outline-primary">
                                <i class="fas fa-info-circle me-2"></i> Project Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No projects are currently listed for this department.
                </div>
            </div>
        @endif
    </div>
    
    <!-- Contact Section -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="section-title text-center mb-4">Contact the Works Department</h2>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <h3 class="h5 fw-bold text-primary">Office Location</h3>
                            <p class="mb-0">
                                Works Department<br>
                                2nd Floor, Micheweni District Council Building<br>
                                Micheweni Town, Pemba Island<br>
                                Tanzania
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h3 class="h5 fw-bold text-primary">Contact Information</h3>
                            <p class="mb-0">
                                Phone: +255 24 245 3289<br>
                                Email: works@micheweni.go.tz<br>
                                Office Hours: Monday-Friday, 8:00 AM - 3:30 PM
                            </p>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ url('/government/contact') }}" class="btn btn-primary">
                            <i class="fas fa-envelope me-2"></i> Send a Message
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 