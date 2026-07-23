@php
    $isPreview = Request::is('*preview*') || isset($request) && $request->has('preview_mode');
    $templateIdentifier = $content->template_identifier ?? $content->template ?? 'standard';
    
    // Handle meta data properly
    $meta = [];
    if (isset($content->meta)) {
        if (is_string($content->meta)) {
            $meta = json_decode($content->meta, true) ?: [];
        } elseif (is_object($content->meta)) {
            $meta = (array) $content->meta;
        } elseif (is_array($content->meta)) {
            $meta = $content->meta;
        }
    }
    
    $class = $meta['css_class'] ?? '';
    $margin = $content->margin ?? '';
    $padding = $content->padding ?? '';
    
    // Generate inline style based on margin and padding
    $styleArray = [];
    if (!empty($margin)) {
        $styleArray[] = "margin: {$margin}";
    }
    if (!empty($padding)) {
        $styleArray[] = "padding: {$padding}";
    }
    $styleString = implode('; ', $styleArray);
    if (!empty($styleString)) {
        $styleString .= ';';
    }
@endphp

<div class="render-component {{ $class }}" style="{{ $styleString }}">
    {{-- Try to include the template by identifier first --}}
    @if(view()->exists('templates.components.' . ($content->template_identifier ?: $content->type)))
        @include('templates.components.' . ($content->template_identifier ?: $content->type), ['content' => $content])
    
    {{-- Try to include by type and template as fallback --}}
    @elseif(view()->exists('templates.components.' . $content->type))
        @include('templates.components.' . $content->type, ['content' => $content])
    
    {{-- Fallback to old component system --}}
    @elseif(view()->exists('admin.layout.components.' . $content->type))
        @include('admin.layout.components.' . $content->type, ['content' => $content, 'isPreview' => $isPreview])
    
    {{-- Error state for missing template --}}
    @else
        <div class="alert alert-warning">
            Component type "{{ $content->type }}" does not have a view template.
        </div>
    @endif
</div> 