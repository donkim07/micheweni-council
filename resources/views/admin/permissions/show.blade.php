@extends('layouts.admin')

@section('title', $permission->name)

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
                        <div class="col-lg-6 d-flex align-items-center">
                            <div class="icon-box bg-success-soft rounded-circle p-3 me-3">
                                <i class="fas fa-shield-alt text-success fa-lg"></i>
                            </div>
                            <div>
                                <h2 class="section-heading mb-0">{{ $permission->name }}</h2>
                                <p class="text-muted mb-0">{{ $permission->slug }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 text-end mt-3 mt-lg-0">
                            <div class="btn-group">
                                <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i>{{ __('Edit Permission') }}
                                </a>
                                <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Permissions') }}
                                </a>
                            </div>
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
                    <h5 class="mb-0 fw-bold">{{ __('Permission Information') }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="icon-box bg-success-soft rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-shield-alt text-success fa-2x"></i>
                        </div>
                        <h5 class="mb-1">{{ $permission->name }}</h5>
                        <p class="text-muted mb-0">{{ $permission->slug }}</p>
                    </div>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-top">
                            <span class="fw-medium">{{ __('Module') }}</span>
                            @if($permission->module)
                                <span class="badge bg-info-soft text-info">{{ $permission->module }}</span>
                            @else
                                <span class="text-muted">General</span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="fw-medium">{{ __('Roles Count') }}</span>
                            <span class="badge rounded-pill bg-primary-soft text-primary">{{ $permission->roles->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="fw-medium">{{ __('Created') }}</span>
                            <span class="text-muted">{{ $permission->created_at->format('M d, Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="fw-medium">{{ __('Last Updated') }}</span>
                            <span class="text-muted">{{ $permission->updated_at->format('M d, Y') }}</span>
                        </li>
                    </ul>
                    
                    @if($permission->description)
                        <div class="mt-4">
                            <h6 class="fw-bold mb-2">{{ __('Description') }}</h6>
                            <p class="text-muted mb-0">{{ $permission->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Actions') }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>{{ __('Edit Permission') }}
                        </a>
                        @if($permission->roles->count() === 0)
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deletePermissionModal">
                                <i class="fas fa-trash me-2"></i>{{ __('Delete Permission') }}
                            </button>
                        @else
                            <button type="button" class="btn btn-outline-danger" disabled title="{{ __('Cannot delete permission assigned to roles') }}">
                                <i class="fas fa-trash me-2"></i>{{ __('Delete Permission') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Roles with this Permission') }}</h5>
                </div>
                <div class="card-body p-0">
                    @if($permission->roles->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">{{ __('Role') }}</th>
                                        <th class="border-0 px-4 py-3">{{ __('Description') }}</th>
                                        <th class="border-0 px-4 py-3">{{ __('Status') }}</th>
                                        <th class="border-0 px-4 py-3 text-end">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($permission->roles as $role)
                                        <tr>
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-box bg-info-soft rounded-circle p-2 me-3">
                                                        <i class="fas fa-user-tag text-info"></i>
                                                    </div>
                                                    <span class="fw-medium">{{ $role->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-muted small">
                                                    {{ Str::limit($role->description, 50) ?: __('No description') }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($role->is_active)
                                                    <span class="badge bg-success-soft text-success">{{ __('Active') }}</span>
                                                @else
                                                    <span class="badge bg-danger-soft text-danger">{{ __('Inactive') }}</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-end">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="{{ __('Edit') }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.roles.show', $role->id) }}" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="{{ __('View') }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center p-5">
                            <i class="fas fa-user-tag fa-3x text-muted mb-3"></i>
                            <p class="mb-0">{{ __('No roles have been assigned this permission.') }}</p>
                            <p class="text-muted small mt-2">{{ __('This permission is not currently in use.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Users with this Permission') }}</h5>
                </div>
                <div class="card-body p-0">
                    @php
                        $usersWithPermission = collect();
                        foreach ($permission->roles as $role) {
                            foreach ($role->users as $user) {
                                if (!$usersWithPermission->contains('id', $user->id)) {
                                    $usersWithPermission->push($user);
                                }
                            }
                        }
                    @endphp
                    
                    @if($usersWithPermission->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">{{ __('User') }}</th>
                                        <th class="border-0 px-4 py-3">{{ __('Email') }}</th>
                                        <th class="border-0 px-4 py-3">{{ __('Roles') }}</th>
                                        <th class="border-0 px-4 py-3 text-end">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($usersWithPermission as $user)
                                        <tr>
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-md bg-primary-soft text-primary rounded-circle me-3">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                    <span class="fw-medium">{{ $user->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-envelope text-muted me-2"></i>
                                                    <span>{{ $user->email }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                @foreach($user->roles->whereIn('id', $permission->roles->pluck('id')) as $role)
                                                    <span class="badge bg-info-soft text-info me-1">{{ $role->name }}</span>
                                                @endforeach
                                            </td>
                                            <td class="px-4 py-3 text-end">
                                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye me-1"></i>{{ __('View') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center p-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="mb-0">{{ __('No users have this permission through their roles.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Modal -->
    @if($permission->roles->count() === 0)
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
                        <p class="text-danger text-center">{{ __('This action cannot be undone.') }}</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">{{ __('Delete Permission') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
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