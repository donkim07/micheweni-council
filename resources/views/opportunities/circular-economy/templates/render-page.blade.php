{{-- templates/render-page.blade.php --}}
{{-- This template renders a page using the section and component templates --}}

@extends('opportunities.layouts.app')

@section('title', $page->title)

@section('styles')
<link rel="stylesheet" href="{{ asset('css/custom-animations.css') }}">
<style>
    /* Custom styles to match home page aesthetics */
    .page-header {
        position: relative;
        overflow: hidden;
        padding: 4rem 0;
        background: linear-gradient(135deg, #198754 0%, #28a745 100%);
        color: white;
    }
    
    .page-title {
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .page-description {
        font-size: 1.2rem;
        opacity: 0.9;
    }
    
    .breadcrumb-section {
        background-color: #f8f9fa;
        padding: 1rem 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .content-section {
        margin-bottom: 2rem;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 15px;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: #28a745;
        transition: width 0.3s ease;
    }
    
    .section-title:hover::after {
        width: 100%;
    }
    
    .sidebar {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
    }
    
    .empty-content {
        text-align: center;
        padding: 3rem;
        background: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .empty-icon {
        font-size: 3rem;
        color: #adb5bd;
        margin-bottom: 1rem;
    }
    
    .component {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .component:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    /* Animation classes */
    .animate-fade-in {
        opacity: 0;
        animation-name: fadeIn;
        animation-duration: 1s;
        animation-fill-mode: both;
    }
    
    .animate-fade-in-up {
        opacity: 0;
        animation-name: fadeInUp;
        animation-duration: 1s;
        animation-fill-mode: both;
        animation-delay: 0.3s;
    }
    
    .animate-fade-in-left {
        opacity: 0;
        animation-name: fadeInLeft;
        animation-duration: 1s;
        animation-fill-mode: both;
    }
    
    .animate-fade-in-right {
        opacity: 0;
        animation-name: fadeInRight;
        animation-duration: 1s;
        animation-fill-mode: both;
    }
    
    .animate-on-scroll {
        opacity: 0;
        transition: opacity 0.6s ease, transform 0.6s ease;
        transform: translateY(20px);
    }
    
    .animate-on-scroll.visible {
        opacity: 1;
        transform: translateY(0);
    }
    
    .delay-200 {
        animation-delay: 0.2s;
    }
    
    .btn-hover-effect {
        transition: all 0.3s ease;
    }
    
    .btn-hover-effect:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translate3d(0, 30px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }
    
    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translate3d(-30px, 0, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }
    
    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translate3d(30px, 0, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }
</style>
@endsection

@section('content')
@php
    use App\Models\Opportunities\CircularEconomy\Section;
    use App\Models\Opportunities\CircularEconomy\Content;
    
    // Fetch all sections for this page, ordered by their position
    $pageSections = Section::where('page_id', $page->id)
                    ->orderBy('order', 'asc')
                    ->get();
@endphp

<!-- Page Header with Animation -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 text-center">
                <h1 class="page-title display-4 fw-bold animate-fade-in">{{ $page->title }}</h1>
                @if($page->description)
                    <p class="page-description lead animate-fade-in-up">{{ $page->description }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Breadcrumb with Animation -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
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
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            @forelse($pageSections as $section)
                @php
                    // Get the contents for this section
                    $sectionContents = Content::where('section', $section->identifier)
                                      ->where('is_active', true)
                                      ->orderBy('order', 'asc')
                                      ->get();
                    
                    // Determine the section template to use
                    $sectionType = $section->type ?? 'standard';
                    $sectionTemplate = 'templates.sections.' . $sectionType;
                    
                    // Fallback to standard template if the specified one doesn't exist
                    if (!view()->exists($sectionTemplate)) {
                        $sectionTemplate = 'templates.sections.standard';
                    }
                @endphp
                
                @include($sectionTemplate, [
                    'section' => $section,
                    'contents' => $sectionContents
                ])
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
            <div class="sidebar animate-fade-in-right">
                <h3 class="section-title">{{ __('Related Content') }}</h3>
                <div class="list-group list-group-flush">
                    @foreach($page->getRelatedPages(4) ?? [] as $relatedPage)
                    <a href="{{ route('opportunities.circular-economy.pages.show', $relatedPage->slug) }}" 
                       class="list-group-item list-group-item-action border-0 bg-transparent animate-on-scroll" 
                       data-delay="{{ $loop->index * 100 }}">
                        <i class="fas fa-angle-right me-2 text-success"></i> {{ $relatedPage->title }}
                    </a>
                    @endforeach
                    
                    @if(count($page->getRelatedPages(4) ?? []) == 0)
                    <div class="text-muted p-3">
                        {{ __('No related content found') }}
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Newsletter Signup with Animation -->
            <div class="sidebar animate-fade-in-right delay-200">
                <h3 class="section-title">{{ __('Stay Updated') }}</h3>
                <p>{{ __('Subscribe to receive the latest news about waste management in the region.') }}</p>
                <form action="{{ route('opportunities.circular-economy.newsletter.subscribe') }}" method="POST">
                    @csrf
                    <div class="mb-3 animate-on-scroll" data-delay="100">
                        <input type="email" class="form-control form-control-lg" 
                               name="email" placeholder="{{ __('Your email address') }}" required>
                    </div>
                    <div class="animate-on-scroll" data-delay="200">
                        <button type="submit" class="btn btn-success btn-lg w-100 btn-hover-effect">
                            <i class="fas fa-paper-plane me-2"></i> {{ __('Subscribe') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize animations for sections and components
        const options = {
            threshold: 0.2
        };
        
        const observer = new IntersectionObserver(function(entries, observer) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    let element = entry.target;
                    let delay = element.dataset.delay || 0;
                    
                    setTimeout(() => {
                        element.classList.add('visible');
                    }, delay);
                    
                    observer.unobserve(element);
                }
            });
        }, options);
        
        document.querySelectorAll('.animate-on-scroll, .animate-fade-in, .animate-fade-in-up, .animate-fade-in-right').forEach(element => {
            observer.observe(element);
        });
    });
</script>
@endsection 