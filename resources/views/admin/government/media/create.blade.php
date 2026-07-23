@extends('layouts.admin')

@section('title', __('Add Media'))

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" integrity="sha512-WvVX1YO12zmsvTpUQV8s7ZU98DnkaAokcciMZJfnNWyNzm7//QRV61t4aEr0WdIa4pe854QHLTV302vH92FSMw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .required::after {
        content: " *";
        color: red;
    }
    
    .image-preview {
        max-width: 100%;
        max-height: 200px;
        margin-top: 10px;
        border-radius: 5px;
    }
    
    .preview-container {
        position: relative;
        margin-top: 15px;
    }
    
    .preview-container img {
        max-width: 100%;
        border-radius: 5px;
        margin-bottom: 10px;
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
    
    .dropzone {
        border: 2px dashed #0087F7;
        border-radius: 5px;
        background: #f8fafc;
        min-height: 200px;
    }
    
    .dropzone .dz-message {
        font-weight: 400;
    }
    
    .dropzone .dz-preview .dz-image {
        border-radius: 8px;
    }
</style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Add Media') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Government') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.government.media.index') }}">{{ __('Media Gallery') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Add Media') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('Add New Media') }}</h5>
                <a href="{{ route('admin.government.media.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> {{ __('Back to Media') }}
                </a>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs mb-4" id="mediaTypeTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" type="button" role="tab" aria-controls="images" aria-selected="true">{{ __('Images') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="videos-tab" data-bs-toggle="tab" data-bs-target="#videos" type="button" role="tab" aria-controls="videos" aria-selected="false">{{ __('Videos') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab" aria-controls="documents" aria-selected="false">{{ __('Documents') }}</button>
                    </li>
                </ul>
                
                <div class="tab-content" id="mediaTypeTabContent">
                    <!-- Images Tab -->
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Add Media') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.media.index') }}">{{ __('Media Gallery') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Add') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-photo-video me-1"></i>
            {{ __('Media Information') }}
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('admin.government.media.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="title" class="required">{{ __('Title') }}</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type" class="required">{{ __('Media Type') }}</label>
                                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="">{{ __('Select Type') }}</option>
                                        <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>{{ __('Image') }}</option>
                                        <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>{{ __('Video') }}</option>
                                        <option value="document" {{ old('type') == 'document' ? 'selected' : '' }}>{{ __('Document') }}</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="required">{{ __('Status') }}</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="file" class="form-label">{{ __('Upload Files') }} <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('files') is-invalid @enderror" id="file" name="files[]" multiple>
                            <div class="form-text">{{ __('You can upload multiple files at once. Max file size: 20MB per file') }}</div>
                            @error('files')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div id="thumbnail-container" class="form-group" style="display: none;">
                            <label for="thumbnail">{{ __('Thumbnail') }}</label>
                            <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail" accept="image/*">
                            <div class="form-text">{{ __('For videos and documents, upload a thumbnail image. Max file size: 2MB') }}</div>
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category">{{ __('Category') }}</label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                                <option value="">{{ __('None') }}</option>
                                <option value="project" {{ old('category') == 'project' ? 'selected' : '' }}>{{ __('Project') }}</option>
                                <option value="news" {{ old('category') == 'news' ? 'selected' : '' }}>{{ __('News') }}</option>
                                <option value="event" {{ old('category') == 'event' ? 'selected' : '' }}>{{ __('Event') }}</option>
                                <option value="gallery" {{ old('category') == 'gallery' ? 'selected' : '' }}>{{ __('Gallery') }}</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="tags">{{ __('Tags') }}</label>
                            <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" value="{{ old('tags') }}" placeholder="tag1, tag2, tag3">
                            @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">{{ __('Separate tags with commas.') }}</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="order">{{ __('Display Order') }}</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', 0) }}" min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input @error('is_featured') is-invalid @enderror" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    {{ __('Featured Media') }}
                                </label>
                                @error('is_featured')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div id="project-container" class="form-group" style="display: none;">
                            <label for="related_id">{{ __('Select Project') }}</label>
                            <select class="form-select" id="project_id" name="related_id">
                                <option value="">{{ __('Select Project') }}</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('related_id') == $project->id && old('related_type') == 'project' ? 'selected' : '' }}>{{ $project->title }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="related_type" id="related_type" value="{{ old('related_type') }}">
                        </div>
                        
                        <div id="news-container" class="form-group" style="display: none;">
                            <label for="related_id">{{ __('Select News') }}</label>
                            <select class="form-select" id="news_id" name="related_id">
                                <option value="">{{ __('Select News') }}</option>
                                @foreach($news as $item)
                                    <option value="{{ $item->id }}" {{ old('related_id') == $item->id && old('related_type') == 'news' ? 'selected' : '' }}>{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.government.media.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-times-circle me-1"></i> {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> {{ __('Save Media') }}
                    </button>
                </div>
            </form>
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
                $('#related_type').val('project');
            } else if (category === 'news') {
                $('#news-container').show();
                $('#related_type').val('news');
            }
        });
        
        // Initialize hidden fields based on existing values
        if ($('#type').val() === 'video' || $('#type').val() === 'document') {
            $('#thumbnail-container').show();
        }
        
        const category = $('#category').val();
        if (category === 'project') {
            $('#project-container').show();
            $('#related_type').val('project');
        } else if (category === 'news') {
            $('#news-container').show();
            $('#related_type').val('news');
        }
        
        // File preview
        $('#file').on('change', function() {
            const file = this.files[0];
            const reader = new FileReader();
            const type = $('#type').val();
            const previewContainer = $('.preview-container');
            
            $('.preview-placeholder').remove();
            previewContainer.find('img, video').remove();
            
            if (file) {
                reader.onload = function(e) {
                    if (type === 'image' && file.type.match('image.*')) {
                        previewContainer.append(`<img src="${e.target.result}" alt="Preview">`);
                    } else if (type === 'video' && file.type.match('video.*')) {
                        previewContainer.append(`<video controls><source src="${e.target.result}" type="${file.type}"></video>`);
                    } else {
                        previewContainer.append(`<div class="preview-placeholder"><i class="fas fa-file fa-2x"></i><br>${file.name}</div>`);
                    }
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.append(`<div class="preview-placeholder"><i class="fas fa-file fa-2x"></i></div>`);
            }
        });
        
        // Thumbnail preview
        $('#thumbnail').on('change', function() {
            const file = this.files[0];
            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('.preview-container').find('img').remove();
                    $('.preview-container').append(`<img src="${e.target.result}" alt="Thumbnail Preview">`);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection