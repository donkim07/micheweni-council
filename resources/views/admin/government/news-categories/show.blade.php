@extends('layouts.admin')

@section('title', __('View News Category'))

@section('styles')
<style>
    .category-card {
        border-left: 4px solid var(--primary);
    }
    
    .news-list-item {
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }
    
    .news-list-item:hover {
        border-left-color: var(--primary);
        background-color: rgba(0, 0, 0, 0.03);
    }
    
    .news-status {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }
    
    .news-status.published {
        background-color: #28a745;
    }
    
    .news-status.draft {
        background-color: #ffc107;
    }
    
    .news-status.archived {
        background-color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ $category->name }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.news.index') }}">{{ __('News') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.news-categories.index') }}">{{ __('Categories') }}</a></li>
        <li class="breadcrumb-item active">{{ $category->name }}</li>
    </ol>
    
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card category-card">
                <div class="card-header">
                    <i class="fas fa-folder me-1"></i>
                    {{ __('Category Details') }}
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="fw-bold">{{ __('Name') }}:</label>
                        <p>{{ $category->name }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="fw-bold">{{ __('Slug') }}:</label>
                        <p class="text-muted">{{ $category->slug }}</p>
                    </div>
                    
                    @if($category->description)
                    <div class="mb-3">
                        <label class="fw-bold">{{ __('Description') }}:</label>
                        <p>{{ $category->description }}</p>
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <label class="fw-bold">{{ __('News Count') }}:</label>
                        <p>{{ $category->news_count ?? $category->news->count() }} {{ __('articles') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="fw-bold">{{ __('Created At') }}:</label>
                        <p>{{ $category->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="fw-bold">{{ __('Last Updated') }}:</label>
                        <p>{{ $category->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.government.news-categories.edit', $category) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i> {{ __('Edit') }}
                    </a>
                    <form action="{{ route('admin.government.news-categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this category? All associated news will be uncategorized.') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> {{ __('Delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-newspaper me-1"></i>
                    {{ __('News in this Category') }}
                </div>
                <div class="card-body">
                    @if($category->news && $category->news->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Published Date') }}</th>
                                        <th style="width: 120px;">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->news as $article)
                                        <tr class="news-list-item">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($article->featured_image)
                                                        <div class="me-3">
                                                            <img src="{{ asset('images/' . $article->featured_image) }}" alt="{{ $article->title }}" class="img-thumbnail" style="width: 40px; height: 40px; object-fit: cover;">
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <a href="{{ route('admin.government.news.show', $article) }}" class="text-decoration-none">
                                                            {{ $article->title }}
                                                        </a>
                                                        @if($article->is_featured)
                                                            <span class="badge bg-danger ms-1">{{ __('Featured') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="news-status {{ $article->status }}"></span>
                                                {{ ucfirst($article->status) }}
                                            </td>
                                            <td>
                                                @if($article->published_at)
                                                    {{ $article->published_at->format('M d, Y') }}
                                                @else
                                                    <span class="text-muted">{{ __('Not published') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('admin.government.news.edit', $article) }}" class="btn btn-sm btn-outline-primary me-1" title="{{ __('Edit') }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.government.news.show', $article) }}" class="btn btn-sm btn-outline-info" title="{{ __('View') }}">
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
                        <div class="text-center py-4">
                            <i class="fas fa-newspaper text-muted mb-2" style="font-size: 2.5rem;"></i>
                            <h5>{{ __('No news articles in this category') }}</h5>
                            <p class="text-muted">{{ __('Start by adding your first news article to this category') }}</p>
                            <a href="{{ route('admin.government.news.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> {{ __('Add News Article') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection