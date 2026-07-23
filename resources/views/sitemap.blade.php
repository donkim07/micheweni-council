@extends('government.layouts.app')

@section('title', __('Sitemap'))

@section('styles')
<style>
    .sitemap-section {
        margin-bottom: 2rem;
    }
    
    .sitemap-section h3 {
        color: var(--primary);
        border-bottom: 2px solid var(--primary);
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .sitemap-list {
        list-style: none;
        padding-left: 0;
        column-count: 1;
    }
    
    @media (min-width: 576px) {
        .sitemap-list {
            column-count: 2;
        }
    }
    
    @media (min-width: 992px) {
        .sitemap-list {
            column-count: 3;
        }
    }
    
    .sitemap-list li {
        margin-bottom: 0.5rem;
        break-inside: avoid;
    }
    
    .sitemap-list li a {
        color: var(--dark);
        text-decoration: none;
        display: inline-block;
        padding: 0.25rem 0;
        transition: all 0.2s ease;
    }
    
    .sitemap-list li a:hover {
        color: var(--primary);
        transform: translateX(5px);
    }
    
    .sitemap-category {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    .sitemap-category h4 {
        color: var(--secondary);
        font-size: 1.25rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 0.5rem;
    }
    
    .admin-section {
        background-color: #f0f8ff;
        border-left: 4px solid var(--primary);
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">{{ __('Sitemap') }}</h1>
            <p class="lead mb-5">{{ __('Find all the pages available on our website organized by sections.') }}</p>
            
            <!-- Public Routes -->
            @foreach($publicRoutes as $category => $routes)
                <div class="sitemap-section">
                    <h3>{{ __($category) }}</h3>
                    <div class="sitemap-category">
                        <ul class="sitemap-list">
                            @foreach($routes as $route)
                                <li><a href="{{ url($route['url']) }}">{{ __($route['title']) }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
            
            <!-- Dynamic Content Sections -->
            <div class="sitemap-section">
                <h3>{{ __('News') }}</h3>
                <div class="sitemap-category">
                    <ul class="sitemap-list">
                        @forelse($news as $item)
                            <li><a href="{{ url('/government/news-new/' . $item->id) }}">{{ $item->title }}</a></li>
                        @empty
                            <li>{{ __('No news articles available') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            
            <div class="sitemap-section">
                <h3>{{ __('Departments') }}</h3>
                <div class="sitemap-category">
                    <ul class="sitemap-list">
                        @forelse($departments as $item)
                            <li><a href="{{ url('/government/departments/' . $item->id) }}">{{ $item->name }}</a></li>
                        @empty
                            <li>{{ __('No departments available') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            
            <div class="sitemap-section">
                <h3>{{ __('Services') }}</h3>
                <div class="sitemap-category">
                    <ul class="sitemap-list">
                        @forelse($services as $item)
                            <li><a href="{{ url('/government/services/' . $item->id) }}">{{ $item->title }}</a></li>
                        @empty
                            <li>{{ __('No services available') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            
            <div class="sitemap-section">
                <h3>{{ __('Projects') }}</h3>
                <div class="sitemap-category">
                    <ul class="sitemap-list">
                        @forelse($projects as $item)
                            <li><a href="{{ url('/government/projects/' . $item->id) }}">{{ $item->title }}</a></li>
                        @empty
                            <li>{{ __('No projects available') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            
            <div class="sitemap-section">
                <h3>{{ __('Publications') }}</h3>
                <div class="sitemap-category">
                    <ul class="sitemap-list">
                        @forelse($publications as $item)
                            <li><a href="{{ url('/government/publications/' . $item->id) }}">{{ $item->title }}</a></li>
                        @empty
                            <li>{{ __('No publications available') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            
            <div class="sitemap-section">
                <h3>{{ __('Opportunities') }}</h3>
                <div class="sitemap-category">
                    <ul class="sitemap-list">
                        @forelse($opportunities as $item)
                            <li><a href="{{ url('/opportunities/' . $item->id) }}">{{ $item->title }}</a></li>
                        @empty
                            <li>{{ __('No opportunities available') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            
            <!-- Admin Routes - Only visible to admin users -->
            @if(count($adminRoutes) > 0)
                <div class="sitemap-section mt-5">
                    <h2 class="mb-4">{{ __('Admin Section') }}</h2>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> {{ __('These pages are only accessible to administrators.') }}
                    </div>
                    
                    @foreach($adminRoutes as $category => $routes)
                        <div class="sitemap-section">
                            <h3>{{ __($category) }}</h3>
                            <div class="sitemap-category admin-section">
                                <ul class="sitemap-list">
                                    @foreach($routes as $route)
                                        <li><a href="{{ url($route['url']) }}">{{ __($route['title']) }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 