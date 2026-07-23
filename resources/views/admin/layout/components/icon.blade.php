<!-- Icon Component -->
@php
    $icon_name = $content->meta->icon_name ?? 'star';
    $icon_style = $content->meta->icon_style ?? 'fas'; // fas, far, fab
    $icon_size = $content->meta->icon_size ?? '3x';
    $icon_color = $content->meta->icon_color ?? '#007bff';
    $icon_alignment = $content->meta->icon_alignment ?? 'center';
    $template = $content->template ?? 'standard';
    $class = $content->meta->css_class ?? '';
    $caption = $content->meta->caption ?? '';
@endphp

<div class="icon-component text-{{ $icon_alignment }} {{ $class }}">
    <div class="icon-wrapper">
        <i class="{{ $icon_style }} fa-{{ $icon_name }} fa-{{ $icon_size }}" style="color: {{ $icon_color }};"></i>
    </div>
    
    @if($caption)
        <div class="icon-caption mt-2">
            {{ $caption }}
        </div>
    @endif
</div> 