<!-- Button Component -->
@php
    // Get button settings from meta
    $text = $content->meta->button_text ?? 'Button';
    $url = $content->meta->button_url ?? '#';
    $style = $content->meta->button_style ?? 'primary';
    $size = $content->meta->button_size ?? '';
    $alignment = $content->meta->alignment ?? 'center';
    $icon = $content->meta->icon ?? '';
    $openInNewTab = $content->meta->open_in_new_tab ?? false;
    
    // Get template style (outline, link, etc)
    $templateStyle = $content->template_identifier;
    
    // Determine button style based on template
    if ($templateStyle === 'outline-button') {
        $buttonClass = "btn-outline-{$style}";
    } elseif ($templateStyle === 'link-button') {
        $buttonClass = 'btn-link';
    } else {
        $buttonClass = "btn-{$style}";
    }
    
    // Add size class if specified
    if ($size) {
        $buttonClass .= " btn-{$size}";
    }
    
    // Add shadow for "shadowed" template
    $shadow = ($templateStyle === 'shadowed-button') ? 'shadow-lg' : '';
    
    // Add rounded for "rounded" template
    $rounded = ($templateStyle === 'rounded-button') ? 'rounded-pill' : '';
    
    // Add animation for "animated" template
    $animated = ($templateStyle === 'animated-button') ? 'btn-animated' : '';
    
    // Set alignment styles
    $alignmentClass = '';
    if ($alignment === 'left') {
        $alignmentClass = 'text-start';
    } elseif ($alignment === 'right') {
        $alignmentClass = 'text-end';
    } elseif ($alignment === 'center') {
        $alignmentClass = 'text-center';
    }
@endphp

<div class="button-component {{ $alignmentClass }}">
    <a href="{{ $url }}" 
       class="btn {{ $buttonClass }} {{ $shadow }} {{ $rounded }} {{ $animated }}"
       {{ $openInNewTab ? 'target="_blank" rel="noopener"' : '' }}>
       
        @if($icon)
            <i class="fas fa-{{ $icon }} me-1"></i>
        @endif
        
        {{ $text }}
    </a>
</div>

@if($templateStyle === 'animated-button')
<style>
/* Animated button hover effect */
.btn-animated {
    position: relative;
    overflow: hidden;
    z-index: 1;
    transition: color 0.4s ease-in-out;
}

.btn-animated:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 0;
    background-color: rgba(255, 255, 255, 0.25);
    z-index: -1;
    transition: height 0.4s ease-in-out;
}

.btn-animated:hover:after {
    height: 100%;
}
</style>
@endif 