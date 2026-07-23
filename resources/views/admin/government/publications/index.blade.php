@extends('layouts.admin')

@section('title', __('Publications'))

@section('styles')
<style>
    .publication-list-item {
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }
    
    .publication-list-item:hover {
        border-left-color: var(--primary);
        background-color: rgba(0, 0, 0, 0.03);
    }
    
    .publication-status {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }
    
    .publication-status.published {
        background-color: #28a745;
    }
    
    .publication-status.draft {
        background-color: #ffc107;
    }
    
    .featured-badge {
        background-color: #dc3545;
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        margin-left: 5px;
    }
    
    .type-badge {
        display: inline-block;
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
    }
    
    .type-report {
        background-color: #17a2b8;
        color: white;
    }
    
    .type-policy {
        background-color: #6f42c1;
        color: white;
    }
    
    .type-document {
        background-color: #6c757d;
        color: white;
    }
    
    .type-brochure {
        background-color: #fd7e14;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Publications') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Publications') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-0">{{ __('Manage Publications') }}</h5>
                    <p class="text-muted small mb-0">{{ __('Create, edit, and manage government publications and documents.') }}</p>
                </div>
                <a href="{{ route('admin.government.publications.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> {{ __('Add Publication') }}
                </a>
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
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Department') }}</th>
                            <th>{{ __('File') }}</th>
                            <th>{{ __('Published Date') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th style="width: 180px;">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($publications as $publication)
                            <tr class="publication-list-item">
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if(isset($publication->cover_image) && $publication->cover_image)
                                            <div class="me-3">
                                                <img src="{{ asset('images/' . $publication->cover_image) }}" alt="{{ $publication->title }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $publication->title ?? 'No Title' }}</strong>
                                            @if(isset($publication->is_featured) && $publication->is_featured)
                                                <span class="badge featured-badge">{{ __('Featured') }}</span>
                                            @endif
                                            <div class="small text-muted">{{ Str::limit($publication->description ?? '', 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="type-badge type-{{ $publication->type ?? 'document' }}">
                                        {{ ucfirst($publication->type) ?? __('Document') }}
                                    </span>
                                </td>
                                <td>
                                    @if($publication->department)
                                        <span>{{ $publication->department->name }}</span>
                                    @else
                                        <span class="text-muted">General</span>
                                    @endif
                                </td>
                                <td>
                                    @if($publication->file_path)
                                        <a href="{{ asset('images/' . $publication->file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-file-pdf me-1"></i> {{ __('View Document') }}
                                        </a>
                                    @else
                                        <span class="text-muted">{{ __('No file uploaded') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($publication->published_at)
                                        <div><i class="fas fa-calendar-alt me-1 small"></i> {{ $publication->published_at->format('M d, Y') }}</div>
                                    @else
                                        <span class="text-muted">{{ __('Not published') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="publication-status {{ $publication->status }}"></span>
                                    {{ ucfirst($publication->status) }}
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.government.publications.show', $publication) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.government.publications.edit', $publication) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.government.publications.destroy', $publication) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this publication?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
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
                                        <i class="fas fa-file-alt text-muted mb-2" style="font-size: 2.5rem;"></i>
                                        <h5>{{ __('No publications found') }}</h5>
                                        <p class="text-muted">{{ __('Start by adding your first publication') }}</p>
                                        <a href="{{ route('admin.government.publications.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> {{ __('Add Publication') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(is_object($publications) && method_exists($publications, 'links'))
                <div class="mt-3">
                    {{ $publications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 