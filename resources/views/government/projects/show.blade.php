@extends('government.layouts.app')

@section('title', $project->title ?? 'Project Details')

@section('styles')
<style>
    .project-header {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8)), 
                    url('/images/government/project-detail-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
    }
    
    .project-featured-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .project-status-badge {
        font-size: 0.85rem;
        padding: 6px 15px;
        border-radius: 50px;
        display: inline-block;
        margin-bottom: 15px;
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
    
    .project-category-badge {
        background-color: rgba(20, 78, 115, 0.1);
        color: var(--primary);
        font-size: 0.85rem;
        padding: 6px 15px;
        border-radius: 50px;
        display: inline-block;
        margin-right: 10px;
    }
    
    .project-info-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        height: 100%;
        margin-bottom: 30px;
        position: relative;
        z-index: 1;
        background-color: #fff;
    }
    
    main {
        position: relative;
        z-index: 2;
        background-color: #fff;
    }
    
    .container {
        position: relative;
        z-index: 2;
    }
    
    .footer {
        position: relative;
        z-index: 1;
    }
    
    .project-info-header {
        background-color: var(--primary);
        color: white;
        padding: 15px 20px;
    }
    
    .project-info-item {
        display: flex;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 12px 0;
    }
    
    .project-info-item:last-child {
        border-bottom: none;
    }
    
    .project-info-label {
        width: 140px;
        font-weight: 600;
        color: var(--primary);
    }
    
    .project-info-value {
        flex: 1;
    }
    
    .project-section {
        margin-bottom: 40px;
    }
    
    .project-section-title {
        color: var(--primary);
        border-bottom: 2px solid var(--accent);
        padding-bottom: 10px;
        margin-bottom: 20px;
        display: inline-block;
    }
    
    .timeline {
        position: relative;
        margin-top: 30px;
    }
    
    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        left: 18px;
        height: 100%;
        width: 2px;
        background: var(--primary);
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 30px;
        padding-left: 45px;
    }
    
    .timeline-dot {
        position: absolute;
        left: 10px;
        top: 0;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: var(--primary);
        border: 3px solid white;
        box-shadow: 0 0 0 2px var(--primary);
    }
    
    .timeline-date {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 5px;
    }
    
    .timeline-content {
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    }
    
    .timeline-title {
        color: var(--primary);
        margin-bottom: 10px;
        font-weight: 600;
    }
    
    .progress-wrapper {
        background-color: #f5f5f5;
        border-radius: 10px;
        height: 10px;
        overflow: hidden;
        margin: 15px 0;
    }
    
    .progress-bar {
        height: 100%;
        border-radius: 10px;
    }
    
    .gallery-item {
        margin-bottom: 20px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    }
    
    .gallery-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .gallery-item:hover img {
        transform: scale(1.05);
    }
    
    .project-impact-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
    }
    
    .impact-icon {
        width: 50px;
        height: 50px;
        background-color: rgba(20, 78, 115, 0.1);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-right: 15px;
        flex-shrink: 0;
    }
</style>
@endsection

