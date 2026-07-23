@extends('layouts.admin')

@section('title', __('Roles'))

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
                            <h2 class="section-heading">{{ __('Role Management') }}</h2>
                            <p class="text-muted">{{ __('Create, edit and manage user roles and permissions') }}</p>
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>{{ __('Add New Role') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">{{ __('All Roles') }}</h5>
                        <span class="badge bg-primary-soft text-primary rounded-pill">
                            {{ $roles->total() }} {{ __('Roles') }}
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
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 px-4 py-3">{{ __('Role Name') }}</th>
                                    <th class="border-0 px-4 py-3 hide-sm">{{ __('Slug') }}</th>
                                    <th class="border-0 px-4 py-3 hide-sm">{{ __('Users') }}</th>
                                    <th class="border-0 px-4 py-3 hide-sm">{{ __('Permissions') }}</th>
                                    <th class="border-0 px-4 py-3">{{ __('Status') }}</th>
                                    <th class="border-0 px-4 py-3">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box bg-info-soft rounded-circle p-2 me-3">
                                                <i class="fas fa-user-tag text-info"></i>
                                            </div>
                                            <span class="fw-medium">{{ $role->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-muted">{{ $role->slug }}</td>
                                    <td class="px-4 py-3">
                                        <span class="badge rounded-pill bg-primary-soft text-primary">
                                            {{ $role->users_count }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge rounded-pill bg-success-soft text-success">
                                            {{ $role->permissions_count }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($role->is_active)
                                            <span class="badge bg-success-soft text-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="badge bg-danger-soft text-danger">{{ __('Inactive') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.roles.show', $role->id) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye me-1"></i> 
                                            </a>
                                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit me-1"></i> 
                                            </a>
                                            @if($role->users_count == 0)
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="if(confirm('{{ __('Are you sure you want to delete this role?') }}')) document.getElementById('delete-form-{{ $role->id }}').submit();">
                                                    <i class="fas fa-trash"></i> 
                                                </button>
                                                <form id="delete-form-{{ $role->id }}" action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @else
                                                <button type="button" class="btn btn-sm btn-outline-danger" disabled title="{{ __('Cannot delete role with assigned users') }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center p-5">
                                        <i class="fas fa-user-tag fa-3x text-muted mb-3"></i>
                                        <p class="mb-0">{{ __('No roles found') }}</p>
                                        <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-primary mt-3">
                                            <i class="fas fa-plus me-1"></i>{{ __('Add Role') }}
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center p-4">
                        {{ $roles->links() }}
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