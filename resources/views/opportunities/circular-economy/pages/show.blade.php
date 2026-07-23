@extends('opportunities.layouts.app')

@section('title', $page->title)

@section('styles')
<link rel="stylesheet" href="{{ asset('css/custom-animations.css') }}">
<style>
    /* Modern layout structure with improved organization */
    .page-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0;
    }
    
    /* Enhanced Page header section with advanced animation */
    .page-header {
        position: relative;
        overflow: hidden;
        min-height: 300px;
        background: linear-gradient(135deg, #198754 0%, #28a745 100%);
        color: white;
        padding: 4rem 0;
        margin-bottom: 0;
        border-bottom: 5px solid rgba(255,255,255,0.2);
        clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);
        animation: rotate 35s linear infinite;
        z-index: 0;
    }
    
    .page-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23ffffff' fill-opacity='0.1' d='M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,202.7C672,203,768,181,864,170.7C960,160,1056,160,1152,170.7C1248,181,1344,203,1392,213.3L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E");
        background-size: cover;
        background-position: center;
        opacity: 0.3;
        z-index: 0;
    }
    
    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .page-title {
        position: relative;
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        z-index: 1;
        opacity: 1;
        transform: translateY(-20px);
        animation: fadeInDown 1s ease forwards 0.3s;
        text-shadow: 0 2px 10px rgba(0,0,0,0.1);
        background: linear-gradient(90deg, #ffffff, #e0f7ef);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .page-description {
        position: relative;
        font-size: 1.3rem;
        max-width: 800px;
        margin: 0 auto;
        opacity: 1;
        transform: translateY(20px);
        animation: fadeInUp 2.9s ease forwards 0.6s;
        z-index: 1;
        text-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    /* Enhanced breadcrumb navigation */
    .breadcrumb-section {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        padding: 0.75rem 0;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        opacity: 1;
        animation: fadeIn 2.9s ease forwards 1s;
        position: relative;
        z-index: 10;
    }
    
    .breadcrumb {
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    
    .breadcrumb-item+.breadcrumb-item::before {
        transition: all 0.3s ease;
        color: #20c997;
    }
    
    .breadcrumb-item:hover+.breadcrumb-item::before {
        color: #198754;
    }
    
    .breadcrumb-item a {
        position: relative;
        display: inline-block;
        transition: all 0.3s ease;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
    }
    
    .breadcrumb-item a:hover {
        background: rgba(32, 201, 151, 0.1);
        transform: translateY(-2px);
        text-decoration: none;
    }
    
    /* Futuristic content sections with enhanced animations */
    .content-section {
        margin-bottom: 4rem;
        opacity: 1;
        transform: translateY(30px);
        transition: opacity 2.9s ease, transform 1.9s ease;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border-radius: 1.5rem;
        padding: 2.5rem;
        background-color: #fff;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(32, 201, 151, 0.1);
    }
    
    .content-section::before {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, rgba(25,135,84,0.05) 0%, rgba(32,201,151,0.05) 100%);
        border-radius: 50%;
        top: -100px;
        right: -100px;
        z-index: 0;
        transition: all 0.8s ease;
    }
    
    .content-section::after {
        content: '';
        position: absolute;
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, rgba(25,135,84,0.05) 0%, rgba(32,201,151,0.05) 100%);
        border-radius: 50%;
        bottom: -50px;
        left: -50px;
        z-index: 0;
        transition: all 0.8s ease;
    }
    
    .content-section:hover::before {
        transform: scale(3);
        opacity: 0.8;
    }
    
    .content-section:hover::after {
        transform: scale(3);
        opacity: 0.8;
    }
    
    .content-section.revealed {
        opacity: 1;
        transform: translateY(0);
    }
    
    .section-title {
        position: relative;
        display: inline-block;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 2rem;
        color: #198754;
        padding-bottom: 1rem;
        transition: all 0.3s ease;
        z-index: 1;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #198754, #20c997);
        border-radius: 2px;
        transition: width 0.5s ease;
    }
    
    .section-title:hover::after {
        width: 100%;
    }
    
    /* Enhanced card styling for better organization */
    .content-card {
        height: 100%;
        border-radius: 1.25rem;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        background: white;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        margin-bottom: 1.5rem;
        border: none;
        position: relative;
        z-index: 1;
        transform: perspective(1000px) rotateY(0deg);
        backface-visibility: hidden;
    }
    
    .content-card:hover {
        transform: translateY(-15px) perspective(1000px) rotateY(2deg);
        box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    }
    
    .content-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(25,135,84,0.1) 0%, rgba(32,201,151,0) 50%);
        z-index: -1;
        opacity: 0.5;
        transition: opacity 2.9s ease;
    }
    
    .content-card:hover::before {
        opacity: 1;
    }
    
    .card-header {
        padding: 1.8rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        background: linear-gradient(to right, #f8f9fa, #ffffff);
        position: relative;
        overflow: hidden;
    }
    
    .card-header::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 0;
        height: 3px;
        background: linear-gradient(90deg, #198754, #20c997);
        transition: width 0.5s ease;
    }
    
    .content-card:hover .card-header::after {
        width: 100%;
    }
    
    .card-body {
        padding: 2rem;
        position: relative;
        z-index: 1;
    }
    
    /* Enhanced image styles with better effects */
    .image-left {
        float: left;
        margin-right: 2rem;
        margin-bottom: 1.5rem;
        max-width: 40%;
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transition: all 0.4s ease;
        border: 3px solid white;
    }
    
    .image-right {
        float: right;
        margin-left: 2rem;
        margin-bottom: 1.5rem;
        max-width: 40%;
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transition: all 0.4s ease;
        border: 3px solid white;
    }
    
    .image-center {
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 2rem;
        max-width: 70%;
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transition: all 0.4s ease;
        border: 3px solid white;
    }
    
    .image-full {
        width: 100%;
        margin-bottom: 2rem;
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transition: all 0.4s ease;
        border: 3px solid white;
    }
    
    .image-left:hover, .image-right:hover, .image-center:hover, .image-full:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    /* Enhanced form styling with animations */
    .form-card {
        border-radius: 1.25rem;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        background: white;
        transition: transform 0.5s ease, box-shadow 0.5s ease;
        border: 1px solid rgba(32, 201, 151, 0.1);
    }
    
    .form-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    }
    
    .form-header {
        background: linear-gradient(135deg, #198754 0%, #20c997 100%);
        color: white;
        padding: 2.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .form-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);
        animation: rotate 25s linear infinite;
        z-index: 0;
    }
    
    .form-title {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
        font-weight: 700;
    }
    
    .form-body {
        padding: 2.5rem;
    }
    
    .form-control {
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        border: 1px solid rgba(0,0,0,0.1);
        transition: all 0.4s ease;
        background-color: #f8f9fa;
        font-size: 1rem;
    }
    
    .form-control:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
        background-color: #fff;
        transform: translateY(-5px);
    }
    
    .form-label {
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: #495057;
        transition: color 0.3s ease;
        font-size: 1rem;
    }
    
    .form-group:hover .form-label {
        color: #198754;
        transform: translateX(5px);
    }
    
    .form-submit {
        background: linear-gradient(135deg, #198754 0%, #20c997 100%);
        border: none;
        border-radius: 1rem;
        padding: 1rem 2rem;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.4s ease;
        box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    
    .form-submit:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(25, 135, 84, 0.4);
    }
    
    .form-submit::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(255,255,255,0.2), rgba(255,255,255,0));
        transition: all 0.6s ease;
        z-index: -1;
    }
    
    .form-submit:hover::after {
        left: 100%;
    }
    
    /* Improved component organization */
    .component {
        position: relative;
        margin-bottom: 2rem;
        transition: all 0.4s ease;
        z-index: 1;
    }
    
    .component:hover {
        transform: translateY(-5px);
    }
    
    .component::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #198754, #20c997);
        transition: width 0.5s ease;
        opacity: 0.5;
    }
    
    .component:hover::after {
        width: 100%;
    }
    
    /* Enhanced grid layouts with better spacing */
    .grid-2-col {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2.5rem;
        margin-bottom: 2rem;
    }
    
    .grid-3-col {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2.5rem;
        margin-bottom: 2rem;
    }
    
    .grid-4-col {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2.5rem;
        margin-bottom: 2rem;
    }
    
    /* Improved Masonry Grid Layout */
    .masonry-grid {
        column-count: 3;
        column-gap: 2rem;
        margin-bottom: 2rem;
    }
    
    .masonry-item {
        break-inside: avoid;
        margin-bottom: 2rem;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transition: all 2.9s ease;
        transform: translateY(30px);
        opacity: 1;
    }
    
    .masonry-item.revealed {
        transform: translateY(0);
        opacity: 1;
    }
    
    .masonry-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    /* Sidebar styles */
    .sidebar {
        position: sticky;
        top: 2rem;
        margin-bottom: 2rem;
    }
    
    /* Enhanced animation keyframes */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0.5;
        }
        to {
            opacity: 1;
        }
    }
    
    /* Empty content styling */
    .empty-content {
        text-align: center;
        padding: 5rem 2rem;
        background: linear-gradient(135deg, rgba(25,135,84,0.05) 0%, rgba(32,201,151,0.05) 100%);
        border-radius: 1rem;
        border: 1px dashed rgba(25,135,84,0.2);
    }
    
    .empty-icon {
        font-size: 3rem;
        color: #20c997;
        margin-bottom: 1.5rem;
        animation: pulse 2s infinite;
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
        .grid-3-col,
        .grid-4-col {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .masonry-grid {
            column-count: 2;
        }
        
        .page-title {
            font-size: 2.5rem;
        }
    }
    
    @media (max-width: 768px) {
        .grid-2-col,
        .grid-3-col,
        .grid-4-col {
            grid-template-columns: 1fr;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
        .masonry-grid {
            column-count: 1;
        }
        
        .image-left,
        .image-right {
            float: none;
            margin: 0 0 1.5rem 0;
            max-width: 100%;
        }
        
        .content-section {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
@php
use App\Helpers\TemplateHelper;
@endphp

<!-- Page Header with Animation -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 text-center">
                <h1 class="page-title">{{ $page->title }}</h1>
                @if($page->description)
                    <p class="page-description">{{ $page->description }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Breadcrumb with Animation -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success">{{ __('Home') }}</a></li>
                @if($page->parent)
                    <li class="breadcrumb-item"><a href="{{ route('opportunities.circular-economy.pages.show', $page->parent->slug) }}" class="text-success">{{ $page->parent->title }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Content with Animations -->
<div class="container page-container py-5">
    <div class="row">
        <div class="col-lg-8">
            @php
                $pageSections = \App\Models\Opportunities\CircularEconomy\Section::where('page_id', $page->id)
                                ->orderBy('order', 'asc')
                                ->get();
            @endphp
            
            @forelse($pageSections as $section)
                <div id="section-{{ $section->identifier }}" class="content-section animate-on-scroll"
                     style="background-color: {{ $section->background_color }}; 
                           color: {{ $section->text_color }}; 
                           padding: {{ $section->padding }};"
                     class="{{ $section->css_class }}" data-delay="{{ $loop->index * 150 }}">
                    
                    <h2 class="section-title">{{ $section->title }}</h2>
                    
                    @php
                        $sectionContents = $contents->where('section', $section->identifier)
                                                    ->where('is_active', true)
                                                    ->sortBy('order');
                        
                        $sectionType = $section->type ?? 'standard';
                    @endphp
                    
                    
                    @if($sectionType == 'columns-2')
                        <div class="row">
                            @foreach($sectionContents->chunk(ceil($sectionContents->count() / 2)) as $columnContents)
                                <div class="col-md-6">
                                    @foreach($columnContents as $content)
                                        <div class="component animate-on-scroll {{ $content->type }}-component {{ $content->css_class }}" data-delay="{{ $loop->index * 100 }}">
                                            @php
                                            // Safety check to ensure component view exists
                                            $componentViewPath = 'admin.layout.components.' . $content->type;
                                            $componentExists = view()->exists($componentViewPath);
                                            @endphp
                                            
                                            @if($componentExists)
                                                @include($componentViewPath, [
                                                    'content' => $content,
                                                    'isPreview' => false,
                                                    'formBuilders' => $formBuilders
                                                ])
                                            @else
                                                <div class="alert alert-warning">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                                    Component type "{{ $content->type }}" does not have a view.
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @elseif($sectionType == 'columns-3')
                        <div class="row">
                            @foreach($sectionContents->chunk(ceil($sectionContents->count() / 3)) as $columnContents)
                                <div class="col-md-4">
                                    @foreach($columnContents as $content)
                                        <div class="component animate-on-scroll {{ $content->getCssClasses() }}" data-delay="{{ $loop->index * 100 }}">
                                            @php
                                                echo TemplateHelper::renderComponent($content, [
                                                    'isPreview' => false,
                                                    'formBuilders' => $formBuilders ?? null
                                                ]);
                                            @endphp
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @elseif($sectionType == 'masonry')
                        <div class="masonry-grid">
                            @foreach($sectionContents as $content)
                                <div class="masonry-item animate-on-scroll" data-delay="{{ $loop->index * 100 }}">
                                    <div class="component {{ $content->getCssClasses() }}" 
                                         style="margin: {{ $content->margin }}; padding: {{ $content->padding }};">
                                        @php
                                            echo TemplateHelper::renderComponent($content, [
                                                'isPreview' => false,
                                                'formBuilders' => $formBuilders ?? null
                                            ]);
                                        @endphp
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="row">
                            @foreach($sectionContents as $content)
                                @php
                                    $columnWidth = 'col-md-' . ($content->column_width ?? '12');
                                @endphp
                                <div class="{{ $columnWidth }}">
                                    <div class="component animate-on-scroll {{ $content->getCssClasses() }}" 
                                         style="margin: {{ $content->margin }}; padding: {{ $content->padding }};"
                                         data-delay="{{ $loop->index * 100 }}">
                                        @php
                                            echo TemplateHelper::renderComponent($content, [
                                                'isPreview' => false,
                                                'formBuilders' => $formBuilders ?? null
                                            ]);
                                        @endphp
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="empty-content animate-fade-in">
                    <i class="fas fa-info-circle empty-icon"></i>
                    <h3 class="mb-3">{{ __('No Content Available') }}</h3>
                    <p class="text-muted">{{ __('No content available for this page at the moment.') }}</p>
                </div>
            @endforelse
        </div>
        
        <!-- Sidebar Column with Animation -->
        <div class="col-lg-4">
            <!-- Related Content Sidebar -->
            <div class="sidebar content-section animate-fade-in-right">
                <h3 class="section-title">{{ __('Related Content') }}</h3>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action border-0 bg-transparent animate-on-scroll" data-delay="100">
                        <i class="fas fa-angle-right me-2 text-success"></i> {{ __('Waste Management Guidelines') }}
                    </a>
                    <a href="#" class="list-group-item list-group-item-action border-0 bg-transparent animate-on-scroll" data-delay="200">
                        <i class="fas fa-angle-right me-2 text-success"></i> {{ __('Recycling Information') }}
                    </a>
                    <a href="#" class="list-group-item list-group-item-action border-0 bg-transparent animate-on-scroll" data-delay="300">
                        <i class="fas fa-angle-right me-2 text-success"></i> {{ __('Collection Schedules') }}
                    </a>
                    <a href="#" class="list-group-item list-group-item-action border-0 bg-transparent animate-on-scroll" data-delay="400">
                        <i class="fas fa-angle-right me-2 text-success"></i> {{ __('Sustainability Tips') }}
                    </a>
                </div>
            </div>
            
            <!-- Newsletter Signup with Animation -->
            <div class="sidebar content-section animate-fade-in-right delay-200">
                <h3 class="section-title">{{ __('Stay Updated') }}</h3>
                <p>{{ __('Subscribe to receive the latest news about waste management in the region.') }}</p>
                <form>
                    <div class="mb-3 animate-on-scroll" data-delay="100">
                        <input type="email" class="form-control" placeholder="{{ __('Your Email Address') }}">
                    </div>
                    <button type="submit" class="btn btn-success w-100 btn-hover-effect animate-on-scroll" data-delay="200">{{ __('Subscribe') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/custom-animations.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Intersection Observer for scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    
                    // If it has a data-delay attribute, add it as a style
                    const delay = entry.target.getAttribute('data-delay');
                    if (delay) {
                        entry.target.style.transitionDelay = `${delay}ms`;
                    }
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        });
        
        // Observe all items with animate-on-scroll class
        document.querySelectorAll('.animate-on-scroll, .content-section').forEach((el) => {
            observer.observe(el);
        });
        
        // Add hover effects to cards and buttons
        document.querySelectorAll('.card, .btn').forEach(el => {
            el.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 15px 35px rgba(0,0,0,0.1)';
            });
            
            el.addEventListener('mouseleave', function() {
                this.style.transform = '';
                this.style.boxShadow = '';
            });
        });
        
        // Add ripple effect to buttons
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = button.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = `${size}px`;
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                ripple.classList.add('ripple');
                
                button.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>
@endsection 