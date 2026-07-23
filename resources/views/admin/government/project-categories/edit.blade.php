@extends('layouts.admin')

@section('title', __('Edit Project Category'))

@section('styles')
<style>
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .required::after {
        content: " *";
        color: red;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Edit Project Category') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.projects.index') }}">{{ __('Projects') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.project-categories.index') }}">{{ __('Categories') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Edit') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-folder me-1"></i>
            {{ __('Category Information') }}
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
            
            <form action="{{ route('admin.government.project-categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name" class="required">{{ __('Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">{{ __('The name of the category as it will appear on the site.') }}</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">{{ __('A brief description of the category (optional).') }}</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="icon">{{ __('Icon') }}</label>
                            <input type="file" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" accept="image/*">
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">{{ __('An optional icon for the category. Recommended size: 64x64px.') }}</small>
                            
                            <div id="icon-preview-container" class="mt-2">
                                @if($category->icon)
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('images/' . $category->icon) }}" alt="{{ $category->name }}" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                        <small class="text-muted ms-3">{{ __('Current icon. Upload a new one to replace it.') }}</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="slug" class="required">{{ __('Slug') }}</label>
                            <input type="text" class="form-control" id="slug" value="{{ $category->slug }}" disabled>
                            <small class="form-text text-muted">{{ __('The slug is automatically generated from the name and cannot be edited directly.') }}</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">{{ __('Status') }}</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="order">{{ __('Display Order') }}</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', $category->order) }}" min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">{{ __('Lower numbers will be displayed first. Use 0 for default ordering.') }}</small>
                        </div>
                        
                        <div class="card mb-3 mt-4">
                            <div class="card-header bg-light">
                                {{ __('Statistics') }}
                            </div>
                            <div class="card-body">
                                <div class="mb-0">
                                    <label class="fw-bold">{{ __('Projects') }}:</label>
                                    <p class="mb-0">{{ $category->projects_count ?? $category->projects->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.government.project-categories.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-times-circle me-1"></i> {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> {{ __('Update Category') }}
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
        // Icon preview
        const iconInput = document.getElementById('icon');
        const previewContainer = document.getElementById('icon-preview-container');
        const originalPreview = previewContainer.innerHTML;
        
        iconInput.addEventListener('change', function() {
            previewContainer.innerHTML = '';
            
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '100px';
                    img.style.maxHeight = '100px';
                    img.classList.add('mt-2', 'img-thumbnail');
                    previewContainer.appendChild(img);
                    
                    const note = document.createElement('small');
                    note.classList.add('text-muted', 'ms-3');
                    note.textContent = '{{ __("New icon selected (not saved yet)") }}';
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