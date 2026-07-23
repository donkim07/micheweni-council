@extends('layouts.admin')

@section('title', __('Project Categories'))

@section('styles')
<style>
    .category-list-item {
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }
    
    .category-list-item:hover {
        border-left-color: var(--primary);
        background-color: rgba(0, 0, 0, 0.03);
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Project Categories') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.projects.index') }}">{{ __('Projects') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Categories') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-0">{{ __('Manage Project Categories') }}</h5>
                    <p class="text-muted small mb-0">{{ __('Create, edit, and manage project categories.') }}</p>
                </div>
                <a href="{{ route('admin.government.project-categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> {{ __('Add Category') }}
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
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Projects Count') }}</th>
                            <th style="width: 180px;">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr class="category-list-item">
                                <td>
                                    <div>
                                        <strong>{{ $category->name }}</strong>
                                        @if($category->slug)
                                            <div class="small text-muted">{{ $category->slug }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    {{ Str::limit($category->description, 100) ?? __('No description') }}
                                </td>
                                <td>
                                    {{ $category->projects_count ?? $category->projects->count() }}
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.government.project-categories.show', $category) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.government.project-categories.edit', $category) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.government.project-categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this category?') }}');">
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
                                <td colspan="4" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-folder-open text-muted mb-2" style="font-size: 2.5rem;"></i>
                                        <h5>{{ __('No project categories found') }}</h5>
                                        <p class="text-muted">{{ __('Start by adding your first project category') }}</p>
                                        <a href="{{ route('admin.government.project-categories.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> {{ __('Add Category') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @isset($projectCategories->links)
                <div class="mt-3">
                    {{ $projectCategories->links() }}
                </div>
            @endisset
        </div>
    </div>
</div>
@endsection 