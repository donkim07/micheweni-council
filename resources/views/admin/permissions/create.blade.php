@extends('layouts.admin')

@section('title', __('Create Permission'))

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
                            <h2 class="section-heading">{{ __('Create New Permission') }}</h2>
                            <p class="text-muted">{{ __('Define a new permission for the system') }}</p>
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Permissions') }}
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
                    <h5 class="mb-0 fw-bold">{{ __('Permission Details') }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.permissions.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="form-label">{{ __('Permission Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('Example: View Users, Edit Posts, etc.') }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="slug" class="form-label">{{ __('Slug') }}</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('Leave blank to auto-generate from name. Example: view-users, edit-posts') }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="module" class="form-label">{{ __('Module') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('module') is-invalid @enderror" id="module" name="module" value="{{ old('module') }}" list="module-list">
                                <datalist id="module-list">
                                    @foreach($modules as $module)
                                        <option value="{{ $module }}">
                                    @endforeach
                                </datalist>
                            </div>
                            @error('module')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('Group permissions by module. Example: Users, Posts, Dashboard') }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('Briefly explain what this permission allows.') }}</div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light">
                                {{ __('Reset') }}
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('Create Permission') }}
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
                            <i class="fas fa-info-circle me-2"></i>{{ __('Permission Naming') }}
                        </h6>
                        <ul class="mb-0 ps-3 mt-2">
                            <li>{{ __('Use clear, descriptive names') }}</li>
                            <li>{{ __('Follow the format: Action Resource') }}</li>
                            <li>{{ __('Example: View Users, Edit Posts, Delete Comments') }}</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-warning border-0 mt-3">
                        <h6 class="alert-heading fw-bold mb-1">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ __('Important Notes') }}
                        </h6>
                        <ul class="mb-0 ps-3 mt-2">
                            <li>{{ __('Permissions must be assigned to roles to take effect.') }}</li>
                            <li>{{ __('Use modules to organize permissions logically.') }}</li>
                            <li>{{ __('Consider using the Generate Defaults option for standard permissions.') }}</li>
                        </ul>
                    </div>
                    
                    <div class="mt-4">
                        <h6 class="fw-bold mb-3">{{ __('Common Permission Types') }}</h6>
                        <div class="row">
                            <div class="col-6 mb-2">
                                <span class="badge bg-light text-dark py-2 px-3 w-100 text-start">
                                    <i class="fas fa-eye me-2 text-primary"></i> View
                                </span>
                            </div>
                            <div class="col-6 mb-2">
                                <span class="badge bg-light text-dark py-2 px-3 w-100 text-start">
                                    <i class="fas fa-plus me-2 text-success"></i> Create
                                </span>
                            </div>
                            <div class="col-6 mb-2">
                                <span class="badge bg-light text-dark py-2 px-3 w-100 text-start">
                                    <i class="fas fa-edit me-2 text-info"></i> Edit
                                </span>
                            </div>
                            <div class="col-6 mb-2">
                                <span class="badge bg-light text-dark py-2 px-3 w-100 text-start">
                                    <i class="fas fa-trash me-2 text-danger"></i> Delete
                                </span>
                            </div>
                        </div>
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
        // Auto-generate slug from name
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        
        nameInput.addEventListener('keyup', function() {
            if (slugInput.value === '') {
                slugInput.value = nameInput.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            }
        });
    });
</script>
@endsection 