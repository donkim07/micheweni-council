@extends('layouts.admin')

@section('title', __('Government Dashboard'))

@section('styles')
<style>
    /* Stat Card Styles */
    .stat-card {
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        height: 100%;
        margin-bottom: 1.5rem;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }
    
    .bg-primary-soft {
        background-color: rgba(52, 152, 219, 0.1);
    }
    
    .bg-success-soft {
        background-color: rgba(39, 174, 96, 0.1);
    }
    
    .bg-info-soft {
        background-color: rgba(52, 152, 219, 0.1);
    }
    
    .bg-warning-soft {
        background-color: rgba(243, 156, 18, 0.1);
    }
    
    .bg-danger-soft {
        background-color: rgba(231, 76, 60, 0.1);
    }
    
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.25rem 1.5rem;
    }
    
    .card-title {
        margin-bottom: 0;
        font-weight: 600;
    }
    
    .card-body {
        /* padding: 1.5rem; */
        padding-bottom: 10px;
    }
    
    .icon-box {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    .list-group-item {
        padding: 1rem 1.5rem;
        border: none;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .list-group-item:last-child {
        border-bottom: none;
    }
    
    .btn-action-group {
        display: flex;
        gap: 0.5rem;
    }
    
    .item-content {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
    
    .dashboard-header {
        background-color: #fff;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    /* Responsive fixes for mobile and tablet */
    @media (max-width: 767px) {
        .icon-box {
            width: 50px;
            height: 50px;
        }
        
        .card-header {
            padding: 1rem;
        }
        
        .item-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .btn-action-group {
            margin-top: 0.5rem;
        }
        
        .dashboard-header {
            padding: 1rem;
        }
        
        .display-6 {
            font-size: 1.75rem;
        }
        
        .stat-card .card-body {
            padding: 1rem;
        }
        
        .dashboard-row {
            display: block;
        }
        
        .dashboard-row > div {
            width: 100%;
            margin-bottom: 1rem;
        }
        
        .card-body .d-flex {
            flex-wrap: wrap;
        }
        
        .chart-container {
            min-height: 300px !important;
            height: auto !important;
        }
    }
    
    /* Tablet responsive fixes */
    @media (min-width: 768px) and (max-width: 991px) {
        .stat-card .card-body {
            padding: 1rem;
        }
        
        .stat-value {
            font-size: 1.8rem;
        }
        
        .chart-container {
            min-height: 350px !important;
        }
    }

</style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h2 mb-1 fw-bold">{{ __('Government Portal Dashboard') }}</h1>
                    <p class="text-muted mb-0">{{ __('Overview of government portal content and activity') }}</p>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-md-end mb-0 mt-2 mt-md-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Government Dashboard') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Statistics Cards -->
        <div class="row dashboard-row admin-government-dashboard">
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card h-100 dashboard-stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="icon-box bg-primary-soft rounded-circle p-3 me-3">
                                    <i class="fas fa-building fa-2x text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="display-6 fw-bold mb-0 stat-value">{{ $departmentsCount }}</h3>
                                <div class="text-muted">{{ __('Departments') }}</div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="{{ $departmentsCount }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.government.departments.index') }}" class="btn btn-sm btn-primary w-100 mt-3">
                            {{ __('Manage departments') }} <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card h-100 dashboard-stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="icon-box bg-success-soft rounded-circle p-3 me-3">
                                    <i class="fas fa-cogs fa-2x text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="display-6 fw-bold mb-0 stat-value">{{ $servicesCount }}</h3>
                                <div class="text-muted">{{ __('Services') }}</div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="{{ $servicesCount }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.government.services.index') }}" class="btn btn-sm btn-success w-100 mt-3">
                            {{ __('Manage services') }} <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card h-100 dashboard-stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="icon-box bg-warning-soft rounded-circle p-3 me-3">
                                    <i class="fas fa-project-diagram fa-2x text-warning"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="display-6 fw-bold mb-0 stat-value">{{ $projectsCount }}</h3>
                                <div class="text-muted">{{ __('Projects') }}</div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="{{ $projectsCount }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.government.projects.index') }}" class="btn btn-sm btn-warning w-100 mt-3">
                            {{ __('Manage projects') }} <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card h-100 dashboard-stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="icon-box bg-danger-soft rounded-circle p-3 me-3">
                                    <i class="fas fa-newspaper fa-2x text-danger"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="display-6 fw-bold mb-0 stat-value">{{ $newsCount }}</h3>
                                <div class="text-muted">{{ __('News Articles') }}</div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="{{ $newsCount }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.government.news.index') }}" class="btn btn-sm btn-danger w-100 mt-3">
                            {{ __('Manage news') }} <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- More Statistics -->
        <div class="row dashboard-row">
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card h-100 dashboard-stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="icon-box bg-info-soft rounded-circle p-3 me-3">
                                    <i class="fas fa-bullhorn fa-2x text-info"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="display-6 fw-bold mb-0 stat-value">{{ $announcementsCount }}</h3>
                                <div class="text-muted">{{ __('Announcements') }}</div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="{{ $announcementsCount }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.government.announcements.index') }}" class="btn btn-sm btn-info w-100 mt-3">
                            {{ __('Manage announcements') }} <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card h-100 dashboard-stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="icon-box bg-secondary-soft rounded-circle p-3 me-3">
                                    <i class="fas fa-comment-dots fa-2x text-secondary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="display-6 fw-bold mb-0 stat-value">{{ $testimonialsCount }}</h3>
                                <div class="text-muted">{{ __('Testimonials') }}</div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-secondary" role="progressbar" style="width: 100%" aria-valuenow="{{ $testimonialsCount }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.government.testimonials.index') }}" class="btn btn-sm btn-secondary w-100 mt-3">
                            {{ __('Manage testimonials') }} <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
           <!-- <div class="col-xl-3 col-md-6">
                <div class="card stat-card h-100 dashboard-stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="icon-box bg-primary-soft rounded-circle p-3 me-3">
                                    <i class="fas fa-chart-bar fa-2x text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="display-6 fw-bold mb-0 stat-value">{{ $statistics ? $statistics->count() : 0 }}</h3>
                                <div class="text-muted">{{ __('Statistics') }}</div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="{{ $statistics ? $statistics->count() : 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.government.statistics.index') }}" class="btn btn-sm btn-primary w-100 mt-3">
                            {{ __('Manage statistics') }} <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div> -->
            
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card h-100 dashboard-stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="icon-box bg-success-soft rounded-circle p-3 me-3">
                                    <i class="fas fa-bell fa-2x text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="display-6 fw-bold mb-0 stat-value">{{ $activeAnnouncements ? $activeAnnouncements->count() : 0 }}</h3>
                                <div class="text-muted">{{ __('Active Announcements') }}</div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="{{ $activeAnnouncements ? $activeAnnouncements->count() : 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.government.announcements.index') }}" class="btn btn-sm btn-success w-100 mt-3">
                            {{ __('View all') }} <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Departments -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="card-title mb-2 mb-md-0">{{ __('Recent Departments') }}</h5>
                        <a href="{{ route('admin.government.departments.index') }}" class="btn btn-sm btn-outline-primary mt-2 mt-md-0">
                            {{ __('View All') }} <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($recentDepartments as $department)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="item-content mb-2 mb-md-0">
                                            <i class="fas fa-building text-primary"></i>
                                            <div>
                                                <span class="fw-medium">{{ $department->name }}</span>
                                                <span class="badge bg-{{ $department->status == 'active' ? 'success' : 'secondary' }} ms-2">
                                                    {{ ucfirst($department->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="btn-action-group">
                                            <a href="{{ route('admin.government.departments.show', $department) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.government.departments.edit', $department) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-center py-4">
                                    <i class="fas fa-folder-open text-muted mb-2" style="font-size: 2rem;"></i>
                                    <p class="mb-0">{{ __('No departments found') }}</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Recent Services -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="card-title mb-2 mb-md-0">{{ __('Recent Services') }}</h5>
                        <a href="{{ route('admin.government.services.index') }}" class="btn btn-sm btn-outline-success mt-2 mt-md-0">
                            {{ __('View All') }} <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($recentServices as $service)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="item-content mb-2 mb-md-0">
                                            <i class="fas fa-cog text-success"></i>
                                            <div>
                                                <span class="fw-medium">{{ $service->title }}</span>
                                                <span class="badge bg-{{ $service->status == 'active' ? 'success' : 'secondary' }} ms-2">
                                                    {{ ucfirst($service->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="btn-action-group">
                                            <a href="{{ route('admin.government.services.show', $service) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.government.services.edit', $service) }}" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-center py-4">
                                    <i class="fas fa-cogs text-muted mb-2" style="font-size: 2rem;"></i>
                                    <p class="mb-0">{{ __('No services found') }}</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Rest of the dashboard content -->
        @include('admin.government.dashboard.recent-projects-news')
        @include('admin.government.dashboard.active-announcements')
    </div>
</div>
@endsection
