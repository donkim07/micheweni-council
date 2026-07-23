@extends('layouts.admin')

@section('title', __('News'))

@section('styles')
<style>
    .news-list-item {
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }
    
    .news-list-item:hover {
        border-left-color: var(--primary);
        background-color: rgba(0, 0, 0, 0.03);
    }
    
    .news-list-item.active {
        border-left-color: var(--primary);
        background-color: rgba(0, 0, 0, 0.05);
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
    
    .featured-badge {
        background-color: #dc3545;
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        margin-left: 5px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('News') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('News') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-0">{{ __('Manage News') }}</h5>
                    <p class="text-muted small mb-0">{{ __('Create, edit, and manage news articles.') }}</p>
                </div>
                <div class="d-flex">
                    <a href="{{ route('admin.government.news-categories.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-folder me-1"></i> {{ __('Categories') }}
                    </a>
                    <a href="{{ route('admin.government.news-tags.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-tags me-1"></i> {{ __('Tags') }}
                    </a>
                    <a href="{{ route('admin.government.news.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> {{ __('Add News') }}
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
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Department') }}</th>
                            <th>{{ __('Tags') }}</th>
                            <th>{{ __('Published Date') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th style="width: 180px;">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($news as $newsItem)
                            <tr class="news-list-item">
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($newsItem->featured_image)
                                            <div class="me-3">
                                                <img src="{{ asset('images/' . $newsItem->featured_image) }}" alt="{{ $newsItem->title }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $newsItem->title }}</strong>
                                            @if($newsItem->is_featured)
                                                <span class="badge featured-badge">{{ __('Featured') }}</span>
                                            @endif
                                            @if($newsItem->slug)
                                                <div class="small text-muted">{{ $newsItem->slug }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($newsItem->category)
                                        <span class="badge bg-secondary">{{ $newsItem->category->name }}</span>
                                    @else
                                        <span class="text-muted">{{ __('Uncategorized') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($newsItem->department)
                                        <span>{{ $newsItem->department->name }}</span>
                                    @else
                                        <span class="text-muted">General</span>
                                    @endif
                                </td>
                                <td>
                                    @if($newsItem->tags && $newsItem->tags->count() > 0)
                                        @foreach($newsItem->tags as $tag)
                                            <span class="badge bg-info">{{ $tag->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">{{ __('No tags') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($newsItem->published_at)
                                        <div><i class="fas fa-calendar-alt me-1 small"></i> {{ $newsItem->published_at->format('M d, Y') }}</div>
                                    @else
                                        <span class="text-muted">{{ __('Not published') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="news-status {{ $newsItem->status }}"></span>
                                    {{ ucfirst($newsItem->status) }}
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.government.news.show', $newsItem) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.government.news.edit', $newsItem) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.government.news.destroy', $newsItem) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this news article?') }}');">
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
                                        <i class="fas fa-newspaper text-muted mb-2" style="font-size: 2.5rem;"></i>
                                        <h5>{{ __('No news articles found') }}</h5>
                                        <p class="text-muted">{{ __('Start by adding your first news article') }}</p>
                                        <a href="{{ route('admin.government.news.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> {{ __('Add News Article') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $news->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 