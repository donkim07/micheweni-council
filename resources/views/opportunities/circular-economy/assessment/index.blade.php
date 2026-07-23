@extends('opportunities.layouts.app')

@section('title', __('Waste Management Assessment'))

@section('styles')
<style>
    .assessment-hero {
        background: linear-gradient(135deg, #115740 0%, #198754 100%);
        color: white;
        padding: 4rem 0;
        position: relative;
        overflow: hidden;
    }
    
    .assessment-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('/images/pattern.png');
        background-size: cover;
        opacity: 0.05;
        z-index: 0;
    }
    
    .assessment-hero-content {
        position: relative;
        z-index: 1;
    }
    
    .assessment-categories {
        margin-top: -60px;
    }
    
    .assessment-card {
        border-radius: 1rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        height: 100%;
        border: none;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        position: relative;
        background: white;
    }
    
    .assessment-card::after {
        content: '';
        position: absolute;
        z-index: -1;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        border-radius: 1rem;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    
    .assessment-card:hover {
        transform: translateY(-10px) scale(1.02);
    }
    
    .assessment-card:hover::after {
        opacity: 1;
    }
    
    .assessment-header {
        padding: 2.5rem 2rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .assessment-header::before {
        content: '';
        position: absolute;
        width: 200%;
        height: 200%;
        top: -50%;
        left: -50%;
        z-index: 0;
        background: radial-gradient(circle, rgba(25,135,84,0.05) 0%, rgba(25,135,84,0) 70%);
        transition: all 0.4s ease;
        transform: scale(0.8);
        opacity: 0;
    }
    
    .assessment-card:hover .assessment-header::before {
        transform: scale(1);
        opacity: 1;
    }
    
    .assessment-icon {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        color: #198754;
        border-radius: 50%;
        font-size: 2rem;
        margin: 0 auto 1.5rem;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        position: relative;
        z-index: 1;
        transition: all 0.4s ease;
    }
    
    .assessment-card:hover .assessment-icon {
        transform: rotateY(180deg);
        background-color: #198754;
        color: #fff;
    }
    
    .assessment-card.completed {
        border-left: 5px solid #198754;
    }
    
    .assessment-card.completed .assessment-header {
        background: linear-gradient(135deg, rgba(25,135,84,0.05) 0%, rgba(25,135,84,0.15) 100%);
    }
    
    .assessment-card.completed .assessment-icon {
        color: #198754;
        box-shadow: 0 10px 20px rgba(25,135,84,0.2);
    }
    
    .assessment-body {
        padding: 2rem;
        position: relative;
        z-index: 1;
    }
    
    .assessment-footer {
        padding: 1.5rem;
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
        text-align: center;
        position: relative;
        z-index: 1;
    }
    
    .progress-indicator {
        position: relative;
        padding: 2rem 0;
    }
    
    .progress-bar-container {
        position: relative;
        height: 8px;
        background-color: #e9ecef;
        border-radius: 4px;
        overflow: hidden;
        margin: 2rem 0;
    }
    
    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(to right, #198754, #20c997);
        border-radius: 4px;
        transition: width 1s ease;
    }
    
    .progress-steps {
        display: flex;
        justify-content: space-between;
        margin-top: -24px;
    }
    
    .progress-step {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-weight: 600;
        position: relative;
        transition: all 0.3s ease;
        z-index: 2;
    }
    
    .progress-step.active {
        background-color: #198754;
        color: white;
    }
    
    .progress-step.completed {
        background-color: #198754;
        color: white;
    }
    
    .progress-step.completed::after {
        content: '✓';
    }
    
    .progress-step-label {
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
        margin-top: 8px;
        font-size: 0.85rem;
        color: #6c757d;
        font-weight: 500;
    }
    
    .btn-hover-effect {
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
        z-index: 1;
    }

    .btn-hover-effect::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: all 0.6s;
        z-index: -1;
    }

    .btn-hover-effect:hover::before {
        left: 100%;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.8s ease forwards;
    }
    
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }
    .delay-500 { animation-delay: 0.5s; }
    
    .badge-pill-lg {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        border-radius: 50rem;
    }
    
    .progress-status {
        position: absolute;
        top: 0;
        right: 0;
        background: rgba(25,135,84,0.1);
        color: #198754;
        padding: 0.5rem 1rem;
        border-radius: 0 1rem 0 1rem;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .assessment-details {
        margin-top: 2rem;
        padding: 2rem;
        background: #f8f9fa;
        border-radius: 1rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .benefits-list {
        padding-left: 0;
        list-style-type: none;
    }
    
    .benefit-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    
    .benefit-icon {
        color: #198754;
        margin-right: 1rem;
        font-size: 1.25rem;
        margin-top: 0.25rem;
    }
</style>
@endsection

@section('content')
<!-- Assessment Hero Section -->
<section class="assessment-hero">
    <div class="container assessment-hero-content">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-4">{{ __('Waste Management Assessment') }}</h1>
                <p class="lead mb-4">{{ __('Evaluate your waste management practices and discover actionable insights for improvement.') }}</p>
                
                @if(auth()->check())
                <div class="progress-indicator">
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" style="width: {{ $completionPercentage ?? 0 }}%;"></div>
                                </div>
                    <div class="progress-steps">
                        <div class="progress-step {{ ($completionPercentage ?? 0) >= 20 ? 'completed' : (($completionPercentage ?? 0) > 0 ? 'active' : '') }}">
                            <span class="progress-step-label">{{ __('Start') }}</span>
                                </div>
                        <div class="progress-step {{ ($completionPercentage ?? 0) >= 40 ? 'completed' : (($completionPercentage ?? 0) >= 20 ? 'active' : '') }}">
                            <span class="progress-step-label">{{ __('Collection') }}</span>
                                </div>
                        <div class="progress-step {{ ($completionPercentage ?? 0) >= 60 ? 'completed' : (($completionPercentage ?? 0) >= 40 ? 'active' : '') }}">
                            <span class="progress-step-label">{{ __('Recycling') }}</span>
                                </div>
                        <div class="progress-step {{ ($completionPercentage ?? 0) >= 80 ? 'completed' : (($completionPercentage ?? 0) >= 60 ? 'active' : '') }}">
                            <span class="progress-step-label">{{ __('Circular') }}</span>
                                </div>
                        <div class="progress-step {{ ($completionPercentage ?? 0) == 100 ? 'completed' : (($completionPercentage ?? 0) >= 80 ? 'active' : '') }}">
                            <span class="progress-step-label">{{ __('Policy') }}</span>
                        </div>
                                        </div>
                                    </div>
                                    
                @if(($completionPercentage ?? 0) == 100)
                <div class="alert alert-success d-inline-block">
                    <i class="fas fa-check-circle me-2"></i> {{ __('Assessment completed! View your results and recommendations.') }}
                                        </div>
                <a href="{{ route('opportunities.circular-economy.assessment.showResults') }}" class="btn btn-light btn-lg shadow-sm mt-3 btn-hover-effect">
                    <i class="fas fa-chart-pie me-2"></i> {{ __('View Results') }}
                </a>
                @elseif(($completionPercentage ?? 0) > 0)
                <a href="{{ route('opportunities.circular-economy.assessment.continue') }}" class="btn btn-light btn-lg shadow-sm mt-3 btn-hover-effect">
                    <i class="fas fa-play-circle me-2"></i> {{ __('Continue Assessment') }}
                </a>
                @else
                <a href="{{ route('opportunities.circular-economy.assessment.section', 'introduction') }}" class="btn btn-light btn-lg shadow-sm mt-3 btn-hover-effect">
                    <i class="fas fa-play-circle me-2"></i> {{ __('Start Assessment') }}
                </a>
                @endif
                @else
                <div class="alert alert-info d-inline-block mb-4">
                    <i class="fas fa-info-circle me-2"></i> {{ __('Sign in to save your assessment progress.') }}
                                    </div>
                <div>
                    
                    <a href="{{ route('opportunities.circular-economy.assessment.section', 'introduction') }}" class="btn btn-outline-light btn-lg btn-hover-effect">
                        <i class="fas fa-play-circle me-2"></i> {{ __('Continue as Guest') }}
                    </a>
                                        </div>
                @endif
                                        </div>
                                    </div>
                                </div>
</section>

<!-- Assessment Categories Section -->
<section class="py-5">
    <div class="container assessment-categories">
        <div class="row g-4">
            <!-- Waste Collection & Sorting Card -->
            <div class="col-md-6 col-lg-3 fade-in-up">
                <div class="assessment-card {{ isset($sectionCompletion['waste-collection']) && $sectionCompletion['waste-collection'] ? 'completed' : '' }}">
                    @if(isset($sectionCompletion['waste-collection']) && $sectionCompletion['waste-collection'])
                    <div class="progress-status">{{ __('Completed') }}</div>
                    @endif
                    <div class="assessment-header">
                        <div class="assessment-icon">
                            <i class="fas fa-trash-alt"></i>
                        </div>
                        <h3 class="h5">{{ __('Waste Collection & Sorting') }}</h3>
                                </div>
                    <div class="assessment-body">
                        <p>{{ __('Evaluate your waste collection system, frequency, sorting practices, and community engagement.') }}</p>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-2">
                                <i class="fas fa-clock text-muted"></i>
                            </div>
                            <span class="small text-muted">{{ __('Approx. 5-7 minutes') }}</span>
                                    </div>
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <i class="fas fa-question-circle text-muted"></i>
                                    </div>
                            <span class="small text-muted">{{ __('10 questions') }}</span>
                                    </div>
                                </div>
                    <div class="assessment-footer">
                        <a href="{{ route('opportunities.circular-economy.assessment.section', 'waste-collection') }}" class="btn btn-outline-success btn-hover-effect w-100">
                            @if(isset($sectionCompletion['waste-collection']) && $sectionCompletion['waste-collection'])
                            <i class="fas fa-eye me-2"></i> {{ __('Review Section') }}
                            @else
                            <i class="fas fa-arrow-right me-2"></i> {{ __('Start Section') }}
                            @endif
                        </a>
                                        </div>
                                    </div>
                                </div>
                                
            <!-- Recycling Infrastructure Card -->
            <div class="col-md-6 col-lg-3 fade-in-up delay-200">
                <div class="assessment-card {{ isset($sectionCompletion['recycling']) && $sectionCompletion['recycling'] ? 'completed' : '' }}">
                    @if(isset($sectionCompletion['recycling']) && $sectionCompletion['recycling'])
                    <div class="progress-status">{{ __('Completed') }}</div>
                    @endif
                    <div class="assessment-header">
                        <div class="assessment-icon">
                            <i class="fas fa-recycle"></i>
                        </div>
                        <h3 class="h5">{{ __('Recycling Infrastructure') }}</h3>
                                </div>
                    <div class="assessment-body">
                        <p>{{ __('Assess your recycling facilities, recovery rates, material processing, and technology adoption.') }}</p>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-2">
                                <i class="fas fa-clock text-muted"></i>
                            </div>
                            <span class="small text-muted">{{ __('Approx. 5-7 minutes') }}</span>
                                    </div>
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <i class="fas fa-question-circle text-muted"></i>
                                    </div>
                            <span class="small text-muted">{{ __('8 questions') }}</span>
                                    </div>
                                </div>
                    <div class="assessment-footer">
                        <a href="{{ route('opportunities.circular-economy.assessment.section', 'recycling') }}" class="btn btn-outline-success btn-hover-effect w-100">
                            @if(isset($sectionCompletion['recycling']) && $sectionCompletion['recycling'])
                            <i class="fas fa-eye me-2"></i> {{ __('Review Section') }}
                            @else
                            <i class="fas fa-arrow-right me-2"></i> {{ __('Start Section') }}
                            @endif
                        </a>
                                        </div>
                                    </div>
                                </div>
                                
            <!-- Circular Product Design Card -->
            <div class="col-md-6 col-lg-3 fade-in-up delay-400">
                <div class="assessment-card {{ isset($sectionCompletion['circular-design']) && $sectionCompletion['circular-design'] ? 'completed' : '' }}">
                    @if(isset($sectionCompletion['circular-design']) && $sectionCompletion['circular-design'])
                    <div class="progress-status">{{ __('Completed') }}</div>
                    @endif
                    <div class="assessment-header">
                        <div class="assessment-icon">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                        <h3 class="h5">{{ __('Circular Product Design') }}</h3>
                                </div>
                    <div class="assessment-body">
                        <p>{{ __('Evaluate your product lifecycle design, material selection, repair and reuse systems.') }}</p>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-2">
                                <i class="fas fa-clock text-muted"></i>
                            </div>
                            <span class="small text-muted">{{ __('Approx. 4-6 minutes') }}</span>
                                            </div>
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <i class="fas fa-question-circle text-muted"></i>
                                            </div>
                            <span class="small text-muted">{{ __('7 questions') }}</span>
                                            </div>
                                        </div>
                    <div class="assessment-footer">
                        <a href="{{ route('opportunities.circular-economy.assessment.section', 'circular-design') }}" class="btn btn-outline-success btn-hover-effect w-100">
                            @if(isset($sectionCompletion['circular-design']) && $sectionCompletion['circular-design'])
                            <i class="fas fa-eye me-2"></i> {{ __('Review Section') }}
                            @else
                            <i class="fas fa-arrow-right me-2"></i> {{ __('Start Section') }}
                            @endif
                        </a>
                                        </div>
                                    </div>
                                </div>
                                
            <!-- Policy & Governance Card -->
            <div class="col-md-6 col-lg-3 fade-in-up delay-500">
                <div class="assessment-card {{ isset($sectionCompletion['policy']) && $sectionCompletion['policy'] ? 'completed' : '' }}">
                    @if(isset($sectionCompletion['policy']) && $sectionCompletion['policy'])
                    <div class="progress-status">{{ __('Completed') }}</div>
                    @endif
                    <div class="assessment-header">
                        <div class="assessment-icon">
                            <i class="fas fa-balance-scale"></i>
                                    </div>
                        <h3 class="h5">{{ __('Policy & Governance') }}</h3>
                                </div>
                    <div class="assessment-body">
                        <p>{{ __('Analyze your waste management policies, regulatory compliance, incentives, and enforcement.') }}</p>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-2">
                                <i class="fas fa-clock text-muted"></i>
                                </div>
                            <span class="small text-muted">{{ __('Approx. 5-7 minutes') }}</span>
                                </div>
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <i class="fas fa-question-circle text-muted"></i>
                            </div>
                            <span class="small text-muted">{{ __('9 questions') }}</span>
                        </div>
                    </div>
                    <div class="assessment-footer">
                        <a href="{{ route('opportunities.circular-economy.assessment.section', 'policy') }}" class="btn btn-outline-success btn-hover-effect w-100">
                            @if(isset($sectionCompletion['policy']) && $sectionCompletion['policy'])
                            <i class="fas fa-eye me-2"></i> {{ __('Review Section') }}
                            @else
                            <i class="fas fa-arrow-right me-2"></i> {{ __('Start Section') }}
                            @endif
                        </a>
                                </div>
                                    </div>
                                        </div>
                                    </div>
                                </div>
</section>

<!-- Assessment Information Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="mb-4">{{ __('Why Complete This Assessment?') }}</h2>
                <ul class="benefits-list">
                    <li class="benefit-item fade-in-up">
                        <div class="benefit-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <h5>{{ __('Benchmark Your Performance') }}</h5>
                            <p>{{ __('Compare your waste management practices against global standards and best practices from around the world.') }}</p>
                                    </div>
                    </li>
                    <li class="benefit-item fade-in-up delay-100">
                        <div class="benefit-icon">
                            <i class="fas fa-lightbulb"></i>
                                                    </div>
                                                    <div>
                            <h5>{{ __('Get Personalized Recommendations') }}</h5>
                            <p>{{ __('Receive tailored action plans and improvement strategies based on your specific circumstances and challenges.') }}</p>
                                                </div>
                                            </li>
                    <li class="benefit-item fade-in-up delay-200">
                        <div class="benefit-icon">
                            <i class="fas fa-file-alt"></i>
                                                    </div>
                                                    <div>
                            <h5>{{ __('Generate Detailed Reports') }}</h5>
                            <p>{{ __('Download comprehensive reports to share with stakeholders, funding agencies, or policy makers.') }}</p>
                                                </div>
                                            </li>
                    <li class="benefit-item fade-in-up delay-300">
                        <div class="benefit-icon">
                            <i class="fas fa-users"></i>
                                                    </div>
                                                    <div>
                            <h5>{{ __('Join a Global Community') }}</h5>
                            <p>{{ __('Connect with other communities facing similar challenges and learn from their experiences and solutions.') }}</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
            <div class="col-lg-6">
                <div class="assessment-details fade-in-up delay-200">
                    <h3 class="mb-4">{{ __('Assessment Details') }}</h3>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-clock text-success me-3 fa-2x"></i>
                                <div>
                                    <h5 class="mb-1">{{ __('20-30 Minutes') }}</h5>
                                    <p class="mb-0 text-muted">{{ __('Typical completion time') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-question-circle text-success me-3 fa-2x"></i>
                                <div>
                                    <h5 class="mb-1">{{ __('34 Questions') }}</h5>
                                    <p class="mb-0 text-muted">{{ __('Across 4 categories') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-save text-success me-3 fa-2x"></i>
                                <div>
                                    <h5 class="mb-1">{{ __('Save & Continue') }}</h5>
                                    <p class="mb-0 text-muted">{{ __('Resume where you left off') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-shield-alt text-success me-3 fa-2x"></i>
                                <div>
                                    <h5 class="mb-1">{{ __('Data Privacy') }}</h5>
                                    <p class="mb-0 text-muted">{{ __('Your data is secure and private') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('opportunities.circular-economy.assessment.section', 'introduction') }}" class="btn btn-success btn-lg btn-hover-effect">
                            <i class="fas fa-play-circle me-2"></i> {{ __('Start Your Assessment') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
    
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        // Animation for progress bar
        const progressBar = document.querySelector('.progress-bar-fill');
        if (progressBar) {
            setTimeout(() => {
                progressBar.style.width = '{{ $completionPercentage ?? 0 }}%';
            }, 500);
        }
        
        // Make assessment cards equal height
        function equalizeCardHeights() {
            const cards = document.querySelectorAll('.assessment-card .assessment-body');
            let maxHeight = 0;
            
            // Reset heights first
            cards.forEach(card => {
                card.style.height = 'auto';
                const height = card.offsetHeight;
                maxHeight = height > maxHeight ? height : maxHeight;
            });
            
            // Set all cards to max height
            cards.forEach(card => {
                card.style.height = `${maxHeight}px`;
            });
        }
        
        // Run on load and resize
        equalizeCardHeights();
        window.addEventListener('resize', equalizeCardHeights);
        });
    </script>
@endsection