@extends('opportunities.layouts.app')

@section('title', __('Latest News & Updates'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/custom-animations.css') }}">
@endsection

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-5 section-transition">
        <div class="col-lg-8 mx-auto text-center animate-fade-in">
            <h1 class="display-4 fw-bold text-success mb-4">{{ __('Latest News & Updates') }}</h1>
            <p class="lead">{{ __('Stay informed about waste management initiatives and environmental news in Micheweni.') }}</p>
        </div>
    </div>
    
    <!-- Category Filter -->
    <div class="row mb-4 section-transition">
        <div class="col-12">
            <div class="d-flex flex-wrap justify-content-center gap-2 animate-fade-in">
                <a href="{{ route('opportunities.circular-economy.news.index') }}" class="btn {{ !request()->route('slug') ? 'btn-success' : 'btn-outline-success' }} btn-hover-effect">
                    {{ __('All News') }}
                </a>
                @foreach($categories as $category)
                <a href="{{ route('opportunities.circular-economy.news.category', $category->slug) }}" 
                   class="btn {{ request()->route('slug') == $category->slug ? 'btn-success' : 'btn-outline-success' }} btn-hover-effect">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- News Articles Grid -->
    <div class="row g-4">
        @forelse($news as $article)
        <div class="col-lg-4 col-md-6 card-grid-item">
            <div class="card news-card h-100 shadow-sm">
                @if($article->featured_image)
                <div class="img-hover-zoom position-relative">
                    <img src="{{ asset('images/' . $article->featured_image) }}" class="card-img-top" alt="{{ $article->title }}" loading="lazy">
                    <span class="position-absolute badge bg-success category-badge">
                        {{ $article->category->name ?? __('News') }}
                    </span>
                </div>
                @endif
                
                <div class="card-body d-flex flex-column">
                    <div class="news-date text-muted small mb-2">
                        <i class="far fa-calendar-alt me-1"></i> {{ $article->published_at->format('M d, Y') }}
                    </div>
                    
                    <h5 class="card-title mb-2 news-title">{{ $article->title }}</h5>
                    
                    <p class="card-text flex-grow-1">{{ Str::limit($article->excerpt, 120) }}</p>
                    
                    <a href="{{ route('opportunities.circular-economy.news.show', $article->slug) }}" class="btn btn-link text-success p-0 news-link mt-auto">
                        {{ __('Read More') }} <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center animate-fade-in">
            <div class="alert alert-info py-5">
                <i class="fas fa-info-circle fa-3x mb-3 text-info"></i>
                <p class="mb-0">{{ __('No news articles available at the moment.') }}</p>
                <p class="mb-0 mt-3">{{ __('Please check back later for updates.') }}</p>
            </div>
        </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div class="row mt-5 section-transition">
        <div class="col-12 d-flex justify-content-center animate-fade-in">
            {{ $news->links() }}
        </div>
    </div>
    
    <!-- Newsletter Subscription -->
    <div class="row mt-5 section-transition">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 bg-light animate-fade-in">
                <div class="card-body p-4 text-center">
                    <h3 class="fw-bold mb-3">{{ __('Subscribe to Our Newsletter') }}</h3>
                    <p class="mb-4">{{ __('Get the latest updates on waste management initiatives and environmental news delivered to your inbox.') }}</p>
                    
                    <form action="{{ route('opportunities.circular-economy.newsletter.subscribe') }}" method="POST" class="row g-2 justify-content-center">
                        @csrf
                        <div class="col-md-8">
                            <input type="email" name="email" class="form-control form-control-lg" placeholder="{{ __('Your email address') }}" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success btn-lg w-100 btn-hover-effect">{{ __('Subscribe') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.news-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    will-change: transform;
    background-color: #fff;
    border-radius: 0.5rem;
    overflow: hidden;
}

.news-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}

.img-hover-zoom {
    overflow: hidden;
}

.img-hover-zoom img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.news-card:hover .img-hover-zoom img {
    transform: scale(1.05);
}

.category-badge {
    top: 15px;
    left: 15px;
    z-index: 2;
    padding: 0.5rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.news-title {
    font-weight: 600;
    position: relative;
    display: inline-block;
}

.news-title:after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: -4px;
    left: 0;
    background-color: currentColor;
    transition: width 0.3s ease;
}

.news-card:hover .news-title:after {
    width: 100%;
}

.news-link {
    font-weight: 600;
    position: relative;
    display: inline-block;
    transition: transform 0.3s ease;
}

.news-link i {
    transition: transform 0.3s ease;
}

.news-card:hover .news-link i {
    transform: translateX(5px);
}

.btn-hover-effect {
    transition: all 0.3s ease;
}

.btn-hover-effect:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
</style>
@endsection

@section('scripts')
<script src="{{ asset('js/custom-animations.js') }}"></script>
@endsection 