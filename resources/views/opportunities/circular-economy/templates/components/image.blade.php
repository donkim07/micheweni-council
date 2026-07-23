{{-- templates/components/image.blade.php --}}
@php
    // Get image data from content
    $meta = is_string($content->meta) ? json_decode($content->meta, true) : [];
    if (empty($meta) && is_object($content->meta)) {
        $meta = (array) $content->meta;
    }
    
    // Extract properties with defaults
    $image = $meta['image'] ?? null;
    $caption = $meta['caption'] ?? '';
    $altText = $meta['alt_text'] ?? $caption ?? 'Image';
    $alignment = $meta['alignment'] ?? 'center';
    $size = $meta['size'] ?? 'medium';
    $shape = $meta['shape'] ?? 'standard';
    $link = $meta['link'] ?? '';
    $linkTarget = $meta['link_target'] ?? '_self';
    $effectStyle = $meta['effect'] ?? 'none';
    $border = $meta['border'] ?? false;
    $shadow = $meta['shadow'] ?? true;
    
    // Generate CSS classes based on settings
    $alignmentClass = match($alignment) {
        'left' => 'text-start',
        'right' => 'text-end',
        'center' => 'text-center',
        default => 'text-center'
    };
    
    $sizeClass = match($size) {
        'small' => 'w-50',
        'medium' => 'w-75',
        'large' => 'w-100',
        default => 'w-75'
    };
    
    $borderRadius = match($shape) {
        'rounded' => 'rounded',
        'circle' => 'rounded-circle',
        'standard' => '',
        default => ''
    };
    
    $shadowClass = $shadow ? 'shadow' : '';
    $borderClass = $border ? 'border' : '';
    
    $effectClass = match($effectStyle) {
        'zoom' => 'img-zoom-effect',
        'fade' => 'img-fade-effect',
        'blur' => 'img-blur-effect',
        'grayscale' => 'img-grayscale-effect',
        default => ''
    };
@endphp

<div class="image-component {{ $alignmentClass }} mb-4">
    <figure class="figure {{ $sizeClass }} mb-0 mx-auto">
        <div class="img-container {{ $effectClass }}">
            @if($image)
                @if($link)
                    <a href="{{ $link }}" target="{{ $linkTarget }}">
                        <img src="{{ asset('images/' . $image) }}" 
                             class="figure-img img-fluid {{ $borderRadius }} {{ $shadowClass }} {{ $borderClass }}" 
                             alt="{{ $altText }}">
                    </a>
                @else
                    <img src="{{ asset('images/' . $image) }}" 
                         class="figure-img img-fluid {{ $borderRadius }} {{ $shadowClass }} {{ $borderClass }}" 
                         alt="{{ $altText }}">
                @endif
            @else
                <div class="image-placeholder p-5 text-center bg-light {{ $borderRadius }} {{ $shadowClass }} {{ $borderClass }}">
                    <i class="fas fa-image fa-4x text-secondary mb-3"></i>
                    <p class="text-muted">{{ __('Image not available') }}</p>
                </div>
            @endif
        </div>
        
        @if($caption)
            <figcaption class="figure-caption text-center mt-2">{{ $caption }}</figcaption>
        @endif
    </figure>
</div>

<style>
    .image-component .img-container {
        overflow: hidden;
        position: relative;
        display: block;
    }
    
    .image-component .figure-img {
        transition: all 0.3s ease;
        margin-bottom: 0;
    }
    
    .image-component .img-zoom-effect img {
        transition: transform 0.5s ease;
    }
    
    .image-component .img-zoom-effect:hover img {
        transform: scale(1.1);
    }
    
    .image-component .img-fade-effect img {
        transition: opacity 0.5s ease;
    }
    
    .image-component .img-fade-effect:hover img {
        opacity: 0.8;
    }
    
    .image-component .img-blur-effect img {
        transition: filter 0.5s ease;
    }
    
    .image-component .img-blur-effect:hover img {
        filter: blur(2px);
    }
    
    .image-component .img-grayscale-effect img {
        transition: filter 0.5s ease;
        filter: grayscale(0%);
    }
    
    .image-component .img-grayscale-effect:hover img {
        filter: grayscale(80%);
    }
    
    .image-component .image-placeholder {
        min-height: 250px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
</style> 