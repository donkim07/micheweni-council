@extends('opportunities.layouts.app')

@section('title', isset($category) ? $category->name . ' - ' . __('News') : __('News Categories'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/custom-animations.css') }}">
@endsection

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-5 section-transition">
        <div class="col-lg-8 mx-auto text-center animate-fade-in">
            <h1 class="display-4 fw-bold text-success mb-4">
                {{ isset($category) ? $category->name : __('News Categories') }}
            </h1>
            @if(isset($category) && $category->description)
            <p class="lead">{{ $category->description }}</p>
            @else
            <p class="lead">{{ __('Browse news and updates by category') }}</p>
            @endif
        </div>
    </div>
    
    <!-- Category Filter -->
    <div class="row mb-4 section-transition">
        <div class="col-12">
            <div class="d-flex flex-wrap justify-content-center gap-2 animate-fade-in">
                <a href="{{ route('opportunities.circular-economy.news.index') }}" class="btn {{ !isset($category) ? 'btn-success' : 'btn-outline-success' }} btn-hover-effect">
                    {{ __('All News') }}
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('opportunities.circular-economy.news.category', $cat->slug) }}" 
                   class="btn {{ isset($category) && $cat->id == $category->id ? 'btn-success' : 'btn-outline-success' }} btn-hover-effect">
                    {{ $cat->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- News Articles Grid -->
    <div class="row g-4">
        @if(isset($news) && count($news) > 0)
            @foreach($news as $index => $article)
            <div class="col-lg-4 col-md-6 card-grid-item delay-{{ $index * 100 }}">
                <div class="card h-100 border-0 shadow-sm card-hover-effect">
                    @if($article->featured_image)
                    <div class="img-hover-zoom">
                        <img src="{{ asset('images/' . $article->featured_image) }}" class="card-img-top" alt="{{ $article->title }}">
                    </div>
                    @else
                    <div class="img-hover-zoom">
                        <img src="{{ asset('images/news-placeholder.jpg') }}" class="card-img-top" alt="{{ $article->title }}">
                    </div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-success text-white">{{ $article->category->name ?? __('News') }}</span>
                            <small class="text-muted">{{ $article->published_at->format('M d, Y') }}</small>
                        </div>
                        <h5 class="card-title fw-bold">{{ $article->title }}</h5>
                        <p class="card-text text-muted">{{ $article->excerpt }}</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="{{ route('opportunities.circular-economy.news.show', $article->slug) }}" class="btn btn-link text-success p-0 fw-bold">
                            {{ __('Read More') }} <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12 text-center animate-fade-in">
                <div class="alert alert-info py-5">
                    <i class="fas fa-info-circle fa-3x mb-3 text-info"></i>
                    <p class="mb-0">{{ __('No news articles available in this category.') }}</p>
                    <p class="mb-0 mt-3">{{ __('Please check other categories or come back later.') }}</p>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Pagination -->
    @if(isset($news) && method_exists($news, 'hasPages') && $news->hasPages())
    <div class="row mt-5 section-transition">
        <div class="col-12 d-flex justify-content-center animate-fade-in">
            {{ $news->links() }}
        </div>
    </div>
    @endif
    
    <!-- Return to all news -->
    <div class="row mt-4 section-transition">
        <div class="col-12 text-center animate-fade-in">
            <a href="{{ route('opportunities.circular-economy.news.index') }}" class="btn btn-outline-secondary btn-hover-effect">
                <i class="fas fa-arrow-left me-2"></i> {{ __('Back to All News') }}
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/custom-animations.js') }}"></script>
@endsection 