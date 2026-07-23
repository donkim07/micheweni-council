{{-- templates/components/text.blade.php --}}
@php
    // Get text data from content
    $meta = is_string($content->meta) ? json_decode($content->meta, true) : [];
    if (empty($meta) && is_object($content->meta)) {
        $meta = (array) $content->meta;
    }
    
    // Get the text content
    $textContent = $content->value ?? '';
    
    // Get template style
    $templateStyle = $content->template_identifier ?: 'standard-text';
    
    // Additional CSS classes based on the template
    $textClass = '';
    
    if ($templateStyle === 'featured-text') {
        $textClass = 'featured-text';
    } else if ($templateStyle === 'callout-text') {
        $textClass = 'callout-text';
    } else if ($templateStyle === 'quote-text') {
        $textClass = 'quote-text';
    }
@endphp

<div class="text-component {{ $textClass }}">
    @if($templateStyle === 'quote-text')
        <blockquote class="blockquote">
            {!! $textContent !!}
            @if(isset($meta['citation']) && !empty($meta['citation']))
                <footer class="blockquote-footer mt-2">{{ $meta['citation'] }}</footer>
            @endif
        </blockquote>
    @elseif($templateStyle === 'callout-text')
        <div class="callout p-4 border-start border-4 bg-light">
            {!! $textContent !!}
        </div>
    @elseif($templateStyle === 'featured-text')
        <div class="featured-content">
            {!! $textContent !!}
        </div>
    @else
        {!! $textContent !!}
    @endif
</div>

<style>
.text-component {
    overflow-wrap: break-word;
}

.featured-text {
    position: relative;
    padding: 0.5rem 0;
}

.featured-text h2, .featured-text h3, .featured-text h4 {
    color: #198754;
    position: relative;
    display: inline-block;
    margin-bottom: 1rem;
}

.featured-text h2::after, .featured-text h3::after, .featured-text h4::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -5px;
    width: 50px;
    height: 3px;
    background-color: #198754;
}

.callout-text {
    border-left-color: #198754 !important;
}

.quote-text .blockquote {
    font-size: 1.1rem;
    font-style: italic;
    position: relative;
    padding: 1.5rem 2rem;
}

.quote-text .blockquote:before {
    content: '\201C';
    position: absolute;
    top: -10px;
    left: 0;
    font-size: 4rem;
    font-family: Georgia, serif;
    color: rgba(25, 135, 84, 0.3);
    line-height: 1;
}

.quote-text .blockquote:after {
    content: '\201D';
    position: absolute;
    bottom: -30px;
    right: 0;
    font-size: 4rem;
    font-family: Georgia, serif;
    color: rgba(25, 135, 84, 0.3);
    line-height: 1;
}
</style> 