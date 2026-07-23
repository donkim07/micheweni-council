@extends('layouts.admin')

@section('title', $department->name)

@section('styles')
<style>
    .department-header {
        position: relative;
        background-color: #f8f9fa;
        padding: 30px;
        border-radius: 5px;
        margin-bottom: 30px;
    }
    
    .department-image {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }
    
    .department-head-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid white;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }
    
    .info-item {
        margin-bottom: 15px;
    }
    
    .info-label {
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 5px;
    }
    
    .info-value {
        margin-bottom: 0;
    }
    
    .description-card {
        height: 100%;
    }
    
    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .status-badge.active {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    
    .status-badge.inactive {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    
    .action-buttons {
        position: absolute;
        top: 20px;
        right: 20px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ $department->name }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.departments.index') }}">{{ __('Departments') }}</a></li>
        <li class="breadcrumb-item active">{{ $department->name }}</li>
    </ol>
    
    <div class="department-header">
        <div class="row align-items-center">
            <div class="col-md-9">
                <h2>{{ $department->name }}</h2>
                <div class="d-flex align-items-center mt-2">
                    <span class="status-badge {{ $department->status }}">{{ ucfirst($department->status) }}</span>
                    @if($department->slug)
                        <span class="ms-3 text-muted">{{ url('/government/departments/' . $department->slug) }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3 text-md-end">
                <div class="action-buttons">
                    <a href="{{ route('admin.government.departments.edit', $department) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit me-1"></i> {{ __('Edit') }}
                    </a>
                    <a href="{{ route('admin.government.departments.edit-details', $department) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-info-circle me-1"></i> {{ __('Edit Details') }}
                    </a>
                    <form action="{{ route('admin.government.departments.destroy', $department) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this department?') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash me-1"></i> {{ __('Delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    {{ __('Department Details') }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            @if($department->featured_image)
                                <img src="{{ asset('images/' . $department->featured_image) }}" alt="{{ $department->name }}" class="department-image mb-3">
                            @else
                                <div class="bg-light text-center py-5 mb-3">
                                    <i class="fas fa-building fa-4x text-muted"></i>
                                    <p class="mt-2 text-muted">{{ __('No featured image') }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">{{ __('Status') }}</div>
                                <div class="info-value">
                                    <span class="status-badge {{ $department->status }}">{{ ucfirst($department->status) }}</span>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">{{ __('Order') }}</div>
                                <div class="info-value">{{ $department->order }}</div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">{{ __('Location') }}</div>
                                <div class="info-value">
                                    @if($department->location)
                                        {{ $department->location }}
                                    @else
                                        <span class="text-muted">{{ __('Not specified') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">{{ __('Category') }}</div>
                                <div class="info-value">
                                    <span class="badge bg-info">{{ ucfirst($department->category ?? 'department') }}</span>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">{{ __('Created At') }}</div>
                                <div class="info-value">{{ $department->created_at->format('F d, Y H:i') }}</div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">{{ __('Last Updated') }}</div>
                                <div class="info-value">{{ $department->updated_at->format('F d, Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="info-label">{{ __('Description') }}</div>
                            <div class="info-value">
                                @if($department->description)
                                    {!! $department->description !!}
                                @else
                                    <span class="text-muted">{{ __('No description provided') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-list me-1"></i>
                    {{ __('Related Services') }}
                </div>
                <div class="card-body">
                    @if($department->services->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Service Name') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($department->services as $service)
                                        <tr>
                                            <td>{{ $service->title }}</td>
                                            <td>
                                                <span class="status-badge {{ $service->status }}">{{ ucfirst($service->status) }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.government.services.edit', $service) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                            <p>{{ __('No services associated with this department.') }}</p>
                            <a href="{{ route('admin.government.services.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i> {{ __('Add Service') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-project-diagram me-1"></i>
                    {{ __('Related Projects') }}
                </div>
                <div class="card-body">
                    @if($department->projects->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Project Name') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Progress') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($department->projects as $project)
                                        <tr>
                                            <td>{{ $project->title }}</td>
                                            <td>
                                                <span class="status-badge {{ $project->status }}">{{ ucfirst($project->status) }}</span>
                                            </td>
                                            <td>
                                                @if($project->completion_percentage)
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $project->completion_percentage }}%;" aria-valuenow="{{ $project->completion_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <small class="text-muted">{{ $project->completion_percentage }}%</small>
                                                @else
                                                    <span class="text-muted">{{ __('Not set') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.government.projects.edit', $project) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                            <p>{{ __('No projects associated with this department.') }}</p>
                            <a href="{{ route('admin.government.projects.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i> {{ __('Add Project') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user me-1"></i>
                    {{ __('Department Head') }}
                </div>
                <div class="card-body text-center">
                    @if($department->head_name)
                        @if($department->head_image)
                            <img src="{{ asset('images/' . $department->head_image) }}" alt="{{ $department->head_name }}" class="department-head-image mb-3">
                        @else
                            <div class="bg-light rounded-circle mx-auto mb-3" style="width: 150px; height: 150px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user fa-4x text-muted"></i>
                            </div>
                        @endif
                        
                        <h5 class="mb-1">{{ $department->head_name }}</h5>
                        
                        @if($department->head_title)
                            <p class="text-muted mb-3">{{ $department->head_title }}</p>
                        @endif
                    @else
                        <div class="py-4">
                            <div class="bg-light rounded-circle mx-auto mb-3" style="width: 150px; height: 150px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user fa-4x text-muted"></i>
                            </div>
                            <p class="text-muted">{{ __('No department head assigned') }}</p>
                            <a href="{{ route('admin.government.departments.edit', $department) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-user-plus me-1"></i> {{ __('Assign Head') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-address-card me-1"></i>
                    {{ __('Contact Information') }}
                </div>
                <div class="card-body">
                    @if($department->contact_email || $department->contact_phone)
                        <div class="info-item">
                            <div class="info-label">{{ __('Email') }}</div>
                            <div class="info-value">
                                @if($department->contact_email)
                                    <a href="mailto:{{ $department->contact_email }}">{{ $department->contact_email }}</a>
                                @else
                                    <span class="text-muted">{{ __('Not provided') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">{{ __('Phone') }}</div>
                            <div class="info-value">
                                @if($department->contact_phone)
                                    <a href="tel:{{ $department->contact_phone }}">{{ $department->contact_phone }}</a>
                                @else
                                    <span class="text-muted">{{ __('Not provided') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">{{ __('Location') }}</div>
                            <div class="info-value">
                                @if($department->location)
                                    {{ $department->location }}
                                @else
                                    <span class="text-muted">{{ __('Not specified') }}</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                            <p>{{ __('No contact information available') }}</p>
                            <a href="{{ route('admin.government.departments.edit', $department) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i> {{ __('Add Contact Info') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-link me-1"></i>
                    {{ __('Quick Links') }}
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('admin.government.departments.edit', $department) }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-edit me-2"></i> {{ __('Edit Department') }}
                        </a>
                        <a href="{{ url('/government/departments/' . $department->slug) }}" class="list-group-item list-group-item-action" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i> {{ __('View on Website') }}
                        </a>
                        <a href="{{ route('admin.government.services.create') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-plus me-2"></i> {{ __('Add New Service') }}
                        </a>
                        <a href="{{ route('admin.government.departments.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-list me-2"></i> {{ __('All Departments') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 