{{-- templates/components/card-horizontal.blade.php --}}
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
    $buttonStyle = $meta['button_style'] ?? 'primary';
    $openInNewTab = $meta['open_in_new_tab'] ?? false;
    $image = $meta['image'] ?? null;
    $imagePosition = $meta['image_position'] ?? 'left';
    $imageWidth = $meta['image_width'] ?? '4'; // Bootstrap column width
    $contentWidth = 12 - (int)$imageWidth;
    
    // Card style settings
    $cardStyle = $meta['card_style'] ?? 'default'; // default, minimal, bordered
    $cardClasses = 'card-horizontal h-100 ';
    
    if ($cardStyle === 'minimal') {
        $cardClasses .= 'border-0 shadow-sm ';
    } elseif ($cardStyle === 'bordered') {
        $cardClasses .= 'border-primary border-2 ';
    } else {
        $cardClasses .= 'shadow ';
    }
@endphp

<div class="{{ $cardClasses }}">
    <div class="row g-0">
        @if($image && $imagePosition === 'left')
            <div class="col-md-{{ $imageWidth }} img-hover-zoom">
                <img src="{{ asset('images/' . $image) }}" class="horizontal-card-img" alt="{{ $title }}">
            </div>
        @endif
        
        <div class="col-md-{{ $contentWidth }} d-flex flex-column">
            <div class="card-body p-4">
                @if($title)
                    <h5 class="card-title fw-bold mb-2">{{ $title }}</h5>
                @endif
                
                @if($subtitle)
                    <h6 class="card-subtitle mb-3 text-muted">{{ $subtitle }}</h6>
                @endif
                
                <div class="card-text mb-3">
                    {!! $contentText !!}
                </div>
                
                @if($buttonText)
                    <div class="mt-auto pt-3">
                        <a href="{{ $buttonUrl }}" class="btn btn-{{ $buttonStyle }} btn-hover-effect" 
                           {{ $openInNewTab ? 'target="_blank" rel="noopener"' : '' }}>
                            {{ $buttonText }}
                        </a>
                    </div>
                @endif
            </div>
            
            @if($footer)
                <div class="card-footer bg-light border-top-0 p-3">
                    {{ $footer }}
                </div>
            @endif
        </div>
        
        @if($image && $imagePosition === 'right')
            <div class="col-md-{{ $imageWidth }} img-hover-zoom">
                <img src="{{ asset('images/' . $image) }}" class="horizontal-card-img" alt="{{ $title }}">
            </div>
        @endif
    </div>
</div>

<style>
    .card-horizontal {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .card-horizontal:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .card-horizontal .card-title {
        position: relative;
        display: inline-block;
    }
    
    .card-horizontal .card-title:after {
        content: '';
        position: absolute;
        width: 30px;
        height: 2px;
        background: var(--primary-color, #198754);
        bottom: -8px;
        left: 0;
        transition: width 0.3s ease;
    }
    
    .card-horizontal:hover .card-title:after {
        width: 100%;
    }
    
    .card-horizontal .horizontal-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .card-horizontal .img-hover-zoom {
        overflow: hidden;
    }
    
    .card-horizontal .img-hover-zoom img {
        transition: transform 0.5s ease;
    }
    
    .card-horizontal:hover .img-hover-zoom img {
        transform: scale(1.05);
    }
    
    .card-horizontal .btn-hover-effect {
        transition: transform 0.3s ease;
    }
    
    .card-horizontal:hover .btn-hover-effect {
        transform: translateX(5px);
    }
    
    @media (max-width: 767.98px) {
        .horizontal-card-img {
            height: 250px;
        }
    }
</style> 