<div class="component-container" data-id="{{ $content->id }}" data-type="{{ $content->type }}">
    <div class="component-handle">
        <span>{{ $content->title }} ({{ ucfirst($content->type) }})</span>
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-secondary component-settings" data-id="{{ $content->id }}">
                <i class="fas fa-cog"></i>
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger remove-component">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    <div class="component-preview">
        @if($content->type == 'text')
            <div class="p-2 text-truncate">{{ Str::limit(strip_tags($content->value), 100) }}</div>
        @elseif($content->type == 'image')
            <div class="text-center p-2">
                @if(isset($content->meta->image))
                    <img src="{{ asset('storage/'.$content->meta->image) }}" alt="{{ $content->title }}" style="max-height: 100px; max-width: 100%;">
                @else
                    <div class="text-muted"><i class="fas fa-image me-1"></i> {{ __('Image Component') }}</div>
                @endif
            </div>
        @elseif($content->type == 'form')
            <div class="p-2">{{ __('Form Component') }}</div>
        @else
            <div class="p-2">{{ ucfirst($content->type) }} {{ __('Component') }}</div>
        @endif
    </div>
</div> 