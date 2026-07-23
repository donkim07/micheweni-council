@extends('layouts.admin')

@section('title', __('Announcements'))

@section('styles')
<style>
    .announcement-list-item {
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }
    
    .announcement-list-item:hover {
        border-left-color: var(--primary);
        background-color: rgba(0, 0, 0, 0.03);
    }
    
    .announcement-list-item.active {
        border-left-color: var(--primary);
        background-color: rgba(0, 0, 0, 0.05);
    }
    
    .announcement-status {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }
    
    .announcement-status.active {
        background-color: #28a745;
    }
    
    .announcement-status.inactive {
        background-color: #dc3545;
    }
    
    .priority-badge {
        font-size: 0.8rem;
        padding: 0.2rem 0.5rem;
    }
    
    .priority-low {
        background-color: #6c757d;
    }
    
    .priority-medium {
        background-color: #17a2b8;
    }
    
    .priority-high {
        background-color: #ffc107;
        color: #212529;
    }
    
    .priority-urgent {
        background-color: #dc3545;
    }
    
    .type-badge {
        font-size: 0.8rem;
        padding: 0.2rem 0.5rem;
    }
    
    .type-alert {
        background-color: #dc3545;
    }
    
    .type-warning {
        background-color: #ffc107;
        color: #212529;
    }
    
    .type-info {
        background-color: #17a2b8;
    }
    
    .type-success {
        background-color: #28a745;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Announcements') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Announcements') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-0">{{ __('Manage Announcements') }}</h5>
                    <p class="text-muted small mb-0">{{ __('Create, edit, and manage government announcements.') }}</p>
                </div>
                <a href="{{ route('admin.government.announcements.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> {{ __('Add Announcement') }}
                </a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Department') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Priority') }}</th>
                            <th>{{ __('Duration') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th style="width: 180px;">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($announcements as $announcement)
                            <tr class="announcement-list-item">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <strong>{{ $announcement->title }}</strong>
                                            <div class="small text-muted">{{ Str::limit($announcement->content, 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($announcement->department)
                                        <div>{{ $announcement->department->name }}</div>
                                    @else
                                        <span class="text-muted">General</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge type-{{ $announcement->type }}">{{ ucfirst($announcement->type) }}</span>
                                </td>
                                <td>
                                    <span class="badge priority-{{ $announcement->priority }}">{{ ucfirst($announcement->priority) }}</span>
                                </td>
                                <td>
                                    <div><i class="fas fa-calendar-alt me-1 small"></i> {{ $announcement->start_date->format('M d, Y') }}</div>
                                    <div><i class="fas fa-calendar-check me-1 small"></i> {{ $announcement->end_date->format('M d, Y') }}</div>
                                </td>
                                <td>
                                    <span class="announcement-status {{ $announcement->status }}"></span>
                                    {{ ucfirst($announcement->status) }}
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.government.announcements.show', $announcement) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.government.announcements.edit', $announcement) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.government.announcements.destroy', $announcement) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this announcement?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-bullhorn text-muted mb-2" style="font-size: 2.5rem;"></i>
                                        <h5>{{ __('No announcements found') }}</h5>
                                        <p class="text-muted">{{ __('Start by adding your first announcement') }}</p>
                                        <a href="{{ route('admin.government.announcements.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> {{ __('Add Announcement') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $announcements->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 