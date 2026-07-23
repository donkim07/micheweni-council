{{-- Default component fallback --}}
<div class="component default-component">
    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0">{{ $content->title ?? 'Component' }}</h5>
        </div>
        <div class="card-body">
            @if(isset($content->value) && !empty($content->value))
                {!! $content->value !!}
            @else
                <p class="text-muted">No content available</p>
            @endif
        </div>
        <div class="card-footer text-muted">
            <small>Component Type: {{ ucfirst($content->type) }}</small>
            @if($content->template_identifier)
                <small class="ms-2">Template: {{ $content->template_identifier }}</small>
            @endif
        </div>
    </div>
</div> 