@extends('layouts.admin')

@section('title', __('Permissions'))

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
                            <h2 class="section-heading">{{ __('Permission Management') }}</h2>
                            <p class="text-muted">{{ __('Create, edit and manage system permissions') }}</p>
                        </div>
                        <div class="col-lg-6 text-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>{{ __('Add New Permission') }}
                                </a>
                                <a href="{{ route('admin.permissions.generate-defaults') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-sync me-2"></i>{{ __('Generate Defaults') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Filter Options') }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.permissions.index') }}" method="GET" class="row g-3">
                        <div class="col-md-5">
                            <label for="search" class="form-label">{{ __('Search') }}</label>
                            <input type="text" name="search" id="search" class="form-control" 
                                placeholder="{{ __('Search by name or description') }}" value="{{ request('search') }}">
                        </div>
                        
                        <div class="col-md-5">
                            <label for="module" class="form-label">{{ __('Module') }}</label>
                            <select name="module" id="module" class="form-select">
                                <option value="">{{ __('All Modules') }}</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>
                                        {{ $module }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>{{ __('Filter') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">{{ __('All Permissions') }}</h5>
                        <span class="badge bg-primary-soft text-primary rounded-pill">
                            {{ $permissions->total() }} {{ __('Permissions') }}
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success m-4 mb-0">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger m-4 mb-0">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover mb-0 admin-permissions-table">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 px-4 py-3">{{ __('Permission Name') }}</th>
                                    <th class="border-0 px-4 py-3 hide-sm">{{ __('Slug') }}</th>
                                    <th class="border-0 px-4 py-3 hide-sm">{{ __('Module') }}</th>
                                    <th class="border-0 px-4 py-3 hide-md">{{ __('Description') }}</th>
                                    <th class="border-0 px-4 py-3">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($permissions as $permission)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box bg-success-soft rounded-circle p-2 me-3">
                                                <i class="fas fa-shield-alt text-success"></i>
                                            </div>
                                            <span class="fw-medium">{{ $permission->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-muted">{{ $permission->slug }}</td>
                                    <td class="px-4 py-3">
                                        @if($permission->module)
                                            <span class="badge bg-info-soft text-info">{{ $permission->module }}</span>
                                        @else
                                            <span class="text-muted">General</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-muted small">
                                            {{ Str::limit($permission->description, 50) }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.permissions.show', $permission->id) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye me-1"></i> 
                                            </a>
                                            <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit me-1"></i> 
                                            </a>
                                            @if($permission->roles_count == 0)
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="if(confirm('{{ __('Are you sure you want to delete this permission?') }}')) document.getElementById('delete-form-{{ $permission->id }}').submit();">
                                                    <i class="fas fa-trash"></i> 
                                                </button>
                                                <form id="delete-form-{{ $permission->id }}" action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @else
                                                <button type="button" class="btn btn-sm btn-outline-danger" disabled title="{{ __('Cannot delete permission assigned to roles') }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center p-5">
                                        <i class="fas fa-shield-alt fa-3x text-muted mb-3"></i>
                                        <p class="mb-0">{{ __('No permissions found') }}</p>
                                        <div class="mt-3">
                                            <a href="{{ route('admin.permissions.create') }}" class="btn btn-sm btn-primary me-2">
                                                <i class="fas fa-plus me-1"></i>{{ __('Add Permission') }}
                                            </a>
                                            <a href="{{ route('admin.permissions.generate-defaults') }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-sync me-1"></i>{{ __('Generate Defaults') }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center p-4">
                        {{ $permissions->links() }}
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
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection 