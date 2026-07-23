@extends('layouts.admin')

@section('title', __('Edit Publication'))

@section('styles')
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
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Edit Publication') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.publications.index') }}">{{ __('Publications') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Edit') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-file-pdf me-1"></i>
            {{ __('Publication Information') }}
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
            
            <form action="{{ route('admin.government.publications.update', $publication) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="title" class="required">{{ __('Title') }}</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $publication->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $publication->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="file_path">{{ __('Publication File') }}</label>
                            <input type="file" class="form-control @error('file_path') is-invalid @enderror" id="file_path" name="file_path" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                            @error('file_path')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">{{ __('Accepted file types: PDF, Word, Excel, PowerPoint') }}</small>
                            
                            @if($publication->file_path)
                                <div class="mt-2">
                                    <strong>{{ __('Current File') }}:</strong>
                                    <a href="{{ asset('images/' . $publication->file_path) }}" target="_blank" class="ms-2">
                                        <i class="fas fa-file me-1"></i> {{ __('View File') }}
                                    </a>
                                    <small class="text-muted ms-2">{{ __('Leave empty to keep the current file') }}</small>
                                </div>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="slug" class="required">{{ __('Slug') }}</label>
                            <input type="text" class="form-control" id="slug" value="{{ $publication->slug }}" disabled>
                            <small class="form-text text-muted">{{ __('The slug is automatically generated from the title and cannot be edited directly.') }}</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category" class="required">{{ __('Category') }}</label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="">{{ __('Select Category') }}</option>
                                <option value="report" {{ old('category', $publication->category) == 'report' ? 'selected' : '' }}>{{ __('Report') }}</option>
                                <option value="policy" {{ old('category', $publication->category) == 'policy' ? 'selected' : '' }}>{{ __('Policy') }}</option>
                                <option value="form" {{ old('category', $publication->category) == 'form' ? 'selected' : '' }}>{{ __('Form') }}</option>
                                <option value="brochure" {{ old('category', $publication->category) == 'brochure' ? 'selected' : '' }}>{{ __('Brochure') }}</option>
                                <option value="newsletter" {{ old('category', $publication->category) == 'newsletter' ? 'selected' : '' }}>{{ __('Newsletter') }}</option>
                                <option value="other" {{ old('category', $publication->category) == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="published_date">{{ __('Publication Date') }}</label>
                            <input type="date" class="form-control @error('published_date') is-invalid @enderror" id="published_date" name="published_date" value="{{ old('published_date', $publication->published_date ? $publication->published_date->format('Y-m-d') : '') }}">
                            @error('published_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="status" class="required">{{ __('Status') }}</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status', $publication->status) == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="inactive" {{ old('status', $publication->status) == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="cover_image">{{ __('Cover Image') }}</label>
                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" accept="image/*">
                            @error('cover_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <div id="image-preview-container">
                                @if($publication->cover_image)
                                    <div class="mt-2">
                                        <img src="{{ asset('images/' . $publication->cover_image) }}" alt="{{ $publication->title }}" class="image-preview">
                                        <small class="d-block text-muted">{{ __('Leave empty to keep the current image') }}</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input @error('is_featured') is-invalid @enderror" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $publication->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    {{ __('Feature this publication') }}
                                </label>
                                @error('is_featured')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="order">{{ __('Display Order') }}</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', $publication->order) }}" min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">{{ __('Lower numbers appear first (0 = use default order)') }}</small>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.government.publications.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-times-circle me-1"></i> {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> {{ __('Update Publication') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview
        const imageInput = document.getElementById('cover_image');
        const previewContainer = document.getElementById('image-preview-container');
        const originalPreview = previewContainer.innerHTML;
        
        imageInput.addEventListener('change', function() {
            previewContainer.innerHTML = '';
            
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('image-preview', 'mt-2');
                    previewContainer.appendChild(img);
                    
                    const note = document.createElement('small');
                    note.classList.add('d-block', 'text-muted');
                    note.textContent = '{{ __("New image selected (not saved yet)") }}';
                    previewContainer.appendChild(note);
                }
                
                reader.readAsDataURL(this.files[0]);
            } else {
                previewContainer.innerHTML = originalPreview;
            }
        });
    });
</script>
@endsection