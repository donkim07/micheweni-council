@extends('admin.layouts.app')

@section('title', __('Edit Project Image') . ' - ' . $project->title)

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('Edit Project Image') }}</h5>
            <a href="{{ route('admin.government.projects.images.index', $project) }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> {{ __('Back to Project Images') }}
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/' . $image->image) }}" alt="{{ $image->caption ?? $project->title }}" 
                             class="img-fluid rounded" style="max-height: 300px;">
                    </div>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('admin.government.projects.images.update', [$project, $image]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">{{ __('Replace Image') }}</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                            <div class="form-text">{{ __('Leave empty to keep the current image.') }}</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="caption" class="form-label">{{ __('Caption') }}</label>
                            <input type="text" class="form-control @error('caption') is-invalid @enderror" id="caption" name="caption" value="{{ old('caption', $image->caption) }}">
                            @error('caption')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="capture_date" class="form-label">{{ __('Capture Date') }}</label>
                            <input type="date" class="form-control @error('capture_date') is-invalid @enderror" id="capture_date" name="capture_date" value="{{ old('capture_date', $image->capture_date ? $image->capture_date->format('Y-m-d') : '') }}">
                            @error('capture_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="order" class="form-label">{{ __('Display Order') }}</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', $image->order) }}" min="1">
                            <div class="form-text">{{ __('Lower numbers will be displayed first.') }}</div>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash"></i> {{ __('Delete') }}
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ __('Update Image') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">{{ __('Delete Image') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('Are you sure you want to delete this image? This action cannot be undone.') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <form action="{{ route('admin.government.projects.images.destroy', [$project, $image]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 