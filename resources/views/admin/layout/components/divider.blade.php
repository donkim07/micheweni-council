<!-- Divider Component -->
@php
    $divider_style = $content->meta->divider_style ?? 'solid';
    $divider_width = $content->meta->divider_width ?? '100%';
    $divider_height = $content->meta->divider_height ?? '1px';
    $divider_color = $content->meta->divider_color ?? '#dee2e6';
    $divider_margin = $content->meta->divider_margin ?? '2rem 0';
    $template = $content->template ?? 'standard';
    $class = $content->meta->css_class ?? '';
@endphp

<div class="divider-component {{ $class }}">
    <hr style="
        border: none;
        border-top: {{ $divider_height }} {{ $divider_style }} {{ $divider_color }};
        width: {{ $divider_width }};
        margin: {{ $divider_margin }};
    ">
</div> 