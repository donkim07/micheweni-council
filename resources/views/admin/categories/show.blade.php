@extends('layouts.admin')

@section('title', $category->name)

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-primary-soft rounded-circle p-3 me-3">
                                    <i class="fas fa-tag fa-lg text-primary"></i>
                                </div>
                                <div>
                                    <h2 class="section-heading mb-0">{{ $category->name }}</h2>
                                    <p class="text-muted mb-0">{{ $category->slug }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3 mt-lg-0">
                            <div class="d-flex justify-content-lg-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i>{{ __('Edit Category') }}
                                </a>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Categories') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Category Details') }}</h5>
                </div>
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-top">
                            <span class="fw-medium">{{ __('Name') }}</span>
                            <span>{{ $category->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="fw-medium">{{ __('Slug') }}</span>
                            <span class="text-muted">{{ $category->slug }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="fw-medium">{{ __('Parent Category') }}</span>
                            @if($category->parent)
                                <a href="{{ route('admin.categories.show', $category->parent->id) }}" class="badge bg-light text-dark text-decoration-none">
                                    {{ $category->parent->name }}
                                </a>
                            @else
                                <span class="text-muted">{{ __('None') }}</span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="fw-medium">{{ __('News Articles') }}</span>
                            <span class="badge rounded-pill bg-primary-soft text-primary">{{ $category->news->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="fw-medium">{{ __('Child Categories') }}</span>
                            <span class="badge rounded-pill bg-info-soft text-info">{{ $category->children->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="fw-medium">{{ __('Created') }}</span>
                            <span class="text-muted">{{ $category->created_at->format('M d, Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="fw-medium">{{ __('Last Updated') }}</span>
                            <span class="text-muted">{{ $category->updated_at->format('M d, Y') }}</span>
                        </li>
                    </ul>
                    
                    @if($category->description)
                        <div class="mt-4">
                            <h6 class="fw-bold mb-3">{{ __('Description') }}</h6>
                            <p class="text-muted mb-0">{{ $category->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="row">
                @if($category->children->count() > 0)
                    <div class="col-12">
                        <div class="card border-0 mb-4">
                            <div class="card-header bg-white p-4 border-0 d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold">{{ __('Child Categories') }}</h5>
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus me-1"></i>{{ __('Add Category') }}
                                </a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="border-0 px-4 py-3">{{ __('Name') }}</th>
                                                <th class="border-0 px-4 py-3">{{ __('Slug') }}</th>
                                                <th class="border-0 px-4 py-3">{{ __('News Count') }}</th>
                                                <th class="border-0 px-4 py-3 text-end">{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($category->children as $child)
                                            <tr>
                                                <td class="px-4 py-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-box bg-light rounded-circle p-2 me-3">
                                                            <i class="fas fa-tag text-primary"></i>
                                                        </div>
                                                        <span class="fw-medium">{{ $child->name }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 text-muted">{{ $child->slug }}</td>
                                                <td class="px-4 py-3">
                                                    <span class="badge rounded-pill bg-primary-soft text-primary">
                                                        {{ $child->news->count() }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-end">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.categories.edit', $child->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="{{ __('Edit') }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="{{ route('admin.categories.show', $child->id) }}" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="{{ __('View') }}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="col-12">
                    <div class="card border-0 mb-4">
                        <div class="card-header bg-white p-4 border-0 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">{{ __('News Articles') }}</h5>
                            <a href="{{ route('admin.news.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i>{{ __('Add News') }}
                            </a>
                        </div>
                        <div class="card-body p-0">
                            @if($category->news->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="border-0 px-4 py-3">{{ __('Title') }}</th>
                                                <th class="border-0 px-4 py-3">{{ __('Author') }}</th>
                                                <th class="border-0 px-4 py-3">{{ __('Status') }}</th>
                                                <th class="border-0 px-4 py-3">{{ __('Published') }}</th>
                                                <th class="border-0 px-4 py-3 text-end">{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($category->news as $news)
                                            <tr>
                                                <td class="px-4 py-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-box bg-light rounded-circle p-2 me-3">
                                                            <i class="fas fa-newspaper text-primary"></i>
                                                        </div>
                                                        <span class="fw-medium">{{ $news->title }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-2">
                                                            {{ substr($news->author->name ?? 'Admin', 0, 1) }}
                                                        </div>
                                                        <div class="small">{{ $news->author->name ?? 'Admin' }}</div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    @if($news->is_published)
                                                        <span class="badge bg-success-soft text-success">{{ __('Published') }}</span>
                                                    @else
                                                        <span class="badge bg-warning-soft text-warning">{{ __('Draft') }}</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-calendar text-muted me-2"></i>
                                                        <span>{{ $news->published_at ? $news->published_at->format('M d, Y') : '-' }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 text-end">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="{{ __('Edit') }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="{{ route('admin.news.show', $news->id) }}" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="{{ __('View') }}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center p-5">
                                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                    <p class="mb-0">{{ __('No news articles in this category yet.') }}</p>
                                    <a href="{{ route('admin.news.create') }}" class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-plus me-1"></i>{{ __('Add News') }}
                                    </a>
                                </div>
                            @endif
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
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection 