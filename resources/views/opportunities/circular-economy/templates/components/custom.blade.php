{{-- templates/components/custom.blade.php --}}
@php
    // Get custom data from content
    $meta = [];
    
    // Handle different meta formats
    if (is_string($content->meta)) {
        $meta = json_decode($content->meta, true) ?: [];
    } elseif (is_object($content->meta)) {
        $meta = (array) $content->meta;
    } elseif (is_array($content->meta)) {
        $meta = $content->meta;
    }
    
    // Extract content - use value by default
    $htmlContent = $content->value ?? '';
    
    // Override with HTML from meta if available
    if(isset($meta['html']) && !empty($meta['html'])) {
        $htmlContent = $meta['html'];
    }
    
    // Get container class and ID if set
    $containerId = $meta['container_id'] ?? '';
    $containerClass = $meta['container_class'] ?? '';
@endphp

<div class="custom-component {{ $containerClass }}" {{ $containerId ? "id=\"{$containerId}\"" : '' }}>
    {!! $htmlContent !!}
</div> 