@extends('layouts.admin')

@section('title', __('Create Category'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h2 class="section-heading">{{ __('Create New Category') }}</h2>
                            <p class="text-muted">{{ __('Add a new category for organizing content') }}</p>
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Categories') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Category Details') }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="slug" class="form-label">{{ __('Slug') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-link text-muted"></i>
                                </span>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" placeholder="{{ __('Will be generated automatically if left empty') }}">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text text-muted">{{ __('The slug is used in the URL of the category page. Leave blank to automatically generate from name.') }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="parent_id" class="form-label">{{ __('Parent Category') }}</label>
                            <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                                <option value="">{{ __('-- None (Top Level Category) --') }}</option>
                                @foreach($parentCategories as $id => $name)
                                    <option value="{{ $id }}" {{ old('parent_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted">{{ __('Selecting a parent category will create a hierarchy.') }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light">
                                {{ __('Reset') }}
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('Create Category') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Guidelines') }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info border-0">
                        <h6 class="alert-heading fw-bold mb-1">
                            <i class="fas fa-info-circle me-2"></i>{{ __('Category Information') }}
                        </h6>
                        <ul class="mb-0 ps-3 mt-2">
                            <li>{{ __('Categories help organize your content for easier navigation.') }}</li>
                            <li>{{ __('Each category can have multiple news articles.') }}</li>
                            <li>{{ __('Categories can be nested to create a hierarchy.') }}</li>
                            <li>{{ __('The slug will be used in URLs and must be unique.') }}</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-warning border-0 mt-3">
                        <h6 class="alert-heading fw-bold mb-1">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ __('Important Notes') }}
                        </h6>
                        <ul class="mb-0 ps-3 mt-2">
                            <li>{{ __('Categories cannot be deleted if they have news articles.') }}</li>
                            <li>{{ __('When deleting a category with children, child categories will be moved up a level.') }}</li>
                            <li>{{ __('Category names should be concise and descriptive.') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        
        nameInput.addEventListener('keyup', function() {
            // Only auto-generate slug if the slug field is empty
            if (slugInput.value === '') {
                // Convert to lowercase and replace spaces with dashes
                const slug = this.value.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') // Remove invalid characters
                    .replace(/\s+/g, '-')         // Replace spaces with dashes
                    .replace(/-+/g, '-');         // Replace multiple dashes with a single dash
                
                slugInput.value = slug;
            }
        });
    });
</script>
@endsection 