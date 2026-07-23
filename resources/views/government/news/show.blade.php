@extends('government.layouts.app')

@section('title', $news->title)

@section('styles')
<style>
    .news-header {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8)), 
                    url('/images/government/news-detail-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
    }
    
    .news-featured-image {
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        max-height: 500px;
        object-fit: cover;
    }
    
    .news-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    
    .news-meta-item {
        display: flex;
        align-items: center;
        margin-right: 20px;
        margin-bottom: 10px;
    }
    
    .news-meta-item i {
        margin-right: 5px;
        color: var(--primary);
    }
    
    .news-category {
        background-color: var(--primary);
        color: white;
        font-size: 0.85rem;
        padding: 5px 15px;
        border-radius: 50px;
        display: inline-block;
        margin-bottom: 15px;
    }
    
    .news-content {
        line-height: 1.8;
        font-size: 1.05rem;
    }
    
    .news-content p {
        margin-bottom: 1.5rem;
    }
    
    .news-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 20px 0;
    }
    
    .news-content h2, .news-content h3 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: var(--primary);
    }
    
    .news-content ul, .news-content ol {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }
    
    .news-content li {
        margin-bottom: 0.5rem;
    }
    
    .news-tag {
        background-color: rgba(20, 78, 115, 0.1);
        color: var(--primary);
        font-size: 0.85rem;
        padding: 5px 10px;
        border-radius: 50px;
        display: inline-block;
        margin-right: 5px;
        margin-bottom: 5px;
        transition: all 0.2s ease;
    }
    
    .news-tag:hover {
        background-color: var(--primary);
        color: white;
        text-decoration: none;
    }
    
    .social-share {
        display: flex;
        align-items: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
    
    .social-share-title {
        margin-right: 15px;
        font-weight: 600;
    }
    
    .social-share-buttons a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        margin-right: 10px;
        color: white;
        transition: all 0.2s ease;
    }
    
    .social-share-buttons a:hover {
        transform: translateY(-3px);
    }
    
    .btn-facebook { background-color: #3b5998; }
    .btn-twitter { background-color: #1da1f2; }
    .btn-linkedin { background-color: #0077b5; }
    .btn-whatsapp { background-color: #25d366; }
    
    .related-news-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 8px;
        overflow: hidden;
        height: 100%;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .related-news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .related-news-card .card-img-top {
        height: 160px;
        object-fit: cover;
    }
    
    .related-news-title {
        font-size: 1rem;
        font-weight: 600;
        line-height: 1.4;
        color: var(--primary);
    }
    
    .sidebar-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        border: none;
    }
    
    .sidebar-card-header {
        background-color: var(--primary);
        color: white;
        padding: 15px 20px;
        font-weight: 600;
    }
    
    .sidebar-list-item {
        display: flex;
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        transition: all 0.2s ease;
    }
    
    .sidebar-list-item:last-child {
        border-bottom: none;
    }
    
    .sidebar-list-item:hover {
        background-color: rgba(20, 78, 115, 0.05);
    }
    
    .sidebar-list-item-image {
        width: 60px;
        height: 60px;
        border-radius: 5px;
        object-fit: cover;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .sidebar-list-item-content h6 {
        font-size: 0.9rem;
        margin-bottom: 5px;
        line-height: 1.4;
    }
    
    .sidebar-list-item-date {
        font-size: 0.8rem;
        color: #666;
    }
</style>
@endsection

@section('content')
<!-- News Header -->
<div class="news-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ url('/government') }}" class="text-white">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/government/news-new') }}" class="text-white">News</a></li>
                        @if($news->category)
                            <li class="breadcrumb-item"><a href="{{ url('/government/news?category=' . $news->category->id) }}" class="text-white">{{ $news->category->name }}</a></li>
                        @endif
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit($news->title, 40) }}</li>
                    </ol>
                </nav>
                
                <h1 class="display-4 fw-bold mb-3">{{ $news->title }}</h1>
                
                @if($news->category)
                    <span class="news-category">
                        <i class="fas fa-folder me-1"></i> {{ $news->category->name }}
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row">
        <!-- Main News Content -->
        <div class="col-lg-8">
            @if($news->featured_image)
                <img src="{{ asset('images/' . $news->featured_image) }}" class="news-featured-image" alt="{{ $news->title }}">
            @endif
            
            <div class="news-meta">
                <div class="news-meta-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ \Carbon\Carbon::parse($news->published_at)->format('M d, Y') }}</span>
                </div>
                
                @if($news->author)
                <div class="news-meta-item">
                    <i class="fas fa-user"></i>
                    <span>{{ $news->author }}</span>
                </div>
                @endif
                
                <div class="news-meta-item">
                    <i class="fas fa-eye"></i>
                    <span>{{ $news->views ?? 0 }} views</span>
                </div>
                
                @if($news->source)
                <div class="news-meta-item">
                    <i class="fas fa-external-link-alt"></i>
                    <span>Source: {{ $news->source }}</span>
                </div>
                @endif
            </div>
            
            <div class="news-content">
                {!! $news->content !!}
            </div>
            
            @if($news->tags && $news->tags->count() > 0)
            <div class="mt-4">
                <h5>Tags:</h5>
                <div class="d-flex flex-wrap">
                    @foreach($news->tags as $tag)
                        <a href="{{ url('/government/news?tag=' . $tag->id) }}" class="news-tag">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Social Share -->
            <div class="social-share">
                <div class="social-share-title">Share this article:</div>
                <div class="social-share-buttons">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn-facebook" title="Share on Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($news->title) }}" target="_blank" class="btn-twitter" title="Share on Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($news->title) }}" target="_blank" class="btn-linkedin" title="Share on LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($news->title . ' ' . request()->url()) }}" target="_blank" class="btn-whatsapp" title="Share on WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
            
            <!-- Related News -->
            @if(isset($relatedNews) && $relatedNews->count() > 0)
            <div class="related-news mt-5">
                <h3 class="mb-4">Related News</h3>
                <div class="row g-4">
                    @foreach($relatedNews as $relatedItem)
                    <div class="col-md-6">
                        <div class="card related-news-card">
                            @if($relatedItem->featured_image)
                                <img src="{{ asset('images/' . $relatedItem->featured_image) }}" class="card-img-top" alt="{{ $relatedItem->title }}">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-newspaper fa-2x text-muted"></i>
                                </div>
                            @endif
                            
                            <div class="card-body">
                                <h5 class="related-news-title">{{ $relatedItem->title }}</h5>
                                <div class="news-meta-item mt-2 mb-2">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>{{ \Carbon\Carbon::parse($relatedItem->published_at)->format('M d, Y') }}</span>
                                </div>
                                <a href="{{ route('government.news.show', $relatedItem->id) }}" class="btn btn-sm btn-outline-primary mt-2">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Latest News -->
            <div class="card sidebar-card">
                <div class="sidebar-card-header">
                    <i class="fas fa-newspaper me-2"></i> Latest News
                </div>
                <div class="card-body p-0">
                    @if(isset($latestNews) && $latestNews->count() > 0)
                        @foreach($latestNews as $latest)
                        <a href="{{ route('government.news.show', $latest->id) }}" class="text-decoration-none text-dark">
                            <div class="sidebar-list-item">
                                @if($latest->featured_image)
                                    <img src="{{ asset('images/' . $latest->featured_image) }}" class="sidebar-list-item-image" alt="{{ $latest->title }}">
                                @else
                                    <div class="sidebar-list-item-image bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-newspaper text-muted"></i>
                                    </div>
                                @endif
                                
                                <div class="sidebar-list-item-content">
                                    <h6>{{ Str::limit($latest->title, 60) }}</h6>
                                    <div class="sidebar-list-item-date">
                                        <i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($latest->published_at)->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    @else
                        <div class="p-3 text-center text-muted">
                            No latest news available.
                        </div>
                    @endif
                </div>
                <div class="card-footer text-center">
                    <a href="{{ url('/government/news-new') }}" class="btn btn-sm btn-outline-primary">View All News</a>
                </div>
            </div>
            
            <!-- Categories -->
            <div class="card sidebar-card">
                <div class="sidebar-card-header">
                    <i class="fas fa-folder me-2"></i> Categories
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($categories as $category)
                        <a href="{{ url('/government/news?category=' . $category->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0">
                            {{ $category->name }}
                            <span class="badge bg-primary rounded-pill">{{ $category->news_count ?? 0 }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Popular Tags -->
            <div class="card sidebar-card">
                <div class="sidebar-card-header">
                    <i class="fas fa-tags me-2"></i> Popular Tags
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        @foreach($tags as $tag)
                        <a href="{{ url('/government/news?tag=' . $tag->id) }}" class="news-tag mb-2 me-2">
                            #{{ $tag->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Subscribe Newsletter -->
            <div class="card sidebar-card">
                <div class="sidebar-card-header">
                    <i class="fas fa-envelope me-2"></i> Subscribe to Newsletter
                </div>
                <div class="card-body">
                    <p class="small mb-3">Stay updated with the latest news and announcements from Micheweni District Council.</p>
                    <form action="{{ url('/government/newsletter/subscribe') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" placeholder="Your Email Address" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-paper-plane me-2"></i> Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 