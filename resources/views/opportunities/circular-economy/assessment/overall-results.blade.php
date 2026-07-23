<x-app-layout>
    <!-- Assessment Results Header -->
    <section class="bg-gradient-to-r from-green-800 to-green-600 text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">{{ __('Assessment Results') }}</h1>
                    <p class="lead mb-4">{{ __('Your overall waste management assessment results and recommendations.') }}</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-inline-block bg-white rounded-circle p-3 shadow-lg">
                        <div class="progress-circle mx-auto" data-value="{{ round($overallScore) }}">
                            <span class="progress-circle-left">
                                <span class="progress-circle-bar border-success"></span>
                            </span>
                            <span class="progress-circle-right">
                                <span class="progress-circle-bar border-success"></span>
                            </span>
                            <div class="progress-circle-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                <div class="h2 font-weight-bold">{{ round($overallScore) }}<span class="small">%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container py-5">
        <!-- Summary Cards -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="h1 mb-4">{{ __('Your Assessment Summary') }}</h2>
                <p class="lead">{{ __('Here\'s how you\'re performing across different waste management areas.') }}</p>
            </div>
        </div>
        
        <div class="row g-4 mb-5">
            @foreach($sections as $section)
                @if(isset($submissions[$section]))
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm rounded-4">
                            <div class="card-body p-4 text-center">
                                <div class="section-icon bg-{{ isset($scores[$section]['percentage']) && $scores[$section]['percentage'] >= 75 ? 'success' : (isset($scores[$section]['percentage']) && $scores[$section]['percentage'] >= 50 ? 'warning' : 'danger') }}-subtle 
                                    text-{{ isset($scores[$section]['percentage']) && $scores[$section]['percentage'] >= 75 ? 'success' : (isset($scores[$section]['percentage']) && $scores[$section]['percentage'] >= 50 ? 'warning' : 'danger') }} 
                                    rounded-circle mx-auto mb-3">
                                    <i class="fas fa-{{ $section == 'waste_collection' ? 'trash-alt' : 
                                                        ($section == 'recycling' ? 'recycle' : 
                                                        ($section == 'circular_design' ? 'sync-alt' : 'gavel')) }}"></i>
                                </div>
                                <h3 class="h5 mb-3">{{ $sectionTitles[$section] ?? $section }}</h3>
                                <div class="progress mb-3" style="height: 10px;">
                                    <div class="progress-bar bg-{{ isset($scores[$section]['percentage']) && $scores[$section]['percentage'] >= 75 ? 'success' : (isset($scores[$section]['percentage']) && $scores[$section]['percentage'] >= 50 ? 'warning' : 'danger') }}" 
                                        role="progressbar" style="width: {{ $scores[$section]['percentage'] ?? 0 }}%;" 
                                        aria-valuenow="{{ $scores[$section]['percentage'] ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="score-value fw-bold mb-3">{{ $scores[$section]['percentage'] ?? 0 }}%</p>
                                <p class="mb-0 small">{{ isset($scores[$section]['percentage']) && $scores[$section]['percentage'] >= 75 ? __('Excellent performance') : 
                                                        (isset($scores[$section]['percentage']) && $scores[$section]['percentage'] >= 50 ? __('Good performance, room for improvement') : 
                                                        __('Needs significant improvement')) }}</p>
                            </div>
                            <div class="card-footer bg-transparent border-0 p-4">
                                <a href="{{ route('opportunities.circular-economy.assessment.section.results', ['section' => $section, 'submission' => $submissions[$section]->id]) }}" 
                                   class="btn btn-sm btn-outline-primary w-100">
                                    <i class="fas fa-chart-bar me-2"></i>{{ __('View Details') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm rounded-4 bg-light">
                            <div class="card-body p-4 text-center">
                                <div class="section-icon bg-secondary-subtle text-secondary rounded-circle mx-auto mb-3">
                                    <i class="fas fa-{{ $section == 'waste_collection' ? 'trash-alt' : 
                                                        ($section == 'recycling' ? 'recycle' : 
                                                        ($section == 'circular_design' ? 'sync-alt' : 'gavel')) }}"></i>
                                </div>
                                <h3 class="h5 mb-3">{{ $sectionTitles[$section] ?? $section }}</h3>
                                <p class="mb-4">{{ __('Not yet assessed') }}</p>
                            </div>
                            <div class="card-footer bg-transparent border-0 p-4">
                                <a href="{{ route('opportunities.circular-economy.assessment.section', $section) }}" class="btn btn-sm btn-outline-secondary w-100">
                                    <i class="fas fa-play-circle me-2"></i>{{ __('Start Assessment') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        
        <!-- Recommendations -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="h1 mb-4">{{ __('Recommendations') }}</h2>
                <p class="lead">{{ __('Based on your assessment, here are our recommended actions.') }}</p>
            </div>
        </div>
        
        <div class="row g-4 mb-5">
            <!-- High Priority Recommendations -->
            @if(!empty($recommendations['high_priority']))
                <div class="col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4">
                        <div class="card-header bg-danger text-white py-3">
                            <h3 class="h5 mb-0"><i class="fas fa-exclamation-circle me-2"></i>{{ __('High Priority Actions') }}</h3>
                        </div>
                        <div class="card-body p-4">
                            <ul class="list-group list-group-flush">
                                @foreach($recommendations['high_priority'] as $recommendation)
                                    <li class="list-group-item border-0 ps-0 d-flex">
                                        <span class="text-danger me-2"><i class="fas fa-arrow-right"></i></span>
                                        <span>{{ $recommendation }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Medium Priority Recommendations -->
            @if(!empty($recommendations['medium_priority']))
                <div class="col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4">
                        <div class="card-header bg-warning text-dark py-3">
                            <h3 class="h5 mb-0"><i class="fas fa-exclamation-triangle me-2"></i>{{ __('Medium Priority Actions') }}</h3>
                        </div>
                        <div class="card-body p-4">
                            <ul class="list-group list-group-flush">
                                @foreach($recommendations['medium_priority'] as $recommendation)
                                    <li class="list-group-item border-0 ps-0 d-flex">
                                        <span class="text-warning me-2"><i class="fas fa-arrow-right"></i></span>
                                        <span>{{ $recommendation }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Low Priority Recommendations -->
            @if(!empty($recommendations['low_priority']))
                <div class="col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4">
                        <div class="card-header bg-success text-white py-3">
                            <h3 class="h5 mb-0"><i class="fas fa-check-circle me-2"></i>{{ __('Low Priority Actions') }}</h3>
                        </div>
                        <div class="card-body p-4">
                            <ul class="list-group list-group-flush">
                                @foreach($recommendations['low_priority'] as $recommendation)
                                    <li class="list-group-item border-0 ps-0 d-flex">
                                        <span class="text-success me-2"><i class="fas fa-arrow-right"></i></span>
                                        <span>{{ $recommendation }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Action Buttons -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('opportunities.circular-economy.assessment.index') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>{{ __('Return to Assessment') }}
                    </a>
                    <button class="btn btn-success btn-lg" onclick="window.print()">
                        <i class="fas fa-print me-2"></i>{{ __('Print Results') }}
                    </button>
                    <a href="{{ route('opportunities.circular-economy.contact') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-envelope me-2"></i>{{ __('Get Expert Advice') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Circular progress bars
            document.querySelectorAll('.progress-circle').forEach(function(circle) {
                var value = parseInt(circle.getAttribute('data-value'));
                var left = circle.querySelector('.progress-circle-left .progress-circle-bar');
                var right = circle.querySelector('.progress-circle-right .progress-circle-bar');
                
                if (value > 0) {
                    if (value <= 50) {
                        right.style.transform = 'rotate(' + (value * 3.6) + 'deg)';
                    } else {
                        right.style.transform = 'rotate(180deg)';
                        left.style.transform = 'rotate(' + ((value - 50) * 3.6) + 'deg)';
                    }
                }
            });
        });
    </script>
    <style>
        .section-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
        }
        
        .score-value {
            font-size: 1.5rem;
        }
        
        /* Progress Circle Styles */
        .progress-circle {
            position: relative;
            height: 120px;
            width: 120px;
            border-radius: 50%;
            background-color: #f8f9fa;
            background: conic-gradient(#28a745 calc(var(--progress) * 1%), #f8f9fa 0);
        }
        
        .progress-circle-left, .progress-circle-right {
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            left: 0;
        }
        
        .progress-circle-left, .progress-circle-right {
            border-radius: 50%;
            clip: rect(0px, 60px, 120px, 0px);
        }
        
        .progress-circle-right {
            transform: rotate(180deg);
        }
        
        .progress-circle-bar {
            position: absolute;
            height: 100%;
            width: 100%;
            border: 10px solid #28a745;
            border-radius: 50%;
            clip: rect(0px, 60px, 120px, 0px);
            transform: rotate(0deg);
            transition: transform 0.5s ease-in-out;
        }
        
        .progress-circle-value {
            position: absolute;
            top: 0;
            left: 0;
            background: white;
            border-radius: 50%;
            height: calc(100% - 20px);
            width: calc(100% - 20px);
            margin: 10px;
        }
        
        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }
        
        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }
        
        .bg-danger-subtle {
            background-color: rgba(220, 53, 69, 0.1) !important;
        }
        
        .bg-secondary-subtle {
            background-color: rgba(108, 117, 125, 0.1) !important;
        }
        
        .rounded-4 {
            border-radius: 0.75rem !important;
        }
        
        @media print {
            .navbar, footer, .btn {
                display: none !important;
            }
            
            .card {
                break-inside: avoid;
            }
            
            .bg-gradient-to-r {
                background: #198754 !important;
                -webkit-print-color-adjust: exact;
            }
            
            body {
                padding-top: 0 !important;
            }
        }
    </style>
    @endpush
</x-app-layout> 