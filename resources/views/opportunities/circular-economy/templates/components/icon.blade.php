{{-- templates/components/icon.blade.php --}}
@php
    // Get icon data from content
    $meta = is_string($content->meta) ? json_decode($content->meta, true) : [];
    if (empty($meta) && is_object($content->meta)) {
        $meta = (array) $content->meta;
    }
    
    // Extract properties with proper fallbacks
    $icon = $meta['icon'] ?? 'circle';
    $size = $meta['size'] ?? 'fa-2x';
    $color = $meta['color'] ?? '#198754';  // Default to green
    $alignment = $meta['alignment'] ?? 'center';
    $link = $meta['link'] ?? '';
    $openInNewTab = $meta['open_in_new_tab'] ?? false;
    
    // Get template style
    $templateStyle = $content->template_identifier ?: 'standard';
    
    // Alignment class
    $alignClass = '';
    if ($alignment === 'left') {
        $alignClass = 'text-start';
    } else if ($alignment === 'center') {
        $alignClass = 'text-center';
    } else if ($alignment === 'right') {
        $alignClass = 'text-end';
    }
    
    // Additional classes based on template
    $iconClass = '';
    
    if ($templateStyle === 'circle') {
        $iconClass = 'icon-circle';
    } else if ($templateStyle === 'square') {
        $iconClass = 'icon-square';
    } else if ($templateStyle === 'outline') {
        $iconClass = 'icon-outline';
    }
@endphp

<div class="icon-component {{ $iconClass }} {{ $alignClass }}">
    @if($link)
        <a href="{{ $link }}" {{ $openInNewTab ? 'target="_blank" rel="noopener"' : '' }}>
    @endif
    
    <span class="icon-wrapper" style="color: {{ $color }};">
        <i class="fas fa-{{ $icon }} {{ $size }}"></i>
    </span>
    
    @if($link)
        </a>
    @endif
</div>

<style>
.icon-component {
    margin-bottom: 1rem;
}

.icon-wrapper {
    display: inline-block;
    transition: transform 0.3s ease;
}

.icon-wrapper:hover {
    transform: translateY(-5px);
}

.icon-circle .icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(25, 135, 84, 0.1);
    color: #198754;
}

.icon-square .icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(25, 135, 84, 0.1);
    color: #198754;
}

.icon-outline .icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid currentColor;
}
</style> 