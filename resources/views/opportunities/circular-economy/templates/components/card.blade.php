{{-- templates/components/card.blade.php --}}
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
@endphp

<div class="content-card card h-100 shadow-sm border-light">
    @if($image)
        <img src="{{ asset('images/' . $image) }}" class="card-img-top" alt="{{ $title }}">
    @endif
    
    <div class="card-body p-4">
        @if($title)
            <h5 class="card-title mb-2 fw-bold">{{ $title }}</h5>
        @endif
        
        @if($subtitle)
            <h6 class="card-subtitle mb-3 text-muted">{{ $subtitle }}</h6>
        @endif
        
        <div class="card-text mb-3">
            {!! $contentText !!}
        </div>
        
        @if($buttonText)
            <div class="mt-auto pt-3">
                <a href="{{ $buttonUrl }}" class="btn btn-{{ $buttonStyle }} px-4" {{ $openInNewTab ? 'target="_blank" rel="noopener"' : '' }}>
                    {{ $buttonText }}
                </a>
            </div>
        @endif
    </div>
    
    @if($footer)
        <div class="card-footer bg-light p-3">
            {{ $footer }}
        </div>
    @endif
</div>

<style>
.content-card {
    transition: transform .3s ease, box-shadow .3s ease;
    border-radius: 0.5rem;
    overflow: hidden;
}

.content-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.content-card .card-title {
    color: #333;
}

.content-card .card-img-top {
    height: 200px;
    object-fit: cover;
}

.content-card .btn {
    border-radius: 0.25rem;
}
</style> 