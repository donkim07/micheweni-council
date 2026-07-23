{{-- templates/components/column.blade.php --}}
@php
    // Get column data from content
    $meta = is_string($content->meta) ? json_decode($content->meta, true) : [];
    if (empty($meta) && is_object($content->meta)) {
        $meta = (array) $content->meta;
    }
    
    // Extract properties with proper fallbacks
    $width = $meta['width'] ?? 12;
    $padding = $meta['padding'] ?? '1rem';
    $backgroundColor = $meta['background_color'] ?? 'transparent';
    $textColor = $meta['text_color'] ?? 'inherit';
    $borderRadius = $meta['border_radius'] ?? '0';
    $cssClass = $meta['css_class'] ?? '';
    
    // Generate inline style
    $style = "padding: {$padding}; background-color: {$backgroundColor}; color: {$textColor}; border-radius: {$borderRadius};";
    if (!empty($meta['border_color'])) {
        $style .= " border: 1px solid {$meta['border_color']};";
    }
@endphp

<div class="column-component col-md-{{ $width }} {{ $cssClass }}" style="{{ $style }}">
    @if(!empty($content->value))
        {!! $content->value !!}
    @elseif(!empty($meta['inner_content']))
        @foreach($meta['inner_content'] as $innerContent)
            @if(isset($innerContent->type))
                @include('templates.components.' . $innerContent->type, ['content' => $innerContent])
            @endif
        @endforeach
    @else
        <div class="p-3 border border-dashed text-center text-muted">
            <i class="fas fa-columns"></i> {{ __('Column Container') }}
        </div>
    @endif
</div> 