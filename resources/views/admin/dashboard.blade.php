@extends('layouts.admin')

@section('title', __('Dashboard'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard-fix.css') }}">
<style>
    /* Emergency inline fixes for dashboard visibility */
    .card, .table, .progress, .icon-box, .chart-container {
        visibility: visible !important;
        opacity: 1 !important;
        display: block !important;
    }
    
    .row {
        display: flex !important;
        flex-wrap: wrap !important;
    }
    
    .table {
        display: table !important;
    }
    
    .table tr {
        display: table-row !important;
    }
    
    .table th, .table td {
        display: table-cell !important;
    }
    
    .icon-box, .progress {
        display: flex !important;
    }
    
    .flex-shrink-0, .flex-grow-1 {
        visibility: visible !important;
        opacity: 1 !important;
    }
    
    /* Fix for dashboard tables */
    .dashboard-recent-tables {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        overflow-x: auto !important;
        width: 100% !important;
    }
    
    .dashboard-recent-tables .table {
        width: 100% !important;
        margin: 0 !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    
    /* Fix for cards overlapping */
    .row > .col-12 > .card {
        margin-bottom: 2rem !important;
    }
    
    /* Fix for top nav buttons */
    @media (max-width: 767px) {
        .d-flex.justify-content-lg-end {
            flex-wrap: wrap;
        }
        
        .dropdown, .btn {
            margin-bottom: 10px;
        }
    }
    
    /* Fix for refresh button */
    .btn-primary {
        white-space: nowrap;
    }
    
    /* Fix for navbar container */
    .navbar .container-fluid {
        max-width: 100%;
        padding-right: 15px;
        overflow: visible;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Dashboard Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h2 class="section-heading">{{ __('Welcome to Micheweni Waste Portal') }}</h2>
                            <p class="text-muted">{{ __('Monitor your waste portal performance with real-time analytics and insights') }}</p>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex justify-content-lg-end align-items-center mt-3 mt-lg-0">
                                <div class="dropdown me-2">
                                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-file-export me-1"></i><span class="d-none d-sm-inline">{{ __('Export') }}</span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i>{{ __('Export to PDF') }}</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-file-csv me-2"></i>{{ __('Export to CSV') }}</a></li>
                                    </ul>
                                </div>
                                <button class="btn btn-primary">
                                    <i class="fas fa-sync-alt me-1"></i><span class="d-none d-sm-inline">{{ __('Refresh') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="icon-box bg-primary-soft rounded-circle p-3 me-3">
                                <i class="fas fa-file-alt fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="display-6 fw-bold mb-0">{{ $totalPages }}</h3>
                            <div class="text-muted">{{ __('Pages') }}</div>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ min(100, $totalPages * 5) }}%" aria-valuenow="{{ $totalPages }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="icon-box bg-success-soft rounded-circle p-3 me-3">
                                <i class="fas fa-newspaper fa-2x text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="display-6 fw-bold mb-0">{{ $totalNews }}</h3>
                            <div class="text-muted">{{ __('News Articles') }}</div>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ min(100, $totalNews * 5) }}%" aria-valuenow="{{ $totalNews }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="icon-box bg-info-soft rounded-circle p-3 me-3">
                                <i class="fas fa-clipboard-list fa-2x text-info"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="display-6 fw-bold mb-0">{{ $totalSubmissions }}</h3>
                            <div class="text-muted">{{ __('Form Submissions') }}</div>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ min(100, $totalSubmissions * 2) }}%" aria-valuenow="{{ $totalSubmissions }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
            <div class="card border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="icon-box bg-warning-soft rounded-circle p-3 me-3">
                                <i class="fas fa-users fa-2x text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="display-6 fw-bold mb-0">{{ $totalUsers }}</h3>
                            <div class="text-muted">{{ __('Users') }}</div>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ min(100, $totalUsers * 3) }}%" aria-valuenow="{{ $totalUsers }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Activity Chart -->
        <div class="col-xl-8 col-lg-7" data-aos="fade-up" data-aos-delay="100">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="mb-0 fw-bold">{{ __('Portal Activity') }}</h5>
                        <div class="btn-group dashboard-filters mt-2 mt-sm-0" role="group">
                            <button type="button" class="btn btn-sm btn-outline-secondary active">{{ __('Weekly') }}</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">{{ __('Monthly') }}</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">{{ __('Yearly') }}</button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="chart-container">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent News -->
        <div class="col-xl-4 col-lg-5" data-aos="fade-up" data-aos-delay="200">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">{{ __('Recent News') }}</h5>
                        <a href="{{ route('admin.news.index') }}" class="text-decoration-none">{{ __('View All') }} <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recentNews as $news)
                        <div class="list-group-item p-4 border-0 border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary-soft text-primary rounded-pill">{{ $news->category->name ?? 'Uncategorized' }}</span>
                                <small class="text-muted">{{ $news->created_at->diffForHumans() }}</small>
                            </div>
                            <h6 class="mb-2 fw-bold">{{ $news->title }}</h6>
                            <p class="mb-2 text-muted small">{{ Str::limit($news->excerpt, 80) }}</p>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    {{ substr($news->author->name ?? 'Admin', 0, 1) }}
                                </div>
                                <div class="small">{{ $news->author->name ?? 'Admin' }}</div>
                                <div class="ms-auto">
                                    <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                        <i class="fas fa-edit me-1"></i>{{ __('Edit') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="list-group-item p-4 border-0 text-center">
                            <div class="py-5">
                                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                <p class="mb-0">{{ __('No recent news articles.') }}</p>
                                <a href="{{ route('admin.news.create') }}" class="btn btn-sm btn-primary mt-3">
                                    <i class="fas fa-plus me-1"></i>{{ __('Add News') }}
                                </a>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recently Updated Pages -->
<div class="row" data-aos="fade-up" data-aos-delay="300">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-file-alt me-1"></i>
                    {{ __('Recently Updated Pages') }}
                </div>
                <div>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-right"></i> {{ __('View All') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($recentPages->isEmpty())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-1"></i>
                        {{ __('No recent pages found.') }}
                    </div>
                    <p>{{ __('Pages will appear here as they are created or updated.') }}</p>
                    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> {{ __('Create Your First Page') }}
                    </a>
                @else
                    <div class="table-responsive dashboard-recent-tables">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Template') }}</th>
                                    <th>{{ __('Last Updated') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPages as $page)
                                    <tr>
                                        <td data-label="{{ __('Title') }}">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-file-alt me-2 text-primary"></i>
                                                <div>
                                                    <strong>{{ $page->title }}</strong>
                                                    <div class="small text-muted">{{ $page->slug }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('Template') }}">
                                            <span class="badge bg-light text-dark">{{ $page->template }}</span>
                                        </td>
                                        <td data-label="{{ __('Last Updated') }}">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-clock text-muted me-2"></i>
                                                <span>{{ $page->updated_at->format('M d, Y H:i') }}</span>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('Status') }}">
                                            @if($page->is_published ?? true)
                                                <span class="badge bg-success">{{ __('Published') }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ __('Draft') }}</span>
                                            @endif
                                        </td>
                                        <td data-label="{{ __('Actions') }}">
                                            <div class="btn-group btn-action-group" role="group">
                                                <a href="{{ route('page.show', $page->slug) }}" class="btn btn-sm btn-outline-info" target="_blank">
                                                    <i class="fas fa-eye me-1"></i> 
                                                </a>
                                                <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit me-1"></i> 
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="if(confirm('{{ __('Are you sure you want to delete this page?') }}')) document.getElementById('delete-page-{{ $page->id }}').submit();">
                                                    <i class="fas fa-trash"></i> 
                                                </button>
                                                <form id="delete-page-{{ $page->id }}" action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recent Form Submissions -->
