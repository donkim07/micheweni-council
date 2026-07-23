{{-- templates/components/card-overlay.blade.php --}}
@php
    // Get card data from content
    $meta = is_string($content->meta) ? json_decode($content->meta, true) : [];
    if (empty($meta) && is_object($content->meta)) {
        $meta = (array) $content->meta;
    }
    
    // Extract properties with proper fallbacks
    $title = $meta['title'] ?? $content->title ?? 'Card Title';
    $subtitle = $meta['subtitle'] ?? '';
    $contentText = $content->value ?? '<p>Card content</p>';
    $footer = $meta['footer_text'] ?? '';
    $buttonText = $meta['button_text'] ?? '';
    $buttonUrl = $meta['button_url'] ?? '#';
    $buttonStyle = $meta['button_style'] ?? 'light';
    $openInNewTab = $meta['open_in_new_tab'] ?? false;
    $image = $meta['image'] ?? null;
    $overlayOpacity = $meta['overlay_opacity'] ?? 0.7;
    $textColor = $meta['text_color'] ?? 'white';
    $overlayColor = $meta['overlay_color'] ?? 'dark';
    $alignText = $meta['align_text'] ?? 'center';
    
    // Generate style for overlay based on opacity and color
    $overlayStyle = '';
    if ($overlayColor == 'dark') {
        $overlayStyle = "rgba(0,0,0,{$overlayOpacity})";
    } elseif ($overlayColor == 'primary') {
        $overlayStyle = "rgba(25,135,84,{$overlayOpacity})";
    } else {
        $overlayStyle = "rgba(52,152,219,{$overlayOpacity})";
    }
@endphp

<div class="card-overlay-component card h-100">
    <div class="card-overlay-wrapper position-relative h-100">
        @if($image)
            <img src="{{ asset('images/' . $image) }}" class="card-img h-100" alt="{{ $title }}">
            <div class="card-img-overlay d-flex flex-column justify-content-center text-{{ $alignText }}" style="background-color: {{ $overlayStyle }};">
                <div class="overlay-content">
                    @if($title)
                        <h5 class="card-title fw-bold text-{{ $textColor }} mb-3">{{ $title }}</h5>
                    @endif
                    
                    @if($subtitle)
                        <h6 class="card-subtitle mb-3 text-{{ $textColor }}-50">{{ $subtitle }}</h6>
                    @endif
                    
                    <div class="card-text text-{{ $textColor }} mb-4">
                        {!! $contentText !!}
                    </div>
                    
                    @if($buttonText)
                        <div class="mt-auto">
                            <a href="{{ $buttonUrl }}" class="btn btn-{{ $buttonStyle }} btn-zoom-effect px-4" 
                               {{ $openInNewTab ? 'target="_blank" rel="noopener"' : '' }}>
                                {{ $buttonText }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="card-body text-center py-5">
                <div class="text-muted">
                    <i class="fas fa-image fa-4x mb-3"></i>
                    <p>{{ __('Image not available') }}</p>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .card-overlay-component {
        border: none;
        border-radius: 0.5rem;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .card-overlay-component:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .card-overlay-component .card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .card-overlay-component .card-img-overlay {
        transition: background-color 0.3s ease;
        padding: 2rem;
    }
    
    .card-overlay-component:hover .card-img-overlay {
        background-color: rgba(0,0,0,0.8) !important;
    }
    
    .card-overlay-component .overlay-content {
        transform: translateY(10px);
        transition: transform 0.3s ease;
        opacity: 0.9;
    }
    
    .card-overlay-component:hover .overlay-content {
        transform: translateY(0);
        opacity: 1;
    }
    
    .card-overlay-component .btn-zoom-effect {
        transition: transform 0.3s ease;
    }
    
    .card-overlay-component:hover .btn-zoom-effect {
        transform: scale(1.05);
    }
</style> 