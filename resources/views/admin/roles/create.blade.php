@extends('layouts.admin')

@section('title', __('Create Role'))

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
                            <h2 class="section-heading">{{ __('Create New Role') }}</h2>
                            <p class="text-muted">{{ __('Define a new role with specific permissions') }}</p>
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Roles') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Role Details') }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.roles.store') }}" method="POST" id="roleForm">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="form-label">{{ __('Role Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="slug" class="form-label">{{ __('Slug') }}</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('Leave blank to auto-generate from name.') }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('Create Role') }}
                            </button>
                            <button type="reset" class="btn btn-light">
                                {{ __('Reset') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Quick Actions') }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary" id="selectAllPermissions">
                            <i class="fas fa-check-square me-2"></i>{{ __('Select All Permissions') }}
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="deselectAllPermissions">
                            <i class="fas fa-square me-2"></i>{{ __('Deselect All Permissions') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Permissions') }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info border-0 mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ __('Select the permissions you want to assign to this role. Users with this role will have these permissions.') }}
                    </div>
                    
                    <div class="accordion" id="permissionsAccordion">
                        @foreach($permissions as $module => $modulePermissions)
                            <div class="accordion-item border-0 mb-3">
                                <h2 class="accordion-header" id="heading{{ Str::slug($module) }}">
                                    <button class="accordion-button bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ Str::slug($module) }}" aria-expanded="true" aria-controls="collapse{{ Str::slug($module) }}">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box bg-primary-soft rounded-circle p-2 me-3">
                                                <i class="fas fa-shield-alt text-primary"></i>
                                            </div>
                                            <div>
                                                <span class="fw-bold">{{ $module }}</span>
                                                <div class="text-muted small">{{ count($modulePermissions) }} {{ __('permissions') }}</div>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse{{ Str::slug($module) }}" class="accordion-collapse collapse show" aria-labelledby="heading{{ Str::slug($module) }}">
                                    <div class="accordion-body">
                                        <div class="row">
                                            @foreach($modulePermissions as $permission)
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input permission-checkbox" type="checkbox" 
                                                            id="permission{{ $permission->id }}" 
                                                            name="permissions[]" 
                                                            value="{{ $permission->id }}" 
                                                            form="roleForm"
                                                            {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="permission{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                            @if($permission->description)
                                                                <div class="text-muted small">{{ $permission->description }}</div>
                                                            @endif
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
        
        // Select/deselect all permissions
        const selectAllBtn = document.getElementById('selectAllPermissions');
        const deselectAllBtn = document.getElementById('deselectAllPermissions');
        const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
        
        selectAllBtn.addEventListener('click', function() {
            permissionCheckboxes.forEach(function(checkbox) {
                checkbox.checked = true;
            });
        });
        
        deselectAllBtn.addEventListener('click', function() {
            permissionCheckboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
        });
    });
</script>
@endsection 