@extends('layouts.admin')

@section('title', __('Component Settings'))

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
    .color-preview {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 10px;
        border: 1px solid #ddd;
        vertical-align: middle;
    }
    
    /* Style preview cards */
    .style-preview-card {
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 10px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .style-preview-card:hover {
        border-color: #0d6efd;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .style-preview-card.selected {
        border: 2px solid #0d6efd;
        box-shadow: 0 0 0 2px rgba(13,110,253,0.25);
    }
    
    .style-preview-card .preview-header {
        padding: 8px 10px;
        background: #f8f9fa;
        border-bottom: 1px solid #ddd;
        font-weight: 500;
    }
    
    .style-preview-card .preview-body {
        padding: 15px;
        min-height: 80px;
    }
    
    /* Template card styling */
    .template-gallery {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .template-card {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
    }
    
    .template-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .template-card.selected {
        border: 2px solid #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
    }
    
    .template-card.selected .card-body {
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    .template-card .card-img-top {
        height: 160px;
        object-fit: cover;
        border-bottom: 1px solid #dee2e6;
    }
    
    .template-badges {
        display: flex;
        gap: 5px;
        margin-top: 8px;
        flex-wrap: wrap;
    }
    
    .template-card.selected::after {
        content: '✓';
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #0d6efd;
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
    
    /* Fix for modal display issues */
    .modal {
        z-index: 10000;
    }
    
    .modal-backdrop {
        z-index: 9999;
    }
    
    /* Template preview styles */
    .card-preview-area {
        min-height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        background-color: #f8f9fc;
    }
    
    .card-preview-area h2, .card-preview-area h3 {
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }
    
    .card-preview-area p {
        font-size: 0.8rem;
        line-height: 1.2;
        margin-bottom: 0.5rem;
    }
    
    .card-preview-area .btn {
        font-size: 0.75rem;
        padding: 0.2rem 0.5rem;
    }
    
    .card-preview {
        width: 100%;
        font-size: 0.8rem;
    }
    
    .card-preview-header {
        font-size: 0.9rem;
    }
    
    .card-preview-body {
        font-size: 0.8rem;
    }
    
    .form-preview {
        width: 100%;
        font-size: 0.8rem;
    }
    
    .form-preview .form-control-sm {
        height: 1.5rem;
        font-size: 0.75rem;
    }
    
    /* Add animation for selected template */
    @keyframes pulse-border {
        0% { box-shadow: 0 0 0 0 rgba(78, 115, 223, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(78, 115, 223, 0); }
        100% { box-shadow: 0 0 0 0 rgba(78, 115, 223, 0); }
    }
    
    .template-card.selected {
        animation: pulse-border 2s infinite;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Component Settings') }}: {{ $content->title }}</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.pages.index') }}">{{ __('Pages') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.layout.builder', $content->page_id) }}">{{ __('Page Builder') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Component Settings') }}</li>
    </ol>
    
    <div class="row">
        <!-- Main content column - 8 units wide -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-cog me-1"></i>
                        {{ __('Component Details') }}
                    </div>
                    <div>
                        <button type="submit" form="componentSettingsForm" class="btn btn-primary btn-sm">
                            <i class="fas fa-save me-1"></i> {{ __('Save Changes') }}
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="componentSettingsForm" action="{{ route('admin.layout.saveComponentSettings', $content->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input class="form-control @error('title') is-invalid @enderror" id="title" 
                                        type="text" name="title" value="{{ old('title', $content->title) }}" placeholder="{{ __('Component Title') }}" required />
                                    <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select @error('type') is-invalid @enderror" id="type" 
                                        name="type" required>
                                        <option value="">{{ __('Select component type') }}</option>
                                        <option value="text" @selected(old('type', $content->type) == 'text')>{{ __('Text') }}</option>
                                        <option value="image" @selected(old('type', $content->type) == 'image')>{{ __('Image') }}</option>
                                        <option value="video" @selected(old('type', $content->type) == 'video')>{{ __('Video') }}</option>
                                        <option value="button" @selected(old('type', $content->type) == 'button')>{{ __('Button') }}</option>
                                        <option value="form" @selected(old('type', $content->type) == 'form')>{{ __('Form') }}</option>
                                        <option value="map" @selected(old('type', $content->type) == 'map')>{{ __('Map') }}</option>
                                        <option value="chart" @selected(old('type', $content->type) == 'chart')>{{ __('Chart') }}</option>
                                        <option value="divider" @selected(old('type', $content->type) == 'divider')>{{ __('Divider') }}</option>
                                        <option value="card" @selected(old('type', $content->type) == 'card')>{{ __('Card') }}</option>
                                        <option value="custom" @selected(old('type', $content->type) == 'custom')>{{ __('Custom HTML') }}</option>
                                    </select>
                                    <label for="type">{{ __('Component Type') }} <span class="text-danger">*</span></label>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select @error('template') is-invalid @enderror" id="template" 
                                        name="template">
                                        <option value="">{{ __('Default template') }}</option>
                                        @foreach($componentTypes[$content->type] ?? [] as $key => $label)
                                            <option value="{{ $key }}" @selected(old('template', $content->template) == $key)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <label for="template">{{ __('Component Template') }}</label>
                                    @error('template')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-check form-switch mt-4">
                                    <input class="form-check-input @error('is_active') is-invalid @enderror" type="checkbox" 
                                        id="is_active" name="is_active" value="1" @checked(old('is_active', $content->is_active))>
                                    <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Template System -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="fas fa-code-branch me-1"></i>
                                {{ __('Templates') }}
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="template_system" id="templateSystemNew" value="new">
                                
                                <!-- Template Gallery -->
                                <div id="templateGallery" class="mb-3">
                                    <div class="mb-3">
                                        <h5>{{ __('Select a Template') }}</h5>
                                        <p class="text-muted">{{ __('Choose from pre-designed templates for this component') }}</p>
                                    </div>
                                    
                                    <div id="templateCards" class="row template-gallery">
                                        <!-- Template cards will be loaded here -->
                                        <div class="col-12 text-center py-3">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p class="mt-2">Loading templates...</p>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" id="templateIdentifierSelect" name="template_identifier" value="{{ $content->template_identifier }}">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Legacy Template Selector - Hidden -->
                        <div class="card mb-3" id="templateSelector" style="display: none;">
                            <div class="card-header">
                                <i class="fas fa-th-large me-1"></i>
                                {{ __('Select Template Style') }}
                            </div>
                            <div class="card-body">
                                <div class="template-options">
                                    <!-- Text Templates -->
                                    <div class="template-category" id="text-templates" style="{{ $content->type == 'text' ? '' : 'display: none;' }}">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'basic' ? 'selected' : '' }}" data-template="basic">
                                                    <div class="preview-header">{{ __('Basic Text') }}</div>
                                                    <div class="preview-body">
                                                        <h5>Heading</h5>
                                                        <p>Regular paragraph text with standard formatting.</p>
                                                    </div>
                                                    <input type="radio" name="template_select" value="basic" class="d-none template-radio" {{ old('template', $content->template) == 'basic' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'card' ? 'selected' : '' }}" data-template="card">
                                                    <div class="preview-header">{{ __('Card Style') }}</div>
                                                    <div class="preview-body">
                                                        <div style="border: 1px solid #ddd; border-radius: 4px; padding: 10px;">
                                                            <h5>Card Title</h5>
                                                            <p>Text with card styling and border.</p>
                                                        </div>
                                                    </div>
                                                    <input type="radio" name="template_select" value="card" class="d-none template-radio" {{ old('template', $content->template) == 'card' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'quote' ? 'selected' : '' }}" data-template="quote">
                                                    <div class="preview-header">{{ __('Quote/Testimonial') }}</div>
                                                    <div class="preview-body">
                                                        <blockquote style="border-left: 3px solid #0d6efd; padding-left: 10px; font-style: italic;">
                                                            "This is a quote or testimonial with citation"
                                                            <footer class="blockquote-footer">Author</footer>
                                                        </blockquote>
                                                    </div>
                                                    <input type="radio" name="template_select" value="quote" class="d-none template-radio" {{ old('template', $content->template) == 'quote' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Image Templates -->
                                    <div class="template-category" id="image-templates" style="{{ $content->type == 'image' ? '' : 'display: none;' }}">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'standard' ? 'selected' : '' }}" data-template="standard">
                                                    <div class="preview-header">{{ __('Standard Image') }}</div>
                                                    <div class="preview-body text-center">
                                                        <div style="background: #f0f0f0; width: 100%; height: 70px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="fas fa-image fa-2x text-secondary"></i>
                                                        </div>
                                                    </div>
                                                    <input type="radio" name="template_select" value="standard" class="d-none template-radio" {{ old('template', $content->template) == 'standard' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'rounded' ? 'selected' : '' }}" data-template="rounded">
                                                    <div class="preview-header">{{ __('Rounded Image') }}</div>
                                                    <div class="preview-body text-center">
                                                        <div style="background: #f0f0f0; width: 70px; height: 70px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                                                            <i class="fas fa-image text-secondary"></i>
                                                        </div>
                                                    </div>
                                                    <input type="radio" name="template_select" value="rounded" class="d-none template-radio" {{ old('template', $content->template) == 'rounded' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'captioned' ? 'selected' : '' }}" data-template="captioned">
                                                    <div class="preview-header">{{ __('Captioned Image') }}</div>
                                                    <div class="preview-body">
                                                        <div style="background: #f0f0f0; width: 100%; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="fas fa-image text-secondary"></i>
                                                        </div>
                                                        <p class="small text-center mt-1">Image caption text</p>
                                                    </div>
                                                    <input type="radio" name="template_select" value="captioned" class="d-none template-radio" {{ old('template', $content->template) == 'captioned' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Button Templates -->
                                    <div class="template-category" id="button-templates" style="{{ $content->type == 'button' ? '' : 'display: none;' }}">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'primary' ? 'selected' : '' }}" data-template="primary">
                                                    <div class="preview-header">{{ __('Primary Button') }}</div>
                                                    <div class="preview-body text-center">
                                                        <button class="btn btn-primary">Button Text</button>
                                                    </div>
                                                    <input type="radio" name="template_select" value="primary" class="d-none template-radio" {{ old('template', $content->template) == 'primary' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'outline' ? 'selected' : '' }}" data-template="outline">
                                                    <div class="preview-header">{{ __('Outline Button') }}</div>
                                                    <div class="preview-body text-center">
                                                        <button class="btn btn-outline-primary">Button Text</button>
                                                    </div>
                                                    <input type="radio" name="template_select" value="outline" class="d-none template-radio" {{ old('template', $content->template) == 'outline' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'icon' ? 'selected' : '' }}" data-template="icon">
                                                    <div class="preview-header">{{ __('Icon Button') }}</div>
                                                    <div class="preview-body text-center">
                                                        <button class="btn btn-success"><i class="fas fa-check me-1"></i> Button Text</button>
                                                    </div>
                                                    <input type="radio" name="template_select" value="icon" class="d-none template-radio" {{ old('template', $content->template) == 'icon' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Video Templates -->
                                    <div class="template-category" id="video-templates" style="{{ $content->type == 'video' ? '' : 'display: none;' }}">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'standard' ? 'selected' : '' }}" data-template="standard">
                                                    <div class="preview-header">{{ __('Standard Video') }}</div>
                                                    <div class="preview-body text-center">
                                                        <i class="fas fa-video fa-2x"></i>
                                                        <p class="mt-2">Simple embedded video</p>
                                                    </div>
                                                    <input type="radio" name="template_select" value="standard" class="d-none template-radio" {{ old('template', $content->template) == 'standard' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'fullwidth' ? 'selected' : '' }}" data-template="fullwidth">
                                                    <div class="preview-header">{{ __('Full Width Video') }}</div>
                                                    <div class="preview-body text-center">
                                                        <div style="background:#eee; width:100%; height:40px; display:flex; align-items:center; justify-content:center;">
                                                            <i class="fas fa-film"></i>
                                                        </div>
                                                    </div>
                                                    <input type="radio" name="template_select" value="fullwidth" class="d-none template-radio" {{ old('template', $content->template) == 'fullwidth' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'modal' ? 'selected' : '' }}" data-template="modal">
                                                    <div class="preview-header">{{ __('Modal Video') }}</div>
                                                    <div class="preview-body text-center">
                                                        <button class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-play me-1"></i> Play Video
                                                        </button>
                                                    </div>
                                                    <input type="radio" name="template_select" value="modal" class="d-none template-radio" {{ old('template', $content->template) == 'modal' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Map Templates -->
                                    <div class="template-category" id="map-templates" style="{{ $content->type == 'map' ? '' : 'display: none;' }}">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'standard' ? 'selected' : '' }}" data-template="standard">
                                                    <div class="preview-header">{{ __('Standard Map') }}</div>
                                                    <div class="preview-body text-center">
                                                        <i class="fas fa-map-marked-alt fa-2x"></i>
                                                        <p class="mt-2">Basic map display</p>
                                                    </div>
                                                    <input type="radio" name="template_select" value="standard" class="d-none template-radio" {{ old('template', $content->template) == 'standard' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'contact' ? 'selected' : '' }}" data-template="contact">
                                                    <div class="preview-header">{{ __('Contact Map') }}</div>
                                                    <div class="preview-body text-center">
                                                        <div style="background:#eee; width:100%; height:40px; display:flex; align-items:center; justify-content:center;">
                                                            <i class="fas fa-map-pin"></i>
                                                        </div>
                                                        <p class="small mt-2">With address details</p>
                                                    </div>
                                                    <input type="radio" name="template_select" value="contact" class="d-none template-radio" {{ old('template', $content->template) == 'contact' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Templates -->
                                    <div class="template-category" id="form-templates" style="{{ $content->type == 'form' ? '' : 'display: none;' }}">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'standard' ? 'selected' : '' }}" data-template="standard">
                                                    <div class="preview-header">{{ __('Standard Form') }}</div>
                                                    <div class="preview-body">
                                                        <div style="background:#f8f9fa; border-radius:4px; padding:8px;">
                                                            <div style="width:100%; height:10px; background:#dee2e6; border-radius:2px; margin-bottom:8px;"></div>
                                                            <div style="width:100%; height:10px; background:#dee2e6; border-radius:2px; margin-bottom:8px;"></div>
                                                            <div style="width:70%; height:10px; background:#0d6efd; border-radius:2px;"></div>
                                                        </div>
                                                    </div>
                                                    <input type="radio" name="template_select" value="standard" class="d-none template-radio" {{ old('template', $content->template) == 'standard' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'inline' ? 'selected' : '' }}" data-template="inline">
                                                    <div class="preview-header">{{ __('Inline Form') }}</div>
                                                    <div class="preview-body">
                                                        <div style="display:flex; background:#f8f9fa; border-radius:4px; padding:8px;">
                                                            <div style="flex:1; height:10px; background:#dee2e6; border-radius:2px; margin-right:4px;"></div>
                                                            <div style="flex:1; height:10px; background:#dee2e6; border-radius:2px; margin-right:4px;"></div>
                                                            <div style="width:50px; height:10px; background:#0d6efd; border-radius:2px;"></div>
                                                        </div>
                                                    </div>
                                                    <input type="radio" name="template_select" value="inline" class="d-none template-radio" {{ old('template', $content->template) == 'inline' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'card' ? 'selected' : '' }}" data-template="card">
                                                    <div class="preview-header">{{ __('Card Form') }}</div>
                                                    <div class="preview-body">
                                                        <div style="border:1px solid #dee2e6; border-radius:4px;">
                                                            <div style="background:#f8f9fa; padding:5px; border-bottom:1px solid #dee2e6; font-size:11px; font-weight:bold;">Form Title</div>
                                                            <div style="padding:8px;">
                                                                <div style="width:100%; height:8px; background:#dee2e6; border-radius:2px; margin-bottom:6px;"></div>
                                                                <div style="width:100%; height:8px; background:#dee2e6; border-radius:2px; margin-bottom:6px;"></div>
                                                                <div style="width:60%; height:8px; background:#0d6efd; border-radius:2px;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="radio" name="template_select" value="card" class="d-none template-radio" {{ old('template', $content->template) == 'card' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card Templates -->
                                    <div class="template-category" id="card-templates" style="{{ $content->type == 'card' ? '' : 'display: none;' }}">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'standard' ? 'selected' : '' }}" data-template="standard">
                                                    <div class="preview-header">{{ __('Standard Card') }}</div>
                                                    <div class="preview-body">
                                                        <div style="border:1px solid #dee2e6; border-radius:4px;">
                                                            <div style="background:#eee; width:100%; height:40px;"></div>
                                                            <div style="padding:8px;">
                                                                <div style="font-weight:bold; font-size:12px;">Card Title</div>
                                                                <div style="font-size:10px; color:#666; margin-bottom:4px;">Subtitle</div>
                                                                <div style="width:100%; height:2px; background:#f0f0f0; margin:4px 0;"></div>
                                                                <div style="margin-top:8px; display:inline-block; padding:2px 8px; background:#0d6efd; color:white; border-radius:2px; font-size:10px;">Button</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="radio" name="template_select" value="standard" class="d-none template-radio" {{ old('template', $content->template) == 'standard' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'horizontal' ? 'selected' : '' }}" data-template="horizontal">
                                                    <div class="preview-header">{{ __('Horizontal Card') }}</div>
                                                    <div class="preview-body">
                                                        <div style="border:1px solid #dee2e6; border-radius:4px; display:flex;">
                                                            <div style="background:#eee; width:30%; height:60px;"></div>
                                                            <div style="padding:5px; width:70%;">
                                                                <div style="font-weight:bold; font-size:11px;">Card Title</div>
                                                                <div style="font-size:9px; color:#666;">Content text</div>
                                                                <div style="margin-top:5px; display:inline-block; padding:1px 6px; background:#0d6efd; color:white; border-radius:2px; font-size:9px;">Button</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="radio" name="template_select" value="horizontal" class="d-none template-radio" {{ old('template', $content->template) == 'horizontal' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'overlay' ? 'selected' : '' }}" data-template="overlay">
                                                    <div class="preview-header">{{ __('Image Overlay Card') }}</div>
                                                    <div class="preview-body">
                                                        <div style="border:1px solid #dee2e6; border-radius:4px; position:relative;">
                                                            <div style="background:#eee; width:100%; height:60px;"></div>
                                                            <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.3); padding:5px; color:white;">
                                                                <div style="font-weight:bold; font-size:11px;">Overlay Title</div>
                                                                <div style="font-size:9px;">Content text</div>
                                                                <div style="position:absolute; bottom:5px; left:5px; display:inline-block; padding:1px 6px; background:white; color:#333; border-radius:2px; font-size:9px;">Button</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="radio" name="template_select" value="overlay" class="d-none template-radio" {{ old('template', $content->template) == 'overlay' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Chart Templates -->
                                    <div class="template-category" id="chart-templates" style="{{ $content->type == 'chart' ? '' : 'display: none;' }}">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'bar' ? 'selected' : '' }}" data-template="bar">
                                                    <div class="preview-header">{{ __('Bar Chart') }}</div>
                                                    <div class="preview-body text-center">
                                                        <div style="height:60px; display:flex; align-items:flex-end; justify-content:space-around; padding:0 10px;">
                                                            <div style="width:15%; height:30%; background:#0d6efd;"></div>
                                                            <div style="width:15%; height:60%; background:#0d6efd;"></div>
                                                            <div style="width:15%; height:40%; background:#0d6efd;"></div>
                                                            <div style="width:15%; height:80%; background:#0d6efd;"></div>
                                                            <div style="width:15%; height:50%; background:#0d6efd;"></div>
                                                        </div>
                                                        <div style="height:10px; border-top:1px solid #dee2e6; margin-top:5px;"></div>
                                                    </div>
                                                    <input type="radio" name="template_select" value="bar" class="d-none template-radio" {{ old('template', $content->template) == 'bar' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'line' ? 'selected' : '' }}" data-template="line">
                                                    <div class="preview-header">{{ __('Line Chart') }}</div>
                                                    <div class="preview-body text-center">
                                                        <svg width="100%" height="60" viewBox="0 0 100 60" preserveAspectRatio="none">
                                                            <polyline points="10,50 30,20 50,35 70,10 90,30" 
                                                                    fill="none" stroke="#0d6efd" stroke-width="2" />
                                                            <line x1="0" y1="59" x2="100" y2="59" stroke="#dee2e6" stroke-width="1" />
                                                        </svg>
                                                    </div>
                                                    <input type="radio" name="template_select" value="line" class="d-none template-radio" {{ old('template', $content->template) == 'line' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'pie' ? 'selected' : '' }}" data-template="pie">
                                                    <div class="preview-header">{{ __('Pie Chart') }}</div>
                                                    <div class="preview-body text-center">
                                                        <div style="width:60px; height:60px; margin:0 auto; border-radius:50%; overflow:hidden; position:relative;">
                                                            <div style="position:absolute; width:100%; height:100%; background:conic-gradient(#0d6efd 0% 25%, #6c757d 25% 55%, #28a745 55% 75%, #dc3545 75% 100%);"></div>
                                                        </div>
                                                    </div>
                                                    <input type="radio" name="template_select" value="pie" class="d-none template-radio" {{ old('template', $content->template) == 'pie' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Divider Templates -->
                                    <div class="template-category" id="divider-templates" style="{{ $content->type == 'divider' ? '' : 'display: none;' }}">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'solid' ? 'selected' : '' }}" data-template="solid">
                                                    <div class="preview-header">{{ __('Solid Line') }}</div>
                                                    <div class="preview-body text-center">
                                                        <div style="width:100%; height:1px; background:#000; margin:30px 0;"></div>
                                                    </div>
                                                    <input type="radio" name="template_select" value="solid" class="d-none template-radio" {{ old('template', $content->template) == 'solid' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'dashed' ? 'selected' : '' }}" data-template="dashed">
                                                    <div class="preview-header">{{ __('Dashed Line') }}</div>
                                                    <div class="preview-body text-center">
                                                        <div style="width:100%; height:1px; border-top:1px dashed #000; margin:30px 0;"></div>
                                                    </div>
                                                    <input type="radio" name="template_select" value="dashed" class="d-none template-radio" {{ old('template', $content->template) == 'dashed' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="style-preview-card {{ old('template', $content->template) == 'spacer' ? 'selected' : '' }}" data-template="spacer">
                                                    <div class="preview-header">{{ __('Spacer') }}</div>
                                                    <div class="preview-body text-center">
                                                        <div style="width:100%; height:40px; background:#f8f9fa; border:1px dashed #ccc;"></div>
                                                    </div>
                                                    <input type="radio" name="template_select" value="spacer" class="d-none template-radio" {{ old('template', $content->template) == 'spacer' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Template Selection -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="fas fa-puzzle-piece me-1"></i>
                                {{ __('Template Selection') }}
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    {{ __('Select a template for this component. Each template provides a unique design and layout.') }}
                                </div>
                                
                                <input type="hidden" name="order" value="{{ old('order', $content->order) }}" />
                                <input type="hidden" name="column_width" value="{{ old('column_width', $content->column_width) }}" />
                                
                                <div class="form-group">
                                    <label for="template_identifier" class="form-label">{{ __('Template') }}:</label>
                                    <input type="hidden" id="template_identifier" name="template_identifier" value="{{ old('template_identifier', $content->template_identifier) }}">
                                    <div id="template-gallery" class="row mt-3">
                                        <!-- Templates will be loaded here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Component Properties Section -->
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">{{ __('Component Properties') }}</h5>
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#componentPropertiesCollapse">
                                    <i class="fas fa-expand-alt"></i>
                                </button>
                            </div>
                            <div id="componentPropertiesCollapse" class="collapse show">
                                <div class="card-body">
                                    <!-- Dynamic template-specific properties will be generated here -->
                                    <div id="dynamicPropertiesContainer" class="mb-4"></div>
                                    
                                    <!-- Dynamic Component Properties -->
                                    @if($content->type == 'card')
                                        <!-- Card Properties - Dynamic based on template -->
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Card Title') }}</label>
                                            <input type="text" name="meta_title" class="form-control" value="{{ $content->meta->title ?? '' }}">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Card Subtitle') }}</label>
                                            <input type="text" name="meta_subtitle" class="form-control" value="{{ $content->meta->subtitle ?? '' }}">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Header Text') }}</label>
                                            <input type="text" name="meta_header_text" class="form-control" value="{{ $content->meta->header_text ?? '' }}">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Footer Text') }}</label>
                                            <input type="text" name="meta_footer_text" class="form-control" value="{{ $content->meta->footer_text ?? '' }}">
                                        </div>
                                        
                                        <!-- Image for all templates except text-only -->
                                        <div id="card-image-field" class="mb-3 {{ ($content->template ?? 'standard') == 'text-only' ? 'd-none' : '' }}">
                                            <label class="form-label">{{ __('Card Image') }}</label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" name="image_file" accept="image/*">
                                                @if(isset($content->meta->image) && $content->meta->image)
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#imagePreviewModal">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger" id="removeImageBtn" name="remove_image">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="form-text">{{ __('Recommended size:') }} 800x400px</div>
                                        </div>
                                        
                                        <!-- Button fields for templates with buttons -->
                                        <div id="card-button-fields" class="{{ in_array($content->template ?? 'standard', ['minimal', 'text-only']) ? 'd-none' : '' }}">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Button Text') }}</label>
                                                <input type="text" name="meta_button_text" class="form-control" value="{{ $content->meta->button_text ?? '' }}">
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Button URL') }}</label>
                                                <input type="text" name="meta_button_url" class="form-control" value="{{ $content->meta->button_url ?? '#' }}">
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('Button Style') }}</label>
                                                        <select name="meta_button_style" class="form-select">
                                                            <option value="primary" {{ isset($content->meta->button_style) && $content->meta->button_style == 'primary' ? 'selected' : '' }}>Primary</option>
                                                            <option value="secondary" {{ isset($content->meta->button_style) && $content->meta->button_style == 'secondary' ? 'selected' : '' }}>Secondary</option>
                                                            <option value="success" {{ isset($content->meta->button_style) && $content->meta->button_style == 'success' ? 'selected' : '' }}>Success</option>
                                                            <option value="danger" {{ isset($content->meta->button_style) && $content->meta->button_style == 'danger' ? 'selected' : '' }}>Danger</option>
                                                            <option value="warning" {{ isset($content->meta->button_style) && $content->meta->button_style == 'warning' ? 'selected' : '' }}>Warning</option>
                                                            <option value="info" {{ isset($content->meta->button_style) && $content->meta->button_style == 'info' ? 'selected' : '' }}>Info</option>
                                                            <option value="light" {{ isset($content->meta->button_style) && $content->meta->button_style == 'light' ? 'selected' : '' }}>Light</option>
                                                            <option value="dark" {{ isset($content->meta->button_style) && $content->meta->button_style == 'dark' ? 'selected' : '' }}>Dark</option>
                                                            <option value="outline-primary" {{ isset($content->meta->button_style) && $content->meta->button_style == 'outline-primary' ? 'selected' : '' }}>Outline Primary</option>
                                                            <option value="outline-secondary" {{ isset($content->meta->button_style) && $content->meta->button_style == 'outline-secondary' ? 'selected' : '' }}>Outline Secondary</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('Button Size') }}</label>
                                                        <select name="meta_button_size" class="form-select">
                                                            <option value="" {{ !isset($content->meta->button_size) || $content->meta->button_size == '' ? 'selected' : '' }}>Default</option>
                                                            <option value="sm" {{ isset($content->meta->button_size) && $content->meta->button_size == 'sm' ? 'selected' : '' }}>Small</option>
                                                            <option value="lg" {{ isset($content->meta->button_size) && $content->meta->button_size == 'lg' ? 'selected' : '' }}>Large</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input" id="openInNewTab" name="meta_open_in_new_tab" {{ isset($content->meta->open_in_new_tab) && $content->meta->open_in_new_tab ? 'checked' : '' }}>
                                                <label class="form-check-label" for="openInNewTab">{{ __('Open in new tab') }}</label>
                                            </div>
                                        </div>
                                        
                                        <!-- Background and text colors -->
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Background Color') }}</label>
                                            <select name="meta_bg_color" class="form-select">
                                                <option value="" {{ !isset($content->meta->bg_color) || $content->meta->bg_color == '' ? 'selected' : '' }}>Default</option>
                                                <option value="primary" {{ isset($content->meta->bg_color) && $content->meta->bg_color == 'primary' ? 'selected' : '' }}>Primary</option>
                                                <option value="secondary" {{ isset($content->meta->bg_color) && $content->meta->bg_color == 'secondary' ? 'selected' : '' }}>Secondary</option>
                                                <option value="light" {{ isset($content->meta->bg_color) && $content->meta->bg_color == 'light' ? 'selected' : '' }}>Light</option>
                                                <option value="dark" {{ isset($content->meta->bg_color) && $content->meta->bg_color == 'dark' ? 'selected' : '' }}>Dark</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Text Alignment') }}</label>
                                            <select name="meta_text_alignment" class="form-select">
                                                <option value="left" {{ !isset($content->meta->text_alignment) || $content->meta->text_alignment == 'left' ? 'selected' : '' }}>Left</option>
                                                <option value="center" {{ isset($content->meta->text_alignment) && $content->meta->text_alignment == 'center' ? 'selected' : '' }}>Center</option>
                                                <option value="right" {{ isset($content->meta->text_alignment) && $content->meta->text_alignment == 'right' ? 'selected' : '' }}>Right</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('CSS Class') }}</label>
                                            <input type="text" name="meta_css_class" class="form-control" value="{{ $content->meta->css_class ?? '' }}" placeholder="custom-class">
                                        </div>
                                        
                                    @elseif($content->type == 'form')
                                        <!-- Form Properties -->
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Select Form') }}</label>
                                            <select name="meta_form_id" class="form-select" id="formSelect">
                                                <option value="">{{ __('-- Select Form --') }}</option>
                                                @foreach($formBuilders as $id => $title)
                                                    <option value="{{ $id }}" {{ isset($content->meta->form_id) && $content->meta->form_id == $id ? 'selected' : '' }}>{{ $title }}</option>
                                                @endforeach
                                            </select>
                                            <div class="form-text">
                                                <a href="{{ route('admin.form-builders.index') }}" target="_blank">
                                                    <i class="fas fa-external-link-alt me-1"></i>{{ __('Manage Forms') }}
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Submit Button Text') }}</label>
                                            <input type="text" name="meta_submit_button_text" class="form-control" value="{{ $content->meta->submit_button_text ?? 'Submit' }}">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Submit Button Style') }}</label>
                                            <select name="meta_submit_button_style" class="form-select">
                                                <option value="primary" {{ !isset($content->meta->submit_button_style) || $content->meta->submit_button_style == 'primary' ? 'selected' : '' }}>Primary</option>
                                                <option value="secondary" {{ isset($content->meta->submit_button_style) && $content->meta->submit_button_style == 'secondary' ? 'selected' : '' }}>Secondary</option>
                                                <option value="success" {{ isset($content->meta->submit_button_style) && $content->meta->submit_button_style == 'success' ? 'selected' : '' }}>Success</option>
                                                <option value="danger" {{ isset($content->meta->submit_button_style) && $content->meta->submit_button_style == 'danger' ? 'selected' : '' }}>Danger</option>
                                                <option value="warning" {{ isset($content->meta->submit_button_style) && $content->meta->submit_button_style == 'warning' ? 'selected' : '' }}>Warning</option>
                                                <option value="info" {{ isset($content->meta->submit_button_style) && $content->meta->submit_button_style == 'info' ? 'selected' : '' }}>Info</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Success Message') }}</label>
                                            <textarea name="meta_success_message" class="form-control" rows="2">{{ $content->meta->success_message ?? 'Thank you for your submission!' }}</textarea>
                                        </div>
                                        
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="enableCaptcha" name="meta_enable_captcha" {{ isset($content->meta->enable_captcha) && $content->meta->enable_captcha ? 'checked' : '' }}>
                                            <label class="form-check-label" for="enableCaptcha">{{ __('Enable CAPTCHA') }}</label>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('CSS Class') }}</label>
                                            <input type="text" name="meta_css_class" class="form-control" value="{{ $content->meta->css_class ?? '' }}" placeholder="custom-class">
                                        </div>
                                        
                                    @elseif($content->type == 'chart')
                                        <!-- Chart Properties -->
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Chart Title') }}</label>
                                            <input type="text" name="meta_title" class="form-control" value="{{ $content->meta->title ?? 'Chart Title' }}">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Chart Type') }}</label>
                                            <select name="meta_chart_type" class="form-select" id="chartTypeSelect">
                                                <option value="bar" {{ !isset($content->meta->chart_type) || $content->meta->chart_type == 'bar' ? 'selected' : '' }}>Bar</option>
                                                <option value="line" {{ isset($content->meta->chart_type) && $content->meta->chart_type == 'line' ? 'selected' : '' }}>Line</option>
                                                <option value="pie" {{ isset($content->meta->chart_type) && $content->meta->chart_type == 'pie' ? 'selected' : '' }}>Pie</option>
                                                <option value="doughnut" {{ isset($content->meta->chart_type) && $content->meta->chart_type == 'doughnut' ? 'selected' : '' }}>Doughnut</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Data') }} <small class="text-muted">({{ __('comma separated') }})</small></label>
                                            <input type="text" name="meta_data" class="form-control" value="{{ is_array($content->meta->data ?? null) ? implode(', ', $content->meta->data) : ($content->meta->data ?? '25, 40, 60, 80, 20') }}">
                                            <div class="form-text">{{ __('Example: 25, 40, 60, 80, 20') }}</div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Labels') }} <small class="text-muted">({{ __('comma separated') }})</small></label>
                                            <input type="text" name="meta_labels" class="form-control" value="{{ is_array($content->meta->labels ?? null) ? implode(', ', $content->meta->labels) : ($content->meta->labels ?? 'Jan, Feb, Mar, Apr, May') }}">
                                            <div class="form-text">{{ __('Example: Jan, Feb, Mar, Apr, May') }}</div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Height') }}</label>
                                            <input type="text" name="meta_height" class="form-control" value="{{ $content->meta->height ?? '400px' }}">
                                        </div>
                                        
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="showGridLines" name="meta_show_grid_lines" {{ isset($content->meta->show_grid_lines) && $content->meta->show_grid_lines ? 'checked' : '' }}>
                                            <label class="form-check-label" for="showGridLines">{{ __('Show Grid Lines') }}</label>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('CSS Class') }}</label>
                                            <input type="text" name="meta_css_class" class="form-control" value="{{ $content->meta->css_class ?? '' }}" placeholder="custom-class">
                                        </div>
                                        
                                    @elseif($content->type == 'divider')
                                        <!-- Divider Properties -->
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Divider Style') }}</label>
                                            <select name="meta_style" class="form-select">
                                                <option value="solid" {{ !isset($content->meta->style) || $content->meta->style == 'solid' ? 'selected' : '' }}>Solid</option>
                                                <option value="dashed" {{ isset($content->meta->style) && $content->meta->style == 'dashed' ? 'selected' : '' }}>Dashed</option>
                                                <option value="dotted" {{ isset($content->meta->style) && $content->meta->style == 'dotted' ? 'selected' : '' }}>Dotted</option>
                                                <option value="double" {{ isset($content->meta->style) && $content->meta->style == 'double' ? 'selected' : '' }}>Double</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Thickness') }}</label>
                                            <select name="meta_thickness" class="form-select">
                                                <option value="1" {{ !isset($content->meta->thickness) || $content->meta->thickness == '1' ? 'selected' : '' }}>1px</option>
                                                <option value="2" {{ isset($content->meta->thickness) && $content->meta->thickness == '2' ? 'selected' : '' }}>2px</option>
                                                <option value="3" {{ isset($content->meta->thickness) && $content->meta->thickness == '3' ? 'selected' : '' }}>3px</option>
                                                <option value="4" {{ isset($content->meta->thickness) && $content->meta->thickness == '4' ? 'selected' : '' }}>4px</option>
                                                <option value="5" {{ isset($content->meta->thickness) && $content->meta->thickness == '5' ? 'selected' : '' }}>5px</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Color') }}</label>
                                            <select name="meta_color" class="form-select">
                                                <option value="primary" {{ !isset($content->meta->color) || $content->meta->color == 'primary' ? 'selected' : '' }}>Primary</option>
                                                <option value="secondary" {{ isset($content->meta->color) && $content->meta->color == 'secondary' ? 'selected' : '' }}>Secondary</option>
                                                <option value="dark" {{ isset($content->meta->color) && $content->meta->color == 'dark' ? 'selected' : '' }}>Dark</option>
                                                <option value="light" {{ isset($content->meta->color) && $content->meta->color == 'light' ? 'selected' : '' }}>Light</option>
                                                <option value="muted" {{ isset($content->meta->color) && $content->meta->color == 'muted' ? 'selected' : '' }}>Muted</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Width') }}</label>
                                            <select name="meta_width" class="form-select">
                                                <option value="100" {{ !isset($content->meta->width) || $content->meta->width == '100' ? 'selected' : '' }}>100%</option>
                                                <option value="75" {{ isset($content->meta->width) && $content->meta->width == '75' ? 'selected' : '' }}>75%</option>
                                                <option value="50" {{ isset($content->meta->width) && $content->meta->width == '50' ? 'selected' : '' }}>50%</option>
                                                <option value="25" {{ isset($content->meta->width) && $content->meta->width == '25' ? 'selected' : '' }}>25%</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Alignment') }}</label>
                                            <select name="meta_alignment" class="form-select">
                                                <option value="left" {{ !isset($content->meta->alignment) || $content->meta->alignment == 'left' ? 'selected' : '' }}>Left</option>
                                                <option value="center" {{ isset($content->meta->alignment) && $content->meta->alignment == 'center' ? 'selected' : '' }}>Center</option>
                                                <option value="right" {{ isset($content->meta->alignment) && $content->meta->alignment == 'right' ? 'selected' : '' }}>Right</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('CSS Class') }}</label>
                                            <input type="text" name="meta_css_class" class="form-control" value="{{ $content->meta->css_class ?? '' }}" placeholder="custom-class">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('admin.layout.builder', $content->page_id) }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times me-1"></i> {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> {{ __('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sidebar column - 4 units wide -->
        <div class="col-md-4">
            <!-- Preview Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-eye me-1"></i>
                    {{ __('Component Preview') }}
                </div>
                <div class="card-body">
                    <div id="componentPreview" class="p-3 border rounded">
                        <div class="text-center text-muted">
                            <i class="fas fa-spinner fa-spin me-2"></i> 
                            {{ __("Updating preview...") }}
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Help Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-question-circle me-1"></i>
                    {{ __('Help & Tips') }}
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ __('Working with Components') }}</h5>
                    <p class="card-text">{{ __('Components are the building blocks of your page. Each component can be styled and positioned individually.') }}</p>
                    
                    <div class="mb-3">
                        <h6><i class="fas fa-lightbulb text-warning me-1"></i> {{ __('Tips:') }}</h6>
                        <ul class="small">
                            <li>{{ __('Use templates to quickly apply pre-defined styles') }}</li>
                            <li>{{ __('Set column width to control component size on different devices') }}</li>
                            <li>{{ __('Use margin and padding to fine-tune spacing') }}</li>
                            <li>{{ __('Preview shows how your component will appear on the page') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Include necessary scripts -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script>
$(document).ready(function() {
    // Toggle between template systems
    $('input[name="template_system"]').change(function() {
        var system = $(this).val();
        if (system === 'legacy') {
            $('#templateSelector').show();
            $('#newTemplateSystem').hide();
            $('#templateIdentifierInput').val('');
        } else {
            $('#templateSelector').hide();
            $('#newTemplateSystem').show();
            loadTemplatesForType($('#type').val());
        }
    });
    
    // Load template details when a template is selected
    $('#templateIdentifierSelect').change(function() {
        var templateId = $(this).val();
        if (templateId) {
            // Find the selected option data
            var $option = $(this).find('option:selected');
            var name = $option.text();
            var description = $option.data('description');
            var thumbnail = $option.data('thumbnail');
            var animation = $option.data('animation');
            var hoverEffect = $option.data('hover');
            
            // Update the preview
            $('#templateName').text(name);
            $('#templateDescription').text(description || 'No description available');
            
            if (thumbnail) {
                $('#templateThumbnail').attr('src', thumbnail).show();
            } else {
                $('#templateThumbnail').hide();
            }
            
            if (animation) {
                $('#templateAnimationBadge').text('Animation: ' + animation).show();
            } else {
                $('#templateAnimationBadge').hide();
            }
            
            if (hoverEffect) {
                $('#templateHoverBadge').text('Hover: ' + hoverEffect).show();
            } else {
                $('#templateHoverBadge').hide();
            }
            
            $('#templatePreview').show();
        } else {
            $('#templatePreview').hide();
        }
    });
    
    // Function to load templates for a component type
    function loadTemplatesForType(type) {
        if (!type) return;
        
        // Clear current template cards
        let $templateContainer = $('#templateCards');
        $templateContainer.html('<div class="col-12 text-center py-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Loading templates...</p></div>');
        
        console.log('Loading templates for type:', type);
        
        // Use the API endpoint
        $.ajax({
            url: '{{ route("api.templates.by-type") }}',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { type: type },
            beforeSend: function() {
                // Show loading state
                $("#templateCards").html('<div class="col-12 text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-3">Loading templates...</p></div>');
            },
            success: function(data) {
                $templateContainer.empty();
                
                if (!data.length) {
                    $templateContainer.html('<div class="col-12 text-center py-3"><div class="alert alert-info">{{ __("No templates available for this component type") }}</div></div>');
                    return;
                }
                
                // Add each template as a visual card
                $.each(data, function(i, template) {
                    let isSelected = template.identifier === '{{ old("template_identifier", $content->template_identifier) }}';
                    let selectedClass = isSelected ? 'selected' : '';
                    
                    // Prepare badges for template features
                    let animationBadge = template.animation ? `<span class="badge bg-info me-1">${template.animation}</span>` : '';
                    let hoverBadge = template.hover_effect ? `<span class="badge bg-secondary">${template.hover_effect} hover</span>` : '';
                    let categoryBadge = `<span class="badge bg-primary me-1">${template.category || 'Basic'}</span>`;
                    
                    // Get thumbnail image with fallback
                    let thumbnailSrc = template.thumbnail ? 
                        '{{ asset("storage") }}/' + template.thumbnail : 
                        `https://via.placeholder.com/400x250/6c757d/ffffff?text=${encodeURIComponent(template.name)}`;
                    
                    // Get default content for preview
                    let defaultContent = template.default_content || {};
                    
                    // Generate preview HTML based on component type
                    let previewHtml = '';
                    
                    // Create proper previews based on component type
                    if (type === 'text') {
                        // Create realistic text preview with formatting
                        previewHtml = `
                            <div class="p-2 text-preview">
                                <h3 class="h6 mb-1">${defaultContent.title || 'Sample Heading'}</h3>
                                <div class="small preview-content">
                                    ${defaultContent.content ? defaultContent.content.substring(0, 120) + '...' : 
                                    '<p>This is sample text content that shows how this text component will appear on your page.</p>'}
                                </div>
                            </div>
                        `;
                    } else if (type === 'card') {
                        // Handle different card templates with proper layout
                        const cardIdentifier = template.identifier || '';
                        
                        if (cardIdentifier.includes('news') || cardIdentifier.includes('image')) {
                            // Image card or news card
                            previewHtml = `
                                <div class="card-preview border">
                                    <div class="image-placeholder bg-light d-flex align-items-center justify-content-center" style="height: 80px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                    <div class="card-preview-body p-2">
                                        <div class="fw-bold small">${defaultContent.title || 'Card Title'}</div>
                                        ${defaultContent.subtitle ? `<div class="text-muted x-small">${defaultContent.subtitle}</div>` : ''}
                                        <p class="x-small mb-1 mt-1">${defaultContent.excerpt || defaultContent.content || 'Card content'}</p>
                                        ${defaultContent.button_text ? 
                                            `<div class="mt-1">
                                                <span class="badge badge-sm bg-${defaultContent.button_style || 'primary'} x-small">
                                                    ${defaultContent.button_text}
                                                </span>
                                            </div>` : ''}
                                    </div>
                                </div>
                            `;
                        } else if (cardIdentifier.includes('horizontal')) {
                            // Horizontal card
                            previewHtml = `
                                <div class="card-preview border d-flex">
                                    <div class="image-placeholder bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                    <div class="card-preview-body p-2 flex-grow-1">
                                        <div class="fw-bold x-small">${defaultContent.title || 'Card Title'}</div>
                                        <p class="x-small mb-1">${defaultContent.content ? defaultContent.content.substring(0, 40) + '...' : 'Card content'}</p>
                                    </div>
                                </div>
                            `;
                        } else {
                            // Standard card
                            previewHtml = `
                                <div class="card-preview border">
                                    ${template.settings?.show_header ? 
                                        `<div class="card-preview-header p-1 bg-light border-bottom x-small fw-bold">${defaultContent.title || 'Card Title'}</div>` : ''}
                                    <div class="card-preview-body p-2">
                                        ${!template.settings?.show_header ? `<div class="fw-bold x-small">${defaultContent.title || 'Card Title'}</div>` : ''}
                                        ${defaultContent.subtitle ? `<div class="text-muted x-small">${defaultContent.subtitle}</div>` : ''}
                                        <p class="x-small mb-1 mt-1">${defaultContent.content ? defaultContent.content.substring(0, 50) + '...' : 'Card content goes here'}</p>
                                        ${defaultContent.button_text ? 
                                            `<div class="mt-1">
                                                <span class="badge badge-sm bg-${defaultContent.button_style || 'primary'} x-small">
                                                    ${defaultContent.button_text}
                                                </span>
                                            </div>` : ''}
                                    </div>
                                </div>
                            `;
                        }
                    } else if (type === 'button') {
                        const btnSize = defaultContent.size ? `btn-${defaultContent.size}` : '';
                        const btnStyle = defaultContent.style || 'primary';
                        const btnIcon = defaultContent.icon ? `<i class="fas fa-${defaultContent.icon} me-1"></i>` : '';
                        previewHtml = `<button class="btn ${btnSize} btn-${btnStyle} btn-sm">${btnIcon}${defaultContent.text || 'Button Text'}</button>`;
                    } else if (type === 'image') {
                        previewHtml = `
                            <div class="text-center">
                                <div class="bg-light p-2 d-inline-block" style="border: 1px dashed #ccc;">
                                    <i class="fas fa-image fa-2x text-muted"></i>
                                    <div class="small text-muted mt-1">Image</div>
                                </div>
                                ${defaultContent.caption ? `<div class="mt-1 text-muted x-small">${defaultContent.caption}</div>` : ''}
                            </div>
                        `;
                    } else if (type === 'form') {
                        // Create a more realistic form preview with the fields from the template
                        let formFields = '';
                        if (defaultContent.fields && Array.isArray(defaultContent.fields)) {
                            formFields = defaultContent.fields.slice(0, 3).map(field => {
                                return `
                                    <div class="mb-1">
                                        <label class="form-label x-small">${field.label}</label>
                                        <div class="form-control form-control-sm disabled" style="height: 10px;"></div>
                                    </div>
                                `;
                            }).join('');
                        } else {
                            formFields = `
                                <div class="mb-1">
                                    <label class="form-label x-small">Name</label>
                                    <div class="form-control form-control-sm disabled" style="height: 10px;"></div>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label x-small">Email</label>
                                    <div class="form-control form-control-sm disabled" style="height: 10px;"></div>
                                </div>
                            `;
                        }
                        
                        previewHtml = `
                            <div class="form-preview border p-2">
                                <div class="mb-1 fw-bold small">${defaultContent.title || 'Form Title'}</div>
                                ${formFields}
                                <div class="mt-2">
                                    <span class="badge bg-${defaultContent.button_style || 'primary'} x-small">
                                        ${defaultContent.button_text || 'Submit'}
                                    </span>
                                </div>
                            </div>
                        `;
                    } else if (type === 'divider') {
                        const style = template.settings?.style || 'solid';
                        const text = defaultContent.text ? `<div class="px-2 small">${defaultContent.text}</div>` : '';
                        const icon = defaultContent.icon ? `<i class="fas fa-${defaultContent.icon} mx-1"></i>` : '';
                        
                        if (template.settings?.has_content) {
                            previewHtml = `
                                <div class="w-100 d-flex align-items-center justify-content-center">
                                    <div style="border-top: 1px ${style} #dee2e6; width: 30%;"></div>
                                    ${text || icon}
                                    <div style="border-top: 1px ${style} #dee2e6; width: 30%;"></div>
                                </div>
                            `;
                        } else {
                            previewHtml = `<div class="w-100 my-2" style="border-top: 1px ${style} #dee2e6;"></div>`;
                        }
                    } else if (type === 'video') {
                        previewHtml = `
                            <div class="text-center bg-dark p-2">
                                <i class="fas fa-play-circle fa-2x text-light"></i>
                                <div class="text-light small mt-1">${defaultContent.title || 'Video'}</div>
                            </div>
                        `;
                    } else {
                        previewHtml = `<div class="p-2 text-center text-muted">${template.name} Preview</div>`;
                    }
                    
                    // Create the template card with live preview instead of just an image
                    let templateCard = `
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 template-card ${selectedClass}" data-template-id="${template.identifier}" 
                                 data-template-settings='${JSON.stringify(template.settings || {})}' 
                                 data-template-content='${JSON.stringify(defaultContent)}'>
                                <div class="card-preview-area p-3 border-bottom">
                                    ${previewHtml}
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">${template.name}</h6>
                                    <p class="card-text small text-muted">${template.description || 'No description available'}</p>
                                    <div class="template-badges">
                                        ${categoryBadge}
                                        ${animationBadge}
                                        ${hoverBadge}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    $templateContainer.append(templateCard);
                });
                
                // If no template is selected but there's at least one template, select the first one
                if (!$('.template-card.selected').length && data.length > 0) {
                    $templateContainer.find('.template-card').first().addClass('selected');
                    $('#templateIdentifierSelect').val($templateContainer.find('.template-card').first().data('template-id'));
                }
                
                // Add click handler for template selection with enhanced functionality
                $('.template-card').click(function() {
                    $('.template-card').removeClass('selected');
                    $(this).addClass('selected');
                    
                    // Get template data
                    const templateId = $(this).data('template-id');
                    const templateSettings = $(this).data('template-settings') || {};
                    const defaultContent = $(this).data('template-content') || {};
                    
                    // Update hidden input - this will be sent to the server to identify the selected template
                    $('#templateIdentifierSelect').val(templateId);
                    
                    // Also update the regular template dropdown if it exists
                    const templateDropdown = $('#template');
                    if (templateDropdown.length) {
                        // Find option with matching value or add a new option
                        if (templateDropdown.find(`option[value="${templateId}"]`).length) {
                            templateDropdown.val(templateId);
                        } else {
                            templateDropdown.append(new Option(templateId, templateId, true, true));
                        }
                    }
                    
                    // Show the Component Properties section if hidden
                    $('#componentPropertiesCollapse').collapse('show');
                    
                    // First apply template settings to form fields if they exist
                    if (templateSettings) {
                        console.log('Applying template settings:', templateSettings);
                        
                        // Apply each setting to matching form elements if they exist
                        $.each(templateSettings, function(key, value) {
                            const field = $(`[name="meta_${key}"]`);
                            if (field.length > 0) {
                                if (field.is(':checkbox')) {
                                    field.prop('checked', Boolean(value));
                                } else {
                                    field.val(value);
                                }
                                // Trigger change event to update any dependent fields
                                field.trigger('change');
                            }
                        });
                    }
                    
                    // Then apply default content to form fields
                    if (defaultContent) {
                        console.log('Applying default content:', defaultContent);
                        
                        // Apply each content value to matching form elements
                        $.each(defaultContent, function(key, value) {
                            const field = $(`[name="meta_${key}"], [name="${key}"]`);
                            if (field.length > 0) {
                                // Special handling for rich text editors
                                if (field.hasClass('summernote') || field.attr('id') === 'value') {
                                    if (typeof value === 'string' && value.trim() !== '') {
                                        field.summernote('code', value);
                                    }
                                } 
                                // Special handling for checkboxes
                                else if (field.is(':checkbox')) {
                                    field.prop('checked', Boolean(value));
                                } 
                                // Default handling
                                else {
                                    field.val(value);
                                }
                                // Trigger change event to update any dependent fields
                                field.trigger('change');
                            }
                        });
                    }
                    
                    // Create dynamic form fields for this template if they don't exist
                    createDynamicFields(templateId, templateSettings, defaultContent);
                    
                    // Update preview if possible
                    if (typeof updateComponentPreview === 'function') {
                        updateComponentPreview();
                    }
                    
                    // Show success message
                    const alert = `<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="fas fa-check-circle me-2"></i> Template applied! Component properties have been updated.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                    
                    $('#templateCards').after(alert);
                    
                    // Auto-dismiss after 3 seconds
                    setTimeout(function() {
                        $('.alert').alert('close');
                    }, 3000);
                });
                
                // Function to create dynamic form fields based on template
                function createDynamicFields(templateId, settings, content) {
                    // Get the component properties container
                    const $propertiesContainer = $('#dynamicPropertiesContainer');
                    if ($propertiesContainer.length === 0) return;
                    
                    // Get component type
                    const componentType = $('#type').val();
                    
                    // Clear existing dynamic fields
                    $propertiesContainer.empty();
                    
                    // Create appropriate fields based on the component type and template
                    let fieldsHtml = '';
                    
                    // Add header for template fields
                    fieldsHtml += `
                        <h5 class="border-bottom pb-2 mt-4">${templateId ? 'Template-Specific Fields' : 'Component Fields'}</h5>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Edit these fields to customize this component's content and appearance.
                        </div>
                    `;
                    
                    // Common fields for all component types
                    if (componentType === 'text') {
                        // Text component fields
                        fieldsHtml += `
                            <div class="mb-3">
                                <label class="form-label fw-bold">Heading</label>
                                <input type="text" class="form-control" name="meta_heading" value="${content.title || ''}">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Content</label>
                                <textarea class="form-control summernote" name="value" rows="6">${content.content || ''}</textarea>
                            </div>
                        `;
                    }
                    else if (componentType === 'card') {
                        // Card component fields
                        fieldsHtml += `
                            <div class="mb-3">
                                <label class="form-label fw-bold">Card Title</label>
                                <input type="text" class="form-control" name="meta_title" value="${content.title || ''}">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Subtitle</label>
                                <input type="text" class="form-control" name="meta_subtitle" value="${content.subtitle || ''}">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Card Content</label>
                                <textarea class="form-control" name="meta_content" rows="4">${content.content || ''}</textarea>
                            </div>
                            
                            ${settings.show_header !== false ? `
                            <div class="mb-3">
                                <label class="form-label">Header Text</label>
                                <input type="text" class="form-control" name="meta_header_text" value="${content.header_text || ''}">
                            </div>
                            ` : ''}
                            
                            <div class="mb-4">
                                <label class="form-label">Card Image</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="image_file" accept="image/*">
                                </div>
                                <div class="form-text">Recommended size: 800x400px</div>
                            </div>
                            
                            ${settings.show_button !== false ? `
                            <h6 class="mt-4 mb-3">Button Options</h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Button Text</label>
                                <input type="text" class="form-control" name="meta_button_text" value="${content.button_text || ''}">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Button URL</label>
                                <input type="text" class="form-control" name="meta_button_url" value="${content.button_url || '#'}">
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Button Style</label>
                                        <select name="meta_button_style" class="form-select">
                                            <option value="primary" ${content.button_style === 'primary' ? 'selected' : ''}>Primary</option>
                                            <option value="secondary" ${content.button_style === 'secondary' ? 'selected' : ''}>Secondary</option>
                                            <option value="success" ${content.button_style === 'success' ? 'selected' : ''}>Success</option>
                                            <option value="outline-primary" ${content.button_style === 'outline-primary' ? 'selected' : ''}>Outline Primary</option>
                                            <option value="link" ${content.button_style === 'link' ? 'selected' : ''}>Link</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="openInNewTab" name="meta_open_in_new_tab" ${content.open_in_new_tab ? 'checked' : ''}>
                                <label class="form-check-label" for="openInNewTab">Open in new tab</label>
                            </div>
                            ` : ''}
                        `;
                    }
                    else if (componentType === 'image') {
                        // Image component fields
                        fieldsHtml += `
                            <div class="mb-4">
                                <label class="form-label">Image</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="image_file" accept="image/*">
                                </div>
                                <div class="form-text">Select an image file to upload</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Image Alt Text</label>
                                <input type="text" class="form-control" name="meta_alt" value="${content.alt || ''}">
                                <div class="form-text">Describe the image for accessibility</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Caption (optional)</label>
                                <input type="text" class="form-control" name="meta_caption" value="${content.caption || ''}">
                            </div>
                        `;
                    }
                    else if (componentType === 'button') {
                        // Button component fields
                        fieldsHtml += `
                            <div class="mb-3">
                                <label class="form-label">Button Text</label>
                                <input type="text" class="form-control" name="meta_text" value="${content.text || ''}">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">URL</label>
                                <input type="text" class="form-control" name="meta_url" value="${content.url || '#'}">
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Button Style</label>
                                        <select name="meta_style" class="form-select">
                                            <option value="primary" ${content.style === 'primary' ? 'selected' : ''}>Primary</option>
                                            <option value="secondary" ${content.style === 'secondary' ? 'selected' : ''}>Secondary</option>
                                            <option value="success" ${content.style === 'success' ? 'selected' : ''}>Success</option>
                                            <option value="outline-primary" ${content.style === 'outline-primary' ? 'selected' : ''}>Outline Primary</option>
                                            <option value="outline-secondary" ${content.style === 'outline-secondary' ? 'selected' : ''}>Outline Secondary</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Button Size</label>
                                        <select name="meta_size" class="form-select">
                                            <option value="" ${!content.size ? 'selected' : ''}>Default</option>
                                            <option value="sm" ${content.size === 'sm' ? 'selected' : ''}>Small</option>
                                            <option value="lg" ${content.size === 'lg' ? 'selected' : ''}>Large</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Icon (optional)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-${content.icon || 'arrow-right'}"></i></span>
                                    <input type="text" class="form-control" name="meta_icon" value="${content.icon || ''}">
                                </div>
                                <div class="form-text">Enter a FontAwesome icon name (e.g., "arrow-right")</div>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="newTabBtn" name="meta_new_tab" ${content.new_tab ? 'checked' : ''}>
                                <label class="form-check-label" for="newTabBtn">Open in new tab</label>
                            </div>
                        `;
                    }
                    else if (componentType === 'form') {
                        // Form component fields
                        fieldsHtml += `
                            <div class="mb-3">
                                <label class="form-label">Form Title</label>
                                <input type="text" class="form-control" name="meta_title" value="${content.title || ''}">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Select Form</label>
                                <select name="meta_form_id" class="form-select" id="formSelect">
                                    <option value="">-- Select Form --</option>
                                    <!-- Form options will be populated by server -->
                                </select>
                                <div class="form-text">
                                    <a href="#" target="_blank">
                                        <i class="fas fa-external-link-alt me-1"></i>Manage Forms
                                    </a>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Submit Button Text</label>
                                <input type="text" class="form-control" name="meta_button_text" value="${content.button_text || 'Submit'}">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Success Message</label>
                                <textarea name="meta_success_message" class="form-control" rows="2">${content.success_message || 'Thank you for your submission!'}</textarea>
                            </div>
                        `;
                    } 
                    else if (componentType === 'video') {
                        // Video component fields
                        fieldsHtml += `
                            <div class="mb-3">
                                <label class="form-label">Video Title</label>
                                <input type="text" class="form-control" name="meta_title" value="${content.title || ''}">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Video Type</label>
                                <select name="meta_source" class="form-select">
                                    <option value="youtube" ${content.source === 'youtube' ? 'selected' : ''}>YouTube</option>
                                    <option value="vimeo" ${content.source === 'vimeo' ? 'selected' : ''}>Vimeo</option>
                                    <option value="url" ${content.source === 'url' ? 'selected' : ''}>Direct URL</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Video URL</label>
                                <input type="text" class="form-control" name="meta_url" value="${content.url || ''}">
                                <div class="form-text">For YouTube or Vimeo, paste the embed URL</div>
                            </div>
                        `;
                    }
                    
                    // Add the fields to the container
                    if (fieldsHtml) {
                        $propertiesContainer.html(fieldsHtml);
                        
                        // Initialize any needed plugins
                        $propertiesContainer.find('.summernote').summernote({
                            height: 200,
                            toolbar: [
                                ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                                ['para', ['ul', 'ol', 'paragraph']],
                                ['insert', ['link']],
                                ['view', ['fullscreen', 'codeview']]
                            ]
                        });
                        
                        // Scroll to the properties section
                        $('html, body').animate({
                            scrollTop: $('#dynamicPropertiesContainer').offset().top - 100
                        }, 500);
                    }
                }
            },
            error: function(xhr) {
                console.error('Error fetching templates:', xhr);
                $templateContainer.html('<div class="col-12 text-center py-3"><div class="alert alert-danger">{{ __("Error loading templates") }}</div></div>');
            }
        });
    }
    
    // Component type change handler
    $('#type').change(function() {
        let selectedType = $(this).val();
        
        // Hide all component-specific settings
        $('.component-type-settings').hide();
        
        // Show settings for selected type
        if (selectedType) {
            $('#' + selectedType + '-settings').show();
        }
        
        // Load templates for this component type
        fetchTemplates(selectedType);
        
        // Generate dynamic fields based on component type
        if (selectedType) {
            // Create default content for this component type
            const defaultContent = {};
            createDynamicFields('', {}, defaultContent);
            
            // Show dynamic properties container
            $('#dynamicPropertiesContainer').show();
        } else {
            // Hide dynamic properties when no component type is selected
            $('#dynamicPropertiesContainer').hide().empty();
        }
    });
    
    // Toggle heading text input based on heading type
    $('#meta_heading_type').change(function() {
        if ($(this).val() === 'none') {
            $('#heading_text_container').hide();
        } else {
            $('#heading_text_container').show();
        }
    });
    
    // Toggle image link options
    $('#meta_link_enabled').change(function() {
        if ($(this).is(':checked')) {
            $('#image_link_container').show();
        } else {
            $('#image_link_container').hide();
        }
    });
    
    // Initialize rich text editor for text component
    if ($('#value').length) {
        $('#value').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    }
    
    // Function to fetch available templates for a component type
    function fetchTemplates(type) {
        $.ajax({
            url: '{{ route("admin.layout.getTemplates") }}',
            type: 'GET',
            data: { type: type },
            success: function(response) {
                // Clear current options
                let templateContainer = $('#template-gallery');
                templateContainer.empty();
                
                if (response.length === 0) {
                    templateContainer.html('<div class="alert alert-info">{{ __("No templates available for this component type") }}</div>');
                    return;
                }
                
                // Add templates to the gallery
                response.forEach(function(template) {
                    let isSelected = template.id === '{{ old("template_identifier", $content->template_identifier) }}';
                    
                    let templateCard = `
                    <div class="col-md-4 mb-4">
                        <div class="template-card ${isSelected ? 'selected' : ''}" data-template-id="${template.id}">
                            <img src="${template.thumbnail}" class="card-img-top" alt="${template.name}">
                            <div class="card-body">
                                <h5 class="card-title">${template.name}</h5>
                                <p class="card-text small">${template.description}</p>
                                <input type="radio" name="template_identifier" value="${template.id}" class="d-none template-radio" ${isSelected ? 'checked' : ''}>
                            </div>
                        </div>
                    </div>
                    `;
                    
                    templateContainer.append(templateCard);
                });
                
                // Add click handler for template selection
                $('.template-card').click(function() {
                    // Remove selected class from all cards
                    $('.template-card').removeClass('selected');
                    
                    // Add selected class to clicked card
                    $(this).addClass('selected');
                    
                    // Select the radio button
                    $(this).find('.template-radio').prop('checked', true);
                    
                    // Update hidden input with template value
                    let templateId = $(this).data('template-id');
                    $('#template_identifier').val(templateId);
                    
                    // Update component preview
                    updateComponentPreview();
                });
            },
            error: function(xhr) {
                console.error('Error fetching templates:', xhr);
                $('#template-gallery').html('<div class="alert alert-danger">{{ __("Error loading templates") }}</div>');
            }
        });
    }
    
    // Initialize the view based on current component type
    let initialType = $('#type').val();
    if (initialType) {
        // Hide all component-specific settings
        $('.component-type-settings').hide();
        
        // Show settings for initial type
        $('#' + initialType + '-settings').show();
        
        // Load templates for initial type
        loadTemplatesForType(initialType);
    }
    
    // Initialize conditional fields
    if ($('#meta_heading_type').val() === 'none') {
        $('#heading_text_container').hide();
    }
    
    if (!$('#meta_link_enabled').is(':checked')) {
        $('#image_link_container').hide();
    }
    
    // Update component preview when form values change
    $('form input, form select, form textarea').on('change keyup', function() {
        updateComponentPreview();
    });
    
    // Function to update component preview
    function updateComponentPreview() {
        var formData = $('#componentSettingsForm').serialize();
        
        $('#componentPreview').html('<div class="text-center"><i class="fas fa-spinner fa-spin me-2"></i>{{ __("Updating preview...") }}</div>');
        
        $.ajax({
            url: '{{ route("admin.layout.previewComponent", $content->id) }}',
            type: 'POST',
            data: formData,
            success: function(data) {
                $('#componentPreview').html(data);
            },
            error: function() {
                $('#componentPreview').html('<div class="alert alert-danger">{{ __("Error loading preview") }}</div>');
            }
        });
    }
    
    // Initial preview load
    updateComponentPreview();
    
    // Warn before leaving with unsaved changes
    var formChanged = false;
    
    $('#componentSettingsForm').on('change', 'input, select, textarea', function() {
        formChanged = true;
    });
    
    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '{{ __("You have unsaved changes. Are you sure you want to leave?") }}';
        }
    });
    
    // Reset the form changed flag when form is submitted
    $('#componentSettingsForm').on('submit', function() {
        formChanged = false;
    });
});
</script>
@endsection 