<div class="row" data-aos="fade-up" data-aos-delay="300">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-clipboard-list me-1"></i>
                    {{ __('Recent Form Submissions') }}
                </div>
                <div>
                    <a href="{{ route('admin.form-submissions.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-right"></i> {{ __('View All') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($recentSubmissions->isEmpty())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-1"></i>
                        {{ __('No recent form submissions found.') }}
                    </div>
                    <p>{{ __('Form submissions will appear here as users submit forms.') }}</p>
                @else
                    <div class="table-responsive dashboard-recent-tables">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('Form') }}</th>
                                    <th>{{ __('Submitted By') }}</th>
                                    <th>{{ __('Submitted') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentSubmissions as $submission)
                                    <tr>
                                        <td data-label="{{ __('Form') }}">
                                            <div class="d-flex align-items-center">
                                                @if($submission->form->icon ?? false)
                                                    <i class="fas {{ $submission->form->icon }} me-2 text-primary"></i>
                                                @else
                                                    <i class="fas fa-clipboard-list me-2 text-primary"></i>
                                                @endif
                                                <div>
                                                    <strong>{{ $submission->form->title ?? 'Unknown Form' }}</strong>
                                                    <div class="small text-muted">#{{ $submission->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('Submitted By') }}">
                                            @if($submission->user)
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-user me-2 text-muted"></i>
                                                    <span>{{ $submission->user->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-muted">{{ __('Anonymous') }}</span>
                                            @endif
                                        </td>
                                        <td data-label="{{ __('Submitted') }}">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-clock text-muted me-2"></i>
                                                <span>{{ $submission->created_at->format('M d, Y H:i') }}</span>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('Status') }}">
                                            @if($submission->status === 'pending')
                                                <span class="badge bg-warning">{{ __('Pending') }}</span>
                                            @elseif($submission->status === 'reviewed')
                                                <span class="badge bg-success">{{ __('Reviewed') }}</span>
                                            @elseif($submission->status === 'rejected')
                                                <span class="badge bg-danger">{{ __('Rejected') }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($submission->status) }}</span>
                                            @endif
                                        </td>
                                        <td data-label="{{ __('Actions') }}">
                                            <div class="btn-group btn-action-group" role="group">
                                                <a href="{{ route('admin.form-submissions.show', $submission->id) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye me-1"></i> 
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="if(confirm('{{ __('Are you sure you want to delete this submission?') }}')) document.getElementById('delete-submission-{{ $submission->id }}').submit();">
                                                    <i class="fas fa-trash"></i> 
                                                </button>
                                                <form id="delete-submission-{{ $submission->id }}" action="{{ route('admin.form-submissions.destroy', $submission->id) }}" method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

    <!-- Quick Actions Section -->
    <!-- <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Quick Actions') }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.home-config-guide') }}" class="text-decoration-none">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body text-center p-4">
                                        <div class="icon-box bg-primary-soft rounded-circle p-3 mx-auto mb-3" style="width: fit-content;">
                                            <i class="fas fa-home fa-2x text-primary"></i>
                                        </div>
                                        <h5 class="card-title mb-2">{{ __('Home Page Guide') }}</h5>
                                        <p class="card-text text-muted small">{{ __('Configure home page content blocks and sections') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.form-builders.index') }}" class="text-decoration-none">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body text-center p-4">
                                        <div class="icon-box bg-success-soft rounded-circle p-3 mx-auto mb-3" style="width: fit-content;">
                                            <i class="fas fa-list-alt fa-2x text-success"></i>
                                        </div>
                                        <h5 class="card-title mb-2">{{ __('Form Builder') }}</h5>
                                        <p class="card-text text-muted small">{{ __('Create and manage dynamic forms for your site') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.contents.index') }}" class="text-decoration-none">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body text-center p-4">
                                        <div class="icon-box bg-info-soft rounded-circle p-3 mx-auto mb-3" style="width: fit-content;">
                                            <i class="fas fa-file-alt fa-2x text-info"></i>
                                        </div>
                                        <h5 class="card-title mb-2">{{ __('Content Blocks') }}</h5>
                                        <p class="card-text text-muted small">{{ __('Manage reusable content blocks throughout the site') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="" class="text-decoration-none">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body text-center p-4">
                                        <div class="icon-box bg-warning-soft rounded-circle p-3 mx-auto mb-3" style="width: fit-content;">
                                            <i class="fas fa-map-marker-alt fa-2x text-warning"></i>
                                        </div>
                                        <h5 class="card-title mb-2">{{ __('Waste Locations') }}</h5>
                                        <p class="card-text text-muted small">{{ __('Manage waste collection points and facilities') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize Chart
    var ctx = document.getElementById('activityChart').getContext('2d');
    
    // Use real data from the controller
    var labels = @json($activityData['months']);
    var datasets = [

        {
            label: 'Form Submissions',
            data: @json($activityData['formSubmissions']),
            borderColor: 'rgba(46, 204, 113, 1)',
            backgroundColor: 'rgba(46, 204, 113, 0.1)',
            tension: 0.4,
            fill: true
        }
    ];
    
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 10,
                        font: {
                            size: 12,
                            family: "'Poppins', sans-serif"
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#333',
                    bodyColor: '#666',
                    bodyFont: {
                        size: 14,
                        family: "'Poppins', sans-serif"
                    },
                    titleFont: {
                        size: 16,
                        family: "'Poppins', sans-serif",
                        weight: 'bold'
                    },
                    borderColor: '#ddd',
                    borderWidth: 1,
                    boxPadding: 8,
                    cornerRadius: 8,
                    displayColors: true,
                    usePointStyle: true
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    }
                }
            },
            elements: {
                point: {
                    radius: 4,
                    hoverRadius: 6
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });
    
    // Add interactivity
    var dashboardCards = document.querySelectorAll('.card');
    dashboardCards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.08)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.boxShadow = '0 5px 20px rgba(0, 0, 0, 0.05)';
        });
    });
});
</script>
@endsection 