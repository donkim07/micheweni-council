@extends('opportunities.layouts.app')

@section('title', 'Assessment Results | ' . config('app.name'))

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<style>
    .results-header {
        background: linear-gradient(135deg, #115740 0%, #198754 100%);
        color: white;
        border-radius: 1rem;
        padding: 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .results-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        opacity: 0.05;
        z-index: 0;
    }
    
    .results-header-content {
        position: relative;
        z-index: 1;
    }
    
    .results-card {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
        border: none;
    }
    
    .results-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .score-card {
        text-align: center;
        padding: 2rem;
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    
    .score-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .score-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 5px;
    }
    
    .score-high::after {
        background: linear-gradient(to right, #198754, #20c997);
    }
    
    .score-medium::after {
        background: linear-gradient(to right, #fd7e14, #ffc107);
    }
    
    .score-low::after {
        background: linear-gradient(to right, #dc3545, #f86565);
    }
    
    .score-circle-container {
        position: relative;
        width: 180px;
        height: 180px;
        margin: 0 auto 1.5rem;
    }
    
    .score-circle-bg {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background-color: #f8f9fa;
        position: absolute;
        top: 0;
        left: 0;
    }
    
    .score-circle-progress {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        position: absolute;
        top: 0;
        left: 0;
        background: conic-gradient(transparent 0%, transparent var(--empty-percentage), var(--score-color) var(--empty-percentage), var(--score-color) 100%);
        mask: radial-gradient(transparent 62px, black 63px);
        -webkit-mask: radial-gradient(transparent 62px, black 63px);
    }
    
    .score-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
    
    .score-high .score-circle {
        background: linear-gradient(135deg, #198754, #20c997);
    }
    
    .score-medium .score-circle {
        background: linear-gradient(135deg, #fd7e14, #ffc107);
    }
    
    .score-low .score-circle {
        background: linear-gradient(135deg, #dc3545, #f86565);
    }
    
    .score-label {
        position: absolute;
        width: 100%;
        text-align: center;
        top: 120%;
        left: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }
    
    .category-score-container {
        position: relative;
        padding: 1.5rem;
        border-radius: 1rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    
    .category-score-container:hover {
        transform: translateX(5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .category-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 1rem;
        color: white;
        background-color: #198754;
    }
    
    .category-progress {
        height: 10px;
        background-color: #e9ecef;
        border-radius: 5px;
        overflow: hidden;
        margin-top: 1rem;
    }
    
    .category-progress-bar {
        height: 100%;
        border-radius: 5px;
        background: linear-gradient(to right, #198754, #20c997);
        width: 0;
        transition: width 1.5s cubic-bezier(0.1, 0.5, 0.5, 1);
    }
    
    .category-score {
        font-size: 1.5rem;
        font-weight: 700;
        color: #198754;
    }
    
    .recommendation-item {
        padding: 1.5rem;
        background-color: #fff;
        border-radius: 1rem;
        margin-bottom: 1.5rem;
        border-left: 5px solid #198754;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .recommendation-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .recommendation-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        background-color: #198754;
        margin-right: 1rem;
        font-size: 1.5rem;
    }
    
    .recommendation-priority {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.25rem 1rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .priority-high {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    
    .priority-medium {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
    
    .priority-low {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
    }
    
    .recommendation-details {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease;
        margin-top: 1rem;
    }
    
    .recommendation-item.expanded .recommendation-details {
        max-height: 500px;
    }
    
    .report-card {
        background-color: #fff;
        border-radius: 1rem;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        height: 100%;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .report-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 8px;
    }
    
    .report-pdf::before {
        background: linear-gradient(to right, #dc3545, #f86565);
    }
    
    .report-comparison::before {
        background: linear-gradient(to right, #0d6efd, #0dcaf0);
    }
    
    .btn-ripple {
        position: relative;
        overflow: hidden;
    }
    
    .btn-ripple::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        pointer-events: none;
        background-image: radial-gradient(circle, rgba(255,255,255,0.3) 10%, transparent 10.01%);
        background-repeat: no-repeat;
        background-position: 50%;
        transform: scale(10, 10);
        opacity: 0;
        transition: transform 0.5s, opacity 0.8s;
    }
    
    .btn-ripple:active::after {
        transform: scale(0, 0);
        opacity: 0.3;
        transition: 0s;
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
    
    .nav-pills .nav-link.active {
        background-color: #198754;
    }
    
    .score-badge {
        position: absolute;
        top: -10px;
        right: -10px;
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #198754;
        color: white;
        border-radius: 50%;
        font-weight: 700;
        font-size: 1.25rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        transform: rotate(15deg);
    }
    
    .action-steps {
        margin-top: 1rem;
        padding-left: 0;
        list-style-type: none;
    }
    
    .action-step {
        display: flex;
        align-items: flex-start;
        margin-bottom: 0.5rem;
        padding: 0.5rem;
        background-color: rgba(25, 135, 84, 0.05);
        border-radius: 0.5rem;
    }
    
    .action-step-icon {
        margin-right: 0.75rem;
        color: #198754;
    }
    
    .progress-stats-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .progress-stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .progress-stats-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: #198754;
        line-height: 1;
    }
    
    .progress-stats-label {
        margin-top: 0.5rem;
        color: #6c757d;
        font-size: 0.9rem;
        text-align: center;
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
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('opportunities.circular-economy.assessment.index') }}">Assessment</a></li>
                    <li class="breadcrumb-item active">Results</li>
                </ol>
            </nav>
            
            <div class="results-header" data-aos="fade-up">
                <div class="results-header-content">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="mb-3">Assessment Results</h1>
                            <p class="lead mb-4">
                                @php
                                    $sectionNames = [
                                        'waste_collection' => 'Waste Collection & Sorting',
                                        'recycling' => 'Recycling Infrastructure',
                                        'circular_design' => 'Circular Product Design',
                                        'policy' => 'Policy & Governance'
                                    ];
                                    $sectionName = $sectionNames[$section] ?? 'Assessment';
                                @endphp
                                {{ $sectionName }} Assessment Completed on {{ $submission->created_at->format('F j, Y') }}
                            </p>
                            
                            @php
                                $overallScore = isset($score['overall_percentage']) ? $score['overall_percentage'] : 
                                    (isset($score['score']) ? $score['score'] : 65);
                                
                                $scoreText = 'Needs Improvement';
                                $scoreDescription = 'Several areas require immediate attention to improve your waste management practices.';
                                
                                if ($overallScore >= 80) {
                                    $scoreText = 'Excellent';
                                    $scoreDescription = 'You\'re implementing leading practices in circular economy and waste management!';
                                } elseif ($overallScore >= 60) {
                                    $scoreText = 'Good';
                                    $scoreDescription = 'Making good progress with room for targeted improvements.';
                                } elseif ($overallScore >= 40) {
                                    $scoreText = 'Fair';
                                    $scoreDescription = 'Some positive initiatives but many areas need attention.';
                                }
                            @endphp
                            
                            <div class="alert alert-light d-inline-block">
                                <strong>{{ $scoreText }}:</strong> {{ $scoreDescription }}
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="{{ route('opportunities.circular-economy.assessment.pdf', $submission->id) }}" class="btn btn-light btn-hover-effect mb-2 mb-md-0">
                                <i class="fas fa-download me-2"></i> Download Report
                            </a>
                            <a href="{{ route('opportunities.circular-economy.assessment.index') }}" class="btn btn-outline-light btn-hover-effect ms-md-2">
                                <i class="fas fa-clipboard-list me-2"></i> Assessment Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Progress Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="progress-stats-card">
                        <div class="progress-stats-value">{{ $overallScore }}%</div>
                        <div class="progress-stats-label">Overall Score</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="progress-stats-card">
                        <div class="progress-stats-value">{{ isset($score['categories']) ? count($score['categories']) : 1 }}</div>
                        <div class="progress-stats-label">Categories Evaluated</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="progress-stats-card">
                        <div class="progress-stats-value">{{ count($recommendations ?? []) }}</div>
                        <div class="progress-stats-label">Recommendations</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="progress-stats-card">
                        <div class="progress-stats-value">{{ $overallScore >= 80 ? 'A' : ($overallScore >= 70 ? 'B' : ($overallScore >= 60 ? 'C' : ($overallScore >= 50 ? 'D' : 'E'))) }}</div>
                        <div class="progress-stats-label">Performance Grade</div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-5">
                <div class="col-lg-5 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                    <div class="score-card {{ $overallScore >= 80 ? 'score-high' : ($overallScore >= 50 ? 'score-medium' : 'score-low') }}">
                        <div class="score-circle-container">
                            <div class="score-circle-bg"></div>
                            <div class="score-circle-progress" style="--empty-percentage: {{ 100 - $overallScore }}%; --score-color: {{ $overallScore >= 80 ? '#198754' : ($overallScore >= 50 ? '#ffc107' : '#dc3545') }};"></div>
                            <div class="score-circle {{ $overallScore >= 80 ? 'score-high' : ($overallScore >= 50 ? 'score-medium' : 'score-low') }}">
                                {{ $overallScore }}%
                            </div>
                        </div>
                        <h3>Overall Assessment Score</h3>
                        <p class="text-muted">
                            @if($overallScore >= 80)
                                Excellent! You're leading in circular economy practices.
                            @elseif($overallScore >= 50)
                                Good progress. Some areas could use improvement.
                            @else
                                Needs attention. Several areas require improvement.
                            @endif
                        </p>
                        
                        <div class="mt-4 d-flex justify-content-center">
                            <a href="#recommendations" class="btn btn-success btn-hover-effect me-2">
                                <i class="fas fa-lightbulb me-2"></i> View Recommendations
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">
                    <div class="card results-card">
                        <div class="card-header bg-light py-3">
                            <h3 class="mb-0">Category Performance</h3>
                        </div>
                        <div class="card-body p-0">
                            @if(isset($score['categories']) && count($score['categories']) > 0)
                                @php
                                    $categoryIcons = [
                                        'waste_collection' => 'trash-alt',
                                        'recycling' => 'recycle',
                                        'circular_design' => 'sync',
                                        'policy' => 'balance-scale',
                                        'waste collection' => 'trash-alt',
                                        'recycling infrastructure' => 'recycle',
                                        'circular product design' => 'sync',
                                        'policy & governance' => 'balance-scale'
                                    ];
                                @endphp
                                
                                @foreach($score['categories'] as $category => $categoryScore)
                                    <div class="category-score-container">
                                        <div class="d-flex align-items-center">
                                            <div class="category-icon">
                                                <i class="fas fa-{{ $categoryIcons[strtolower($category)] ?? 'chart-bar' }}"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h4 class="mb-0">{{ ucwords(str_replace('_', ' ', $category)) }}</h4>
                                                    <span class="category-score">{{ $categoryScore }}%</span>
                                                </div>
                                                <div class="category-progress">
                                                    <div class="category-progress-bar" style="width: 0%" data-width="{{ $categoryScore }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="category-score-container">
                                    <div class="d-flex align-items-center">
                                        <div class="category-icon">
                                            <i class="fas fa-{{ $section === 'waste_collection' ? 'trash' : 
                                                              ($section === 'recycling' ? 'recycle' : 
                                                              ($section === 'circular_design' ? 'sync' : 'gavel')) }}"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h4 class="mb-0">{{ ucwords(str_replace('_', ' ', $section)) }}</h4>
                                                <span class="category-score">{{ $overallScore }}%</span>
                                            </div>
                                            <div class="category-progress">
                                                <div class="category-progress-bar" style="width: 0%" data-width="{{ $overallScore }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="recommendations" class="row">
                <div class="col-12 mb-4" data-aos="fade-up">
                    <div class="card results-card">
                        <div class="card-header bg-light py-3">
                            <h3 class="mb-0">Key Recommendations</h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-4">Based on your assessment, we've identified the following actionable recommendations to improve your waste management practices:</p>
                            
                            @if(isset($recommendations) && count($recommendations) > 0)
                                @foreach($recommendations as $index => $recommendation)
                                    @php
                                        $priorityClass = 'priority-medium';
                                        $priorityText = 'Medium Priority';
                                        $iconClass = 'lightbulb';
                                        
                                        if (isset($recommendation['priority'])) {
                                            if ($recommendation['priority'] === 'high') {
                                                $priorityClass = 'priority-high';
                                                $priorityText = 'High Priority';
                                            } elseif ($recommendation['priority'] === 'low') {
                                                $priorityClass = 'priority-low';
                                                $priorityText = 'Low Priority';
                                            }
                                        }
                                        
                                        if (isset($recommendation['icon'])) {
                                            $iconClass = $recommendation['icon'];
                                        }
                                    @endphp
                                    
                                    <div class="recommendation-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                        <span class="recommendation-priority {{ $priorityClass }}">{{ $priorityText }}</span>
                                        <div class="d-flex">
                                            <div class="recommendation-icon">
                                                <i class="fas fa-{{ $iconClass }}"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h4>{{ $recommendation['title'] }}</h4>
                                                <p class="mb-0">{{ $recommendation['description'] }}</p>
                                                
                                                <div class="recommendation-details">
                                                    <hr>
                                                    <h5>Action Steps:</h5>
                                                    <ul class="action-steps">
                                                        @if(isset($recommendation['actions']) && count($recommendation['actions']) > 0)
                                                            @foreach($recommendation['actions'] as $action)
                                                                <li class="action-step">
                                                                    <span class="action-step-icon"><i class="fas fa-check-circle"></i></span>
                                                                    <span>{{ $action }}</span>
                                                                </li>
                                                            @endforeach
                                                        @else
                                                            <li class="action-step">
                                                                <span class="action-step-icon"><i class="fas fa-check-circle"></i></span>
                                                                <span>Review current practices and identify areas for improvement</span>
                                                            </li>
                                                            <li class="action-step">
                                                                <span class="action-step-icon"><i class="fas fa-check-circle"></i></span>
                                                                <span>Develop an implementation plan with clear timelines</span>
                                                            </li>
                                                            <li class="action-step">
                                                                <span class="action-step-icon"><i class="fas fa-check-circle"></i></span>
                                                                <span>Assign responsibility to team members for execution</span>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                    
                                                    <div class="mt-3">
                                                        <a href="#" class="btn btn-sm btn-outline-success btn-hover-effect">
                                                            <i class="fas fa-info-circle me-2"></i> Learn More
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Default recommendations if none provided -->
                                <div class="recommendation-item" data-aos="fade-up">
                                    <span class="recommendation-priority priority-high">High Priority</span>
                                    <div class="d-flex">
                                        <div class="recommendation-icon">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h4>Establish Regular Monitoring System</h4>
                                            <p class="mb-0">Implement a comprehensive system to regularly monitor your waste management performance metrics and track progress over time.</p>
                                            
                                            <div class="recommendation-details">
                                                <hr>
                                                <h5>Action Steps:</h5>
                                                <ul class="action-steps">
                                                    <li class="action-step">
                                                        <span class="action-step-icon"><i class="fas fa-check-circle"></i></span>
                                                        <span>Define key performance indicators (KPIs) for waste management</span>
                                                    </li>
                                                    <li class="action-step">
                                                        <span class="action-step-icon"><i class="fas fa-check-circle"></i></span>
                                                        <span>Implement data collection processes for these KPIs</span>
                                                    </li>
                                                    <li class="action-step">
                                                        <span class="action-step-icon"><i class="fas fa-check-circle"></i></span>
                                                        <span>Create regular reporting templates for stakeholders</span>
                                                    </li>
                                                </ul>
                                                
                                                <div class="mt-3">
                                                    <a href="#" class="btn btn-sm btn-outline-success btn-hover-effect">
                                                        <i class="fas fa-info-circle me-2"></i> Learn More
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="recommendation-item" data-aos="fade-up" data-aos-delay="100">
                                    <span class="recommendation-priority priority-medium">Medium Priority</span>
                                    <div class="d-flex">
                                        <div class="recommendation-icon">
                                            <i class="fas fa-bullseye"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h4>Set Clear Measurable Targets</h4>
                                            <p class="mb-0">Define specific, measurable goals for waste reduction and recycling rates with clear timelines and accountability.</p>
                                            
                                            <div class="recommendation-details">
                                                <hr>
                                                <h5>Action Steps:</h5>
                                                <ul class="action-steps">
                                                    <li class="action-step">
                                                        <span class="action-step-icon"><i class="fas fa-check-circle"></i></span>
                                                        <span>Analyze current waste generation and recycling rates</span>
                                                    </li>
                                                    <li class="action-step">
                                                        <span class="action-step-icon"><i class="fas fa-check-circle"></i></span>
                                                        <span>Set realistic but ambitious targets for improvement</span>
                                                    </li>
                                                    <li class="action-step">
                                                        <span class="action-step-icon"><i class="fas fa-check-circle"></i></span>
                                                        <span>Develop action plans for achieving each target</span>
                                                    </li>
                                                </ul>
                                                
                                                <div class="mt-3">
                                                    <a href="#" class="btn btn-sm btn-outline-success btn-hover-effect">
                                                        <i class="fas fa-info-circle me-2"></i> Learn More
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="recommendation-item" data-aos="fade-up" data-aos-delay="200">
                                    <span class="recommendation-priority priority-medium">Medium Priority</span>
                                    <div class="d-flex">
                                        <div class="recommendation-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h4>Enhance Community Engagement</h4>
                                            <p class="mb-0">Develop comprehensive programs to engage community members in waste sorting and recycling initiatives through education and incentives.</p>
                                            
                                            <div class="recommendation-details">
                                                <hr>
                                                <h5>Action Steps:</h5>
                                                <ul class="action-steps">
                                                    <li class="action-step">
                                                        <span class="action-step-icon"><i class="fas fa-check-circle"></i></span>
                                                        <span>Create educational materials about proper waste sorting</span>
                                                    </li>
                                                    <li class="action-step">
                                                        <span class="action-step-icon"><i class="fas fa-check-circle"></i></span>
                                                        <span>Organize community workshops and awareness campaigns</span>
                                                    </li>
                                                    <li class="action-step">
                                                        <span class="action-step-icon"><i class="fas fa-check-circle"></i></span>
                                                        <span>Implement incentive programs for recycling participation</span>
                                                    </li>
                                                </ul>
                                                
                                                <div class="mt-3">
                                                    <a href="#" class="btn btn-sm btn-outline-success btn-hover-effect">
                                                        <i class="fas fa-info-circle me-2"></i> Learn More
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="report-card report-pdf">
                        <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                        <h4>Comprehensive PDF Report</h4>
                        <p class="text-muted">Download a detailed assessment report with complete analysis and actionable recommendations.</p>
                        <button class="btn btn-danger btn-ripple mt-2" onclick="alert('Report generation will be implemented in the next phase.')">
                            <i class="fas fa-download me-2"></i> Download PDF Report
                        </button>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="report-card report-comparison">
                        <div class="score-badge">+12%</div>
                        <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
                        <h4>Progress Comparison</h4>
                        <p class="text-muted">See how your current assessment compares with previous results and track your improvement over time.</p>
                        <button class="btn btn-primary btn-ripple mt-2" onclick="alert('Comparison feature will be implemented in the next phase.')">
                            <i class="fas fa-chart-bar me-2"></i> View Progress Trends
                        </button>
                    </div>
                </div>
                
                <div class="col-12 text-center mt-3" data-aos="fade-up" data-aos-delay="500">
                    <a href="{{ route('opportunities.circular-economy.assessment.section', $section) }}" class="btn btn-success btn-ripple me-3">
                        <i class="fas fa-redo me-2"></i> Retake Assessment
                    </a>
                    <a href="{{ route('opportunities.circular-economy.assessment.index') }}" class="btn btn-outline-success btn-hover-effect">
                        <i class="fas fa-clipboard-list me-2"></i> Continue to Other Sections
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            once: true
        });
        
        // Animate category progress bars
        setTimeout(() => {
            document.querySelectorAll('.category-progress-bar').forEach(bar => {
                bar.style.width = bar.dataset.width;
            });
        }, 500);
        
        // Make recommendation items expandable
        document.querySelectorAll('.recommendation-item').forEach(item => {
            item.addEventListener('click', function() {
                this.classList.toggle('expanded');
            });
        });
    });
</script>
@endsection