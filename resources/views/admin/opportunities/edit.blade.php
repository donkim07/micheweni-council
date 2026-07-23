@extends('layouts.admin')

@section('title', __('Edit Opportunity'))

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Edit Opportunity') }}</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.opportunities.index') }}">{{ __('Opportunities') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Edit') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            {{ __('Edit Opportunity') }}
        </div>
        <div class="card-body">
            <form action="{{ route('admin.opportunities.update', $opportunity->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                @php
                    $metaData = json_decode($opportunity->meta_data, true) ?? [];
                @endphp
                
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Title') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $opportunity->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">{{ __('Description') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control summernote @error('content') is-invalid @enderror" id="content" name="content" rows="10" required>{{ old('content', $opportunity->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">{{ __('Opportunity Details') }}</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="category" class="form-label">{{ __('Category') }} <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                        <option value="" disabled>{{ __('Select Category') }}</option>
                                        @foreach($categories as $value => $label)
                                            <option value="{{ $value }}" {{ old('category', $metaData['category'] ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="deadline" class="form-label">{{ __('Deadline (if applicable)') }}</label>
                                    <input type="date" class="form-control @error('deadline') is-invalid @enderror" id="deadline" name="deadline" value="{{ old('deadline', $metaData['deadline'] ?? '') }}">
                                    @error('deadline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="location" class="form-label">{{ __('Location') }}</label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $metaData['location'] ?? '') }}">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="image" class="form-label">{{ __('Featured Image') }}</label>
                                    @if($opportunity->image)
                                        <div class="mb-2">
                                            <img src="{{ $opportunity->image_url }}" alt="{{ $opportunity->title }}" class="img-thumbnail" style="max-height: 150px;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                    <small class="text-muted">{{ __('Leave empty to keep current image. Recommended size: 800x600px. Max size: 2MB.') }}</small>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $opportunity->type === 'featured_opportunity' ? 'checked' : '') }}>
                                    <label class="form-check-label" for="is_featured">
                                        {{ __('Feature this opportunity') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mt-3">
                            <div class="card-header">{{ __('Contact Information') }}</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="contact" class="form-label">{{ __('Contact Person') }}</label>
                                    <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact" value="{{ old('contact', $metaData['contact'] ?? '') }}">
                                    @error('contact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $metaData['email'] ?? '') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="phone" class="form-label">{{ __('Phone') }}</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $metaData['phone'] ?? '') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="website" class="form-label">{{ __('Website') }}</label>
                                    <input type="url" class="form-control @error('website') is-invalid @enderror" id="website" name="website" value="{{ old('website', $metaData['website'] ?? '') }}" placeholder="https://">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mt-3">
                            <div class="card-header">{{ __('Application Details') }}</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="application_url" class="form-label">{{ __('Application URL') }}</label>
                                    <input type="url" class="form-control @error('application_url') is-invalid @enderror" id="application_url" name="application_url" value="{{ old('application_url', $metaData['application_url'] ?? '') }}" placeholder="https://">
                                    @error('application_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="application_process" class="form-label">{{ __('Application Process') }}</label>
                                    <textarea class="form-control @error('application_process') is-invalid @enderror" id="application_process" name="application_process" rows="3">{{ old('application_process', $metaData['application_process'] ?? '') }}</textarea>
                                    @error('application_process')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">{{ __('Requirements') }}</div>
                            <div class="card-body">
                                <div id="requirements-container">
                                    @php
                                        $requirements = old('requirements', $metaData['requirements'] ?? []);
                                        if (empty($requirements)) {
                                            $requirements = [''];
                                        }
                                    @endphp
                                    
                                    @foreach($requirements as $requirement)
                                        <div class="input-group mb-2 requirement-item">
                                            <input type="text" class="form-control" name="requirements[]" value="{{ $requirement }}" placeholder="{{ __('Requirement') }}">
                                            <button type="button" class="btn btn-danger remove-requirement"><i class="fas fa-times"></i></button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-requirement">
                                    <i class="fas fa-plus"></i> {{ __('Add Requirement') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">{{ __('Benefits') }}</div>
                            <div class="card-body">
                                <div id="benefits-container">
                                    @php
                                        $benefits = old('benefits', $metaData['benefits'] ?? []);
                                        if (empty($benefits)) {
                                            $benefits = [''];
                                        }
                                    @endphp
                                    
                                    @foreach($benefits as $benefit)
                                        <div class="input-group mb-2 benefit-item">
                                            <input type="text" class="form-control" name="benefits[]" value="{{ $benefit }}" placeholder="{{ __('Benefit') }}">
                                            <button type="button" class="btn btn-danger remove-benefit"><i class="fas fa-times"></i></button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-benefit">
                                    <i class="fas fa-plus"></i> {{ __('Add Benefit') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.opportunities.index') }}" class="btn btn-secondary me-2">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('Update Opportunity') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Summernote
        $('.summernote').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
        
        // Handle requirements
        $('#add-requirement').click(function() {
            const html = `
                <div class="input-group mb-2 requirement-item">
                    <input type="text" class="form-control" name="requirements[]" placeholder="{{ __('Requirement') }}">
                    <button type="button" class="btn btn-danger remove-requirement"><i class="fas fa-times"></i></button>
                </div>
            `;
            $('#requirements-container').append(html);
        });
        
        $(document).on('click', '.remove-requirement', function() {
            if ($('.requirement-item').length > 1) {
                $(this).closest('.requirement-item').remove();
            } else {
                $(this).closest('.requirement-item').find('input').val('');
            }
        });
        
        // Handle benefits
        $('#add-benefit').click(function() {
            const html = `
                <div class="input-group mb-2 benefit-item">
                    <input type="text" class="form-control" name="benefits[]" placeholder="{{ __('Benefit') }}">
                    <button type="button" class="btn btn-danger remove-benefit"><i class="fas fa-times"></i></button>
                </div>
            `;
            $('#benefits-container').append(html);
        });
        
        $(document).on('click', '.remove-benefit', function() {
            if ($('.benefit-item').length > 1) {
                $(this).closest('.benefit-item').remove();
            } else {
                $(this).closest('.benefit-item').find('input').val('');
            }
        });
    });
</script>
@endsection