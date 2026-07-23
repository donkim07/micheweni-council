@extends('layouts.admin')

@section('title', 'Media Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Media Details</h1>
        <div>
            <a href="{{ route('admin.government.media.edit', $media->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit fa-sm"></i> Edit Media
            </a>
            <a href="{{ route('admin.government.media.index') }}" class="btn btn-sm btn-secondary ml-2">
                <i class="fas fa-arrow-left fa-sm"></i> Back to Media
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Media Preview</h6>
                    <span class="badge {{ $media->status == 'active' ? 'badge-success' : 'badge-danger' }}">{{ ucfirst($media->status) }}</span>
                </div>
                <div class="card-body">
                    @if($media->type == 'image')
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/' . $media->file_path) }}" class="img-fluid" style="max-height: 400px;" alt="{{ $media->title }}">
                        </div>
                    @elseif($media->type == 'video')
                        <div class="text-center mb-4">
                            @if(strpos($media->file_path, 'youtube.com') !== false || strpos($media->file_path, 'youtu.be') !== false)
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="{{ $media->file_path }}" allowfullscreen></iframe>
                                </div>
                            @else
                                <video controls class="img-fluid" style="max-height: 400px;">
                                    <source src="{{ asset('images/' . $media->file_path) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        </div>
                    @elseif($media->type == 'document')
                        <div class="text-center mb-4">
                            @if($media->thumbnail_path)
                                <img src="{{ asset('images/' . $media->thumbnail_path) }}" class="img-thumbnail" style="max-height: 200px;" alt="{{ $media->title }}">
                            @endif
                            <div class="mt-3">
                                <a href="{{ asset('images/' . $media->file_path) }}" class="btn btn-primary" target="_blank">
                                    <i class="fas fa-file-download mr-1"></i> Download Document
                                </a>
                            </div>
                        </div>
                    @endif
                    
                    <h4 class="font-weight-bold">{{ $media->title }}</h4>
                    
                    @if($media->description)
                        <div class="mt-3">
                            <h6 class="font-weight-bold">Description</h6>
                            <p>{{ $media->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Media Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Media Information</h6>
                </div>
                <div class="card-body">
                    <div class="media-info-item">
                        <span class="font-weight-bold">Type:</span> 
                        <span class="badge badge-info">{{ ucfirst($media->type) }}</span>
                    </div>
                    
                    @if($media->category)
                    <div class="media-info-item mt-2">
                        <span class="font-weight-bold">Category:</span> 
                        <span>{{ ucfirst($media->category) }}</span>
                    </div>
                    @endif
                    
                    @if($media->model_type && $media->model_id)
                    <div class="media-info-item mt-2">
                        <span class="font-weight-bold">Related To:</span>
                        @if(strpos($media->model_type, 'Project') !== false && $media->project)
                            <a href="{{ route('admin.government.projects.show', $media->model_id) }}">
                                {{ $media->project->title ?? 'Project #'.$media->model_id }}
                            </a>
                        @elseif(strpos($media->model_type, 'News') !== false && $media->news)
                            <a href="{{ route('admin.government.news.show', $media->model_id) }}">
                                {{ $media->news->title ?? 'News #'.$media->model_id }}
                            </a>
                        @else
                            {{ class_basename($media->model_type) ?? 'Unknown' }} #{{ $media->model_id }}
                        @endif
                    </div>
                    @endif
                    
                    <div class="media-info-item mt-2">
                        <span class="font-weight-bold">File:</span>
                        <small class="d-block text-muted">{{ $media->file_path }}</small>
                    </div>
                    
                    <div class="media-info-item mt-2">
                        <span class="font-weight-bold">Featured:</span> 
                        <span>{{ $media->is_featured ? 'Yes' : 'No' }}</span>
                    </div>
                    
                    <div class="media-info-item mt-2">
                        <span class="font-weight-bold">Created:</span> 
                        <span>{{ $media->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    
                    <div class="media-info-item mt-2">
                        <span class="font-weight-bold">Updated:</span> 
                        <span>{{ $media->updated_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Actions Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.government.media.edit', $media->id) }}" class="btn btn-primary btn-block">
                        <i class="fas fa-edit fa-sm"></i> Edit Media
                    </a>
                    
                    @if($media->type == 'image' || $media->type == 'document')
                    <a href="{{ asset('images/' . $media->file_path) }}" class="btn btn-info btn-block mt-2" target="_blank" download>
                        <i class="fas fa-download fa-sm"></i> Download File
                    </a>
                    @endif
                    
                    <button type="button" class="btn btn-danger btn-block mt-2" data-toggle="modal" data-target="#deleteModal">
                        <i class="fas fa-trash fa-sm"></i> Delete Media
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Media</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this media? This action cannot be undone.</p>
                <p><strong>Title:</strong> {{ $media->title }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.government.media.destroy', $media->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .media-info-item {
        margin-bottom: 8px;
    }
</style>
@endsection 