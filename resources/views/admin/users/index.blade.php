@extends('layouts.admin')

@section('title', __('Users'))

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
                            <h2 class="section-heading">{{ __('User Management') }}</h2>
                            <p class="text-muted">{{ __('Create, edit and manage user accounts') }}</p>
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus me-2"></i>{{ __('Add New User') }}
                            </a>
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
                    <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">
                        <div class="col-md-5">
                            <label for="search" class="form-label">{{ __('Search') }}</label>
                            <input type="text" name="search" id="search" class="form-control" 
                                placeholder="{{ __('Search by name or email') }}" value="{{ request('search') }}">
                        </div>
                        
                        <div class="col-md-5">
                            <label for="role_id" class="form-label">{{ __('Role') }}</label>
                            <select name="role_id" id="role_id" class="form-select">
                                <option value="">{{ __('All Roles') }}</option>
                                @foreach($roles as $id => $name)
                                    <option value="{{ $id }}" {{ request('role_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
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
                        <h5 class="mb-0 fw-bold">{{ __('All Users') }}</h5>
                        <span class="badge bg-primary-soft text-primary rounded-pill">
                            {{ $users->total() }} {{ __('Users') }}
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

                    @if(session('info'))
                        <div class="alert alert-info m-4 mb-0">
                            {{ session('info') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 px-4 py-3">{{ __('User') }}</th>
                                    <th class="border-0 px-4 py-3 hide-sm">{{ __('Email') }}</th>
                                    <th class="border-0 px-4 py-3">{{ __('Roles') }}</th>
                                    <th class="border-0 px-4 py-3 hide-sm">{{ __('Created') }}</th>
                                    <th class="border-0 px-4 py-3">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
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
                                        @forelse($user->roles as $role)
                                            <span class="badge bg-info-soft text-info me-1">{{ $role->name }}</span>
                                        @empty
                                            <span class="text-muted">{{ __('No roles assigned') }}</span>
                                        @endforelse
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar text-muted me-2"></i>
                                            <span>{{ $user->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye me-1"></i> 
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit me-1"></i> 
                                            </a>
                                            @if(Auth::id() != $user->id)
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="if(confirm('{{ __('Are you sure you want to delete this user?') }}')) document.getElementById('delete-form-{{ $user->id }}').submit();">
                                                    <i class="fas fa-trash"></i> 
                                                </button>
                                                <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center p-5">
                                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                        <p class="mb-0">{{ __('No users found') }}</p>
                                        <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary mt-3">
                                            <i class="fas fa-user-plus me-1"></i>{{ __('Add User') }}
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center p-4">
                        {{ $users->links() }}
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