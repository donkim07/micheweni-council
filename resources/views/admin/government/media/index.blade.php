@extends('layouts.admin')

@section('title', __('Government Media Gallery'))

@section('styles')
<style>
    .filter-form {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .media-card {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .media-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .media-thumbnail {
        height: 180px;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
    }
    
    .media-thumbnail-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .media-card:hover .media-thumbnail-overlay {
        opacity: 1;
    }
    
    .media-thumbnail-actions {
        display: flex;
        gap: 10px;
    }
    
    .media-thumbnail-actions .btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: white;
        color: #333;
        border: none;
        transition: background 0.3s, color 0.3s;
    }
    
    .media-thumbnail-actions .btn:hover {
        background: #007bff;
        color: white;
    }
    
    .media-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 2;
    }
    
    .media-info {
        padding: 15px;
        background: white;
    }
    
    .media-title {
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .media-meta {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Government Media Gallery') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Government') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Media Gallery') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">{{ __('All Media') }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.government.media.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('Add New Media') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filters -->
                        <div class="filter-form">
                            <form action="{{ route('admin.government.media.index') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="type">{{ __('Media Type') }}</label>
                                            <select name="type" id="type" class="form-control">
                                                <option value="">{{ __('All Types') }}</option>
                                                <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>{{ __('Images') }}</option>
                                                <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>{{ __('Videos') }}</option>
                                                <option value="document" {{ request('type') == 'document' ? 'selected' : '' }}>{{ __('Documents') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="category">{{ __('Category') }}</label>
                                            <select name="category" id="category" class="form-control">
                                                <option value="">{{ __('All Categories') }}</option>
                                                <option value="project" {{ request('category') == 'project' ? 'selected' : '' }}>{{ __('Projects') }}</option>
                                                <option value="news" {{ request('category') == 'news' ? 'selected' : '' }}>{{ __('News') }}</option>
                                                <option value="event" {{ request('category') == 'event' ? 'selected' : '' }}>{{ __('Events') }}</option>
                                                <option value="gallery" {{ request('category') == 'gallery' ? 'selected' : '' }}>{{ __('Gallery') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">{{ __('Status') }}</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="">{{ __('All Status') }}</option>
                                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="search">{{ __('Search') }}</label>
                                            <div class="input-group">
                                                <input type="text" name="search" id="search" class="form-control" placeholder="{{ __('Search title...') }}" value="{{ request('search') }}">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Media Grid -->
                        @if(count($media) > 0)
                            <div class="media-grid">
                                @foreach($media as $item)
                                    <div class="media-card">
                                        @if($item->is_featured)
                                            <div class="media-badge">
                                                <span class="badge bg-primary">{{ __('Featured') }}</span>
                                            </div>
                                        @endif
                                        
                                        <div class="media-thumbnail" style="background-image: url('{{ asset('images/' . ($item->type == 'image' ? $item->file_path : ($item->thumbnail_path ?? 'media/default-' . $item->type . '.jpg'))) }}');">
                                            <div class="media-thumbnail-overlay">
                                                <div class="media-thumbnail-actions">
                                                    <a href="{{ route('admin.government.media.show', $item->id) }}" class="btn" title="{{ __('View') }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.government.media.edit', $item->id) }}" class="btn" title="{{ __('Edit') }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.government.media.destroy', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn" onclick="return confirm('{{ __('Are you sure you want to delete this media?') }}')" title="{{ __('Delete') }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="media-info">
                                            <h5 class="media-title" title="{{ $item->title }}">{{ $item->title }}</h5>
                                            <div class="media-meta">
                                                <span>
                                                    @if($item->type == 'image')
                                                        <i class="fas fa-image text-success"></i>
                                                    @elseif($item->type == 'video')
                                                        <i class="fas fa-video text-primary"></i>
                                                    @else
                                                        <i class="fas fa-file-alt text-warning"></i>
                                                    @endif
                                                    {{ ucfirst($item->type) }}
                                                </span>
                                                <span class="text-{{ $item->status == 'active' ? 'success' : 'danger' }}">{{ ucfirst($item->status) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-4">
                                {{ $media->withQueryString()->links() }}
                            </div>
                        @else
                            <div class="alert alert-info">
                                {{ __('No media found. Click the "Add New Media" button to upload.') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 