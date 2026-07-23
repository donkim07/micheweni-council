@extends('layouts.admin')

@section('title', __('View Publication'))

@section('styles')
<style>
    .publication-card {
        border-left: 4px solid var(--primary);
    }
    
    .publication-image {
        max-width: 100%;
        max-height: 250px;
        object-fit: contain;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .badge-category {
        padding: 0.4rem 0.6rem;
        font-size: 0.8rem;
        border-radius: 4px;
    }
    
    .badge-report {
        background-color: #17a2b8;
        color: white;
    }
    
    .badge-policy {
        background-color: #6f42c1;
        color: white;
    }
    
    .badge-form {
        background-color: #28a745;
        color: white;
    }
    
    .badge-brochure {
        background-color: #fd7e14;
        color: white;
    }
    
    .badge-newsletter {
        background-color: #e83e8c;
        color: white;
    }
    
    .badge-other {
        background-color: #6c757d;
        color: white;
    }
    
    .file-download {
        background-color: #f8f9fa;
        border-radius: 5px;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ $publication->title }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.publications.index') }}">{{ __('Publications') }}</a></li>
        <li class="breadcrumb-item active">{{ Str::limit($publication->title, 30) }}</li>
    </ol>
    
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card publication-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-file-pdf me-1"></i>
                        {{ __('Publication Details') }}
                    </div>
                    @if($publication->is_featured)
                        <span class="badge bg-danger">{{ __('Featured') }}</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            @if($publication->cover_image)
                                <img src="{{ asset('images/' . $publication->cover_image) }}" alt="{{ $publication->title }}" class="publication-image mb-3">
                            @else
                                <div class="text-center p-4 bg-light mb-3">
                                    <i class="fas fa-file-pdf text-muted" style="font-size: 5rem;"></i>
                                    <p class="mt-2 text-muted mb-0">{{ __('No cover image') }}</p>
                                </div>
                            @endif
                            
                            <div class="mb-3">
                                <span class="badge badge-category badge-{{ $publication->category ?? 'other' }}">
                                    {{ ucfirst($publication->category ?? __('Other')) }}
                                </span>
                            </div>
                            
                            <div class="mb-3">
                                <label class="fw-bold">{{ __('Status') }}:</label>
                                <p>
                                    <span class="badge bg-{{ $publication->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($publication->status) }}
                                    </span>
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="fw-bold">{{ __('Publication Date') }}:</label>
                                <p>{{ $publication->published_date ? $publication->published_date->format('M d, Y') : __('Not specified') }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="fw-bold">{{ __('Title') }}:</label>
                                <p>{{ $publication->title }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="fw-bold">{{ __('Slug') }}:</label>
                                <p class="text-muted">{{ $publication->slug }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="fw-bold">{{ __('Description') }}:</label>
                                <p>{{ $publication->description ?? __('No description provided') }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="fw-bold">{{ __('Display Order') }}:</label>
                                <p>{{ $publication->order > 0 ? $publication->order : __('Default') }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="fw-bold">{{ __('Created At') }}:</label>
                                <p>{{ $publication->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="fw-bold">{{ __('Last Updated') }}:</label>
                                <p>{{ $publication->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($publication->file_path)
                        <div class="file-download mt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">{{ __('Publication File') }}</h5>
                                    <p class="mb-0 text-muted">{{ Str::afterLast($publication->file_path, '/') }}</p>
                                </div>
                                <a href="{{ asset('images/' . $publication->file_path) }}" target="_blank" class="btn btn-primary">
                                    <i class="fas fa-download me-1"></i> {{ __('Download') }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.government.publications.edit', $publication) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i> {{ __('Edit') }}
                    </a>
                    <form action="{{ route('admin.government.publications.destroy', $publication) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this publication?') }}');">
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
                        <a href="{{ route('admin.government.publications.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-list me-2"></i> {{ __('All Publications') }}
                        </a>
                        <a href="{{ route('admin.government.publications.create') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-plus me-2"></i> {{ __('Add New Publication') }}
                        </a>
                        <a href="{{ route('admin.government.publications.edit', $publication) }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-edit me-2"></i> {{ __('Edit This Publication') }}
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" 
                           onclick="event.preventDefault(); if(confirm('{{ __('Are you sure you want to toggle featured status?') }}')) document.getElementById('toggle-featured-form').submit();">
                            <i class="fas {{ $publication->is_featured ? 'fa-star text-warning' : 'fa-star-half-alt' }} me-2"></i> 
                            {{ $publication->is_featured ? __('Remove from Featured') : __('Add to Featured') }}
                        </a>
                        <form id="toggle-featured-form" action="{{ route('admin.government.publications.update', $publication) }}" method="POST" style="display: none;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="title" value="{{ $publication->title }}">
                            <input type="hidden" name="description" value="{{ $publication->description }}">
                            <input type="hidden" name="category" value="{{ $publication->category }}">
                            <input type="hidden" name="status" value="{{ $publication->status }}">
                            <input type="hidden" name="order" value="{{ $publication->order }}">
                            <input type="hidden" name="is_featured" value="{{ $publication->is_featured ? 0 : 1 }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection