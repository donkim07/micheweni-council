{{-- templates/components/button.blade.php --}}
@php
    // Get button data from content
    $meta = is_string($content->meta) ? json_decode($content->meta, true) : [];
    if (empty($meta) && is_object($content->meta)) {
        $meta = (array) $content->meta;
    }
    
    // Extract properties with proper fallbacks
    $text = $meta['text'] ?? 'Button';
    $url = $meta['url'] ?? '#';
    $style = $meta['style'] ?? 'primary';
    $size = $meta['size'] ?? 'md';
    $icon = $meta['icon'] ?? '';
    $openInNewTab = $meta['open_in_new_tab'] ?? false;
    $alignment = $meta['alignment'] ?? 'center';
    $fullWidth = $meta['full_width'] ?? false;
    
    // Get template style
    $templateStyle = $content->template_identifier ?: 'standard-button';
    
    // Additional classes
    $buttonClasses = ['btn'];
    $buttonClasses[] = 'btn-' . $style;
    $buttonClasses[] = 'btn-' . $size;
    
    if ($templateStyle === 'outline-button') {
        $buttonClasses = ['btn', 'btn-outline-' . $style, 'btn-' . $size];
    } elseif ($templateStyle === 'rounded-button') {
        $buttonClasses[] = 'rounded-pill';
    }
    
    if ($fullWidth) {
        $buttonClasses[] = 'btn-block w-100';
    }
    
    // Alignment class for the container
    $alignmentClass = 'text-' . $alignment;
@endphp

<div class="button-component {{ $alignmentClass }} my-3">
    <a href="{{ $url }}" 
       class="{{ implode(' ', $buttonClasses) }} btn-hover-effect shadow-sm" 
       {{ $openInNewTab ? 'target="_blank" rel="noopener"' : '' }}>
        @if($icon)
            <i class="fas fa-{{ $icon }} me-2"></i>
        @endif
        {{ $text }}
    </a>
</div>

<style>
.button-component .btn {
    padding: 0.6rem 1.5rem;
    transition: all 0.3s ease;
    font-weight: 600;
    letter-spacing: 0.3px;
    border-radius: 8px;
    position: relative;
    overflow: hidden;
}

.button-component .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.15) !important;
}

.button-component .btn-primary {
    background: linear-gradient(135deg, #148f77, #3498db);
    border: none;
}

.button-component .btn-primary:hover {
    background: linear-gradient(135deg, #3498db, #148f77);
    box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
}

.button-component .btn-secondary {
    background: linear-gradient(135deg, #6c757d, #495057);
    border: none;
}

.button-component .btn-secondary:hover {
    background: linear-gradient(135deg, #495057, #6c757d);
}

.button-component .btn-success {
    background: linear-gradient(135deg, #27ae60, #2ecc71);
    border: none;
}

.button-component .btn-success:hover {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
    box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
}

.button-component .btn-danger {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    border: none;
}

.button-component .btn-danger:hover {
    background: linear-gradient(135deg, #c0392b, #e74c3c);
    box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
}

.button-component .btn-warning {
    background: linear-gradient(135deg, #f39c12, #f1c40f);
    border: none;
    color: #fff;
}

.button-component .btn-warning:hover {
    background: linear-gradient(135deg, #f1c40f, #f39c12);
    color: #fff;
}

.button-component .btn-info {
    background: linear-gradient(135deg, #3498db, #2980b9);
    border: none;
    color: #fff;
}

.button-component .btn-info:hover {
    background: linear-gradient(135deg, #2980b9, #3498db);
    color: #fff;
}

.button-component .btn-light {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border: none;
    color: #212529;
}

.button-component .btn-light:hover {
    background: linear-gradient(135deg, #e9ecef, #f8f9fa);
    color: #212529;
}

.button-component .btn-dark {
    background: linear-gradient(135deg, #343a40, #212529);
    border: none;
}

.button-component .btn-dark:hover {
    background: linear-gradient(135deg, #212529, #343a40);
}

.button-component .btn-outline-primary,
.button-component .btn-outline-secondary,
.button-component .btn-outline-success,
.button-component .btn-outline-danger,
.button-component .btn-outline-warning,
.button-component .btn-outline-info,
.button-component .btn-outline-light,
.button-component .btn-outline-dark {
    background: transparent;
    position: relative;
    z-index: 1;
    border-width: 2px;
    overflow: hidden;
}

.button-component .btn-outline-primary:hover,
.button-component .btn-outline-secondary:hover,
.button-component .btn-outline-success:hover,
.button-component .btn-outline-danger:hover,
.button-component .btn-outline-warning:hover,
.button-component .btn-outline-info:hover,
.button-component .btn-outline-light:hover,
.button-component .btn-outline-dark:hover {
    color: #fff;
}

.button-component .btn-hover-effect:hover {
    transform: translateY(-3px);
}

.button-component .btn-block {
    display: block;
    width: 100%;
}
</style>

@if($templateStyle === 'animated-button')
<style>
.button-component .btn {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.button-component .btn:after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.2);
    transition: all 0.4s ease;
    z-index: 1;
}

.button-component .btn:hover:after {
    left: 100%;
}

.button-component .btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
</style>
@endif 