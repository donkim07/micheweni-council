@extends('layouts.admin')

@section('title', __('Create Department'))

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
    .preview-image {
        max-width: 100%;
        max-height: 200px;
        border-radius: 5px;
        margin-top: 10px;
    }
    
    .required-label::after {
        content: " *";
        color: red;
    }
    
    .note-editor {
        border-color: #ced4da !important;
        border-radius: 0.25rem !important;
    }
    
    .image-preview-container {
        position: relative;
        display: inline-block;
    }
    
    .image-preview-container .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Create Department') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.departments.index') }}">{{ __('Departments') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Create') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.government.departments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5>{{ __('Basic Information') }}</h5>
                        <hr>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label required-label">{{ __('Department Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('This will be used to generate the URL slug automatically.') }}</div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="status" class="form-label required-label">{{ __('Status') }}</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="order" class="form-label">{{ __('Display Order') }}</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', 0) }}" min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('Lower numbers will be displayed first. Leave as 0 for automatic ordering.') }}</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="featured_image" class="form-label">{{ __('Featured Image') }}</label>
                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror" id="featured_image" name="featured_image" accept="image/*">
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('Recommended size: 800x600 pixels, max 2MB.') }}</div>
                            <div id="featured_image_preview" class="image-preview-container mt-2"></div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="location" class="form-label">{{ __('Location') }}</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="category" class="form-label required-label">{{ __('Category') }}</label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="department" {{ old('category') == 'department' ? 'selected' : '' }}>{{ __('Department') }}</option>
                                <option value="division" {{ old('category') == 'division' ? 'selected' : '' }}>{{ __('Division') }}</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control summernote @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4 mt-4">
                    <div class="col-md-12">
                        <h5>{{ __('Department Head Information') }}</h5>
                        <hr>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="head_name" class="form-label">{{ __('Head Name') }}</label>
                            <input type="text" class="form-control @error('head_name') is-invalid @enderror" id="head_name" name="head_name" value="{{ old('head_name') }}">
                            @error('head_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="head_title" class="form-label">{{ __('Head Title/Position') }}</label>
                            <input type="text" class="form-control @error('head_title') is-invalid @enderror" id="head_title" name="head_title" value="{{ old('head_title') }}">
                            @error('head_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('E.g., Director, Manager, Chief, etc.') }}</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="head_image" class="form-label">{{ __('Head Photo') }}</label>
                            <input type="file" class="form-control @error('head_image') is-invalid @enderror" id="head_image" name="head_image" accept="image/*">
                            @error('head_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('Recommended size: 400x400 pixels, max 2MB.') }}</div>
                            <div id="head_image_preview" class="image-preview-container mt-2"></div>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4 mt-4">
                    <div class="col-md-12">
                        <h5>{{ __('Contact Information') }}</h5>
                        <hr>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="contact_email" class="form-label">{{ __('Contact Email') }}</label>
                            <input type="email" class="form-control @error('contact_email') is-invalid @enderror" id="contact_email" name="contact_email" value="{{ old('contact_email') }}">
                            @error('contact_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="contact_phone" class="form-label">{{ __('Contact Phone') }}</label>
                            <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}">
                            @error('contact_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.government.departments.index') }}" class="btn btn-secondary me-2">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('Create Department') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Summernote

        
        // Image preview functionality
        function setupImagePreview(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            
            if (input && preview) {
                input.addEventListener('change', function() {
                    preview.innerHTML = '';
                    
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            const container = document.createElement('div');
                            container.className = 'image-preview-container';
                            
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'preview-image';
                            
                            const removeBtn = document.createElement('div');
                            removeBtn.className = 'remove-image';
                            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                            removeBtn.addEventListener('click', function() {
                                input.value = '';
                                preview.innerHTML = '';
                            });
                            
                            container.appendChild(img);
                            container.appendChild(removeBtn);
                            preview.appendChild(container);
                        }
                        
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }
        }
        
        setupImagePreview('featured_image', 'featured_image_preview');
        setupImagePreview('head_image', 'head_image_preview');
    });
</script>
@endsection 