@extends('layouts.admin')

@section('title', __('View Project'))

@section('styles')
<style>
    .project-card {
        border-left: 4px solid var(--primary);
    }
    
    .project-image {
        max-width: 100%;
        max-height: 250px;
        object-fit: cover;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .project-status {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 5px;
    }
    
    .project-status.active {
        background-color: #28a745;
    }
    
    .project-status.completed {
        background-color: #007bff;
    }
    
    .project-status.pending {
        background-color: #ffc107;
    }
    
    .project-status.canceled {
        background-color: #dc3545;
    }
    
    .priority-badge {
        padding: 0.4rem 0.6rem;
        font-size: 0.8rem;
        border-radius: 4px;
    }
    
    .priority-low {
        background-color: #6c757d;
        color: white;
    }
    
    .priority-medium {
        background-color: #17a2b8;
        color: white;
    }
    
    .priority-high {
        background-color: #dc3545;
        color: white;
    }
    
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 5px;
        height: calc(100% - 10px);
        width: 2px;
        background-color: #dee2e6;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 25px;
    }
    
    .timeline-dot {
        position: absolute;
        left: -30px;
        top: 5px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: var(--primary);
    }
    
    .timeline-date {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 5px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ $project->title }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.projects.index') }}">{{ __('Projects') }}</a></li>
        <li class="breadcrumb-item active">{{ Str::limit($project->title, 30) }}</li>
    </ol>
    
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card project-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-project-diagram me-1"></i>
                        {{ __('Project Details') }}
                    </div>
                    <div>
                        @if($project->is_featured)
                            <span class="badge bg-danger me-2">{{ __('Featured') }}</span>
                        @endif
                        <span class="badge bg-{{ $project->status == 'active' ? 'success' : ($project->status == 'completed' ? 'primary' : ($project->status == 'pending' ? 'warning' : 'secondary')) }}">
                            <span class="project-status {{ $project->status }}"></span>
                            {{ ucfirst($project->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    @if($project->featured_image)
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/' . $project->featured_image) }}" alt="{{ $project->title }}" class="project-image">
                        </div>
                    @endif
                    
                    <div class="row mb-4">
                        <div class="col-md-8">
                            @if($project->short_description)
                                <div class="mb-3">
                                    <p class="lead">{{ $project->short_description }}</p>
                                </div>
                            @endif
                            
                            <div class="mb-3">
                                <label class="fw-bold">{{ __('Description') }}:</label>
                                <div class="mt-2">
                                    {!! nl2br(e($project->description)) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    {{ __('Project Information') }}
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <label class="fw-bold">{{ __('Category') }}:</label>
                                        <p>{{ $project->category ? $project->category->name : __('Not specified') }}</p>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <label class="fw-bold">{{ __('Department') }}:</label>
                                        <p>{{ $project->department ? $project->department->name : __('Not specified') }}</p>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <label class="fw-bold">{{ __('Priority') }}:</label>
                                        <p>
                                            <span class="priority-badge priority-{{ $project->priority ?? 'medium' }}">
                                                {{ ucfirst($project->priority ?? __('Medium')) }}
                                            </span>
                                        </p>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <label class="fw-bold">{{ __('Location') }}:</label>
                                        <p>{{ $project->location ?? __('Not specified') }}</p>
                                    </div>
                                    
                                    @if($project->budget)
                                        <div class="mb-2">
                                            <label class="fw-bold">{{ __('Budget') }}:</label>
                                            <p>TZS {{ number_format($project->budget, 2) }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    {{ __('Timeline') }}
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-dot"></div>
                                            <div class="timeline-date">{{ __('Created') }}</div>
                                            <div>{{ $project->created_at->format('M d, Y') }}</div>
                                        </div>
                                        
                                        @if($project->start_date)
                                            <div class="timeline-item">
                                                <div class="timeline-dot"></div>
                                                <div class="timeline-date">{{ __('Start Date') }}</div>
                                                <div>{{ $project->start_date->format('M d, Y') }}</div>
                                            </div>
                                        @endif
                                        
                                        @if($project->end_date)
                                            <div class="timeline-item">
                                                <div class="timeline-dot"></div>
                                                <div class="timeline-date">{{ __('End Date') }}</div>
                                                <div>{{ $project->end_date->format('M d, Y') }}</div>
                                            </div>
                                        @endif
                                        
                                        <div class="timeline-item">
                                            <div class="timeline-dot"></div>
                                            <div class="timeline-date">{{ __('Last Updated') }}</div>
                                            <div>{{ $project->updated_at->format('M d, Y') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    {{ __('Contact Information') }}
                                </div>
                                <div class="card-body">
                                    @if($project->contact_person)
                                        <div class="mb-2">
                                            <label class="fw-bold">{{ __('Contact Person') }}:</label>
                                            <p>{{ $project->contact_person }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($project->contact_email)
                                        <div class="mb-2">
                                            <label class="fw-bold">{{ __('Email') }}:</label>
                                            <p><a href="mailto:{{ $project->contact_email }}">{{ $project->contact_email }}</a></p>
                                        </div>
                                    @endif
                                    
                                    @if($project->contact_phone)
                                        <div class="mb-2">
                                            <label class="fw-bold">{{ __('Phone') }}:</label>
                                            <p><a href="tel:{{ $project->contact_phone }}">{{ $project->contact_phone }}</a></p>
                                        </div>
                                    @endif
                                    
                                    @if(!$project->contact_person && !$project->contact_email && !$project->contact_phone)
                                        <p class="text-muted">{{ __('No contact information provided') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.government.projects.edit', $project) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i> {{ __('Edit') }}
                    </a>
                    <form action="{{ route('admin.government.projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this project?') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> {{ __('Delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-link me-1"></i>
                    {{ __('Quick Actions') }}
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('admin.government.projects.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-list me-2"></i> {{ __('All Projects') }}
                        </a>
                        <a href="{{ route('admin.government.projects.create') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-plus me-2"></i> {{ __('Add New Project') }}
                        </a>
                        <a href="{{ route('admin.government.projects.edit', $project) }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-edit me-2"></i> {{ __('Edit This Project') }}
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" 
                           onclick="event.preventDefault(); if(confirm('{{ __('Are you sure you want to toggle featured status?') }}')) document.getElementById('toggle-featured-form').submit();">
                            <i class="fas {{ $project->is_featured ? 'fa-star text-warning' : 'fa-star-half-alt' }} me-2"></i> 
                            {{ $project->is_featured ? __('Remove from Featured') : __('Add to Featured') }}
                        </a>
                        <form id="toggle-featured-form" action="{{ route('admin.government.projects.update', $project) }}" method="POST" style="display: none;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="title" value="{{ $project->title }}">
                            <input type="hidden" name="description" value="{{ $project->description }}">
                            <input type="hidden" name="category_id" value="{{ $project->category_id }}">
                            <input type="hidden" name="status" value="{{ $project->status }}">
                            <input type="hidden" name="is_featured" value="{{ $project->is_featured ? 0 : 1 }}">
                        </form>
                    </div>
                </div>
            </div>
            
            @if($project->category)
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-folder me-1"></i>
                        {{ __('Category Information') }}
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            @if($project->category->icon)
                                <img src="{{ asset('images/' . $project->category->icon) }}" alt="{{ $project->category->name }}" class="me-3" style="width: 40px; height: 40px; object-fit: cover;">
                            @endif
                            <h5 class="mb-0">{{ $project->category->name }}</h5>
                        </div>
                        
                        @if($project->category->description)
                            <p>{{ $project->category->description }}</p>
                        @endif
                        
                        <a href="{{ route('admin.government.project-categories.show', $project->category) }}" class="btn btn-sm btn-outline-primary mt-2">
                            {{ __('View Category') }}
                        </a>
                    </div>
                </div>
            @endif
            
            @if($project->department)
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-building me-1"></i>
                        {{ __('Department Information') }}
                    </div>
                    <div class="card-body">
                        <h5 class="mb-2">{{ $project->department->name }}</h5>
                        
                        @if($project->department->description)
                            <p>{{ $project->department->description }}</p>
                        @endif
                        
                        <a href="{{ route('admin.government.departments.show', $project->department) }}" class="btn btn-sm btn-outline-primary mt-2">
                            {{ __('View Department') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection