@extends('layouts.admin')

@section('title', 'View Service')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <h1 class="h3 mb-0 text-gray-800">View Service</h1>
                <div>
                    <a href="{{ route('admin.government.services.edit', $service->id) }}" class="btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-edit fa-sm text-white-50"></i> Edit
                    </a>
                    <a href="{{ route('admin.government.services.index') }}" class="btn btn-sm btn-secondary shadow-sm ml-2">
                        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Services
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Service Details</h6>
                    <span class="badge badge-{{ $service->status == 'active' ? 'success' : 'danger' }}">
                        {{ ucfirst($service->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h2 class="h4 font-weight-bold">
                            @if($service->icon)
                                <i class="fas {{ $service->icon }} mr-2"></i>
                            @endif
                            {{ $service->title }}
                            @if($service->is_featured)
                                <span class="badge badge-warning ml-2">Featured</span>
                            @endif
                        </h2>
                        
                        @if($service->department)
                            <div class="text-muted mb-3">
                                <i class="fas fa-building mr-1"></i> Department: {{ $service->department->name }}
                            </div>
                        @endif
                        
                        @if($service->short_description)
                            <div class="alert alert-info">
                                {{ $service->short_description }}
                            </div>
                        @endif
                        
                        <div class="service-description">
                            {!! $service->description !!}
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Display Information</h5>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <strong>Display Order:</strong> {{ $service->order ?? 'Not set' }}
                                        </li>
                                        <li class="mb-2">
                                            <strong>Created:</strong> {{ $service->created_at->format('M d, Y H:i') }}
                                        </li>
                                        <li>
                                            <strong>Last Updated:</strong> {{ $service->updated_at->format('M d, Y H:i') }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Featured Image</h6>
                </div>
                <div class="card-body">
                    @if($service->featured_image)
                        <img src="{{ asset('images/' . $service->featured_image) }}" alt="{{ $service->title }}" class="img-fluid">
                    @else
                        <div class="text-center py-5 bg-light">
                            <i class="fas fa-image fa-3x text-muted"></i>
                            <p class="mt-2 text-muted">No image available</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.government.services.edit', $service->id) }}" class="btn btn-primary btn-block">
                        <i class="fas fa-edit"></i> Edit Service
                    </a>
                    
                    <button type="button" class="btn btn-danger btn-block mt-2" data-toggle="modal" data-target="#deleteModal">
                        <i class="fas fa-trash"></i> Delete Service
                    </button>
                    
                    @if($service->status == 'active')
                        <a href="{{ route('government.services.show', $service->id) }}" target="_blank" class="btn btn-info btn-block mt-2">
                            <i class="fas fa-external-link-alt"></i> View on Website
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this service? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.government.services.destroy', $service->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 