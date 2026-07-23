@extends('government.layouts.app')

@section('title', __('News & Updates'))

@section('styles')
<style>
    .news-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 8px;
        overflow: hidden;
        height: 100%;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .news-card .card-img-top {
        height: 200px;
        object-fit: cover;
    }
    
    .news-meta {
        display: flex;
        align-items: center;
        color: #666;
        font-size: 0.85rem;
        margin-bottom: 10px;
    }
    
    .news-meta i {
        margin-right: 5px;
        color: var(--primary);
    }
    
    .news-meta span {
        margin-right: 15px;
    }
    
    .news-title {
        color: var(--primary);
        font-weight: 600;
        line-height: 1.4;
    }
    
    .news-tag {
        background-color: rgba(20, 78, 115, 0.1);
        color: var(--primary);
        font-size: 0.75rem;
        padding: 3px 8px;
        border-radius: 50px;
        display: inline-block;
        margin-right: 5px;
        margin-bottom: 5px;
    }
    
    .page-hero {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8)), url('/images/government/news-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
    }
    
    .news-filter {
        background-color: var(--light);
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
    }
    
    .news-category-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 1;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        background-color: var(--primary);
        color: white;
    }
    
    .featured-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 1;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        background-color: var(--accent);
        color: var(--dark);
    }
    
    .category-link {
        display: block;
        padding: 10px 15px;
        margin-bottom: 5px;
        border-radius: 5px;
        text-decoration: none;
        color: var(--dark);
        transition: all 0.2s ease;
    }
    
    .category-link:hover, .category-link.active {
        background-color: rgba(20, 78, 115, 0.1);
        color: var(--primary);
        padding-left: 20px;
    }
    
    .category-link i {
        margin-right: 10px;
        color: var(--primary);
    }
    
    .category-link .badge {
        float: right;
        background-color: var(--primary);
        color: white;
    }
    
    .featured-news-card {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .featured-news-img {
        height: 400px;
        object-fit: cover;
        width: 100%;
    }
    
    .featured-news-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
        color: white;
        padding: 30px;
    }
    
    .featured-news-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .featured-news-meta {
        display: flex;
        align-items: center;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.85rem;
        margin-bottom: 15px;
    }
    
    .featured-news-meta i {
        margin-right: 5px;
    }
    
    .featured-news-meta span {
        margin-right: 15px;
    }
    
    .featured-news-excerpt {
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<!-- Page Hero -->
<div class="page-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">News & Updates</h1>
                <p class="lead mb-4">Stay informed about the latest news, announcements, and events from the Micheweni District Council.</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">News Categories</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ url('/government/news-new') }}" class="category-link {{ !request('category') ? 'active' : '' }}">
                            <i class="fas fa-newspaper"></i> All News
                            <span class="badge rounded-pill">{{ $totalNews }}</span>
                        </a>
                        
                        @foreach($categories as $category)
                        <a href="{{ url('/government/news?category=' . $category->id) }}" 
                           class="category-link {{ request('category') == $category->id ? 'active' : '' }}">
                            <i class="fas {{ $category->icon ?? 'fa-folder' }}"></i> 
                            {{ $category->name }}
                            <span class="badge rounded-pill">{{ $category->news_count ?? 0 }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Popular Tags</h5>
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
            
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Quick Filters</h5>
                </div>
                <div class="card-body">
                    <form action="{{ url('/government/news-new') }}" method="GET">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        
                        <div class="mb-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search news..." value="{{ request('search') }}">
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
                            <i class="fas fa-filter me-2"></i> Apply Filters
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- News Content -->
        <div class="col-lg-9">
            <!-- Featured News -->
            @if($featuredNews && !request('search') && !request('tag') && !request('year') && (!request('category') || request('page')))
                <div class="featured-news-card">
                    @if($featuredNews->featured_image)
                        <img src="{{ asset('images/' . $featuredNews->featured_image) }}" class="featured-news-img" alt="{{ $featuredNews->title }}">
                    @else
                        <div class="featured-news-img bg-primary d-flex align-items-center justify-content-center">
                            <i class="fas fa-newspaper fa-5x text-white opacity-50"></i>
                        </div>
                    @endif
                    
                    <div class="featured-news-content">
                        <span class="badge bg-warning text-dark mb-2">Featured</span>
                        
                        @if($featuredNews->category)
                            <span class="badge bg-primary mb-2 ms-2">{{ $featuredNews->category->name }}</span>
                        @endif
                        
                        <h2 class="featured-news-title">{{ $featuredNews->title }}</h2>
                        
                        <div class="featured-news-meta">
                            <span><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($featuredNews->published_at)->format('M d, Y') }}</span>
                            <span><i class="fas fa-user"></i> {{ $featuredNews->author ?? 'Admin' }}</span>
                        </div>
                        
                        <p class="featured-news-excerpt">{{ Str::limit(strip_tags($featuredNews->content), 200) }}</p>
                        
                        <a href="{{ route('government.news.show', $featuredNews->id) }}" class="btn btn-light">
                            Read More <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            @endif
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title mb-0">
                    @if(request('category') && isset($currentCategory))
                        {{ $currentCategory->name }}
                    @elseif(request('tag') && isset($currentTag))
                        #{{ $currentTag->name }}
                    @else
                        Latest News
                    @endif
                </h2>
                
                <div class="d-flex align-items-center">
                    <label for="sort" class="me-2 mb-0">Sort by:</label>
                    <select class="form-select form-select-sm" id="sort" name="sort" style="width: auto;">
                        <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    </select>
                </div>
            </div>
            
            @if(request('search') || request('year') || request('tag'))
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
                            @if(request('tag') && isset($currentTag))
                                with tag <strong>#{{ $currentTag->name }}</strong>
                            @endif
                        </div>
                        <a href="{{ url('/government/news' . (request('category') ? '?category=' . request('category') : '')) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-times me-1"></i> Clear Filters
                        </a>
                    </div>
                </div>
            @endif
            
            @if($news->count() > 0)
                <div class="row g-4">
                    @foreach($news as $newsItem)
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="card news-card h-100">
                            @if($newsItem->category)
                                <span class="news-category-badge">
                                    {{ $newsItem->category->name }}
                                </span>
                            @endif
                            
                            @if($newsItem->is_featured)
                                <span class="featured-badge">
                                    <i class="fas fa-star me-1"></i> Featured
                                </span>
                            @endif
                            
                            @if($newsItem->featured_image)
                                <img src="{{ asset('images/' . $newsItem->featured_image) }}" class="card-img-top" alt="{{ $newsItem->title }}">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-newspaper fa-3x text-muted"></i>
                                </div>
                            @endif
                            
                            <div class="card-body">
                                <h5 class="card-title news-title">{{ $newsItem->title }}</h5>
                                
                                <div class="news-meta">
                                    <span><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($newsItem->published_at)->format('M d, Y') }}</span>
                                    <span><i class="fas fa-user"></i> {{ $newsItem->author ?? 'Admin' }}</span>
                                </div>
                                
                                <p class="card-text">{{ Str::limit(strip_tags($newsItem->content), 120) }}</p>
                                
                                @if($newsItem->tags && $newsItem->tags->count() > 0)
                                    <div class="mb-3">
                                        @foreach($newsItem->tags as $tag)
                                            <a href="{{ url('/government/news?tag=' . $tag->id) }}" class="news-tag">
                                                #{{ $tag->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <a href="{{ route('government.news.show', $newsItem->id) }}" class="btn btn-outline-primary mt-2">
                                    Read More <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-center mt-5">
                    {{ $news->links() }}
                </div>
            @else
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle me-2"></i> No news found matching your criteria. Please try a different search or browse all available news.
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
    });
</script>
@endsection 