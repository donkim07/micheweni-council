{{-- templates/components/gallery.blade.php --}}
@php
    // Get gallery data from content
    $meta = is_string($content->meta) ? json_decode($content->meta, true) : [];
    if (empty($meta) && is_object($content->meta)) {
        $meta = (array) $content->meta;
    }
    
    // Extract properties with proper fallbacks
    $images = isset($meta['images']) && is_array($meta['images']) ? $meta['images'] : [];
    $columns = $meta['columns'] ?? 3;
    $spacing = $meta['spacing'] ?? 'medium';
    $imageHeight = $meta['image_height'] ?? '200px';
    $title = $meta['title'] ?? '';
    $showCaptions = $meta['show_captions'] ?? true;
    
    // Determine template style
    $templateStyle = $content->template_identifier ?: 'grid';
    
    // Get spacing class
    $spacingClass = '';
    if ($spacing === 'small') {
        $spacingClass = 'g-2';
    } elseif ($spacing === 'medium') {
        $spacingClass = 'g-3';
    } elseif ($spacing === 'large') {
        $spacingClass = 'g-4';
    }
    
    // Calculate column width based on number of columns
    $colClass = 'col-md-' . (12 / $columns);
    
    // For masonry layout
    $galleryId = 'gallery-' . md5(json_encode($meta) . time() . rand(1000, 9999));
@endphp

<div class="gallery-component {{ $templateStyle }}-gallery">
    @if($title)
        <h5 class="gallery-title mb-3">{{ $title }}</h5>
    @endif
    
    @if(empty($images))
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            {{ __('No images have been added to the gallery.') }}
        </div>
    @else
        @if($templateStyle === 'grid')
            <div class="row {{ $spacingClass }}">
                @foreach($images as $image)
                    <div class="{{ $colClass }} mb-3">
                        <div class="gallery-item">
                            <img src="{{ asset('images/' . $image['url']) }}" 
                                 alt="{{ $image['caption'] ?? '' }}" 
                                 class="img-fluid rounded"
                                 style="height: {{ $imageHeight }}; object-fit: cover; width: 100%;">
                            @if($showCaptions && isset($image['caption']) && $image['caption'])
                                <div class="gallery-caption text-center small text-muted mt-1">{{ $image['caption'] }}</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif($templateStyle === 'masonry')
            <div id="{{ $galleryId }}" class="masonry-gallery {{ $spacingClass }}">
                @foreach($images as $image)
                    <div class="masonry-item">
                        <img src="{{ asset('images/' . $image['url']) }}" 
                             alt="{{ $image['caption'] ?? '' }}" 
                             class="img-fluid rounded shadow-sm">
                        @if($showCaptions && isset($image['caption']) && $image['caption'])
                            <div class="gallery-caption text-center small text-muted mt-1">{{ $image['caption'] }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @elseif($templateStyle === 'carousel')
            <div id="{{ $galleryId }}" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner rounded">
                    @foreach($images as $index => $image)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ asset('images/' . $image['url']) }}" 
                                 class="d-block w-100" 
                                 alt="{{ $image['caption'] ?? '' }}"
                                 style="height: {{ $imageHeight }}; object-fit: cover;">
                            @if($showCaptions && isset($image['caption']) && $image['caption'])
                                <div class="carousel-caption d-none d-md-block">
                                    <p class="bg-dark bg-opacity-50 p-1 rounded mb-0">{{ $image['caption'] }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#{{ $galleryId }}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#{{ $galleryId }}" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        @endif
    @endif
</div>

<style>
.gallery-component {
    margin-bottom: 1rem;
}

.gallery-item {
    transition: transform 0.3s ease;
    overflow: hidden;
    position: relative;
}

.gallery-item img {
    transition: transform 0.5s ease;
}

.gallery-item:hover img {
    transform: scale(1.05);
}

.masonry-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    grid-gap: 15px;
}

.masonry-item {
    margin-bottom: 15px;
    break-inside: avoid;
}

.carousel .carousel-item img {
    transition: transform 1.5s ease;
}

.carousel-caption {
    left: 0;
    right: 0;
    bottom: 0;
}
</style>

@if($templateStyle === 'masonry')
    @push('scripts')
    <script>
        // Add masonry layout initialization if needed
    </script>
    @endpush
@endif 