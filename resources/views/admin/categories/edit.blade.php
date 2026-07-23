@extends('layouts.admin')

@section('title', __('Edit Category'))

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
                            <h2 class="section-heading">{{ __('Edit Category') }}</h2>
                            <p class="text-muted">{{ __('Update category information for :name', ['name' => $category->name]) }}</p>
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
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="name" class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" required>
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
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $category->slug) }}">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text text-muted">{{ __('The slug is used in the URL of the category page.') }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="parent_id" class="form-label">{{ __('Parent Category') }}</label>
                            <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                                <option value="">{{ __('-- None (Top Level Category) --') }}</option>
                                @foreach($parentCategories as $id => $name)
                                    <option value="{{ $id }}" {{ old('parent_id', $category->parent_id) == $id ? 'selected' : '' }}>
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
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-2"></i>{{ __('Delete Category') }}
                            </button>
                            
                            <div>
                                <button type="reset" class="btn btn-light me-2">
                                    {{ __('Reset') }}
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>{{ __('Update Category') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">{{ __('Delete Category') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center mb-4">
                                        <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                                        <h5 class="mb-2">{{ __('Are you sure you want to delete this category?') }}</h5>
                                        <p class="text-muted mb-0">{{ $category->name }}</p>
                                    </div>
                                    
                                    @if($category->news()->count() > 0)
                                        <div class="alert alert-danger">
                                            <i class="fas fa-exclamation-circle me-2"></i>
                                            {{ __('Cannot delete category with associated news articles. Reassign articles first.') }}
                                        </div>
                                    @endif
                                    
                                    @if($category->children()->count() > 0)
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            {{ __('This category has') }} <strong>{{ $category->children()->count() }}</strong> {{ __('child categories that will be updated to reference the parent\'s parent.') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" {{ $category->news()->count() > 0 ? 'disabled' : '' }}>
                                            {{ __('Delete Category') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Category Information') }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-box bg-primary-soft rounded-circle p-3 me-3">
                            <i class="fas fa-tag fa-lg text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">{{ $category->name }}</h6>
                            <div class="text-muted small">{{ $category->slug }}</div>
                        </div>
                    </div>
                    
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-top">
                            <span>{{ __('News Articles') }}</span>
                            <span class="badge rounded-pill bg-primary-soft text-primary">{{ $category->news()->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span>{{ __('Child Categories') }}</span>
                            <span class="badge rounded-pill bg-info-soft text-info">{{ $category->children()->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span>{{ __('Created') }}</span>
                            <span class="text-muted">{{ $category->created_at->format('M d, Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span>{{ __('Last Updated') }}</span>
                            <span class="text-muted">{{ $category->updated_at->format('M d, Y') }}</span>
                        </li>
                    </ul>
                    
                    <div class="alert alert-warning border-0">
                        <h6 class="alert-heading fw-bold mb-1">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ __('Important') }}
                        </h6>
                        <p class="mb-0 mt-2">{{ __('Categories cannot be deleted if they have news articles. Reassign articles first.') }}</p>
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
        const originalSlug = '{{ $category->slug }}';
        
        nameInput.addEventListener('keyup', function() {
            // Only auto-generate slug if the slug hasn't been manually edited
            if (slugInput.value === originalSlug) {
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