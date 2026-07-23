<x-app-layout>
    <style>
        /* Fix chart containers overlapping */
        .chart-container {
            position: relative;
            z-index: 1;
            background-color: #f8f9fa;
            margin-bottom: 20px;
            overflow: visible;
        }
        
        .tab-content {
            position: relative;
            z-index: 1;
            overflow: visible;
        }
        
        .tab-pane {
            position: relative;
            z-index: 1;
            overflow: visible;
        }
        
        /* Ensure cards don't overlap */
        .card {
            position: relative;
            z-index: 1;
            background-color: #fff;
            margin-bottom: 20px;
            overflow: visible;
        }
        
        /* Fix for row layout */
        .row {
            position: relative;
            z-index: 1;
            overflow: visible;
            clear: both;
        }
        
        /* Make sure columns don't overlap */
        .col-lg-4, .col-lg-6, .col-lg-8, .col-md-3, .col-md-6 {
            overflow: visible;
        }
        
        /* Fix for stat cards */
        .stat-card {
            margin-bottom: 20px;
        }
        
        /* Fix for canvas elements */
        canvas {
            position: relative;
            z-index: 1;
        }
    </style>

    <!-- Dashboard Header and Filters -->
    <div class="bg-gradient-to-r from-green-800 to-green-600 text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold mb-2">{{ __('Waste Data Dashboard') }}</h1>
                    <p class="lead mb-0">{{ __('Interactive data visualization and analytics for waste management in Micheweni, Pemba.') }}</p>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex flex-wrap justify-content-lg-end mt-4 mt-lg-0 gap-2">
                        <div class="dropdown me-2">
                            <button class="btn btn-light dropdown-toggle" type="button" id="periodDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-calendar-alt me-2"></i> {{ __('2025') }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="periodDropdown">
                                <li><a class="dropdown-item" href="#">{{ __('2025') }}</a></li>
                                <li><a class="dropdown-item" href="#">{{ __('2022') }}</a></li>
                                <li><a class="dropdown-item" href="#">{{ __('2021') }}</a></li>
                            </ul>
                        </div>
                        <div class="dropdown me-2">
                            <button class="btn btn-light dropdown-toggle" type="button" id="regionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-map-marker-alt me-2"></i> {{ __('All Regions') }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="regionDropdown">
                                <li><a class="dropdown-item" href="#">{{ __('All Regions') }}</a></li>
                                <li><a class="dropdown-item" href="#">{{ __('Micheweni Town') }}</a></li>
                                <li><a class="dropdown-item" href="#">{{ __('Northern') }}</a></li>
                                <li><a class="dropdown-item" href="#">{{ __('Southern') }}</a></li>
                                <li><a class="dropdown-item" href="#">{{ __('Eastern') }}</a></li>
                                <li><a class="dropdown-item" href="#">{{ __('Western') }}</a></li>
                            </ul>
                        </div>
                        <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="fas fa-download me-2"></i> {{ __('Export Data') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <!-- Key Stats Cards with Animation -->
        <div class="row mb-5">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 stat-card stat-collected">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon bg-primary-subtle text-primary rounded-circle me-3">
                                <i class="fas fa-trash-alt"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-0">{{ __('Waste Collected') }}</h6>
                                <h3 class="mb-0 counter-value" data-target="124">0</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="stat-label">{{ __('Tons Last Month') }}</div>
                            <div class="ms-auto stat-change">
                                <span class="badge bg-success-subtle text-success rounded-pill">
                                    <i class="fas fa-arrow-up me-1"></i> 5.3%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 stat-card stat-recycled">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon bg-success-subtle text-success rounded-circle me-3">
                                <i class="fas fa-recycle"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-0">{{ __('Waste Recycled') }}</h6>
                                <h3 class="mb-0 counter-value" data-target="37">0</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="stat-label">{{ __('Tons Last Month') }}</div>
                            <div class="ms-auto stat-change">
                                <span class="badge bg-success-subtle text-success rounded-pill">
                                    <i class="fas fa-arrow-up me-1"></i> 8.2%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 stat-card stat-points">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon bg-warning-subtle text-warning rounded-circle me-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-0">{{ __('Collection Points') }}</h6>
                                <h3 class="mb-0 counter-value" data-target="28">0</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="stat-label">{{ __('Active Points') }}</div>
                            <div class="ms-auto stat-change">
                                <span class="badge bg-success-subtle text-success rounded-pill">
                                    <i class="fas fa-plus me-1"></i> 2 new
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 stat-card stat-vehicles">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon bg-info-subtle text-info rounded-circle me-3">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-0">{{ __('Collection Vehicles') }}</h6>
                                <h3 class="mb-0 counter-value" data-target="12">0</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="stat-label">{{ __('In Service') }}</div>
                            <div class="ms-auto stat-change">
                                <span class="badge bg-success-subtle text-success rounded-pill">
                                    <i class="fas fa-check me-1"></i> 100%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard content -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm mb-4 border-0 rounded-4">
                    <div class="card-body p-4">
                        <!-- Tab Navigation for Different Visualizations -->
                        <ul class="nav nav-pills nav-fill mb-4" id="dashboardTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">
                                    <i class="fas fa-chart-line me-2"></i> {{ __('Overview') }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="composition-tab" data-bs-toggle="tab" data-bs-target="#composition" type="button" role="tab" aria-controls="composition" aria-selected="false">
                                    <i class="fas fa-chart-pie me-2"></i> {{ __('Waste Composition') }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="recycling-tab" data-bs-toggle="tab" data-bs-target="#recycling" type="button" role="tab" aria-controls="recycling" aria-selected="false">
                                    <i class="fas fa-recycle me-2"></i> {{ __('Recycling Metrics') }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="geographic-tab" data-bs-toggle="tab" data-bs-target="#geographic" type="button" role="tab" aria-controls="geographic" aria-selected="false">
                                    <i class="fas fa-map-marked-alt me-2"></i> {{ __('Geographic Data') }}
                                </button>
                            </li>
                        </ul>
                        
                        <!-- Tab Content -->
                        <div class="tab-content" id="dashboardTabContent">
                            <!-- Overview Tab -->
                            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                <div class="row">
                                    <div class="col-lg-8 mb-4">
                                        <div class="chart-container p-3 bg-light rounded-4 shadow-sm">
                                            <div class="d-flex justify-content-between mb-3">
                                                <h5 class="mb-0">{{ __('Monthly Waste Collection (2025)') }}</h5>
                                                <div class="chart-controls">
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <button type="button" class="btn btn-outline-primary active" data-chart-period="month">{{ __('Monthly') }}</button>
                                                        <button type="button" class="btn btn-outline-primary" data-chart-period="quarter">{{ __('Quarterly') }}</button>
                                                        <button type="button" class="btn btn-outline-primary" data-chart-period="year">{{ __('Yearly') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <canvas id="monthly-collection-chart" height="300"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-4">
                                        <div class="chart-container p-3 bg-light rounded-4 shadow-sm h-100">
                                            <div class="d-flex justify-content-between mb-3">
                                                <h5 class="mb-0">{{ __('Waste Composition') }}</h5>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="compositionPeriodDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                        {{ __('September 2025') }}
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="compositionPeriodDropdown">
                                                        <li><a class="dropdown-item" href="#">{{ __('September 2025') }}</a></li>
                                                        <li><a class="dropdown-item" href="#">{{ __('August 2025') }}</a></li>
                                                        <li><a class="dropdown-item" href="#">{{ __('Q3 2025') }}</a></li>
                                                        <li><a class="dropdown-item" href="#">{{ __('2025 Overall') }}</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <canvas id="waste-composition-chart" height="300"></canvas>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-6 mb-4">
                                        <div class="chart-container p-3 bg-light rounded-4 shadow-sm">
                                            <div class="d-flex justify-content-between mb-3">
                                                <h5 class="mb-0">{{ __('Recycling Rate Trend') }}</h5>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="showTargetLine" checked>
                                                    <label class="form-check-label small" for="showTargetLine">{{ __('Show Target') }}</label>
                                                </div>
                                            </div>
                                            <canvas id="recycling-trend-chart" height="250"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-4">
                                        <div class="chart-container p-3 bg-light rounded-4 shadow-sm">
                                            <div class="d-flex justify-content-between mb-3">
                                                <h5 class="mb-0">{{ __('Collection by District') }}</h5>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="districtPeriodDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                        {{ __('September 2025') }}
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="districtPeriodDropdown">
                                                        <li><a class="dropdown-item" href="#">{{ __('September 2025') }}</a></li>
                                                        <li><a class="dropdown-item" href="#">{{ __('August 2025') }}</a></li>
                                                        <li><a class="dropdown-item" href="#">{{ __('Q3 2025') }}</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <canvas id="district-collection-chart" height="250"></canvas>
                            </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Waste Composition Tab -->
                            <div class="tab-pane fade" id="composition" role="tabpanel" aria-labelledby="composition-tab">
                                <div class="row">
                                    <div class="col-lg-7 mb-4">
                                        <div class="chart-container p-3 bg-light rounded-4 shadow-sm">
                                            <h5 class="mb-3">{{ __('Detailed Waste Composition Analysis') }}</h5>
                                            <canvas id="detailed-composition-chart" height="400"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 mb-4">
                                        <div class="chart-container p-3 bg-light rounded-4 shadow-sm">
                                            <h5 class="mb-3">{{ __('Composition Trends (2021-2025)') }}</h5>
                                            <canvas id="composition-trend-chart" height="300"></canvas>
                                            <div class="mt-3">
                                                <div class="d-flex justify-content-between small text-muted">
                                                    <div>{{ __('Click on a waste type to see detailed trend') }}</div>
                                                    <div><i class="fas fa-info-circle me-1"></i> {{ __('Source: Waste Audits') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div class="card bg-light border-0 rounded-4 shadow-sm">
                                            <div class="card-header bg-transparent border-0">
                                                <h5 class="mb-0">{{ __('Waste Type Breakdown') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('Waste Type') }}</th>
                                                                <th>{{ __('Percentage') }}</th>
                                                                <th>{{ __('Volume (tons)') }}</th>
                                                                <th>{{ __('Recyclability') }}</th>
                                                                <th>{{ __('Year-on-Year Change') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><i class="fas fa-leaf text-success me-2"></i> {{ __('Organic') }}</td>
                                                                <td>45%</td>
                                                                <td>58.5</td>
                                                                <td>
                                                                    <div class="progress" style="height: 8px;">
                                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                    <span class="small">90% - {{ __('High') }}</span>
                                                                </td>
                                                                <td><span class="text-success"><i class="fas fa-arrow-down me-1"></i> 2.3%</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><i class="fas fa-wine-bottle text-primary me-2"></i> {{ __('Plastic') }}</td>
                                                                <td>20%</td>
                                                                <td>26.0</td>
                                                                <td>
                                                                    <div class="progress" style="height: 8px;">
                                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                    <span class="small">65% - {{ __('Medium') }}</span>
                                                                </td>
                                                                <td><span class="text-danger"><i class="fas fa-arrow-up me-1"></i> 4.1%</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><i class="fas fa-newspaper text-secondary me-2"></i> {{ __('Paper') }}</td>
                                                                <td>15%</td>
                                                                <td>19.5</td>
                                                                <td>
                                                                    <div class="progress" style="height: 8px;">
                                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                    <span class="small">85% - {{ __('High') }}</span>
                                                                </td>
                                                                <td><span class="text-success"><i class="fas fa-arrow-down me-1"></i> 1.5%</span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                </div>
                            </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Recycling Metrics Tab -->
                            <div class="tab-pane fade" id="recycling" role="tabpanel" aria-labelledby="recycling-tab">
                                <div class="alert alert-success mb-4">
                                    <i class="fas fa-info-circle me-2"></i> 
                                    {{ __('The recycling rate has increased by 5.2% compared to the same period last year, exceeding the annual target.') }}
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-8 mb-4">
                                        <div class="chart-container p-3 bg-light rounded-4 shadow-sm">
                                            <h5 class="mb-3">{{ __('Recycling Performance vs. Targets') }}</h5>
                                            <canvas id="recycling-performance-chart" height="300"></canvas>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-4">
                                        <div class="chart-container p-3 bg-light rounded-4 shadow-sm h-100">
                                            <h5 class="mb-3">{{ __('Material Recovery Rate') }}</h5>
                                            <canvas id="recovery-rate-chart" height="250"></canvas>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        
                            <!-- Geographic Data Tab -->
                            <div class="tab-pane fade" id="geographic" role="tabpanel" aria-labelledby="geographic-tab">
                                <div class="row">
                                    <div class="col-lg-8 mb-4">
                                        <div class="chart-container p-3 bg-light rounded-4 shadow-sm">
                                            <div class="d-flex justify-content-between mb-3">
                                                <h5 class="mb-0">{{ __('Global Circularity Index') }}</h5>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="circularity-year-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                        {{ __('2025') }}
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="circularity-year-dropdown">
                                                        <li><a class="dropdown-item" href="#">{{ __('2025') }}</a></li>
                                                        <li><a class="dropdown-item" href="#">{{ __('2022') }}</a></li>
                                                        <li><a class="dropdown-item" href="#">{{ __('2021') }}</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div id="circularity-map" style="height: 400px;"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-4">
                                        <div class="chart-container p-3 bg-light rounded-4 shadow-sm h-100">
                                            <h5 class="mb-3">{{ __('Top Countries by Circularity') }}</h5>
                                            <div class="circularity-leaderboard">
                                                @foreach($circularityData['countries'] as $index => $country)
                                                    @if($index < 10)
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="position-relative me-3">
                                                            <div class="circularity-rank">{{ $index + 1 }}</div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                                <span class="fw-medium">{{ $country['name'] }}</span>
                                                                <span class="badge bg-success">{{ $country['score'] }}%</span>
                                                            </div>
                                                            <div class="progress" style="height: 6px;">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $country['score'] }}%" aria-valuenow="{{ $country['score'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="chart-container p-3 bg-light rounded-4 shadow-sm h-100">
                                            <h5 class="mb-3">{{ __('Circularity Progress Over Time') }}</h5>
                                            <canvas id="circularity-trend-chart" height="250"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="chart-container p-3 bg-light rounded-4 shadow-sm h-100">
                                            <h5 class="mb-3">{{ __('Regional Circularity Comparison') }}</h5>
                                            <div id="regional-comparison" style="height: 250px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">{{ __('Waste Collection Reports') }}</h5>
                                            <button class="btn btn-sm btn-outline-light">
                                                <i class="fas fa-plus me-1"></i> {{ __('View All Reports') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('Report Name') }}</th>
                                                        <th>{{ __('Period') }}</th>
                                                        <th>{{ __('Date Published') }}</th>
                                                        <th>{{ __('Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ __('Monthly Waste Collection Report') }}</td>
                                                        <td>{{ __('August 2025') }}</td>
                                                        <td>{{ __('September 5, 2025') }}</td>
                                                        <td>
                                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-download me-1"></i> {{ __('Download') }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('Quarterly Recycling Report') }}</td>
                                                        <td>{{ __('Q2 2025') }}</td>
                                                        <td>{{ __('July 15, 2025') }}</td>
                                                        <td>
                                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-download me-1"></i> {{ __('Download') }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('Annual Waste Management Summary') }}</td>
                                                        <td>{{ __('2022') }}</td>
                                                        <td>{{ __('February 10, 2025') }}</td>
                                                        <td>
                                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-download me-1"></i> {{ __('Download') }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">{{ __('Export Data') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="exportFormat" class="form-label">{{ __('Format') }}</label>
                            <select class="form-select" id="exportFormat">
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel</option>
                                <option value="csv">CSV</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exportPeriod" class="form-label">{{ __('Time Period') }}</label>
                            <select class="form-select" id="exportPeriod">
                                <option value="current">{{ __('Current Month') }}</option>
                                <option value="quarter">{{ __('Current Quarter') }}</option>
                                <option value="year">{{ __('Year to Date') }}</option>
                                <option value="custom">{{ __('Custom Range') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exportContent" class="form-label">{{ __('Data to Include') }}</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="includeCollectionData" checked>
                                <label class="form-check-label" for="includeCollectionData">
                                    {{ __('Collection Data') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="includeRecyclingData" checked>
                                <label class="form-check-label" for="includeRecyclingData">
                                    {{ __('Recycling Metrics') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="includeCompositionData" checked>
                                <label class="form-check-label" for="includeCompositionData">
                                    {{ __('Waste Composition Data') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="includeGeographicData">
                                <label class="form-check-label" for="includeGeographicData">
                                    {{ __('Geographic Distribution') }}
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-primary">{{ __('Export') }}</button>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/jvectormap@2.0.4/jquery-jvectormap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jvectormap@2.0.4/jquery-jvectormap-world-mill.js"></script>

    <script>
        // Check if Chart.js is loaded
        function isChartJsLoaded() {
            return typeof Chart !== 'undefined';
        }
        
        // Check if Leaflet is loaded
        function isLeafletLoaded() {
            return typeof L !== 'undefined';
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure libraries are loaded
            if (!isChartJsLoaded()) {
                console.error('Chart.js is not loaded properly');
                return;
            }
            
            // Counter animation
            const counterElements = document.querySelectorAll('.counter-value');
            counterElements.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const duration = 2000; // 2 seconds
                const step = Math.ceil(target / (duration / 20)); // Update every 20ms
                let current = 0;
                
                const updateCounter = () => {
                    current += step;
                    if (current > target) current = target;
                    counter.textContent = current;
                    
                    if (current < target) {
                        setTimeout(updateCounter, 20);
                    }
                };
                
                updateCounter();
            });
            
            // Monthly Collection Chart
            const monthlyCollectionCtx = document.getElementById('monthly-collection-chart');
            if (monthlyCollectionCtx) {
                const monthlyCollectionChart = new Chart(monthlyCollectionCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        {
                            label: '{{ __("Total Waste (tons)") }}',
                            data: [98, 105, 110, 115, 112, 120, 125, 124, 130, 0, 0, 0],
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: '{{ __("Recycled (tons)") }}',
                            data: [25, 28, 30, 32, 31, 34, 36, 37, 39, 0, 0, 0],
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: '{{ __("Tons") }}'
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    footer: (tooltipItems) => {
                                        const item = tooltipItems[0];
                                        const datasetIndex = item.datasetIndex;
                                        if (datasetIndex === 1) {
                                            const total = tooltipItems[0].dataset.data[item.dataIndex];
                                            const percentage = total > 0 ? Math.round((total / tooltipItems[0].dataset.data[item.dataIndex]) * 100) : 0;
                                            return `{{ __("Recycling Rate") }}: ${percentage}%`;
                                        }
                                        return '';
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            // Waste Composition Chart
            const wasteCompositionCtx = document.getElementById('waste-composition-chart');
            if (wasteCompositionCtx) {
                const wasteCompositionChart = new Chart(wasteCompositionCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['{{ __("Organic") }}', '{{ __("Plastic") }}', '{{ __("Paper") }}', '{{ __("Glass") }}', '{{ __("Metal") }}', '{{ __("Other") }}'],
                    datasets: [{
                        data: [45, 20, 15, 8, 7, 5],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)',
                            'rgba(201, 203, 207, 0.7)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        return `${label}: ${value}%`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            // Recycling Trend Chart
            const recyclingTrendCtx = document.getElementById('recycling-trend-chart');
            if (recyclingTrendCtx) {
                const recyclingTrendChart = new Chart(recyclingTrendCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                    datasets: [{
                        label: '{{ __("Recycling Rate (%)") }}',
                        data: [25.5, 26.7, 27.3, 27.8, 27.7, 28.3, 28.8, 29.8, 30.0],
                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                        },
                        {
                            label: '{{ __("Target (%)") }}',
                            data: [25, 25, 25, 25, 25, 25, 25, 25, 25],
                            borderColor: 'rgba(220, 53, 69, 0.7)',
                            borderWidth: 2,
                            borderDash: [5, 5],
                            fill: false,
                            pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 20,
                            max: 35,
                            title: {
                                display: true,
                                text: '{{ __("Percentage (%)") }}'
                            }
                        }
                    }
                }
            });
                
                // Toggle target line
                const showTargetLine = document.getElementById('showTargetLine');
                if (showTargetLine) {
                    showTargetLine.addEventListener('change', function() {
                        recyclingTrendChart.data.datasets[1].hidden = !this.checked;
                        recyclingTrendChart.update();
                    });
                }
            }
            
            // District Collection Chart
            const districtCollectionCtx = document.getElementById('district-collection-chart');
            if (districtCollectionCtx) {
                const districtCollectionChart = new Chart(districtCollectionCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['{{ __("Micheweni Town") }}', '{{ __("Northern") }}', '{{ __("Southern") }}', '{{ __("Eastern") }}', '{{ __("Western") }}'],
                    datasets: [{
                        label: '{{ __("Waste Collected (tons)") }}',
                        data: [48, 22, 18, 25, 17],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: '{{ __("Tons") }}'
                            }
                        }
                    }
                }
            });
            }
            
            // Detailed composition chart
            const detailedCompositionCtx = document.getElementById('detailed-composition-chart');
            if (detailedCompositionCtx) {
                const detailedCompositionChart = new Chart(detailedCompositionCtx.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: [
                            '{{ __("Food Waste") }}', 
                            '{{ __("Garden Waste") }}', 
                            '{{ __("PET Plastic") }}',
                            '{{ __("HDPE Plastic") }}',
                            '{{ __("LDPE Plastic") }}',
                            '{{ __("Cardboard") }}',
                            '{{ __("Paper") }}',
                            '{{ __("Glass") }}',
                            '{{ __("Metal") }}',
                            '{{ __("Textiles") }}',
                            '{{ __("E-Waste") }}',
                            '{{ __("Other") }}'
                        ],
                        datasets: [{
                            data: [30, 15, 8, 6, 6, 8, 7, 8, 7, 3, 1, 1],
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(120, 192, 100, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(54, 120, 235, 0.7)',
                                'rgba(54, 90, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(255, 180, 86, 0.7)',
                                'rgba(153, 102, 255, 0.7)',
                                'rgba(255, 159, 64, 0.7)',
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(100, 99, 132, 0.7)',
                                'rgba(201, 203, 207, 0.7)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                            }
                        }
                    }
                });
            }
            
            // Initialize waste map if it exists
            const wasteMapElement = document.getElementById('waste-map');
            if (wasteMapElement && isLeafletLoaded()) {
                const map = L.map('waste-map').setView([-5.0535, 39.7194], 12);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
                
                // Sample collection points
                const collectionPoints = [
                    {name: 'Micheweni Central', lat: -5.0535, lng: 39.7194, status: 'optimal', volume: 12.3},
                    {name: 'Northern Market', lat: -5.0435, lng: 39.7294, status: 'warning', volume: 8.7},
                    {name: 'Southern District', lat: -5.0635, lng: 39.7094, status: 'optimal', volume: 6.2},
                    {name: 'Eastern Area', lat: -5.0535, lng: 39.7394, status: 'optimal', volume: 5.8},
                    {name: 'Western District', lat: -5.0535, lng: 39.6994, status: 'warning', volume: 7.9}
                ];
                
                collectionPoints.forEach(point => {
                    const markerColor = point.status === 'optimal' ? 'green' : 'orange';
                    const markerIcon = L.divIcon({
                        className: 'custom-div-icon',
                        html: `<div style="background-color: ${markerColor}; width: 15px; height: 15px; border-radius: 50%; border: 2px solid white;"></div>`,
                        iconSize: [15, 15],
                        iconAnchor: [7, 7]
                    });
                    
                    L.marker([point.lat, point.lng], {icon: markerIcon})
                        .addTo(map)
                        .bindPopup(`
                            <strong>${point.name}</strong><br>
                            Volume: ${point.volume} tons<br>
                            Status: ${point.status === 'optimal' ? 'Optimal' : 'Near Capacity'}
                        `);
                });
            }
            
            // Initialize circularity map
            if (typeof $.fn.vectorMap === 'function' && document.getElementById('circularity-map')) {
                // Prepare map data
                const mapData = {};
                const countryData = @json($circularityData['countries']);
                
                // Convert country data to map format
                countryData.forEach(country => {
                    // Using 2-letter ISO country codes
                    const countryCode = getCountryCode(country.name);
                    if (countryCode) {
                        mapData[countryCode] = country.score;
                    }
                });
                
                // Initialize map
                $('#circularity-map').vectorMap({
                    map: 'world_mill',
                    backgroundColor: 'transparent',
                    zoomOnScroll: false,
                    series: {
                        regions: [{
                            values: mapData,
                            scale: ['#e9ecef', '#198754'],
                            normalizeFunction: 'linear'
                        }]
                    },
                    onRegionTipShow: function(e, el, code) {
                        if (mapData[code]) {
                            el.html(el.html() + ': ' + mapData[code] + '%');
                        } else {
                            el.html(el.html() + ': No data');
                        }
                    },
                    regionStyle: {
                        initial: {
                            fill: '#e9ecef',
                            "fill-opacity": 1,
                            stroke: 'none',
                            "stroke-width": 0,
                            "stroke-opacity": 1
                        },
                        hover: {
                            "fill-opacity": 0.8,
                            cursor: 'pointer'
                        }
                    }
                });
            }
            
            // Initialize circularity trend chart
            if (typeof Chart === 'function' && document.getElementById('circularity-trend-chart')) {
                const ctx = document.getElementById('circularity-trend-chart').getContext('2d');
                
                const trendChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($circularityData['years']),
                        datasets: [
                            {
                                label: 'Tanzania',
                                data: @json($circularityData['tanzania_progress']),
                                borderColor: '#198754',
                                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Kenya',
                                data: @json($circularityData['kenya_progress']),
                                borderColor: '#fd7e14',
                                backgroundColor: 'rgba(253, 126, 20, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Global Average',
                                data: [42, 44, 46, 49, 52, 55],
                                borderColor: '#6c757d',
                                backgroundColor: 'rgba(108, 117, 125, 0.1)',
                                borderDash: [5, 5],
                                tension: 0.4,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        scales: {
                            y: {
                                min: 0,
                                max: 100,
                                title: {
                                    display: true,
                                    text: 'Circularity Score (%)'
                                }
                            }
                        }
                    }
                });
            }
            
            // Regional comparison chart using JVectorMap
            if (typeof $.fn.vectorMap === 'function' && document.getElementById('regional-comparison')) {
                $('#regional-comparison').vectorMap({
                    map: 'world_mill',
                    backgroundColor: 'transparent',
                    zoomOnScroll: false,
                    zoomButtons: false,
                    regionsSelectable: true,
                    regionsSelectableOne: true,
                    regionStyle: {
                        initial: {
                            fill: '#e9ecef',
                            "fill-opacity": 0.8,
                            stroke: 'none',
                            "stroke-width": 0,
                            "stroke-opacity": 1
                        },
                        hover: {
                            "fill-opacity": 1,
                            cursor: 'pointer'
                        },
                        selected: {
                            fill: '#198754'
                        }
                    },
                    focusOn: {
                        x: 0.5,
                        y: 0.5,
                        scale: 1,
                        animate: true
                    },
                    series: {
                        regions: [{
                            values: {
                                'TZ': '#198754',
                                'KE': '#28a745',
                                'UG': '#66bb6a',
                                'RW': '#88c188',
                                'ET': '#aad6aa'
                            },
                            attribute: 'fill'
                        }]
                    }
                });
            }
            
            // Helper function to get country code from name
            function getCountryCode(countryName) {
                const countryCodes = {
                    'Tanzania': 'TZ',
                    'Kenya': 'KE',
                    'Uganda': 'UG',
                    'Rwanda': 'RW',
                    'Ethiopia': 'ET',
                    'Finland': 'FI',
                    'Netherlands': 'NL',
                    'Germany': 'DE',
                    'Pemba': 'TZ' // Using Tanzania code for Pemba
                };
                
                return countryCodes[countryName] || null;
            }
        });
    </script>
    <style>
        /* Dashboard Stats Styling */
        .stat-card {
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .stat-label {
            font-size: 0.75rem;
            color: #6c757d;
        }
        
        .chart-container {
            transition: all 0.3s ease;
        }
        
        .chart-container:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .nav-pills .nav-link {
            border-radius: 50rem;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }
        
        .nav-pills .nav-link:not(.active):hover {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
        }
        
        .nav-pills .nav-link.active {
            background-color: #198754;
        }
        
        .rounded-4 {
            border-radius: 0.75rem !important;
        }
        
        .bg-primary-subtle {
            background-color: rgba(13, 110, 253, 0.1) !important;
        }
        
        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }
        
        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }
        
        .bg-info-subtle {
            background-color: rgba(13, 202, 240, 0.1) !important;
        }
        
        .text-primary {
            color: #0d6efd !important;
        }
        
        .text-success {
            color: #198754 !important;
        }
        
        .text-warning {
            color: #ffc107 !important;
        }
        
        .text-info {
            color: #0dcaf0 !important;
        }
    </style>
    @endpush
</x-app-layout> 