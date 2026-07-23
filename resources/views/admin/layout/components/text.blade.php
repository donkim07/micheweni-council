<!-- Text Component -->
@php
    $content_text = $content->value ?? 'Text content goes here.';
    $template = $content->template ?? 'standard';
    $class = $content->meta->css_class ?? '';
    $text_alignment = $content->meta->text_alignment ?? 'left';
    $heading_type = $content->meta->heading_type ?? 'none';
    $heading_text = $content->meta->heading_text ?? '';
@endphp

<div class="text-component {{ $class }} text-{{ $text_alignment }}">
    @if($heading_type !== 'none' && $heading_text)
        @if($heading_type == 'h1')
            <h1>{{ $heading_text }}</h1>
        @elseif($heading_type == 'h2')
            <h2>{{ $heading_text }}</h2>
        @elseif($heading_type == 'h3')
            <h3>{{ $heading_text }}</h3>
        @elseif($heading_type == 'h4')
            <h4>{{ $heading_text }}</h4>
        @elseif($heading_type == 'h5')
            <h5>{{ $heading_text }}</h5>
        @elseif($heading_type == 'h6')
            <h6>{{ $heading_text }}</h6>
        @endif
    @endif
    
    <div class="text-content">
        {!! $content_text !!}
    </div>
</div> 