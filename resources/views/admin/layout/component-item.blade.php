<div class="component-item" data-id="{{ $content->id }}" data-component-type="{{ $content->type }}" data-template="{{ $content->template_identifier }}">
    <div class="card component-card mb-2">
        <div class="card-header d-flex justify-content-between align-items-center py-2 bg-light">
            <div class="d-flex align-items-center">
                @php
                    $typeIcons = [
                        'text' => 'fa-paragraph',
                        'image' => 'fa-image',
                        'card' => 'fa-th-large',
                        'button' => 'fa-link',
                        'form' => 'fa-wpforms',
                        'video' => 'fa-video',
                        'divider' => 'fa-minus',
                        'chart' => 'fa-chart-bar',
                        'map' => 'fa-map-marker-alt',
                    ];
                    $icon = $typeIcons[$content->type] ?? 'fa-cube';
                @endphp
                <i class="fas {{ $icon }} me-2 text-primary"></i>
                <span class="fw-bold">{{ $content->title }}</span>
                <span class="badge bg-secondary ms-2">{{ ucfirst($content->type) }}</span>
                @if($content->template_identifier)
                    <span class="badge bg-info ms-2" title="Template">{{ $content->template_identifier }}</span>
                @endif
            </div>
            <div class="component-actions">
                <button type="button" class="btn btn-sm btn-outline-secondary edit-component" title="Edit Component" data-id="{{ $content->id }}">
                    <i class="fas fa-pen"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger delete-component" title="Delete Component" data-id="{{ $content->id }}">
                    <i class="fas fa-trash"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-dark move-component" title="Move Component">
                    <i class="fas fa-grip-vertical"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-2">
            <div class="component-preview">
                @if($content->type == 'text')
                    <div class="text-preview">
                        {!! Str::limit(strip_tags($content->value), 100) !!}
                    </div>
                @elseif($content->type == 'card')
                    <div class="card-preview d-flex align-items-center">
                        @if(isset($content->meta->image))
                            <img src="{{ asset('images/' . $content->meta->image) }}" class="img-thumbnail me-2" style="max-width: 50px; max-height: 50px;" alt="Card image">
                        @else
                            <div class="placeholder-image me-2 bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-image text-secondary"></i>
                            </div>
                        @endif
                        <div class="card-info">
                            <strong>{{ $content->meta->title ?? 'Card Title' }}</strong><br>
                            <small>{{ Str::limit($content->meta->subtitle ?? 'Subtitle', 30) }}</small>
                        </div>
                    </div>
                @elseif($content->type == 'image')
                    <div class="image-preview text-center">
                        @if(isset($content->meta->image))
                            <img src="{{ asset('images/' . $content->meta->image) }}" class="img-thumbnail" style="max-height: 80px;" alt="Image preview">
                        @else
                            <div class="placeholder-image bg-light d-flex align-items-center justify-content-center" style="height: 80px;">
                                <i class="fas fa-image fa-2x text-secondary"></i>
                            </div>
                        @endif
                    </div>
                @elseif($content->type == 'button')
                    <div class="button-preview text-center">
                        <button class="btn btn-{{ $content->meta->button_style ?? 'primary' }} btn-sm" disabled>
                            {{ $content->meta->button_text ?? 'Button' }}
                        </button>
                    </div>
                @elseif($content->type == 'form')
                    <div class="form-preview">
                        <i class="fas fa-wpforms text-primary me-2"></i>
                        {{ $content->meta->title ?? 'Form' }}
                    </div>
                @elseif($content->type == 'video')
                    <div class="video-preview d-flex align-items-center">
                        <i class="fas fa-video text-primary me-2"></i>
                        {{ $content->meta->video_url ?? 'Video' }}
                    </div>
                @elseif($content->type == 'divider')
                    <div class="divider-preview">
                        <hr style="border-top: {{ $content->meta->thickness ?? '1px' }} {{ $content->meta->style ?? 'solid' }} {{ $content->meta->color ?? '#dee2e6' }};">
                    </div>
                @elseif($content->type == 'chart')
                    <div class="chart-preview text-center">
                        <i class="fas fa-chart-{{ $content->meta->chart_type ?? 'bar' }} fa-2x text-primary"></i>
                        <div>{{ $content->meta->title ?? 'Chart' }}</div>
                    </div>
                @else
                    <div class="default-preview text-muted">
                        {{ ucfirst($content->type) }} component
                    </div>
                @endif
            </div>
        </div>
    </div>
</div> 