@section('content')
<!-- Project Header -->
<div class="project-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ url('/government') }}" class="text-white">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/government/projects') }}" class="text-white">Projects</a></li>
                        @if($project->category)
                            <li class="breadcrumb-item"><a href="{{ url('/government/projects?category=' . $project->category->id) }}" class="text-white">{{ $project->category->name }}</a></li>
                        @endif
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ $project->title }}</li>
                    </ol>
                </nav>
                
                <h1 class="display-4 fw-bold mb-3">{{ $project->title }}</h1>
                <p class="lead mb-0">{{ Str::limit($project->short_description ?? $project->description, 150) }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row">
        <!-- Main Project Information -->
        <div class="col-lg-8">
            @if($project->featured_image)
                <img src="{{ asset('images/' . $project->featured_image) }}" class="project-featured-image" alt="{{ $project->title }}">
            @endif
            
            <div class="d-flex flex-wrap align-items-center mb-4">
                @if($project->status)
                    <span class="project-status-badge badge-{{ $project->status }} me-3">
                        <i class="fas fa-circle me-1"></i> {{ ucfirst($project->status) }}
                    </span>
                @endif
                
                @if($project->category)
                    <span class="project-category-badge">
                        <i class="fas fa-tag me-1"></i> {{ $project->category->name }}
                    </span>
                @endif
            </div>
            
            @if($project->status == 'ongoing' && $project->progress)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="mb-3">Project Progress</h5>
                        <div class="progress-wrapper">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $project->progress }}%" aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <small>Started: {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('M d, Y') : 'N/A' }}</small>
                            <small><strong>{{ $project->progress }}% Complete</strong></small>
                            <small>Estimated completion: {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('M d, Y') : 'N/A' }}</small>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="project-section">
                <h2 class="project-section-title">About this Project</h2>
                <div class="project-description">
                    {!! nl2br(e($project->description)) !!}
                </div>
            </div>
            
            @if($project->objectives)
            <div class="project-section">
                <h2 class="project-section-title">Project Objectives</h2>
                <div class="card project-info-card">
                    <div class="card-body">
                        <ul class="mb-0">
                            @foreach(explode("\n", $project->objectives) as $objective)
                                @if(trim($objective))
                                    <li class="mb-2">{{ $objective }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            
            @if(isset($projectGallery) && $projectGallery->count() > 0)
            <div class="project-section">
                <h2 class="project-section-title">Project Gallery</h2>
                <div class="row g-3">
                    @foreach($projectGallery as $galleryItem)
                    <div class="col-md-4">
                        <div class="gallery-item">
                            @if(isset($galleryItem->file_path))
                                <a href="{{ asset('images/' . $galleryItem->file_path) }}" data-lightbox="project-gallery" data-title="{{ $galleryItem->caption ?? $project->title }}">
                                    <img src="{{ asset('images/' . $galleryItem->file_path) }}" alt="{{ $galleryItem->caption ?? $project->title }}">
                                </a>
                            @elseif(isset($galleryItem->image))
                                <a href="{{ asset('images/' . $galleryItem->image) }}" data-lightbox="project-gallery" data-title="{{ $galleryItem->caption ?? $project->title }}">
                                    <img src="{{ asset('images/' . $galleryItem->image) }}" alt="{{ $galleryItem->caption ?? $project->title }}">
                                </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            @if($project->impact)
            <div class="project-section">
                <h2 class="project-section-title">Project Impact</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="card project-info-card">
                            <div class="card-body">
                                <div class="project-impact-item">
                                    <div class="impact-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div>
                                        <h5>Community Impact</h5>
                                        <p>{!! nl2br(e($project->impact)) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Project Sidebar -->
        <div class="col-lg-4">
            <!-- Project Information -->
            <div class="card project-info-card mb-4">
                <div class="project-info-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Project Information</h5>
                </div>
                <div class="card-body">
                    <div class="project-info-item">
                        <div class="project-info-label">Status</div>
                        <div class="project-info-value">{{ ucfirst($project->status ?? 'N/A') }}</div>
                    </div>
                    
                    <div class="project-info-item">
                        <div class="project-info-label">Start Date</div>
                        <div class="project-info-value">{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('M d, Y') : 'N/A' }}</div>
                    </div>
                    
                    <div class="project-info-item">
                        <div class="project-info-label">End Date</div>
                        <div class="project-info-value">{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('M d, Y') : 'N/A' }}</div>
                    </div>
                    
                    <div class="project-info-item">
                        <div class="project-info-label">Budget</div>
                        <div class="project-info-value">{{ $project->budget ? number_format($project->budget) . ' TZS' : 'N/A' }}</div>
                    </div>
                    
                    <div class="project-info-item">
                        <div class="project-info-label">Location</div>
                        <div class="project-info-value">{{ $project->location ?? 'N/A' }}</div>
                    </div>
                    
                    <div class="project-info-item">
                        <div class="project-info-label">Priority</div>
                        <div class="project-info-value">
                            @if($project->priority == 'high')
                                <span class="text-danger">High</span>
                            @elseif($project->priority == 'medium')
                                <span class="text-warning">Medium</span>
                            @elseif($project->priority == 'low')
                                <span class="text-success">Low</span>
                            @else
                                <span>N/A</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($project->funding_source)
                    <div class="project-info-item">
                        <div class="project-info-label">Funding Source</div>
                        <div class="project-info-value">{{ $project->funding_source }}</div>
                    </div>
                    @endif
                    
                    @if($project->partners)
                    <div class="project-info-item">
                        <div class="project-info-label">Partners</div>
                        <div class="project-info-value">{{ $project->partners }}</div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Project Timeline -->
            @if($project->timeline)
            <div class="card project-info-card mb-4">
                <div class="project-info-header">
                    <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i> Project Timeline</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach(explode("\n", $project->timeline) as $timelineEntry)
                            @if(trim($timelineEntry))
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        @php
                                            $parts = explode(':', $timelineEntry, 2);
                                            $title = isset($parts[0]) ? trim($parts[0]) : '';
                                            $content = isset($parts[1]) ? trim($parts[1]) : $timelineEntry;
                                        @endphp
                                        
                                        @if($title && $content != $timelineEntry)
                                            <div class="timeline-title">{{ $title }}</div>
                                        @endif
                                        
                                        <div>{{ $content }}</div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Project Contact -->
            <!-- <div class="card project-info-card">
                <div class="project-info-header">
                    <h5 class="mb-0"><i class="fas fa-phone-alt me-2"></i> Contact Information</h5>
                </div>
                <div class="card-body">
                    @if($project->contact_person)
                    <div class="project-info-item">
                        <div class="project-info-label">Contact Person</div>
                        <div class="project-info-value">{{ $project->contact_person }}</div>
                    </div>
                    @endif
                    
                    @if($project->contact_email)
                    <div class="project-info-item">
                        <div class="project-info-label">Email</div>
                        <div class="project-info-value">
                            <a href="mailto:{{ $project->contact_email }}">{{ $project->contact_email }}</a>
                        </div>
                    </div>
                    @endif
                    
                    @if($project->contact_phone)
                    <div class="project-info-item">
                        <div class="project-info-label">Phone</div>
                        <div class="project-info-value">
                            <a href="tel:{{ $project->contact_phone }}">{{ $project->contact_phone }}</a>
                        </div>
                    </div>
                    @endif
                    
                    <div class="mt-3">
                        <a href="{{ url('/government/contact?subject=Project Inquiry: ' . $project->title) }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-envelope me-2"></i> Send Inquiry
                        </a>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    
    <!-- Related Projects -->
    @if(isset($relatedProjects) && $relatedProjects->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Related Projects</h3>
            <div class="row g-4">
                @foreach($relatedProjects as $relatedProject)
                <div class="col-md-4">
                    <div class="card project-card h-100">
                        @if($relatedProject->status)
                            <span class="project-badge badge-{{ $relatedProject->status }}">
                                {{ ucfirst($relatedProject->status) }}
                            </span>
                        @endif
                        
                        @if($relatedProject->featured_image)
                            <img src="{{ asset('images/' . $relatedProject->featured_image) }}" class="card-img-top" alt="{{ $relatedProject->title }}">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-project-diagram fa-3x text-muted"></i>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <h5 class="card-title project-title">{{ $relatedProject->title }}</h5>
                            <p class="card-text">{{ Str::limit($relatedProject->short_description ?? $relatedProject->description, 100) }}</p>
                            <a href="{{ route('government.projects.show', $relatedProject->id) }}" class="btn btn-outline-primary mt-2">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': "Image %1 of %2"
        });
    });
</script>
@endsection 