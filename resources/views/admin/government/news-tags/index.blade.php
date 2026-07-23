@extends('layouts.admin')

@section('title', __('News Tags'))

@section('styles')
<style>
    .tag-list-item {
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }
    
    .tag-list-item:hover {
        border-left-color: var(--primary);
        background-color: rgba(0, 0, 0, 0.03);
    }
    
    .tag-badge {
        display: inline-block;
        padding: 0.35rem 0.65rem;
        font-size: 0.85rem;
        font-weight: 500;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
        background-color: #17a2b8;
        color: white;
        margin-right: 0.5rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('News Tags') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.news.index') }}">{{ __('News') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Tags') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-0">{{ __('Manage News Tags') }}</h5>
                    <p class="text-muted small mb-0">{{ __('Create, edit, and manage news article tags.') }}</p>
                </div>
                <a href="{{ route('admin.government.news-tags.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> {{ __('Add Tag') }}
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
                            <th>{{ __('Tag') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('News Count') }}</th>
                            <th style="width: 180px;">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tags as $tag)
                            <tr class="tag-list-item">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="tag-badge">{{ $tag->name }}</span>
                                        @if($tag->slug)
                                            <div class="small text-muted">{{ $tag->slug }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    {{ Str::limit($tag->description, 100) ?? __('No description') }}
                                </td>
                                <td>
                                    {{ $tag->news_count ?? $tag->news->count() }}
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.government.news-tags.show', $tag) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.government.news-tags.edit', $tag) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.government.news-tags.destroy', $tag) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this tag?') }}');">
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
                                        <i class="fas fa-tags text-muted mb-2" style="font-size: 2.5rem;"></i>
                                        <h5>{{ __('No news tags found') }}</h5>
                                        <p class="text-muted">{{ __('Start by adding your first news tag') }}</p>
                                        <a href="{{ route('admin.government.news-tags.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> {{ __('Add Tag') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @isset($tags->links)
                <div class="mt-3">
                    {{ $tags->links() }}
                </div>
            @endisset
        </div>
    </div>
</div>
@endsection 