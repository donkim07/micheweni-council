@extends('layouts.admin')

@section('title', $role->name)

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
                            <div class="icon-box bg-info-soft rounded-circle p-3 me-3">
                                <i class="fas fa-user-tag text-info fa-lg"></i>
                            </div>
                            <div>
                                <h2 class="section-heading mb-0">{{ $role->name }}</h2>
                                <p class="text-muted mb-0">{{ $role->slug }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 text-end mt-3 mt-lg-0">
                            <div class="btn-group">
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i>{{ __('Edit Role') }}
                                </a>
                                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Roles') }}
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
                    <h5 class="mb-0 fw-bold">{{ __('Role Information') }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="icon-box bg-info-soft rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-user-tag text-info fa-2x"></i>
                        </div>
                        <h5 class="mb-1">{{ $role->name }}</h5>
                        <p class="text-muted mb-0">{{ $role->slug }}</p>
                    </div>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-top">
                            <span class="fw-medium">{{ __('Status') }}</span>
                            @if($role->is_active)
                                <span class="badge bg-success-soft text-success">{{ __('Active') }}</span>
                            @else
                                <span class="badge bg-danger-soft text-danger">{{ __('Inactive') }}</span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="fw-medium">{{ __('Users with this role') }}</span>
                            <span class="badge rounded-pill bg-primary-soft text-primary">{{ $role->users->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="fw-medium">{{ __('Permissions') }}</span>
                            <span class="badge rounded-pill bg-success-soft text-success">{{ $role->permissions->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="fw-medium">{{ __('Created') }}</span>
                            <span class="text-muted">{{ $role->created_at->format('M d, Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="fw-medium">{{ __('Last Updated') }}</span>
                            <span class="text-muted">{{ $role->updated_at->format('M d, Y') }}</span>
                        </li>
                    </ul>
                    
                    @if($role->description)
                        <div class="mt-4">
                            <h6 class="fw-bold mb-2">{{ __('Description') }}</h6>
                            <p class="text-muted mb-0">{{ $role->description }}</p>
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
                        <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>{{ __('Edit Role') }}
                        </a>
                        @if($role->users->count() === 0)
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteRoleModal">
                                <i class="fas fa-trash me-2"></i>{{ __('Delete Role') }}
                            </button>
                        @else
                            <button type="button" class="btn btn-outline-danger" disabled title="{{ __('Cannot delete role with assigned users') }}">
                                <i class="fas fa-trash me-2"></i>{{ __('Delete Role') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Assigned Permissions') }}</h5>
                </div>
                <div class="card-body p-4">
                    @if($role->permissions->count() > 0)
                        <div class="accordion" id="permissionsAccordion">
                            @php
                                $groupedPermissions = [];
                                foreach($role->permissions as $permission) {
                                    $module = $permission->module ?? 'General';
                                    if (!isset($groupedPermissions[$module])) {
                                        $groupedPermissions[$module] = [];
                                    }
                                    $groupedPermissions[$module][] = $permission;
                                }
                                ksort($groupedPermissions);
                            @endphp
                            
                            @foreach($groupedPermissions as $module => $modulePermissions)
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
                                                    <div class="col-md-6 mb-3">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-check-circle text-success me-2"></i>
                                                            <div>
                                                                <span class="fw-medium">{{ $permission->name }}</span>
                                                                @if($permission->description)
                                                                    <div class="text-muted small">{{ $permission->description }}</div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center p-5">
                            <i class="fas fa-shield-alt fa-3x text-muted mb-3"></i>
                            <p class="mb-0">{{ __('No permissions assigned to this role.') }}</p>
                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-primary mt-3">
                                <i class="fas fa-edit me-1"></i>{{ __('Assign Permissions') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Users with this Role') }}</h5>
                </div>
                <div class="card-body p-0">
                    @if($role->users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">{{ __('User') }}</th>
                                        <th class="border-0 px-4 py-3">{{ __('Email') }}</th>
                                        <th class="border-0 px-4 py-3 text-end">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($role->users as $user)
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
                            <p class="mb-0">{{ __('No users have been assigned this role.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Modal -->
    @if($role->users->count() === 0)
        <div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteRoleModalLabel">{{ __('Delete Role') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                            <h5 class="mb-2">{{ __('Are you sure you want to delete this role?') }}</h5>
                            <p class="text-muted mb-0">{{ $role->name }}</p>
                        </div>
                        <p class="text-danger text-center">{{ __('This action cannot be undone.') }}</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">{{ __('Delete Role') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection 