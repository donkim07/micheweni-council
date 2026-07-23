@extends('government.layouts.app')

@section('title', $announcement->title)

@section('styles')
<style>
    .announcement-meta {
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .announcement-content {
        font-size: 1.1rem;
        line-height: 1.7;
    }
    
    .announcement-date {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .announcement-badge {
        font-size: 0.9rem;
    }
    
    .announcement-header {
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
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
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('government.home') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Announcement') }}</li>
                </ol>
            </nav>
            
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="announcement-header">
                        <h1 class="mb-3">{{ $announcement->title }}</h1>
                        <div class="d-flex flex-wrap align-items-center mb-3">
                            @if($announcement->department)
                                <span class="me-3">
                                    <i class="fas fa-building me-1"></i>
                                    {{ $announcement->department->name }}
                                </span>
                            @endif
                            <span class="me-3">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ __('Valid from') }} {{ $announcement->start_date->format('M d, Y') }} 
                                {{ __('to') }} {{ $announcement->end_date->format('M d, Y') }}
                            </span>
                        </div>
                        <div class="d-flex flex-wrap">
                            <span class="badge type-{{ $announcement->type }} me-2">{{ ucfirst($announcement->type) }}</span>
                            <span class="badge priority-{{ $announcement->priority }}">{{ ucfirst(__($announcement->priority)) }}</span>
                        </div>
                    </div>
                    
                    <div class="announcement-content">
                        {!! nl2br(e($announcement->content)) !!}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ __('Related Announcements') }}</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($relatedAnnouncements as $relatedAnnouncement)
                            <li class="list-group-item">
                                <h6>
                                    <a href="{{ route('government.announcements.show', $relatedAnnouncement->id) }}" class="text-decoration-none">
                                        {{ $relatedAnnouncement->title }}
                                    </a>
                                </h6>
                                <div class="small">
                                    <span class="badge type-{{ $relatedAnnouncement->type }}">{{ ucfirst($relatedAnnouncement->type) }}</span>
                                    <span class="text-muted ms-2">
                                        <i class="fas fa-calendar-alt me-1"></i> 
                                        {{ $relatedAnnouncement->start_date->format('M d, Y') }}
                                    </span>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center py-4">
                                <p class="text-muted mb-0">{{ __('No related announcements found') }}</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ __('Contact Information') }}</h5>
                </div>
                <div class="card-body">
                    <p>{{ __('For more information about this announcement, please contact:') }}</p>
                    @if($announcement->department)
                        <div class="mb-3">
                            <h6>{{ $announcement->department->name }}</h6>
                            @if($announcement->department->contact_email)
                                <p class="mb-1">
                                    <i class="fas fa-envelope me-2"></i>
                                    <a href="mailto:{{ $announcement->department->contact_email }}">{{ $announcement->department->contact_email }}</a>
                                </p>
                            @endif
                            @if($announcement->department->contact_phone)
                                <p class="mb-1">
                                    <i class="fas fa-phone me-2"></i>
                                    <a href="tel:{{ $announcement->department->contact_phone }}">{{ $announcement->department->contact_phone }}</a>
                                </p>
                            @endif
                        </div>
                    @else
                        <p class="mb-1">
                            <i class="fas fa-envelope me-2"></i>
                            <a href="mailto:info@micheweni.go.tz">info@micheweni.go.tz</a>
                        </p>
                        <p class="mb-1">
                            <i class="fas fa-phone me-2"></i>
                            <a href="tel:+255776543210">+255 776 543 210</a>
                        </p>
                    @endif
                    
                    <a href="{{ route('government.contact') }}" class="btn btn-outline-primary mt-3">
                        <i class="fas fa-paper-plane me-1"></i> {{ __('Contact Us') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 