@extends('layouts.admin')

@section('title', __('View Announcement'))

@section('styles')
<style>
    .badge {
        font-size: 0.9rem;
        padding: 0.4rem 0.8rem;
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
    
    .status-badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        font-weight: 500;
    }
    
    .status-active {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid #28a745;
    }
    
    .status-inactive {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 1px solid #dc3545;
    }
    
    .info-box {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .info-label {
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 5px;
    }
    
    .announcement-content {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        border: 1px solid #e9ecef;
        white-space: pre-wrap;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('View Announcement') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.announcements.index') }}">{{ __('Announcements') }}</a></li>
        <li class="breadcrumb-item active">{{ __('View') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-bullhorn me-1"></i>
                {{ __('Announcement Details') }}
            </div>
            <div>
                <a href="{{ route('admin.government.announcements.edit', $announcement) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit me-1"></i> {{ __('Edit') }}
                </a>
                <form action="{{ route('admin.government.announcements.destroy', $announcement) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this announcement?') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash me-1"></i> {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="mb-4">{{ $announcement->title }}</h2>
                    
                    <div class="mb-4">
                        <div class="info-label">{{ __('Content') }}</div>
                        <div class="announcement-content">{{ $announcement->content }}</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="info-box">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <div class="info-label">{{ __('Status') }}</div>
                                <span class="status-badge status-{{ $announcement->status }}">
                                    {{ ucfirst($announcement->status) }}
                                </span>
                            </div>
                            <div>
                                <div class="info-label">{{ __('Type') }}</div>
                                <span class="badge type-{{ $announcement->type }}">
                                    {{ ucfirst($announcement->type) }}
                                </span>
                            </div>
                            <div>
                                <div class="info-label">{{ __('Priority') }}</div>
                                <span class="badge priority-{{ $announcement->priority }}">
                                    {{ ucfirst($announcement->priority) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="info-label">{{ __('Department') }}</div>
                            <div>{{ $announcement->department ? $announcement->department->name : __('General (No specific department)') }}</div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="info-label">{{ __('Duration') }}</div>
                            <div class="d-flex flex-column">
                                <div class="mb-1"><i class="fas fa-calendar-alt me-2"></i> {{ __('Start') }}: {{ $announcement->start_date->format('M d, Y H:i') }}</div>
                                <div><i class="fas fa-calendar-check me-2"></i> {{ __('End') }}: {{ $announcement->end_date->format('M d, Y H:i') }}</div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="info-label">{{ __('Created/Updated') }}</div>
                            <div class="d-flex flex-column">
                                <div class="mb-1"><i class="fas fa-plus-circle me-2"></i> {{ __('Created') }}: {{ $announcement->created_at->format('M d, Y H:i') }}</div>
                                <div><i class="fas fa-edit me-2"></i> {{ __('Updated') }}: {{ $announcement->updated_at->format('M d, Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('admin.government.announcements.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> {{ __('Back to Announcements') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 