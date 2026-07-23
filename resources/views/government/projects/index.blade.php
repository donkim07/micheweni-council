@extends('government.layouts.app')

@section('title', __('Projects'))

@section('styles')
<style>
    .project-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 8px;
        overflow: hidden;
        height: 100%;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .project-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .project-card .card-img-top {
        height: 200px;
        object-fit: cover;
    }
    
    .project-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 1;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-completed {
        background-color: #27ae60;
        color: white;
    }
    
    .badge-ongoing {
        background-color: #3498db;
        color: white;
    }
    
    .badge-planned {
        background-color: #f39c12;
        color: white;
    }
    
    .page-hero {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8)), url('/images/government/projects-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
    }
    
    .category-filter {
        background-color: var(--light);
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
    }
    
    .project-category {
        background-color: rgba(20, 78, 115, 0.1);
        color: var(--primary);
        font-size: 0.8rem;
        padding: 5px 10px;
        border-radius: 50px;
        display: inline-block;
        margin-bottom: 10px;
    }
    
    .project-meta {
        display: flex;
        align-items: center;
        color: #666;
        font-size: 0.85rem;
        margin-bottom: 5px;
    }
    
    .project-meta i {
        margin-right: 5px;
        color: var(--primary);
    }
    
    .project-meta span {
        margin-right: 15px;
    }
    
    .progress-wrapper {
        background-color: #f5f5f5;
        border-radius: 10px;
        height: 8px;
        overflow: hidden;
        margin-top: 15px;
    }
    
    .progress-bar {
        height: 100%;
        border-radius: 10px;
    }
    
    .project-title {
        color: var(--primary);
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<!-- Page Hero -->
<div class="page-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Government Projects</h1>
                <p class="lead mb-4">Discover the development projects undertaken by the Micheweni District Council to improve our community and infrastructure.</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <!-- Category Filter -->
    <div class="category-filter">
        <form action="{{ url('/government/projects') }}" method="GET" id="project-filter-form">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="category" class="form-label">Project Category</label>
                    <select class="form-select auto-submit" name="category" id="category">
                        <option value="">All Categories</option>
                        @php
                            $categories = $categories ?? \App\Models\Government\ProjectCategory::all();
                        @endphp
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select auto-submit" name="status" id="status">
                        <option value="">All Statuses</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="planned" {{ request('status') == 'planned' ? 'selected' : '' }}>Planned</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" name="search" id="search" placeholder="Search projects..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Projects List -->
    @if($projects->count() > 0)
        <div class="row g-4">
            @foreach($projects as $project)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card project-card h-100">
                    @if($project->status)
                        <span class="project-badge badge-{{ $project->status }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    @endif
                    
                    @if($project->featured_image)
                        <img src="{{ asset('images/' . $project->featured_image) }}" class="card-img-top" alt="{{ $project->title }}">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-project-diagram fa-3x text-muted"></i>
                        </div>
                    @endif
                    
                    <div class="card-body">
                        @if($project->category)
                            <div class="project-category">
                                <i class="fas fa-tag me-1"></i> {{ $project->category->name }}
                            </div>
                        @endif
                        
                        <h5 class="card-title project-title">{{ $project->title }}</h5>
                        
                        <div class="project-meta">
                            @if($project->start_date)
                                <span><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($project->start_date)->format('M Y') }}</span>
                            @endif
                            
                            @if($project->budget)
                                <span><i class="fas fa-coins"></i> {{ number_format($project->budget) }} TZS</span>
                            @endif
                        </div>
                        
                        <p class="card-text mt-2">{{ Str::limit($project->description, 100) }}</p>
                        
                        @if($project->status == 'ongoing' && $project->completion_percentage)
                            <div class="progress-wrapper">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $project->completion_percentage }}%" aria-valuenow="{{ $project->completion_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="text-end mt-1">
                                <small>{{ $project->completion_percentage }}% Complete</small>
                            </div>
                        @endif
                        
                        <a href="{{ route('government.projects.show', $project->id) }}" class="btn btn-outline-primary mt-3">
                            View Details <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="d-flex justify-content-center mt-5">
            {{ $projects->links() }}
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle me-2"></i> No projects found matching your criteria. Please try a different search or browse all available projects.
        </div>
    @endif

    <!-- Project Categories -->
    <div class="row mt-5 g-4">
        <div class="col-12">
            <h2 class="section-title mb-4">Browse Projects by Category</h2>
        </div>
        
        @foreach($categories as $category)
        <div class="col-md-4 col-lg-3" data-aos="fade-up">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas {{ $category->icon ?? 'fa-folder' }} fa-3x text-primary"></i>
                    </div>
                    <h5>{{ $category->name }}</h5>
                    <p class="text-muted">{{ $category->projects_count ?? 0 }} Projects</p>
                    <a href="{{ url('government/projects?category=' . $category->id) }}" class="btn btn-sm btn-outline-primary">
                        View Projects
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Project Statistics -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 bg-light">
                <div class="card-body p-4">
                    <h3 class="mb-4">Project Statistics</h3>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <i class="fas fa-check-circle fa-3x text-success"></i>
                            </div>
                            <h4>{{ $completedCount ?? 0 }}</h4>
                            <p class="text-muted">Completed Projects</p>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <i class="fas fa-cogs fa-3x text-primary"></i>
                            </div>
                            <h4>{{ $ongoingCount ?? 0 }}</h4>
                            <p class="text-muted">Ongoing Projects</p>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <i class="fas fa-calendar fa-3x text-warning"></i>
                            </div>
                            <h4>{{ $plannedCount ?? 0 }}</h4>
                            <p class="text-muted">Planned Projects</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-submit form when select changes
    document.addEventListener('DOMContentLoaded', function() {
        const autoSubmitElements = document.querySelectorAll('.auto-submit');
        autoSubmitElements.forEach(function(element) {
            element.addEventListener('change', function() {
                document.getElementById('project-filter-form').submit();
            });
        });
    });
</script>
@endsection 