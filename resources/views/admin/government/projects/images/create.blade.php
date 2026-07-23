@extends('admin.layouts.app')

@section('title', __('Add Project Images') . ' - ' . $project->title)

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" integrity="sha512-WvVX1YO12zmsvTpUQV8s7ZU98DnkaAokcciMZJfnNWyNzm7//QRV61t4aEr0WdIa4pe854QHLTV302vH92FSMw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .dropzone {
        border: 2px dashed #0087F7;
        border-radius: 5px;
        background: #f8fafc;
        min-height: 200px;
    }
    
    .dropzone .dz-message {
        font-weight: 400;
    }
    
    .dropzone .dz-preview .dz-image {
        border-radius: 8px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('Add Images to') }}: {{ $project->title }}</h5>
            <a href="{{ route('admin.government.projects.images.index', $project) }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> {{ __('Back to Project Images') }}
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.government.projects.images.store', $project) }}" method="POST" enctype="multipart/form-data" id="image-upload-form">
                @csrf
                
                <div class="mb-4">
                    <label for="caption" class="form-label">{{ __('Caption (applies to all uploaded images)') }}</label>
                    <input type="text" class="form-control @error('caption') is-invalid @enderror" id="caption" name="caption" value="{{ old('caption') }}">
                    @error('caption')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="capture_date" class="form-label">{{ __('Capture Date (applies to all uploaded images)') }}</label>
                    <input type="date" class="form-control @error('capture_date') is-invalid @enderror" id="capture_date" name="capture_date" value="{{ old('capture_date', now()->format('Y-m-d')) }}">
                    @error('capture_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="form-label">{{ __('Upload Images') }}</label>
                    <div class="dropzone" id="imageDropzone"></div>
                    <div class="text-muted mt-2">
                        <small>{{ __('Allowed file types: JPG, JPEG, PNG, GIF. Maximum size: 2MB per image.') }}</small>
                    </div>
                    @error('images')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                    @error('images.*')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary" id="submit-btn" disabled>
                        <i class="fas fa-save"></i> {{ __('Save Images') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js" integrity="sha512-oQq8uth41D+gIH/NJvSJvVB85MFk1eWpMK6glnkg6I7EdMqC1XVkW7RxLheXwmFdG03qScCM7gKS/Cx3FYt7Tg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    Dropzone.autoDiscover = false;
    
    $(document).ready(function() {
        const myDropzone = new Dropzone("#imageDropzone", {
            url: "{{ route('admin.government.projects.images.store', $project) }}",
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 5,
            maxFiles: 10,
            maxFilesize: 2, // MB
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            paramName: "images",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        myDropzone.on("addedfile", function() {
            $('#submit-btn').prop('disabled', false);
        });
        
        myDropzone.on("removedfile", function() {
            if (myDropzone.files.length === 0) {
                $('#submit-btn').prop('disabled', true);
            }
        });
        
        $('#image-upload-form').on('submit', function(e) {
            e.preventDefault();
            
            if (myDropzone.files.length) {
                // Append form fields to dropzone request
                myDropzone.on('sending', function(file, xhr, formData) {
                    formData.append('caption', $('#caption').val());
                    formData.append('capture_date', $('#capture_date').val());
                });
                
                myDropzone.processQueue();
            } else {
                toastr.error("{{ __('Please add at least one image.') }}");
            }
        });
        
        myDropzone.on("success", function() {
            window.location.href = "{{ route('admin.government.projects.images.index', $project) }}";
        });
    });
</script>
@endsection 