{{-- resources/views/admin/layout/components/image.blade.php --}}
@php
    // Check if we're in preview mode
    $isPreview = $isPreview ?? false;
    
    // Get template data
    $templateData = $templateData ?? [];
    $settings = $templateData['settings'] ?? [];
    $template = $templateData['template'] ?? null;
    
    // Get image data
    $image = isset($content->meta->image) ? $content->meta->image : null;
    $alt = $content->meta->alt_text ?? '';
    $caption = $content->meta->caption ?? '';
    $alignment = $content->meta->alignment ?? 'center';
    $link = $content->meta->link ?? '';
    $openInNewTab = $content->meta->open_in_new_tab ?? false;
    
    // Get template style
    $templateStyle = $content->template_identifier ?: 'standard-image';
    
    // CSS class based on alignment
    $alignmentClass = '';
    if ($alignment === 'left') {
        $alignmentClass = 'float-start me-3 mb-3';
    } elseif ($alignment === 'right') {
        $alignmentClass = 'float-end ms-3 mb-3';
    } elseif ($alignment === 'center') {
        $alignmentClass = 'mx-auto d-block';
    }
    
    // CSS class for rounded image
    $roundedClass = ($templateStyle === 'rounded-image') ? 'rounded-circle' : '';
    
    // CSS class for captioned image
    $captionedClass = ($templateStyle === 'captioned-image') ? 'figure-img' : '';
    
    // CSS classes for featured image
    $featuredClass = ($templateStyle === 'featured-image') ? 'img-thumbnail shadow-lg border-primary' : '';
    
    // Handle missing image in preview mode
    $showImagePlaceholder = $isPreview && !$image;
@endphp

<div class="image-component {{ $templateStyle }}">
    @if($templateStyle === 'captioned-image')
        <figure class="figure {{ $alignment === 'center' ? 'd-flex justify-content-center flex-column align-items-center w-100' : '' }}">
            @if($link)
                <a href="{{ $link }}" {{ $openInNewTab ? 'target="_blank" rel="noopener"' : '' }}>
            @endif
            
            @if($image)
                <img src="{{ asset('images/' . $image) }}" 
                     alt="{{ $alt }}" 
                     class="img-fluid {{ $alignmentClass }} {{ $captionedClass }} {{ $roundedClass }} {{ $featuredClass }}"
                     {{ isset($content->meta->max_width) ? 'style=max-width:' . $content->meta->max_width : '' }}>
            @elseif($showImagePlaceholder)
                <div class="image-placeholder bg-light d-flex align-items-center justify-content-center" 
                     style="height: 200px; width: 100%; border: 1px dashed #ccc;">
                    <i class="fas fa-image fa-3x text-secondary"></i>
                </div>
            @endif
            
            @if($link)
                </a>
            @endif
            
            @if($caption)
                <figcaption class="figure-caption text-center mt-2">{{ $caption }}</figcaption>
            @endif
        </figure>
    @else
        @if($link)
            <a href="{{ $link }}" {{ $openInNewTab ? 'target="_blank" rel="noopener"' : '' }} class="{{ $alignment === 'center' ? 'd-flex justify-content-center' : '' }}">
        @endif
        
        @if($image)
            <img src="{{ asset('images/' . $image) }}" 
                 alt="{{ $alt }}" 
                 class="img-fluid {{ $alignmentClass }} {{ $roundedClass }} {{ $featuredClass }}"
                 {{ isset($content->meta->max_width) ? 'style=max-width:' . $content->meta->max_width : '' }}>
        @elseif($showImagePlaceholder)
            <div class="image-placeholder bg-light d-flex align-items-center justify-content-center {{ $alignmentClass }}" 
                 style="height: 200px; min-width: 50%; border: 1px dashed #ccc;">
                <i class="fas fa-image fa-3x text-secondary"></i>
            </div>
        @endif
        
        @if($link)
            </a>
        @endif
        
        @if($caption && $templateStyle !== 'captioned-image')
            <div class="image-caption text-muted small text-center mt-2">{{ $caption }}</div>
        @endif
    @endif
</div>

<style>
/* Image component styles */
.image-component img {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.featured-image img {
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    border: 5px solid white;
    transition: all 0.5s ease;
}

.featured-image img:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
}

.rounded-image img {
    object-fit: cover;
}

.captioned-image figcaption {
    font-style: italic;
    opacity: 0.8;
}

/* Ensure images in preview mode have reasonable sizes */
.image-placeholder {
    max-width: 100%;
}
</style> 