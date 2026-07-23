@extends('admin.layouts.app')

@section('title', __('Project Images') . ' - ' . $project->title)

@section('styles')
<style>
    .image-card {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .image-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: all 0.3s ease;
    }
    
    .image-card:hover img {
        transform: scale(1.05);
    }
    
    .image-card .card-body {
        padding: 15px;
        background: #fff;
    }
    
    .image-card .card-actions {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        gap: 5px;
    }
    
    .image-card .card-actions .btn {
        background: rgba(255,255,255,0.9);
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        font-size: 14px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .sortable-ghost {
        opacity: 0.5;
        background: #f3f4f6;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('Project Images') }} - {{ $project->title }}</h5>
            <div>
                <a href="{{ route('admin.government.projects.edit', $project) }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> {{ __('Back to Project') }}
                </a>
                <a href="{{ route('admin.government.projects.images.create', $project) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> {{ __('Add Images') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            @if ($images->isEmpty())
                <div class="alert alert-info">
                    {{ __('No images found for this project. Add some images to showcase your project.') }}
                </div>
            @else
                <div class="row" id="sortable-images">
                    @foreach($images as $image)
                        <div class="col-md-4 col-sm-6" data-id="{{ $image->id }}">
                            <div class="image-card">
                                <img src="{{ asset('images/' . $image->image) }}" alt="{{ $image->caption ?? $project->title }}">
                                <div class="card-body">
                                    <h6 class="mb-1">{{ $image->caption ?? __('No Caption') }}</h6>
                                    <p class="text-muted mb-1 small">{{ __('Order') }}: {{ $image->order }}</p>
                                    @if($image->capture_date)
                                        <p class="text-muted mb-0 small">{{ __('Captured') }}: {{ $image->capture_date->format('M d, Y') }}</p>
                                    @endif
                                </div>
                                <div class="card-actions">
                                    <a href="{{ route('admin.government.projects.images.edit', [$project, $image]) }}" class="btn btn-light" title="{{ __('Edit') }}">
                                        <i class="fas fa-edit text-primary"></i>
                                    </a>
                                    <button type="button" class="btn btn-light delete-image" data-id="{{ $image->id }}" title="{{ __('Delete') }}">
                                        <i class="fas fa-trash text-danger"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">{{ __('Delete Image') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('Are you sure you want to delete this image? This action cannot be undone.') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    $(document).ready(function() {
        // Sortable functionality
        if ($('#sortable-images').length) {
            const sortable = new Sortable(document.getElementById('sortable-images'), {
                animation: 150,
                ghostClass: 'sortable-ghost',
                onEnd: function() {
                    // Get the new order
                    const imageIds = [];
                    $('#sortable-images > div').each(function() {
                        imageIds.push($(this).data('id'));
                    });
                    
                    // Send to server
                    $.ajax({
                        url: "{{ route('admin.government.projects.images.update-order', $project) }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            images: imageIds
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success("{{ __('Image order updated successfully.') }}");
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            }
                        },
                        error: function() {
                            toastr.error("{{ __('Error updating image order.') }}");
                        }
                    });
                }
            });
        }
        
        // Delete image
        $('.delete-image').on('click', function() {
            const imageId = $(this).data('id');
            $('#deleteForm').attr('action', "{{ route('admin.government.projects.images.destroy', [$project, 'image' => '']) }}/" + imageId);
            $('#deleteModal').modal('show');
        });
    });
</script>
@endsection 