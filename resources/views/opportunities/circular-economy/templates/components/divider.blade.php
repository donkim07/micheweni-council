{{-- templates/components/divider.blade.php --}}
@php
    // Get divider data from content
    $meta = is_string($content->meta) ? json_decode($content->meta, true) : [];
    if (empty($meta) && is_object($content->meta)) {
        $meta = (array) $content->meta;
    }
    
    // Extract properties with proper fallbacks
    $color = $meta['color'] ?? '#dee2e6';
    $height = $meta['height'] ?? '1px';
    $width = $meta['width'] ?? '100%';
    $margin = $meta['margin'] ?? '2rem 0';
    
    // Get template style
    $templateStyle = $content->template_identifier ?: 'solid';
    
    // Style properties based on template
    $dividerStyle = '';
    
    if ($templateStyle === 'solid') {
        $dividerStyle = "border-top: {$height} solid {$color}; margin: {$margin}; width: {$width};";
    } elseif ($templateStyle === 'dashed') {
        $dividerStyle = "border-top: {$height} dashed {$color}; margin: {$margin}; width: {$width};";
    } elseif ($templateStyle === 'spacer') {
        // For spacer, we don't need a visible line, just margin
        $spacerHeight = isset($meta['spacer_height']) ? $meta['spacer_height'] : '50px';
        $dividerStyle = "height: {$spacerHeight}; margin: 0; width: {$width};";
    }
@endphp

<div class="divider-component">
    @if($templateStyle === 'spacer')
        <div class="spacer" style="{{ $dividerStyle }}"></div>
    @else
        <hr class="divider {{ $templateStyle }}-divider" style="{{ $dividerStyle }}">
    @endif
</div> 