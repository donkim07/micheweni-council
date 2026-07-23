@extends('layouts.admin')

@section('title', __('Edit Leadership Information'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Edit Leadership Information') }}</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.government.site-config.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> {{ __('Back to Configuration') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <form action="{{ route('admin.government.site-config.update-leadership') }}" method="POST" enctype="multipart/form-data" class="form">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">{{ __('Commissioner Information') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Current Image -->
                                        <div class="text-center mb-3">
                                            <img src="{{ asset($leadership['commissioner']['image'] ?? 'images/government/avatar-placeholder.jpg') }}" 
                                                 class="img-fluid rounded" style="max-height: 200px;" 
                                                 alt="{{ $leadership['commissioner']['name'] ?? 'Commissioner' }}">
                                        </div>
                                        
                                        <!-- Image Upload -->
                                        <div class="mb-3">
                                            <label for="commissioner_image" class="form-label">{{ __('Photo') }}</label>
                                            <input type="file" name="commissioner_image" id="commissioner_image" class="form-control @error('commissioner_image') is-invalid @enderror" accept="image/*">
                                            @error('commissioner_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">{{ __('Recommended size: 500x600 pixels') }}</small>
                                        </div>
                                        
                                        <!-- Name -->
                                        <div class="mb-3">
                                            <label for="commissioner_name" class="form-label">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="commissioner_name" id="commissioner_name" class="form-control @error('commissioner_name') is-invalid @enderror" value="{{ old('commissioner_name', $leadership['commissioner']['name'] ?? '') }}" required>
                                            @error('commissioner_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Title -->
                                        <div class="mb-3">
                                            <label for="commissioner_title" class="form-label">{{ __('Title/Position') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="commissioner_title" id="commissioner_title" class="form-control @error('commissioner_title') is-invalid @enderror" value="{{ old('commissioner_title', $leadership['commissioner']['title'] ?? '') }}" required>
                                            @error('commissioner_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Email -->
                                        <div class="mb-3">
                                            <label for="commissioner_email" class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                                            <input type="email" name="commissioner_email" id="commissioner_email" class="form-control @error('commissioner_email') is-invalid @enderror" value="{{ old('commissioner_email', $leadership['commissioner']['email'] ?? '') }}" required>
                                            @error('commissioner_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Phone -->
                                        <div class="mb-3">
                                            <label for="commissioner_phone" class="form-label">{{ __('Phone Number') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="commissioner_phone" id="commissioner_phone" class="form-control @error('commissioner_phone') is-invalid @enderror" value="{{ old('commissioner_phone', $leadership['commissioner']['phone'] ?? '') }}" required>
                                            @error('commissioner_phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Office -->
                                        <div class="mb-3">
                                            <label for="commissioner_office" class="form-label">{{ __('Office Location') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="commissioner_office" id="commissioner_office" class="form-control @error('commissioner_office') is-invalid @enderror" value="{{ old('commissioner_office', $leadership['commissioner']['office'] ?? '') }}" required>
                                            @error('commissioner_office')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Bio -->
                                        <div class="mb-3">
                                            <label for="commissioner_bio" class="form-label">{{ __('Biography') }} <span class="text-danger">*</span></label>
                                            <textarea name="commissioner_bio" id="commissioner_bio" class="form-control @error('commissioner_bio') is-invalid @enderror" rows="5" required>{{ old('commissioner_bio', $leadership['commissioner']['bio'] ?? '') }}</textarea>
                                            @error('commissioner_bio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">{{ __('Director Information') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Current Image -->
                                        <div class="text-center mb-3">
                                            <img src="{{ asset($leadership['director']['image'] ?? 'images/government/avatar-placeholder.jpg') }}" 
                                                 class="img-fluid rounded" style="max-height: 200px;" 
                                                 alt="{{ $leadership['director']['name'] ?? 'Director' }}">
                                        </div>
                                        
                                        <!-- Image Upload -->
                                        <div class="mb-3">
                                            <label for="director_image" class="form-label">{{ __('Photo') }}</label>
                                            <input type="file" name="director_image" id="director_image" class="form-control @error('director_image') is-invalid @enderror" accept="image/*">
                                            @error('director_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">{{ __('Recommended size: 500x600 pixels') }}</small>
                                        </div>
                                        
                                        <!-- Name -->
                                        <div class="mb-3">
                                            <label for="director_name" class="form-label">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="director_name" id="director_name" class="form-control @error('director_name') is-invalid @enderror" value="{{ old('director_name', $leadership['director']['name'] ?? '') }}" required>
                                            @error('director_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Title -->
                                        <div class="mb-3">
                                            <label for="director_title" class="form-label">{{ __('Title/Position') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="director_title" id="director_title" class="form-control @error('director_title') is-invalid @enderror" value="{{ old('director_title', $leadership['director']['title'] ?? '') }}" required>
                                            @error('director_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Email -->
                                        <div class="mb-3">
                                            <label for="director_email" class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                                            <input type="email" name="director_email" id="director_email" class="form-control @error('director_email') is-invalid @enderror" value="{{ old('director_email', $leadership['director']['email'] ?? '') }}" required>
                                            @error('director_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Phone -->
                                        <div class="mb-3">
                                            <label for="director_phone" class="form-label">{{ __('Phone Number') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="director_phone" id="director_phone" class="form-control @error('director_phone') is-invalid @enderror" value="{{ old('director_phone', $leadership['director']['phone'] ?? '') }}" required>
                                            @error('director_phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Office -->
                                        <div class="mb-3">
                                            <label for="director_office" class="form-label">{{ __('Office Location') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="director_office" id="director_office" class="form-control @error('director_office') is-invalid @enderror" value="{{ old('director_office', $leadership['director']['office'] ?? '') }}" required>
                                            @error('director_office')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Bio -->
                                        <div class="mb-3">
                                            <label for="director_bio" class="form-label">{{ __('Biography') }} <span class="text-danger">*</span></label>
                                            <textarea name="director_bio" id="director_bio" class="form-control @error('director_bio') is-invalid @enderror" rows="5" required>{{ old('director_bio', $leadership['director']['bio'] ?? '') }}</textarea>
                                            @error('director_bio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ __('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
