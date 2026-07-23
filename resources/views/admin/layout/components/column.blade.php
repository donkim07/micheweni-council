@php
    $column_width = $content->column_width ?? 12;
    $class = $content->meta->css_class ?? '';
    $content_html = $content->value ?? '';
@endphp

<div class="component-column col-md-{{ $column_width }} {{ $class }}">
    @if(!empty($content_html))
        {!! $content_html !!}
    @else
        <div class="placeholder-content p-3 text-center bg-light">
            <i class="fas fa-columns"></i>
            <p class="mb-0 small">Column content</p>
        </div>
    @endif
</div> 