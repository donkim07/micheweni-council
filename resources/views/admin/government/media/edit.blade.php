@extends('layouts.admin')

@section('title', __('Edit Media'))

@section('styles')
<style>
    .preview-container {
        position: relative;
        margin-top: 15px;
        max-width: 300px;
    }
    
    .preview-container img {
        max-width: 100%;
        border-radius: 5px;
    }
    
    .preview-container video {
        max-width: 100%;
        border-radius: 5px;
    }
    
    .preview-placeholder {
        width: 100%;
        height: 200px;
        border-radius: 5px;
        background-color: #f7f7f7;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #888;
        font-size: 18px;
    }
</style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Edit Media') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Government') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.government.media.index') }}">{{ __('Media Gallery') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Edit') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('Edit Media') }}</h5>
                <a href="{{ route('admin.government.media.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> {{ __('Back to Media Gallery') }}
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.government.media.update', $media) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('Title') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $media->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('Description') }}</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $media->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">{{ __('Media Type') }} <span class="text-danger">*</span></label>
                                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                            <option value="image" {{ old('type', $media->type) == 'image' ? 'selected' : '' }}>{{ __('Image') }}</option>
                                            <option value="video" {{ old('type', $media->type) == 'video' ? 'selected' : '' }}>{{ __('Video') }}</option>
                                            <option value="document" {{ old('type', $media->type) == 'document' ? 'selected' : '' }}>{{ __('Document') }}</option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                            <option value="active" {{ old('status', $media->status) == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                            <option value="inactive" {{ old('status', $media->status) == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="file" class="form-label">{{ __('Replace File') }}</label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file">
                                <div class="form-text">{{ __('Leave empty to keep the current file. Max file size: 20MB') }}</div>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div id="thumbnail-container" class="mb-3" style="{{ in_array($media->type, ['video', 'document']) ? '' : 'display: none;' }}">
                                <label for="thumbnail" class="form-label">{{ __('Replace Thumbnail') }}</label>
                                <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail" accept="image/*">
                                <div class="form-text">{{ __('Leave empty to keep the current thumbnail. Max file size: 2MB') }}</div>
                                @error('thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">{{ __('Additional Options') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $media->is_featured) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">{{ __('Featured Media') }}</label>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="order" class="form-label">{{ __('Display Order') }}</label>
                                        <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', $media->order) }}" min="0">
                                        @error('order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="category" class="form-label">{{ __('Media Category') }}</label>
                                        <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                                            <option value="">{{ __('None') }}</option>
                                            <option value="project" {{ old('category', $media->category) == 'project' ? 'selected' : '' }}>{{ __('Project') }}</option>
                                            <option value="news" {{ old('category', $media->category) == 'news' ? 'selected' : '' }}>{{ __('News') }}</option>
                                            <option value="event" {{ old('category', $media->category) == 'event' ? 'selected' : '' }}>{{ __('Event') }}</option>
                                            <option value="gallery" {{ old('category', $media->category) == 'gallery' ? 'selected' : '' }}>{{ __('Gallery') }}</option>
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div id="project-container" class="mb-3" style="{{ $media->category == 'project' ? '' : 'display: none;' }}">
                                        <label for="related_id" class="form-label">{{ __('Select Project') }}</label>
                                        <select class="form-select" id="project_id" name="related_id">
                                            <option value="">{{ __('Select Project') }}</option>
                                            @if(isset($projects) && count($projects) > 0)
                                                @foreach($projects as $project)
                                                    <option value="{{ $project->id }}" {{ (old('related_id', $media->model_id) == $project->id && old('related_type', $media->model_type) == \App\Models\Government\Project::class) ? 'selected' : '' }}>{{ $project->title }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <input type="hidden" name="related_type" id="related_type" value="{{ old('related_type', $media->model_type) }}">
                                    </div>
                                    
                                    <div id="news-container" class="mb-3" style="{{ $media->category == 'news' ? '' : 'display: none;' }}">
                                        <label for="related_id" class="form-label">{{ __('Select News') }}</label>
                                        <select class="form-select" id="news_id" name="related_id">
                                            <option value="">{{ __('Select News') }}</option>
                                            @if(isset($news) && count($news) > 0)
                                                @foreach($news as $item)
                                                    <option value="{{ $item->id }}" {{ (old('related_id', $media->model_id) == $item->id && old('related_type', $media->model_type) == \App\Models\Government\News::class) ? 'selected' : '' }}>{{ $item->title }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="preview-container mt-4">
                                <h6>{{ __('Current Preview') }}</h6>
                                @if($media->type == 'image')
                                    <img src="{{ asset('images/' . $media->file_path) }}" alt="{{ $media->title }}" class="img-thumbnail">
                                @elseif($media->type == 'video')
                                    @if($media->thumbnail_path)
                                        <img src="{{ asset('images/' . $media->thumbnail_path) }}" alt="{{ $media->title }}" class="img-thumbnail">
                                    @else
                                        <div class="preview-placeholder">
                                            <i class="fas fa-video fa-2x"></i>
                                        </div>
                                    @endif
                                @elseif($media->type == 'document')
                                    @if($media->thumbnail_path)
                                        <img src="{{ asset('images/' . $media->thumbnail_path) }}" alt="{{ $media->title }}" class="img-thumbnail">
                                    @else
                                        <div class="preview-placeholder">
                                            <i class="fas fa-file fa-2x"></i>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ __('Update Media') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Show/hide thumbnail field based on media type
        $('#type').on('change', function() {
            const type = $(this).val();
            if (type === 'video' || type === 'document') {
                $('#thumbnail-container').show();
            } else {
                $('#thumbnail-container').hide();
            }
        });
        
        // Show/hide related entity fields based on category
        $('#category').on('change', function() {
            const category = $(this).val();
            $('#project-container, #news-container').hide();
            $('#related_type').val('');
            
            if (category === 'project') {
                $('#project-container').show();
                $('#related_type').val('{{ \App\Models\Government\Project::class }}');
            } else if (category === 'news') {
                $('#news-container').show();
                $('#related_type').val('{{ \App\Models\Government\News::class }}');
            }
        });
        
        // File preview
        $('#file').on('change', function() {
            const file = this.files[0];
            const reader = new FileReader();
            const type = $('#type').val();
            const previewContainer = $('.preview-container');
            
            previewContainer.find('img, video, .preview-placeholder').remove();
            
            if (file) {
                reader.onload = function(e) {
                    if (type === 'image' && file.type.match('image.*')) {
                        previewContainer.append(`<img src="${e.target.result}" alt="Preview" class="img-thumbnail">`);
                    } else if (type === 'video' && file.type.match('video.*')) {
                        previewContainer.append(`<div class="preview-placeholder"><i class="fas fa-video fa-2x"></i><br>${file.name}</div>`);
                    } else {
                        previewContainer.append(`<div class="preview-placeholder"><i class="fas fa-file fa-2x"></i><br>${file.name}</div>`);
                    }
                }
                reader.readAsDataURL(file);
            }
        });
        
        // Thumbnail preview
        $('#thumbnail').on('change', function() {
            const file = this.files[0];
            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('.preview-container').find('img, .preview-placeholder').remove();
                    $('.preview-container').append(`<img src="${e.target.result}" alt="Thumbnail Preview" class="img-thumbnail">`);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection 