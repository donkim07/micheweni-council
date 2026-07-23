<!-- Gallery Component -->
@php
    $gallery_images = $content->meta->gallery_images ?? [];
    $gallery_layout = $content->meta->gallery_layout ?? 'grid';
    $gallery_columns = $content->meta->gallery_columns ?? 3;
    $gallery_captions = $content->meta->gallery_captions ?? true;
    $gallery_lightbox = $content->meta->gallery_lightbox ?? true;
    $template = $content->template ?? 'standard';
    $class = $content->meta->css_class ?? '';
    
    // Convert string to array if needed
    if (is_string($gallery_images) && !empty($gallery_images)) {
        $gallery_images = json_decode($gallery_images, true) ?: [];
    }
@endphp

<div class="gallery-component {{ $class }}" id="gallery-{{ $content->id }}">
    @if(!empty($gallery_images))
        @if($gallery_layout == 'grid')
            <div class="row g-3">
                @foreach($gallery_images as $index => $image)
                    <div class="col-md-{{ 12 / $gallery_columns }}">
                        <div class="gallery-item">
                            <a href="{{ asset('images/' . $image['path']) }}" 
                               class="{{ $gallery_lightbox ? 'gallery-lightbox' : '' }}" 
                               title="{{ $image['caption'] ?? '' }}" 
                               data-gallery="#gallery-{{ $content->id }}">
                                <img src="{{ asset('images/' . $image['path']) }}" 
                                     alt="{{ $image['alt'] ?? '' }}" 
                                     class="img-fluid">
                            </a>
                            
                            @if($gallery_captions && !empty($image['caption']))
                                <div class="gallery-caption mt-1">
                                    {{ $image['caption'] }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif($gallery_layout == 'masonry')
            <div class="masonry-grid">
                @foreach($gallery_images as $index => $image)
                    <div class="masonry-item">
                        <a href="{{ asset('images/' . $image['path']) }}" 
                           class="{{ $gallery_lightbox ? 'gallery-lightbox' : '' }}" 
                           title="{{ $image['caption'] ?? '' }}" 
                           data-gallery="#gallery-{{ $content->id }}">
                            <img src="{{ asset('images/' . $image['path']) }}" 
                                 alt="{{ $image['alt'] ?? '' }}" 
                                 class="img-fluid">
                        </a>
                        
                        @if($gallery_captions && !empty($image['caption']))
                            <div class="gallery-caption mt-1">
                                {{ $image['caption'] }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @elseif($gallery_layout == 'slider')
            <div id="carousel-{{ $content->id }}" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($gallery_images as $index => $image)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <img src="{{ asset('images/' . $image['path']) }}" 
                                 alt="{{ $image['alt'] ?? '' }}" 
                                 class="d-block w-100">
                            
                            @if($gallery_captions && !empty($image['caption']))
                                <div class="carousel-caption d-none d-md-block">
                                    <p>{{ $image['caption'] }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $content->id }}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $content->id }}" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        @endif
    @else
        <div class="alert alert-info">
            Please add images in the gallery settings.
        </div>
    @endif
</div>

@if($gallery_lightbox)
    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize lightbox for gallery
            $('.gallery-lightbox').on('click', function(e) {
                e.preventDefault();
                
                // Your lightbox logic here
                // This is just a placeholder - you would normally use a lightbox library
                const image = $(this).attr('href');
                const title = $(this).attr('title');
                
                // Example with Bootstrap modal (simplified)
                const modal = `
                    <div class="modal fade" id="lightbox-modal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-body p-0">
                                    <img src="${image}" alt="${title}" class="img-fluid">
                                </div>
                                ${title ? `<div class="modal-footer"><p class="m-0">${title}</p></div>` : ''}
                            </div>
                        </div>
                    </div>
                `;
                
                $('body').append(modal);
                $('#lightbox-modal').modal('show');
                
                $('#lightbox-modal').on('hidden.bs.modal', function() {
                    $(this).remove();
                });
            });
        });
    </script>
    @endpush
@endif 