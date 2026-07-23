@extends('layouts.admin')

@section('title', $user->name)

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
                            <div class="avatar avatar-lg bg-primary-soft text-primary rounded-circle me-3">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <h2 class="section-heading mb-0">{{ $user->name }}</h2>
                                <p class="text-muted mb-0">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 text-end mt-3 mt-lg-0">
                            <div class="btn-group">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i>{{ __('Edit User') }}
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Users') }}
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
                    <h5 class="mb-0 fw-bold">{{ __('User Information') }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="avatar avatar-xl bg-primary-soft text-primary rounded-circle mx-auto mb-3">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <h5 class="mb-1">{{ $user->name }}</h5>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                    </div>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-top">
                            <span class="fw-medium">{{ __('User ID') }}</span>
                            <span class="badge bg-light text-dark">{{ $user->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="fw-medium">{{ __('Email Verified') }}</span>
                            @if($user->email_verified_at)
                                <span class="badge bg-success-soft text-success">{{ __('Yes') }}</span>
                            @else
                                <span class="badge bg-warning-soft text-warning">{{ __('No') }}</span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="fw-medium">{{ __('Created') }}</span>
                            <span class="text-muted">{{ $user->created_at->format('M d, Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <span class="fw-medium">{{ __('Last Updated') }}</span>
                            <span class="text-muted">{{ $user->updated_at->format('M d, Y') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">{{ __('Actions') }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>{{ __('Edit User') }}
                        </a>
                        @if(Auth::id() != $user->id)
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                                <i class="fas fa-trash me-2"></i>{{ __('Delete User') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Assigned Roles') }}</h5>
                </div>
                <div class="card-body p-4">
                    @if($user->roles->count() > 0)
                        <div class="row">
                            @foreach($user->roles as $role)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 border-0 bg-light">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-box bg-info-soft rounded-circle p-2 me-3">
                                                    <i class="fas fa-user-tag text-info"></i>
                                                </div>
                                                <h6 class="mb-0 fw-bold">{{ $role->name }}</h6>
                                            </div>
                                            @if($role->description)
                                                <p class="text-muted small mb-0">{{ $role->description }}</p>
                                            @else
                                                <p class="text-muted small mb-0">{{ __('No description available.') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center p-5">
                            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                            <p class="mb-0">{{ __('No roles assigned to this user.') }}</p>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary mt-3">
                                <i class="fas fa-user-tag me-1"></i>{{ __('Assign Roles') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Activity Log') }}</h5>
                </div>
                <div class="card-body p-4">
                    <!-- This section would display user activity log if implemented -->
                    <div class="text-center p-5">
                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                        <p class="mb-0">{{ __('Activity logging is not implemented yet.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Modal -->
    @if(Auth::id() != $user->id)
        <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteUserModalLabel">{{ __('Delete User') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                            <h5 class="mb-2">{{ __('Are you sure you want to delete this user?') }}</h5>
                            <p class="text-muted mb-0">{{ $user->name }} ({{ $user->email }})</p>
                        </div>
                        <p class="text-danger text-center">{{ __('This action cannot be undone.') }}</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">{{ __('Delete User') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection 