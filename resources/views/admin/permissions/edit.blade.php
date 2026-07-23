@extends('layouts.admin')

@section('title', __('Edit Permission'))

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
                            <h2 class="section-heading">{{ __('Edit Permission') }}</h2>
                            <p class="text-muted">{{ $permission->name }}</p>
                        </div>
                        <div class="col-lg-6 text-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.permissions.show', $permission->id) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye me-2"></i>{{ __('View Permission') }}
                                </a>
                                <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Permissions') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Permission Details') }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="name" class="form-label">{{ __('Permission Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $permission->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="slug" class="form-label">{{ __('Slug') }}</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $permission->slug) }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('The slug is used internally and in URLs.') }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="module" class="form-label">{{ __('Module') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('module') is-invalid @enderror" id="module" name="module" value="{{ old('module', $permission->module) }}" list="module-list">
                                <datalist id="module-list">
                                    @foreach($modules as $module)
                                        <option value="{{ $module }}">
                                    @endforeach
                                </datalist>
                            </div>
                            @error('module')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('Group permissions by module for better organization.') }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $permission->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deletePermissionModal">
                                <i class="fas fa-trash me-2"></i>{{ __('Delete') }}
                            </button>
                            
                            <div>
                                <button type="reset" class="btn btn-light me-2">
                                    {{ __('Reset') }}
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>{{ __('Save Changes') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Permission Information') }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-box bg-success-soft rounded-circle p-3 me-3">
                            <i class="fas fa-shield-alt text-success"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">{{ $permission->name }}</h6>
                            <div class="text-muted small">{{ $permission->slug }}</div>
                        </div>
                    </div>
                    
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-top">
                            <span>{{ __('Roles using this permission') }}</span>
                            <span class="badge rounded-pill bg-primary-soft text-primary">{{ $permission->roles_count ?? $permission->roles->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span>{{ __('Module') }}</span>
                            @if($permission->module)
                                <span class="badge bg-info-soft text-info">{{ $permission->module }}</span>
                            @else
                                <span class="text-muted">General</span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span>{{ __('Created') }}</span>
                            <span class="text-muted">{{ $permission->created_at->format('M d, Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span>{{ __('Last Updated') }}</span>
                            <span class="text-muted">{{ $permission->updated_at->format('M d, Y') }}</span>
                        </li>
                    </ul>
                    
                    <div class="alert alert-warning border-0">
                        <h6 class="alert-heading fw-bold mb-1">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ __('Important') }}
                        </h6>
                        <p class="mb-0 mt-2">{{ __('Changing a permission may affect users who have roles with this permission assigned.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Modal -->
    <div class="modal fade" id="deletePermissionModal" tabindex="-1" aria-labelledby="deletePermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePermissionModalLabel">{{ __('Delete Permission') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                        <h5 class="mb-2">{{ __('Are you sure you want to delete this permission?') }}</h5>
                        <p class="text-muted mb-0">{{ $permission->name }}</p>
                    </div>
                    
                    @if($permission->roles_count > 0 || $permission->roles->count() > 0)
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ __('Cannot delete permission assigned to roles. Remove from roles first.') }}
                        </div>
                    @else
                        <p class="text-danger text-center">{{ __('This action cannot be undone.') }}</p>
                    @endif
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" {{ ($permission->roles_count > 0 || $permission->roles->count() > 0) ? 'disabled' : '' }}>
                            {{ __('Delete Permission') }}
                        </button>
                    </form>
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
        const originalSlug = '{{ $permission->slug }}';
        
        nameInput.addEventListener('keyup', function() {
            if (slugInput.value === originalSlug) {
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