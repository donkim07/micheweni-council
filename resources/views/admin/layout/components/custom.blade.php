<!-- Custom HTML Component -->
@php
    $customHtml = $content->value ?? '';
    $template = $content->template ?? 'standard';
    $class = $content->meta->css_class ?? '';
@endphp

<div class="custom-html-component {{ $class }} {{ $template }}-template">
    {!! $customHtml !!}
</div> 