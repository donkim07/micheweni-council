@extends('opportunities.layouts.app')

@section('title', $article->title)

@section('styles')
<link rel="stylesheet" href="{{ asset('css/custom-animations.css') }}">
<style>
    .article-content {
        line-height: 1.8;
    }
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 20px 0;
    }
    .article-content h2, .article-content h3 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    .article-content p {
        margin-bottom: 1.2rem;
    }
    .article-content ul, .article-content ol {
        margin-bottom: 1.2rem;
        padding-left: 1.5rem;
    }
    .social-share-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        color: white;
        margin-right: 8px;
        transition: all 0.3s ease;
    }
    .social-share-btn:hover {
        transform: translateY(-3px);
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8 section-transition">
            <!-- Breadcrumb -->
            <div class="mb-4 animate-fade-in">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('opportunities.circular-economy.news.index') }}" class="text-decoration-none">{{ __('News') }}</a></li>
                        @if($article->category)
                        <li class="breadcrumb-item"><a href="{{ route('opportunities.circular-economy.news.category', $article->category->slug) }}" class="text-decoration-none">{{ $article->category->name }}</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($article->title, 40) }}</li>
                    </ol>
                </nav>
            </div>
            
            <!-- Article Content -->
            <div class="article-wrapper animate-fade-in">
                <!-- Article Header -->
                <div class="mb-4">
                    @if($article->category)
                    <a href="{{ route('opportunities.circular-economy.news.category', $article->category->slug) }}" class="badge bg-success text-decoration-none mb-3 fs-6">
                        {{ $article->category->name }}
                    </a>
                    @endif
                    
                    <h1 class="display-5 fw-bold">{{ $article->title }}</h1>
                    
                    <div class="d-flex align-items-center text-muted mb-4">
                        <div class="me-3">
                            <i class="far fa-calendar-alt me-1"></i> {{ $article->published_at->format('F d, Y') }}
                        </div>
                        
                        @if($article->author)
                        <div class="me-3">
                            <i class="far fa-user me-1"></i> {{ $article->author->name }}
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Featured Image -->
                @if($article->featured_image)
                <div class="mb-4 img-hover-zoom">
                    <img src="{{ asset('images/' . $article->featured_image) }}" alt="{{ $article->title }}" class="img-fluid rounded shadow">
                    @if($article->image_caption)
                    <figcaption class="figure-caption text-center mt-2">{{ $article->image_caption }}</figcaption>
                    @endif
                </div>
                @endif
                
                <!-- Article Content -->
                <div class="article-content mb-5">
                    {!! $article->content !!}
                </div>
                
                <!-- Tags -->
                @if(isset($article->meta_data['tags']) && count($article->meta_data['tags']) > 0)
                <div class="mb-4">
                    <h5 class="mb-3">{{ __('Tags') }}</h5>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($article->meta_data['tags'] as $tag)
                        <span class="badge bg-light text-dark p-2">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Social Share -->
                <div class="mb-5">
                    <h5 class="mb-3">{{ __('Share This Article') }}</h5>
                    <div class="d-flex">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="social-share-btn bg-primary">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" class="social-share-btn bg-info">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . url()->current()) }}" target="_blank" class="social-share-btn bg-success">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="mailto:?subject={{ urlencode($article->title) }}&body={{ urlencode(url()->current()) }}" class="social-share-btn bg-secondary">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4 section-transition">
            <!-- Related Articles -->
            <div class="card border-0 shadow-sm mb-4 animate-fade-in-right">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0">{{ __('Related Articles') }}</h5>
                </div>
                <div class="card-body p-0">
                    @if($relatedNews && $relatedNews->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($relatedNews as $related)
                        <a href="{{ route('opportunities.circular-economy.news.show', $related->slug) }}" class="list-group-item list-group-item-action border-0 p-3">
                            <div class="d-flex">
                                @if($related->featured_image)
                                <div class="flex-shrink-0 me-3">
                                    <div class="img-hover-zoom">
                                        <img src="{{ asset('images/' . $related->featured_image) }}" alt="{{ $related->title }}" 
                                             class="rounded" style="width: 70px; height: 70px; object-fit: cover;">
                                    </div>
                                </div>
                                @endif
                                <div>
                                    <h6 class="mb-1 related-title">{{ $related->title }}</h6>
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i> {{ $related->published_at->format('M d, Y') }}
                                    </small>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <div class="p-4 text-center">
                        <p class="mb-0 text-muted">{{ __('No related articles found.') }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Categories -->
            <div class="card border-0 shadow-sm mb-4 animate-fade-in-right delay-100">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0">{{ __('Categories') }}</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach(\App\Models\Opportunities\CircularEconomy\Category::has('news')->get() as $category)
                        <a href="{{ route('opportunities.circular-economy.news.category', $category->slug) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 ps-0">
                            {{ $category->name }}
                            <span class="badge bg-success rounded-pill">{{ $category->news_count ?? $category->news()->count() }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Newsletter Signup -->
            <div class="card border-0 bg-light shadow-sm animate-fade-in-right delay-200">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-3">{{ __('Stay Updated') }}</h5>
                    <p class="card-text mb-3">{{ __('Subscribe to receive the latest news about waste management in Micheweni.') }}</p>
                    <form action="{{ route('opportunities.circular-economy.newsletter.subscribe') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="{{ __('Your email address') }}" required>
                            <button class="btn btn-success btn-hover-effect" type="submit">{{ __('Subscribe') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .img-hover-zoom {
        overflow: hidden;
    }
    
    .img-hover-zoom img {
        transition: transform 0.3s ease;
    }
    
    a:hover .img-hover-zoom img {
        transform: scale(1.05);
    }
    
    .related-title {
        transition: color 0.3s ease;
    }
    
    a:hover .related-title {
        color: #198754;
    }
    
    .btn-hover-effect {
        transition: all 0.3s ease;
    }
    
    .btn-hover-effect:hover {
        transform: translateY(-3px);
    }
</style>
@endsection

@section('scripts')
<script src="{{ asset('js/custom-animations.js') }}"></script>
@endsection 