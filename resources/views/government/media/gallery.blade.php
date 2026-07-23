@extends('government.layouts.app')

@section('title', __('Media Gallery'))

@section('styles')
<style>
    .page-hero {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8)), url('/images/government/media-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
    }
    
    .gallery-filters {
        /* position: sticky;
        top: 80px;
        z-index: 10; */
        background-color: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    
    .gallery-grid {
        column-count: 4;
        column-gap: 20px;
    }
    
    @media (max-width: 1200px) {
        .gallery-grid {
            column-count: 3;
        }
    }
    
    @media (max-width: 992px) {
        .gallery-grid {
            column-count: 2;
        }
    }
    
    @media (max-width: 576px) {
        .gallery-grid {
            column-count: 1;
        }
    }
    
    .gallery-item {
        position: relative;
        display: block;
        break-inside: avoid;
        margin-bottom: 20px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    
    .gallery-item:hover {
        transform: translateY(-5px);
    }
    
    .gallery-item img {
        width: 100%;
        display: block;
    }
    
    .gallery-caption {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.7));
        color: white;
        padding: 15px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .gallery-item:hover .gallery-caption {
        opacity: 1;
    }
    
    .gallery-title {
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .gallery-date {
        font-size: 0.85rem;
        opacity: 0.8;
    }
    
    /* Lightbox Overlay */
    .lightbox {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }
    
    .lightbox.active {
        opacity: 1;
        pointer-events: auto;
    }
    
    .lightbox-content {
        position: relative;
        max-width: 80%;
        max-height: 80vh;
    }
    
    .lightbox img {
        max-width: 100%;
        max-height: 80vh;
        border: 5px solid white;
        border-radius: 3px;
    }
    
    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 30px;
        color: white;
        cursor: pointer;
        z-index: 1001;
    }
    
    .lightbox-prev, .lightbox-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: white;
        font-size: 30px;
        background: rgba(0,0,0,0.5);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    
    .lightbox-prev {
        left: 20px;
    }
    
    .lightbox-next {
        right: 20px;
    }
    
    .lightbox-caption {
        position: absolute;
        bottom: -40px;
        left: 0;
        right: 0;
        color: white;
        text-align: center;
    }
</style>
@endsection

@section('content')
<!-- Page Hero -->
<div class="page-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ url('/government') }}" class="text-white">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Media Gallery</li>
                    </ol>
                </nav>
                
                <h1 class="display-4 fw-bold mb-3">Media Gallery</h1>
                <p class="lead mb-4">Explore the visual chronicle of our district's development, events, and community activities.</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <!-- Gallery Filters -->
    <div class="gallery-filters mb-4">
        <form action="{{ route('government.media.gallery') }}" method="GET" class="row g-3">
            @if(isset($categories) && $categories->count() > 0)
                <div class="col-md-4">
                    <label for="category" class="form-label">Filter by Category</label>
                    <select name="category" id="category" class="form-select" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
            
            @if(isset($albums) && $albums && $albums->count() > 0)
                <div class="col-md-4">
                    <label for="album" class="form-label">Filter by Album</label>
                    <select name="album" id="album" class="form-select" onchange="this.form.submit()">
                        <option value="">All Albums</option>
                        @foreach($albums as $album)
                            <option value="{{ $album->id }}" {{ request('album') == $album->id ? 'selected' : '' }}>
                                {{ $album->name }} ({{ $album->media_count }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
            
            <div class="col-md-4">
                <label for="search" class="form-label">Search</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="search" name="search" placeholder="Search images..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Gallery Display -->
    @if(count($media) > 0)
        <div class="gallery-grid" id="gallery">
            @foreach($media as $item)
                <div class="gallery-item" data-id="{{ $item->id }}">
                    <img src="{{ asset('images/' . $item->file_path) }}" alt="{{ $item->title }}" loading="lazy">
                    <div class="gallery-caption">
                        <h5 class="gallery-title">{{ $item->title }}</h5>
                        @if($item->created_at)
                            <div class="gallery-date">
                                <i class="far fa-calendar-alt me-1"></i> {{ $item->created_at->format('M d, Y') }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $media->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-images fa-5x text-muted"></i>
            </div>
            <h3>No images found</h3>
            <p class="text-muted">Try adjusting your search or filter criteria</p>
        </div>
    @endif
</div>

<!-- Lightbox -->
<div class="lightbox" id="lightbox">
    <span class="lightbox-close" id="lightbox-close">&times;</span>
    <div class="lightbox-content">
        <img src="" alt="Gallery Image" id="lightbox-img">
        <div class="lightbox-caption" id="lightbox-caption"></div>
    </div>
    <span class="lightbox-prev" id="lightbox-prev"><i class="fas fa-chevron-left"></i></span>
    <span class="lightbox-next" id="lightbox-next"><i class="fas fa-chevron-right"></i></span>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lightbox functionality
    const gallery = document.getElementById('gallery');
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxCaption = document.getElementById('lightbox-caption');
    const lightboxClose = document.getElementById('lightbox-close');
    const lightboxPrev = document.getElementById('lightbox-prev');
    const lightboxNext = document.getElementById('lightbox-next');
    
    let currentIndex = 0;
    const galleryItems = document.querySelectorAll('.gallery-item');
    
    if (gallery) {
        gallery.addEventListener('click', function(e) {
            const item = e.target.closest('.gallery-item');
            if (item) {
                e.preventDefault();
                
                // Find the index of the clicked item
                for (let i = 0; i < galleryItems.length; i++) {
                    if (galleryItems[i] === item) {
                        currentIndex = i;
                        break;
                    }
                }
                
                const img = item.querySelector('img');
                const caption = item.querySelector('.gallery-title');
                
                lightboxImg.src = img.src;
                lightboxCaption.textContent = caption ? caption.textContent : '';
                lightbox.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        });
    }
    
    // Close lightbox
    if (lightboxClose) {
        lightboxClose.addEventListener('click', function() {
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
    
    // Navigate to previous image
    if (lightboxPrev) {
        lightboxPrev.addEventListener('click', function() {
            currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
            const item = galleryItems[currentIndex];
            const img = item.querySelector('img');
            const caption = item.querySelector('.gallery-title');
            
            lightboxImg.src = img.src;
            lightboxCaption.textContent = caption ? caption.textContent : '';
        });
    }
    
    // Navigate to next image
    if (lightboxNext) {
        lightboxNext.addEventListener('click', function() {
            currentIndex = (currentIndex + 1) % galleryItems.length;
            const item = galleryItems[currentIndex];
            const img = item.querySelector('img');
            const caption = item.querySelector('.gallery-title');
            
            lightboxImg.src = img.src;
            lightboxCaption.textContent = caption ? caption.textContent : '';
        });
    }
    
    // Close lightbox on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && lightbox.classList.contains('active')) {
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        // Navigate with arrow keys
        if (lightbox.classList.contains('active')) {
            if (e.key === 'ArrowLeft') {
                lightboxPrev.click();
            } else if (e.key === 'ArrowRight') {
                lightboxNext.click();
            }
        }
    });
});
</script>
@endsection 