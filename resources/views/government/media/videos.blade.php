@extends('government.layouts.app')

@section('title', __('Video Gallery'))

@section('styles')
<style>
    .video-filter {
        background-color: var(--light);
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
    }
    
    .video-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 8px;
        overflow: hidden;
        height: 100%;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .video-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .video-thumbnail {
        position: relative;
        overflow: hidden;
    }
    
    .video-thumbnail img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .video-card:hover .video-thumbnail img {
        transform: scale(1.05);
    }
    
    .video-play-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60px;
        height: 60px;
        background-color: rgba(20, 78, 115, 0.8);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        opacity: 0.9;
        transition: all 0.3s ease;
    }
    
    .video-card:hover .video-play-button {
        background-color: var(--primary);
        opacity: 1;
        width: 70px;
        height: 70px;
        font-size: 28px;
    }
    
    .video-duration {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 12px;
    }
    
    .video-meta {
        display: flex;
        align-items: center;
        color: #666;
        font-size: 0.85rem;
        margin-bottom: 10px;
    }
    
    .video-meta i {
        margin-right: 5px;
        color: var(--primary);
    }
    
    .video-meta span {
        margin-right: 15px;
    }
    
    .video-title {
        color: var(--primary);
        font-weight: 600;
        line-height: 1.4;
    }
    
    .page-hero {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8)), url('/images/government/videos-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
    }
    
    .video-modal .modal-dialog {
        max-width: 800px;
    }
    
    .video-modal .modal-content {
        background-color: #000;
        border: none;
    }
    
    .video-modal .modal-header {
        border-bottom: none;
        padding: 15px;
        background-color: rgba(0, 0, 0, 0.7);
    }
    
    .video-modal .modal-title {
        color: white;
    }
    
    .video-modal .btn-close {
        color: white;
        filter: invert(1) grayscale(100%) brightness(200%);
    }
    
    .video-modal .modal-body {
        padding: 0;
    }
    
    .video-container {
        position: relative;
        width: 100%;
        padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
        height: 0;
    }
    
    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }
    
    .featured-video {
        margin-bottom: 40px;
    }
    
    .featured-video-container {
        position: relative;
        width: 100%;
        padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
        height: 0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .featured-video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }
    
    .featured-video-content {
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        margin-top: -30px;
        position: relative;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .featured-video-title {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .category-filter-sidebar {
        margin-bottom: 30px;
    }
    
    .category-filter-header {
        background-color: var(--primary);
        color: white;
        padding: 15px 20px;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    
    .category-filter-body {
        background-color: white;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        padding: 15px;
    }
    
    .category-filter-link {
        display: block;
        padding: 10px 15px;
        color: #333;
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    
    .category-filter-link:hover, .category-filter-link.active {
        background-color: rgba(20, 78, 115, 0.1);
        color: var(--primary);
        padding-left: 20px;
    }
    
    .category-filter-link i {
        margin-right: 10px;
        color: var(--primary);
    }
</style>
@endsection

@section('content')
<!-- Page Hero -->
<div class="page-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Video Gallery</h1>
                <p class="lead mb-4">Browse through our collection of videos showcasing various events, projects, and initiatives of the Micheweni District Council.</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="category-filter-sidebar">
                <div class="category-filter-header">
                    <h5 class="mb-0"><i class="fas fa-filter me-2"></i> Categories</h5>
                </div>
                <div class="category-filter-body">
                    <a href="{{ url('/government/media/videos') }}" class="category-filter-link {{ !request('category') ? 'active' : '' }}">
                        <i class="fas fa-video"></i> All Videos
                    </a>
                    
                    @foreach($categories as $category)
                    <a href="{{ url('/government/media/videos?category=' . $category->id) }}" class="category-filter-link {{ request('category') == $category->id ? 'active' : '' }}">
                        <i class="fas {{ $category->icon ?? 'fa-folder' }}"></i> {{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-search me-2"></i> Search Videos</h5>
                </div>
                <div class="card-body">
                    <form action="{{ url('/government/media/videos') }}" method="GET">
                        @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        
                        <div class="mb-3">
                            <label for="search" class="form-label">Keyword</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search videos..." value="{{ request('search') }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="year" class="form-label">Year</label>
                            <select class="form-select" id="year" name="year">
                                <option value="">All Years</option>
                                @for($year = date('Y'); $year >= 2010; $year--)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i> Search
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Featured Video -->
            @if($featuredVideo && !request('search') && !request('year') && (!request('category') || request('page')))
            <div class="featured-video">
                <div class="featured-video-container">
                    <iframe src="{{ $featuredVideo->video_url }}" allowfullscreen></iframe>
                </div>
                <div class="featured-video-content">
                    <span class="badge bg-warning text-dark mb-2">Featured</span>
                    
                    @if($featuredVideo->category)
                        <span class="badge bg-primary mb-2 ms-2">{{ $featuredVideo->category->name }}</span>
                    @endif
                    
                    <h3 class="featured-video-title">{{ $featuredVideo->title }}</h3>
                    
                    <div class="video-meta">
                        <span><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($featuredVideo->created_at)->format('M d, Y') }}</span>
                        <span><i class="fas fa-eye"></i> {{ $featuredVideo->views ?? 0 }} views</span>
                    </div>
                    
                    <p>{{ $featuredVideo->description }}</p>
                </div>
            </div>
            @endif
            
            <!-- Page Title and Filters -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title mb-0">
                    @if(request('category') && isset($currentCategory))
                        {{ $currentCategory->name }} Videos
                    @else
                        All Videos
                    @endif
                </h2>
                
                <div class="d-flex align-items-center">
                    <label for="sort" class="me-2 mb-0">Sort by:</label>
                    <select class="form-select form-select-sm" id="sort" name="sort" style="width: auto;">
                        <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Viewed</option>
                    </select>
                </div>
            </div>
            
            @if(request('search') || request('year'))
                <div class="alert alert-info mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-filter me-2"></i> 
                            Showing filtered results 
                            @if(request('search'))
                                for "<strong>{{ request('search') }}</strong>"
                            @endif
                            @if(request('year'))
                                from <strong>{{ request('year') }}</strong>
                            @endif
                        </div>
                        <a href="{{ url('/government/media/videos' . (request('category') ? '?category=' . request('category') : '')) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-times me-1"></i> Clear Filters
                        </a>
                    </div>
                </div>
            @endif
            
            <!-- Videos Grid -->
            @if($videos->count() > 0)
                <div class="row g-4">
                    @foreach($videos as $video)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="card video-card h-100">
                            <div class="video-thumbnail">
                                @if($video->thumbnail)
                                    <img src="{{ asset('images/' . $video->thumbnail) }}" alt="{{ $video->title }}">
                                @else
                                    <img src="https://img.youtube.com/vi/{{ getYoutubeIdFromUrl($video->video_url) }}/hqdefault.jpg" alt="{{ $video->title }}">
                                @endif
                                
                                <div class="video-play-button" data-bs-toggle="modal" data-bs-target="#videoModal{{ $video->id }}">
                                    <i class="fas fa-play"></i>
                                </div>
                                
                                @if($video->duration)
                                <div class="video-duration">{{ $video->duration }}</div>
                                @endif
                            </div>
                            
                            <div class="card-body">
                                <h5 class="card-title video-title">{{ $video->title }}</h5>
                                
                                <div class="video-meta">
                                    <span><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($video->created_at)->format('M d, Y') }}</span>
                                    <span><i class="fas fa-eye"></i> {{ $video->views ?? 0 }}</span>
                                </div>
                                
                                <p class="card-text">{{ Str::limit($video->description, 80) }}</p>
                                
                                <button class="btn btn-outline-primary mt-2 w-100" data-bs-toggle="modal" data-bs-target="#videoModal{{ $video->id }}">
                                    <i class="fas fa-play me-2"></i> Watch Video
                                </button>
                            </div>
                        </div>
                        
                        <!-- Video Modal -->
                        <div class="modal fade video-modal" id="videoModal{{ $video->id }}" tabindex="-1" aria-labelledby="videoModalLabel{{ $video->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="videoModalLabel{{ $video->id }}">{{ $video->title }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="video-container">
                                            <iframe src="{{ $video->video_url }}" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-center mt-5">
                    {{ $videos->links() }}
                </div>
            @else
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle me-2"></i> No videos found matching your criteria. Please try a different search or browse all available videos.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto submit form when sorting changes
        document.getElementById('sort').addEventListener('change', function() {
            // Get current URL and parameters
            var url = new URL(window.location.href);
            var params = new URLSearchParams(url.search);
            
            // Update or add the sort parameter
            params.set('sort', this.value);
            
            // Redirect to the new URL
            window.location.href = url.pathname + '?' + params.toString();
        });
        
        // Auto submit form when year filter changes
        document.getElementById('year').addEventListener('change', function() {
            this.form.submit();
        });
        
        // Pause videos when modal is closed
        $('.video-modal').on('hidden.bs.modal', function () {
            var iframe = $(this).find('iframe');
            var src = iframe.attr('src');
            iframe.attr('src', '');
            iframe.attr('src', src);
        });
    });
    
    // Helper function to extract YouTube video ID from URL
    function getYoutubeIdFromUrl(url) {
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
        var match = url.match(regExp);
        return (match && match[7].length == 11) ? match[7] : false;
    }
</script>
@endsection 