@extends('layouts.admin')

@section('title', __('Projects'))

@section('styles')
<style>
    .project-list-item {
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }
    
    .project-list-item:hover {
        border-left-color: var(--primary);
        background-color: rgba(0, 0, 0, 0.03);
    }
    
    .project-list-item.active {
        border-left-color: var(--primary);
        background-color: rgba(0, 0, 0, 0.05);
    }
    
    .project-status {
        display: inline-block;
        padding: 0.35rem 0.65rem;
        font-size: 0.85rem;
        font-weight: 500;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
    }
    
    .project-status.planned {
        background-color: #6c757d;
        color: white;
    }
    
    .project-status.ongoing {
        background-color: #17a2b8;
        color: white;
    }
    
    .project-status.completed {
        background-color: #28a745;
        color: white;
    }
    
    .project-status.delayed {
        background-color: #ffc107;
        color: #212529;
    }
    
    .project-status.cancelled {
        background-color: #dc3545;
        color: white;
    }
    
    .featured-badge {
        background-color: #dc3545;
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        margin-left: 5px;
    }
    
    .progress {
        height: 5px;
    }
    
    /* Action buttons styling */
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }
    
    .action-btn {
        margin-bottom: 5px;
    }
    
    /* Responsive action buttons */
    @media (max-width: 1199px) and (min-width: 992px) {
        .action-buttons {
            flex-direction: column;
        }
    }
    
    /* Handle 110% zoom specifically */
    @media (min-width: 992px) and (max-width: 1199px), 
           (min-resolution: 110dpi) and (min-width: 992px) and (max-width: 1300px) {
        .action-buttons {
            flex-direction: column;
        }
        
        .action-btn {
            width: 100%;
        }
        
        /* Auto-collapse sidebar at 110% zoom but allow toggle */
        body.zoom-detected #wrapper:not(.toggled) #sidebar-wrapper {
            margin-left: calc(-1 * var(--sidebar-width)) !important;
        }
        
        body.zoom-detected #wrapper:not(.toggled) #page-content-wrapper {
            margin-left: 0 !important;
            width: 100% !important;
        }
        
        body.zoom-detected #wrapper.toggled #sidebar-wrapper {
            margin-left: 0 !important;
            z-index: 1050 !important;
        }
        
        body.zoom-detected #wrapper.toggled #page-content-wrapper {
            margin-left: var(--sidebar-width) !important;
            width: calc(100% - var(--sidebar-width)) !important;
        }
        
        /* Reduce font size in table */
        .table {
            font-size: 0.85rem;
        }
        
        .action-btn {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Projects') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Projects') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-0">{{ __('Manage Projects') }}</h5>
                    <p class="text-muted small mb-0">{{ __('Create, edit, and manage government projects.') }}</p>
                </div>
                <div class="d-flex">
                    <a href="{{ route('admin.government.project-categories.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-folder me-1"></i> {{ __('Categories') }}
                    </a>
                    <a href="{{ route('admin.government.projects.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> {{ __('Add Project') }}
                    </a>
                </div>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('Title') }}</th>
                            <th class="hide-sm">{{ __('Category/Department') }}</th>
                            <th class="hide-sm">{{ __('Location') }}</th>
                            <th class="hide-sm">{{ __('Budget') }}</th>
                            <th class="hide-sm">{{ __('Timeline') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th style="width: 180px;">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr class="project-list-item">
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($project->featured_image)
                                            <div class="me-3">
                                                <img src="{{ asset('images/' . $project->featured_image) }}" alt="{{ $project->title }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $project->title }}</strong>
                                            @if($project->is_featured)
                                                <span class="badge featured-badge">{{ __('Featured') }}</span>
                                            @endif
                                            @if($project->slug)
                                                <div class="small text-muted">{{ $project->slug }}</div>
                                            @endif
                                            @if($project->completion_percentage)
                                                <div class="progress mt-1">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ $project->completion_percentage }}%" aria-valuenow="{{ $project->completion_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="small text-muted text-end">{{ $project->completion_percentage }}% {{ __('completed') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        @if($project->category)
                                            <span class="badge bg-secondary">{{ $project->category->name }}</span>
                                        @else
                                            <span class="text-muted">{{ __('Uncategorized') }}</span>
                                        @endif
                                    </div>
                                    <div class="small mt-1">
                                        @if($project->department)
                                            <i class="fas fa-building me-1"></i> {{ $project->department->name }}
                                        @else
                                            <span class="text-muted"><i class="fas fa-building me-1"></i> General</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($project->location)
                                        <i class="fas fa-map-marker-alt me-1"></i> {{ $project->location }}
                                    @else
                                        <span class="text-muted">{{ __('N/A') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($project->budget)
                                        <strong>{{ number_format($project->budget, 2) }}</strong> <span class="small text-muted">TZS</span>
                                    @else
                                        <span class="text-muted">{{ __('Not specified') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($project->start_date)
                                        <div><i class="fas fa-calendar-alt me-1 small"></i> {{ __('Start') }}: {{ $project->start_date->format('M d, Y') }}</div>
                                    @endif
                                    @if($project->end_date)
                                        <div><i class="fas fa-calendar-check me-1 small"></i> {{ __('End') }}: {{ $project->end_date->format('M d, Y') }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="project-status {{ $project->status }}">
                                        {{ ucfirst($project->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.government.projects.show', $project) }}" class="btn btn-sm btn-outline-primary action-btn">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.government.projects.edit', $project) }}" class="btn btn-sm btn-outline-primary action-btn">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.government.projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this project?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger action-btn">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-project-diagram text-muted mb-2" style="font-size: 2.5rem;"></i>
                                        <h5>{{ __('No projects found') }}</h5>
                                        <p class="text-muted">{{ __('Start by adding your first project') }}</p>
                                        <a href="{{ route('admin.government.projects.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> {{ __('Add Project') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
</div>

@endsection 