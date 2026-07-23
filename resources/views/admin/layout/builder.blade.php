@extends('layouts.admin')

@section('title', __('Page Builder') . ' - ' . $page->title)

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link href="{{ asset('css/dragula.min.css') }}" rel="stylesheet">
<style>
    .builder-container {
        position: relative;
        min-height: 200px;
        background: #f8f9fa;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .section-container {
        position: relative;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: #fff;
    }
    
    .section-handle {
        cursor: move;
        background: #f0f0f0;
        padding: 8px;
        margin-bottom: 10px;
        border-radius: 4px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .component-container {
        position: relative;
        padding: 10px;
        margin: 10px 0;
        border: 1px dashed #ccc;
        border-radius: 4px;
        background: #f8f9fa;
    }
    
    .component-handle {
        cursor: move;
        background: #e9ecef;
        padding: 5px;
        margin-bottom: 5px;
        border-radius: 3px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .component-placeholder {
        border: 1px dashed #999;
        background: #f0f0f0;
        height: 50px;
        margin: 10px 0;
        border-radius: 4px;
    }
    
    .section-placeholder {
        border: 1px dashed #666;
        background: #e6e6e6;
        height: 80px;
        margin: 20px 0;
        border-radius: 4px;
    }
    
    .components-sidebar {
        position: sticky;
        top: 20px;
        background: #fff;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .component-item {
        padding: 10px;
        margin: 5px 0;
        background: #f0f0f0;
        border: 1px solid #ddd;
        border-radius: 4px;
        cursor: grab;
        text-align: center;
    }
    
    .component-item:hover {
        background: #e9ecef;
    }
    
    .preview-frame {
        width: 100%;
        height: 600px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .builder-controls {
        position: sticky;
        bottom: 0;
        background: #fff;
        padding: 15px;
        border-top: 1px solid #ddd;
        z-index: 100;
        display: flex;
        justify-content: space-between;
    }
    
    /* Template styles */
    .template-card {
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .template-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .template-card .card-body {
        padding: 15px;
    }
    
    .template-card img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
    }
    
    .template-tabs .nav-link {
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem;
    }
    
    .template-tabs .nav-link.active {
        font-weight: bold;
        color: #0d6efd;
        background-color: transparent;
        border-bottom: 2px solid #0d6efd;
    }
    
    .style-preset {
        display: inline-block;
        width: 40px;
        height: 40px;
        margin: 5px;
        border-radius: 4px;
        cursor: pointer;
        border: 1px solid #ddd;
    }
    
    .style-preset:hover {
        transform: scale(1.1);
    }
    
    .style-preset.active {
        border: 2px solid #0d6efd;
        box-shadow: 0 0 0 2px rgba(13,110,253,0.25);
    }
    
    .template-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
    }
    
    /* Fix for modal display issues */
    .modal {
        z-index: 10000 !important;
    }
    
    .modal-backdrop {
        z-index: 9999 !important;
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        background-color: rgba(0, 0, 0, 0.5) !important;
        pointer-events: none !important; /* Allow clicking through the backdrop */
    }
    
    .modal-dialog {
        z-index: 10001 !important;
        pointer-events: auto !important;
    }
    
    .modal-content {
        pointer-events: auto !important;
        box-shadow: 0 10px 50px rgba(0, 0, 0, 0.3) !important;
        border: none !important;
    }
    
    /* Override Bootstrap's modal backdrop */
    body.modal-open {
        overflow: auto !important;
        padding-right: 0 !important;
    }
    
    /* Override JQueryUI z-index which might conflict with modals */
    .ui-draggable, .ui-sortable {
        z-index: auto !important;
    }
    
    /* UI elements that should always be on top */
    .ui-draggable-dragging,
    .ui-sortable-helper {
        z-index: 10100 !important;
    }
    
    /* Additional fix for modal backdrop */
    #modal-backdrop-fix {
        display: none !important;
    }
    
    /* Custom modal backdrop that doesn't block interaction */
    .interactive-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 9998;
        pointer-events: none;
    }
    
    /* Ensure sidebar is consistent with the rest of the admin */
    #sidebar-wrapper {
        z-index: 900;
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

    /* Custom notification styles */
    .custom-notification {
        position: relative;
        min-width: 300px;
        max-width: 500px;
        z-index: 10050;
        border-radius: 6px;
        padding: 15px 20px;
        margin-bottom: 10px;
        background: white;
        box-shadow: 0 5px 30px rgba(0,0,0,0.2);
        opacity: 0;
        transform: translateY(-20px);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }

    .custom-notification.show {
        opacity: 1;
        transform: translateY(0);
    }

    .custom-notification .icon {
        margin-right: 15px;
        font-size: 20px;
        min-width: 24px;
        text-align: center;
    }

    .custom-notification .content {
        flex: 1;
    }

    .custom-notification .title {
        font-weight: 600;
        margin-bottom: 3px;
    }

    .custom-notification .message {
        color: #555;
    }

    .custom-notification .close {
        margin-left: 10px;
        color: #999;
        cursor: pointer;
        font-size: 20px;
    }

    .custom-notification.success {
        border-left: 4px solid #28a745;
    }

    .custom-notification.success .icon {
        color: #28a745;
    }

    .custom-notification.error {
        border-left: 4px solid #dc3545;
    }

    .custom-notification.error .icon {
        color: #dc3545;
    }

    .custom-notification.warning {
        border-left: 4px solid #ffc107;
    }

    .custom-notification.warning .icon {
        color: #ffc107;
    }

    .custom-notification.info {
        border-left: 4px solid #17a2b8;
    }

    .custom-notification.info .icon {
        color: #17a2b8;
    }

    /* Custom confirm dialog */
    .custom-confirm {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        z-index: 10100;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .custom-confirm.show {
        opacity: 1;
        visibility: visible;
    }

    .custom-confirm-dialog {
        background: white;
        border-radius: 8px;
        max-width: 450px;
        width: 90%;
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        transform: scale(0.8);
        transition: transform 0.3s ease;
    }

    .custom-confirm.show .custom-confirm-dialog {
        transform: scale(1);
    }

    .custom-confirm-header {
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
    }

    .custom-confirm-icon {
        margin-right: 15px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .custom-confirm-icon.warning {
        background: #fff3cd;
        color: #856404;
    }

    .custom-confirm-icon.danger {
        background: #f8d7da;
        color: #721c24;
    }

    .custom-confirm-title {
        font-weight: 600;
        font-size: 1.1rem;
        margin: 0;
        flex: 1;
    }

    .custom-confirm-body {
        padding: 20px;
    }

    .custom-confirm-footer {
        padding: 15px 20px;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: flex-end;
    }

    .custom-confirm-footer .btn {
        margin-left: 10px;
    }

    /* Better template gallery styling */
    .template-preview-container {
        overflow: hidden;
        border-radius: 5px;
        background: #f0f0f0;
        height: 180px;
        position: relative;
    }

    .template-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .template-card:hover .template-preview {
        transform: scale(1.05);
    }

    .template-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.6);
        color: white;
        padding: 8px 12px;
        font-size: 14px;
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }

    .template-card:hover .template-overlay {
        transform: translateY(0);
    }

    /* Template label */
    .template-label {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(25, 135, 84, 0.85);
        color: white;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .template-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0,0,0,0.6);
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        font-weight: 500;
    }

    .template-card.active {
        border: 2px solid #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
    }
    
    /* Highlight drop targets */
    .drop-highlight {
        background-color: rgba(13, 110, 253, 0.1);
        border: 2px dashed #0d6efd;
        min-height: 80px;
    }
    
    .active-drop-target {
        background-color: rgba(25, 135, 84, 0.1);
        border: 2px dashed #198754;
        min-height: 80px;
    }
    
    .ui-state-highlight {
        background-color: rgba(25, 135, 84, 0.2);
        border: 2px solid #198754;
        min-height: 80px;
    }
    
    /* Empty section styling */
    .components-container:empty {
        min-height: 100px;
        border: 2px dashed #0d6efd;
        border-radius: 5px;
        margin: 10px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(13, 110, 253, 0.05);
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .components-container:empty::after {
        content: 'Double-click or drag components here';
        color: #0d6efd;
        font-style: italic;
        font-weight: 500;
    }
    
    .components-container:empty:hover {
        background-color: rgba(13, 110, 253, 0.1);
        border-color: #0d6efd;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Modal Backdrop Fix -->
    <div id="modal-backdrop-fix"></div>
    
    @if(session('section_updated'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Section Updated!</strong> The section settings have been saved.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    
    @if(session('debug_section_before') && session('debug_section_after'))
    <div class="card mb-3">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Debug Information (Section Update)</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Before Update:</h6>
                    <pre class="bg-light p-2" style="max-height: 200px; overflow-y: auto;">{{ json_encode(session('debug_section_before'), JSON_PRETTY_PRINT) }}</pre>
                </div>
                <div class="col-md-6">
                    <h6>After Update:</h6>
                    <pre class="bg-light p-2" style="max-height: 200px; overflow-y: auto;">{{ json_encode(session('debug_section_after'), JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif
    
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>{{ __('Page Builder') }} - {{ $page->title }}</h1>
        </div>
        <div class="col-md-6 text-right">
            <div class="btn-group">
                <a href="{{ route('admin.pages.show', $page) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> {{ __('Back to Page') }}
                </a>
                <button type="button" class="btn btn-primary" id="saveLayout">
                    <i class="fas fa-save"></i> {{ __('Save Layout') }}
                </button>
                <a href="{{ route('admin.layout.preview', $page) }}" class="btn btn-info" target="_blank">
                    <i class="fas fa-eye"></i> {{ __('Preview') }}
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-9">
            <div class="card mb-4">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="builderTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="layout-tab" data-bs-toggle="tab" href="#layout" role="tab" aria-controls="layout" aria-selected="true">
                                {{ __('Layout Editor') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="preview-tab" data-bs-toggle="tab" href="#preview" role="tab" aria-controls="preview" aria-selected="false">
                                {{ __('Live Preview') }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="builderTabsContent">
                        <div class="tab-pane fade show active" id="layout" role="tabpanel" aria-labelledby="layout-tab">
                            <div class="builder-container" id="pageBuilder">
                                @php
                                    $sections = $page->contents->pluck('section')->unique();
                                @endphp
                                
                                @foreach($sections as $sectionName)
                                    <div class="section-container" data-section="{{ $sectionName }}">
                                        <div class="section-handle">
                                            <span>{{ ucfirst($sectionName) }} {{ __('Section') }}</span>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary section-settings" data-section="{{ $sectionName }}">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-section">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="components-container" data-section="{{ $sectionName }}">
                                            @foreach($page->contents->where('section', $sectionName)->sortBy('order') as $content)
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
                                                            <div class="p-2 text-truncate">{{ Str::limit(strip_tags(is_string($content->content) ? $content->content : ''), 100) }}</div>
                                                        @elseif($content->type == 'image')
                                                            <div class="text-center p-2">
                                                                <img src="{{ asset('storage/'.(is_string($content->content) ? $content->content : '')) }}" alt="{{ $content->title }}" style="max-height: 100px; max-width: 100%;">
                                                            </div>
                                                        @elseif($content->type == 'form')
                                                            <div class="p-2">{{ __('Form Component') }}</div>
                                                        @else
                                                            <div class="p-2">{{ ucfirst($content->type) }} {{ __('Component') }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if($sections->isEmpty())
                                <div class="text-center p-5">
                                    <h3>{{ __('Let\'s Build Your Page!') }}</h3>
                                    <p>{{ __('Start by adding a section and components') }}</p>
                                    <button type="button" class="btn btn-primary btn-lg mt-3" id="emptyPageAddTemplate">
                                        <i class="fas fa-plus-circle"></i> {{ __('Add a Pre-made Section') }}
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="preview" role="tabpanel" aria-labelledby="preview-tab">
                            <div class="mb-3 d-flex align-items-center justify-content-between">
                                <div>
                                    <label for="viewportSize" class="form-label me-2">{{ __('Device:') }}</label>
                                    <select class="form-select form-select-sm d-inline-block w-auto" id="viewportSize">
                                        <option value="desktop">{{ __('Desktop') }}</option>
                                        <option value="tablet">{{ __('Tablet') }}</option>
                                        <option value="mobile">{{ __('Mobile') }}</option>
                                    </select>
                                </div>
                                
                            </div>
                            <iframe id="previewFrame" class="preview-frame" src="{{ route('admin.layout.preview', $page) }}"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="components-sidebar mb-4">
                <h5>{{ __('Components') }}</h5>
                <div class="mb-3">
                    <input type="text" class="form-control form-control-sm" id="componentSearch" placeholder="{{ __('Search components...') }}">
                </div>
                <div class="component-item" data-type="text">
                    <i class="fas fa-paragraph"></i> {{ __('Text Block') }}
                </div>
                <div class="component-item" data-type="image">
                    <i class="fas fa-image"></i> {{ __('Image') }}
                </div>
                <div class="component-item" data-type="button">
                    <i class="fas fa-mouse-pointer"></i> {{ __('Button') }}
                </div>
                <div class="component-item" data-type="form">
                    <i class="fas fa-wpforms"></i> {{ __('Form') }}
                </div>
                <div class="component-item" data-type="video">
                    <i class="fas fa-video"></i> {{ __('Video') }}
                </div>
                <div class="component-item" data-type="map">
                    <i class="fas fa-map-marker-alt"></i> {{ __('Map') }}
                </div>
                <div class="component-item" data-type="card">
                    <i class="fas fa-credit-card"></i> {{ __('Card') }}
                </div>
                <div class="component-item" data-type="divider">
                    <i class="fas fa-minus"></i> {{ __('Divider') }}
                </div>
                <div class="component-item" data-type="icon">
                    <i class="fas fa-icons"></i> {{ __('Icon') }}
                </div>
                <div class="component-item" data-type="gallery">
                    <i class="fas fa-images"></i> {{ __('Gallery') }}
                </div>
                <div class="component-item" data-type="custom">
                    <i class="fas fa-code"></i> {{ __('Custom HTML') }}
                </div>
                
                <hr>
                
                <div class="d-grid">
                    <button type="button" class="btn btn-primary" id="addSection">
                        <i class="fas fa-plus-circle"></i> {{ __('Add Section') }}
                    </button>
                </div>
                
                <div class="mt-3 d-grid">
                    <button type="button" class="btn btn-success" id="openTemplateModal">
                        <i class="fas fa-puzzle-piece"></i> {{ __('Pre-made Templates') }}
                    </button>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    {{ __('Help') }}
                </div>
                <div class="card-body">
                    <p><i class="fas fa-arrows-alt me-2"></i>{{ __('Drag components into your layout') }}</p>
                    <p><i class="fas fa-cog me-2"></i>{{ __('Click the gear icon to edit settings') }}</p>
                    <p><i class="fas fa-eye me-2"></i>{{ __('Use Preview to see how your page looks') }}</p>
                    <p><i class="fas fa-save me-2"></i>{{ __('Don\'t forget to save your changes!') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Section Modal -->
<div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="addSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSectionModalLabel">{{ __('Add New Section') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group mb-3">
                        <label for="sectionTitle">{{ __('Section Title') }}</label>
                        <input type="text" class="form-control" id="sectionTitle" placeholder="{{ __('e.g. Hero, Features, About Us') }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="sectionIdentifier">{{ __('Section Identifier') }}</label>
                        <input type="text" class="form-control" id="sectionIdentifier" placeholder="{{ __('e.g. hero-section, features-section') }}">
                        <small class="form-text text-muted">{{ __('Leave blank to auto-generate from title') }}</small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="sectionType">{{ __('Section Type') }}</label>
                        <select class="form-control" id="sectionType">
                            <option value="content">{{ __('Standard Content') }}</option>
                            <option value="hero">{{ __('Hero Banner') }}</option>
                            <option value="columns-2">{{ __('Two Columns') }}</option>
                            <option value="columns-3">{{ __('Three Columns') }}</option>
                            <option value="columns-4">{{ __('Four Columns') }}</option>
                            <option value="cards">{{ __('Card Grid') }}</option>
                            <option value="cta">{{ __('Call to Action') }}</option>
                            <option value="sidebar-left">{{ __('Left Sidebar') }}</option>
                            <option value="sidebar-right">{{ __('Right Sidebar') }}</option>
                            <option value="tabs">{{ __('Tabbed Content') }}</option>
                            <option value="accordion">{{ __('Accordion') }}</option>
                            <option value="slider">{{ __('Slider') }}</option>
                            <option value="footer">{{ __('Footer') }}</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" id="confirmAddSection">{{ __('Add Section') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Template Gallery Modal -->
<div class="modal fade" id="addTemplateModal" tabindex="-1" aria-labelledby="addTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTemplateModalLabel">{{ __('Pre-made Templates') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs mb-3" id="templateTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="hero-tab" data-bs-toggle="tab" href="#hero-templates" role="tab">
                            <i class="fas fa-image me-1"></i> {{ __('Hero Sections') }}
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="content-tab" data-bs-toggle="tab" href="#content-templates" role="tab">
                            <i class="fas fa-paragraph me-1"></i> {{ __('Content Blocks') }}
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="cards-tab" data-bs-toggle="tab" href="#cards-templates" role="tab">
                            <i class="fas fa-th-large me-1"></i> {{ __('Cards & Grids') }}
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="cta-tab" data-bs-toggle="tab" href="#cta-templates" role="tab">
                            <i class="fas fa-bullhorn me-1"></i> {{ __('Call to Action') }}
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="form-tab" data-bs-toggle="tab" href="#form-templates" role="tab">
                            <i class="fas fa-clipboard-list me-1"></i> {{ __('Forms & Feedback') }}
                        </a>
                    </li>
                </ul>
                
                <div class="tab-content" id="templateTabsContent">
                    <!-- Hero Templates -->
                    <div class="tab-pane fade show active" id="hero-templates" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 template-card" data-template="hero-basic">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0">{{ __('Basic Hero Banner') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="template-preview mb-3 p-3 bg-light text-center">
                                            <i class="fas fa-image fa-2x mb-2 text-primary"></i>
                                            <div><b>Banner Image</b></div>
                                            <div class="mt-2 mb-2">
                                                <h5>Banner Heading</h5>
                                                <p class="small">Supporting text with call to action</p>
                                            </div>
                                            <button class="btn btn-sm btn-primary">Button</button>
                                        </div>
                                        <p class="card-text small">{{ __('Showcase your key message with a compelling banner') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 template-card" data-template="hero-split">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0">{{ __('Split Hero Layout') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="template-preview mb-3 p-3 bg-light">
                                            <div class="row">
                                                <div class="col-6 text-center">
                                                    <i class="fas fa-image fa-2x text-info"></i>
                                                    <p class="small mt-2">Image</p>
                                                </div>
                                                <div class="col-6">
                                                    <h5>Split Hero</h5>
                                                    <p class="small">Content next to image</p>
                                                    <button class="btn btn-sm btn-info">Action</button>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="card-text small">{{ __('Equal focus on visuals and text content') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 template-card" data-template="hero-video">
                                    <div class="card-header bg-dark text-white">
                                        <h6 class="mb-0">{{ __('Video Background') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="template-preview mb-3 p-3 bg-dark text-white text-center">
                                            <i class="fas fa-play-circle fa-2x mb-2"></i>
                                            <div><small>Video Background</small></div>
                                            <div class="mt-2 mb-2">
                                                <h5>Video Heading</h5>
                                                <p class="small">Text overlay on video</p>
                                            </div>
                                            <button class="btn btn-sm btn-outline-light">Watch</button>
                                        </div>
                                        <p class="card-text small">{{ __('Engaging motion background for maximum impact') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content Block Templates -->
                    <div class="tab-pane fade" id="content-templates" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 template-card" data-template="content-image-text">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">{{ __('Image with Text') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="template-preview mb-3 p-3 bg-light">
                                            <div class="row">
                                                <div class="col-4 text-center">
                                                    <i class="fas fa-image fa-2x text-success"></i>
                                                </div>
                                                <div class="col-8">
                                                    <h5>Content Title</h5>
                                                    <p class="small">Text beside image...</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="card-text small">{{ __('Visual content with supporting text') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 template-card" data-template="content-rich-text">
                                    <div class="card-header bg-secondary text-white">
                                        <h6 class="mb-0">{{ __('Rich Text Content') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="template-preview mb-3 p-3 bg-light">
                                            <h5>Formatted Heading</h5>
                                            <p class="small">Paragraph of content...</p>
                                            <ul class="small">
                                                <li>List item one</li>
                                                <li>List item two</li>
                                            </ul>
                                        </div>
                                        <p class="card-text small">{{ __('Well-formatted text for readability') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 template-card" data-template="content-quote">
                                    <div class="card-header bg-warning text-dark">
                                        <h6 class="mb-0">{{ __('Quote/Testimonial') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="template-preview mb-3 p-3 bg-light">
                                            <div class="text-center mb-2">
                                                <i class="fas fa-quote-left fa-2x text-warning"></i>
                                            </div>
                                            <p class="small text-center font-italic">
                                                "This is a sample testimonial quote that would appear in this template."
                                            </p>
                                            <p class="small text-end mb-0">— John Smith, Company</p>
                                        </div>
                                        <p class="card-text small">{{ __('Showcase customer feedback or important quotes') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cards & Grid Templates -->
                    <div class="tab-pane fade" id="cards-templates" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 template-card" data-template="news-cards">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">{{ __('News Cards') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="template-preview mb-3 p-3 bg-light">
                                            <div class="row">
                                                <div class="col-4 text-center p-2 border">
                                                    <i class="fas fa-newspaper fa-lg"></i>
                                                    <p class="small mb-0">News 1</p>
                                                </div>
                                                <div class="col-4 text-center p-2 border">
                                                    <i class="fas fa-newspaper fa-lg"></i>
                                                    <p class="small mb-0">News 2</p>
                                                </div>
                                                <div class="col-4 text-center p-2 border">
                                                    <i class="fas fa-newspaper fa-lg"></i>
                                                    <p class="small mb-0">News 3</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="card-text small">{{ __('Display news articles with hover effects') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 template-card" data-template="grid-3-col">
                                    <div class="card-header bg-purple text-white" style="background-color: #6f42c1;">
                                        <h6 class="mb-0">{{ __('3 Column Grid') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="template-preview mb-3 p-3 bg-light">
                                            <div class="row">
                                                <div class="col-4 text-center p-2 border">
                                                    <i class="fas fa-box fa-lg"></i>
                                                    <p class="small mb-0">Item 1</p>
                                                </div>
                                                <div class="col-4 text-center p-2 border">
                                                    <i class="fas fa-box fa-lg"></i>
                                                    <p class="small mb-0">Item 2</p>
                                                </div>
                                                <div class="col-4 text-center p-2 border">
                                                    <i class="fas fa-box fa-lg"></i>
                                                    <p class="small mb-0">Item 3</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="card-text small">{{ __('Perfect for features, services, or team members') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 template-card" data-template="grid-features">
                                    <div class="card-header bg-indigo text-white" style="background-color: #6610f2;">
                                        <h6 class="mb-0">{{ __('Feature Grid') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="template-preview mb-3 p-3 bg-light">
                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    <div class="d-flex">
                                                        <i class="fas fa-check-circle text-success me-2"></i>
                                                        <span class="small">Feature One</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex">
                                                        <i class="fas fa-check-circle text-success me-2"></i>
                                                        <span class="small">Feature Two</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="d-flex">
                                                        <i class="fas fa-check-circle text-success me-2"></i>
                                                        <span class="small">Feature Three</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex">
                                                        <i class="fas fa-check-circle text-success me-2"></i>
                                                        <span class="small">Feature Four</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="card-text small">{{ __('Highlight product/service features with icons') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 template-card" data-template="masonry-grid">
                                    <div class="card-header bg-danger text-white">
                                        <h6 class="mb-0">{{ __('Masonry Grid') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="template-preview mb-3 p-3 bg-light">
                                            <div class="row g-2">
                                                <div class="col-4">
                                                    <div class="border p-1 text-center" style="height: 30px;">
                                                        <small>Item</small>
                                                    </div>
                                                </div>
                                                <div class="col-8">
                                                    <div class="border p-1 text-center" style="height: 50px;">
                                                        <small>Larger Item</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="border p-1 text-center" style="height: 40px;">
                                                        <small>Medium</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="border p-1 text-center" style="height: 30px;">
                                                        <small>Item</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="card-text small">{{ __('Dynamic grid layout for varied content') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- CTA Templates -->
                    <div class="tab-pane fade" id="cta-templates" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 template-card" data-template="cta-basic">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">{{ __('Basic Call to Action') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="template-preview mb-3 p-3 bg-light text-center">
                                            <h5>Ready to Get Started?</h5>
                                            <p class="small mb-3">This is your call-to-action message</p>
                                            <button class="btn btn-sm btn-success">Click Here</button>
                                        </div>
                                        <p class="card-text small">{{ __('Drive conversions with a clear CTA') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 template-card" data-template="split-cta">
                                    <div class="card-header bg-danger text-white">
                                        <h6 class="mb-0">{{ __('Split Call to Action') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="template-preview mb-3 p-3 bg-light">
                                            <div class="row">
                                                <div class="col-4 text-center">
                                                    <i class="fas fa-image fa-2x text-danger"></i>
                                                </div>
                                                <div class="col-8 text-center">
                                                    <h5>Take Action Now</h5>
                                                    <p class="small mb-2">With image and button</p>
                                                    <button class="btn btn-sm btn-danger">Action</button>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="card-text small">{{ __('Visual CTA with compelling imagery') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 template-card" data-template="cta-newsletter">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0">{{ __('Newsletter Signup') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="template-preview mb-3 p-3 bg-light">
                                            <h5 class="mb-2">Stay Updated</h5>
                                            <p class="small mb-2">Sign up for our newsletter</p>
                                            <div class="input-group input-group-sm mb-2">
                                                <input type="text" class="form-control" placeholder="Email address">
                                                <button class="btn btn-primary">Sign Up</button>
                                            </div>
                                        </div>
                                        <p class="card-text small">{{ __('Grow your email list with this form') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Forms & Feedback Templates -->
                    <div class="tab-pane fade" id="form-templates" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 template-card" data-template="form-contact">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0">{{ __('Contact Form') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="template-preview mb-3 p-3 bg-light">
                                            <h5 class="mb-2">Contact Us</h5>
                                            <div class="mb-2">
                                                <input type="text" class="form-control form-control-sm mb-1" placeholder="Name">
                                                <input type="text" class="form-control form-control-sm mb-1" placeholder="Email">
                                                <textarea class="form-control form-control-sm mb-1" rows="2" placeholder="Message"></textarea>
                                                <button class="btn btn-sm btn-info w-100">Send</button>
                                            </div>
                                        </div>
                                        <p class="card-text small">{{ __('Allow visitors to get in touch easily') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 template-card" data-template="feedback-form">
                                    <div class="card-header bg-warning text-dark">
                                        <h6 class="mb-0">{{ __('Feedback Form') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="template-preview mb-3 p-3 bg-light">
                                            <h5 class="mb-2">Your Feedback</h5>
                                            <div class="mb-2 small">
                                                <div class="mb-1">How would you rate us?</div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>⭐</span>
                                                    <span>⭐</span>
                                                    <span>⭐</span>
                                                    <span>⭐</span>
                                                    <span>⭐</span>
                                                </div>
                                                <textarea class="form-control form-control-sm mb-1" rows="1" placeholder="Comments"></textarea>
                                                <button class="btn btn-sm btn-warning w-100">Submit</button>
                                            </div>
                                        </div>
                                        <p class="card-text small">{{ __('Gather valuable user feedback') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 template-card" data-template="booking-form">
                                    <div class="card-header bg-dark text-white">
                                        <h6 class="mb-0">{{ __('Booking Form') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="template-preview mb-3 p-3 bg-light">
                                            <h5 class="mb-2">Book Now</h5>
                                            <div class="mb-2">
                                                <input type="text" class="form-control form-control-sm mb-1" placeholder="Name">
                                                <input type="text" class="form-control form-control-sm mb-1" placeholder="Date">
                                                <select class="form-select form-select-sm mb-1">
                                                    <option>Select time</option>
                                                </select>
                                                <button class="btn btn-sm btn-dark w-100">Book</button>
                                            </div>
                                        </div>
                                        <p class="card-text small">{{ __('Schedule appointments or services') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" id="addSelectedTemplate">{{ __('Add Template') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom Notification Container -->
<div id="notificationContainer" class="notification-container"></div>

<style>
    .notification-container {
        position: fixed;
        top: 20px;
        right: 20px;
        width: 350px;
        max-width: 100%;
        z-index: 10100;
        pointer-events: none;
    }
    
    .notification-container .custom-notification {
        pointer-events: auto;
        position: relative;
        top: 0;
        right: 0;
    }
</style>

<!-- Custom Confirm Dialog -->
<div class="custom-confirm" id="customConfirm">
    <div class="custom-confirm-dialog">
        <div class="custom-confirm-header">
            <div class="custom-confirm-icon warning">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h5 class="custom-confirm-title" id="confirmTitle">Confirm Action</h5>
        </div>
        <div class="custom-confirm-body" id="confirmMessage">
            Are you sure you want to proceed with this action?
        </div>
        <div class="custom-confirm-footer">
            <button type="button" class="btn btn-secondary" id="confirmCancel">Cancel</button>
            <button type="button" class="btn btn-primary" id="confirmOk">Confirm</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/dragula.min.js') }}"></script>
<script src="{{ asset('js/template-implementations.js') }}"></script>
<script>
    $(document).ready(function() {
        // Setup AJAX CSRF token for all requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Initialize variables
        let deletedItems = [];
        let deletedSections = [];
        let selectedTemplate = '';
        
        console.log('Document ready. Initializing builder...');
        
        // Fix modal issues
        fixModalIssues();
        
        // Add double-click event for empty sections
        $(document).on('dblclick', '.components-container:empty', function() {
            const sectionId = $(this).data('section');
            console.log('Double-clicked on empty section:', sectionId);
            
            // Show component picker dialog
            showComponentPicker(sectionId);
        });
        
        // Function to show component picker dialog
        function showComponentPicker(sectionId) {
            // Create modal HTML
            const modalHTML = `
                <div class="modal fade" id="quickComponentModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Component</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Select a component type to add:</p>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-primary quick-add-btn" data-type="text">
                                        <i class="fas fa-paragraph me-2"></i> Text Component
                                    </button>
                                    <button class="btn btn-outline-primary quick-add-btn" data-type="image">
                                        <i class="fas fa-image me-2"></i> Image Component
                                    </button>
                                    <button class="btn btn-outline-primary quick-add-btn" data-type="button">
                                        <i class="fas fa-mouse-pointer me-2"></i> Button Component
                                    </button>
                                    <button class="btn btn-outline-primary quick-add-btn" data-type="form">
                                        <i class="fas fa-wpforms me-2"></i> Form Component
                                    </button>
                                    <button class="btn btn-outline-primary quick-add-btn" data-type="card">
                                        <i class="fas fa-credit-card me-2"></i> Card Component
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove any existing modal
            $('#quickComponentModal').remove();
            
            // Add modal to body
            $('body').append(modalHTML);
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('quickComponentModal'));
            modal.show();
            
            // Handle component selection
            $('.quick-add-btn').click(function() {
                const componentType = $(this).data('type');
                console.log('Selected component type:', componentType);
                
                // Close modal
                modal.hide();
                
                // Add component directly via AJAX
                addComponentToSection(sectionId, componentType);
            });
        }
        
        // Function to add component to section via AJAX
        function addComponentToSection(sectionId, componentType) {
            // Show processing notification
            const notificationId = showNotification('info', 'Adding Component', 'Adding component to section...', 0);
            
            // Send AJAX request
            $.ajax({
                url: '{{ route("admin.layout.addComponent") }}',
                type: 'POST',
                data: {
                    section_id: sectionId,
                    type: componentType,
                    page_id: {{ $page->id }},
                    title: 'New ' + componentType.charAt(0).toUpperCase() + componentType.slice(1)
                },
                success: function(response) {
                    // Remove processing notification
                    $(`#${notificationId}`).remove();
                    
                    if (response.success) {
                        // Add component to DOM
                        $(`.components-container[data-section="${sectionId}"]`).append(response.component.html);
                        
                        // Re-initialize sortable
                        $(`.components-container[data-section="${sectionId}"]`).sortable('refresh');
                        
                        // Show success notification
                        showNotification('success', 'Component Added', 'Component has been added to the section');
                    } else {
                        // Show error notification
                        showNotification('error', 'Error', response.message || 'Error adding component');
                    }
                },
                error: function(xhr) {
                    // Remove processing notification
                    $(`#${notificationId}`).remove();
                    
                    // Show error notification
                    let errorMessage = 'Error adding component';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    showNotification('error', 'Error', errorMessage);
                    console.error('Error adding component:', xhr.responseText);
                }
            });
        }
        
        // Initialize custom notification system
        function showNotification(type, title, message, duration = 5000) {
            // Create notification element
            const notificationId = 'notification-' + Date.now();
            const notification = `
                <div class="custom-notification ${type}" id="${notificationId}">
                    <div class="icon">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
                    </div>
                    <div class="content">
                        <div class="title">${title}</div>
                        <div class="message">${message}</div>
                    </div>
                    <div class="close" onclick="document.getElementById('${notificationId}').remove()">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
            `;
            
            // Add to container
            $('#notificationContainer').append(notification);
            
            // Show with animation
            setTimeout(() => {
                $(`#${notificationId}`).addClass('show');
            }, 10);
            
            // Auto-remove after duration
            if (duration > 0) {
                setTimeout(() => {
                    $(`#${notificationId}`).removeClass('show');
                    setTimeout(() => {
                        $(`#${notificationId}`).remove();
                    }, 300);
                }, duration);
            }
            
            return notificationId;
        }
        
        // Custom confirm dialog
        function showConfirm(title, message, callback) {
            // Set content
            $('#confirmTitle').text(title);
            $('#confirmMessage').text(message);
            
            // Show dialog
            $('#customConfirm').addClass('show');
            
            // Handle buttons
            $('#confirmCancel').off('click').on('click', function() {
                $('#customConfirm').removeClass('show');
            });
            
            $('#confirmOk').off('click').on('click', function() {
                $('#customConfirm').removeClass('show');
                if (typeof callback === 'function') {
                    callback(true);
                }
            });
        }
        
        // Initialize template modal
        $('#openTemplateModal, #emptyPageAddTemplate').click(function(e) {
            e.preventDefault();
            console.log('Opening template modal');
            var templateModal = new bootstrap.Modal(document.getElementById('addTemplateModal'), {
                backdrop: 'static',
                keyboard: false
            });
            templateModal.show();
            // Add interactive backdrop
            $('body').append('<div class="interactive-backdrop"></div>');
        });
        
        // Close modals properly to remove backdrop
        $('.btn-close, .modal button[data-bs-dismiss="modal"]').on('click', function() {
            $('.interactive-backdrop').remove();
        });
        
        // Initialize drag and drop for sections
        function initSortable() {
            console.log('Initializing sortable...');
            try {
                $("#pageBuilder").sortable({
                    items: ".section-container",
                    handle: ".section-handle",
                    placeholder: "section-placeholder",
                    cursor: "move",
                    opacity: 0.7,
                    helper: "clone",
                    appendTo: "body",
                    zIndex: 10100,
                    update: function(event, ui) {
                        // Update section order
                        console.log('Section order updated, saving section positions...');
                        
                        // Get section order
                        let sectionOrder = [];
                        $('.section-container').each(function() {
                            sectionOrder.push($(this).data('section'));
                        });
                        
                        // Show notification
                        const savingNotificationId = showNotification('info', 'Saving Section Order', 'Updating section positions...', 0);
                        
                        // Save section order via AJAX
                        $.ajax({
                            url: '{{ route("admin.layout.saveLayout", $page->id) }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                section_order: sectionOrder,
                                action: 'update_section_order'
                            },
                            success: function(response) {
                                // Remove notification
                                $(`#${savingNotificationId}`).remove();
                                
                                if (response.success) {
                                    showNotification('success', 'Sections Updated', 'Section order has been saved.', 3000);
                                } else {
                                    showNotification('error', 'Update Failed', response.message || 'There was an error saving section order.', 5000);
                                }
                            },
                            error: function(xhr) {
                                // Remove notification
                                $(`#${savingNotificationId}`).remove();
                                
                                showNotification('error', 'Update Failed', 'There was an error saving section order.', 5000);
                                console.error('Error saving section order:', xhr.responseText);
                            }
                        });
                    }
                });
                
                // Initialize sortable for components within each section
                $(".components-container").sortable({
                    items: ".component-container",
                    handle: ".component-handle",
                    placeholder: "component-placeholder",
                    cursor: "move",
                    opacity: 0.7,
                    helper: "clone",
                    appendTo: "body",
                    zIndex: 10100,
                    connectWith: ".components-container",
                    update: function(event, ui) {
                        // Update component order
                        console.log('Component order updated');
                    },
                    // Add a receive callback to detect when an item is added from a draggable
                    receive: function(event, ui) {
                        console.log('Component received in section');
                    }
                });
                
                // Make sidebar components draggable
                $(".component-item").draggable({
                    helper: "clone",
                    appendTo: "body",
                    zIndex: 10100,
                    revert: "invalid",
                    cursor: "move",
                    start: function(event, ui) {
                        console.log('Component drag started');
                        ui.helper.css({
                            width: $(this).width(),
                            height: "auto",
                            zIndex: 10100
                        });
                        
                        // Highlight all drop targets
                        $(".components-container").addClass("drop-highlight");
                    },
                    stop: function(event, ui) {
                        console.log('Component drag stopped');
                        // Remove highlight from all drop targets
                        $(".components-container").removeClass("drop-highlight");
                    }
                });
                
                // Add drop event to components container - using droppable instead of connectToSortable
                $(".components-container").droppable({
                    accept: ".component-item",
                    activeClass: "active-drop-target",
                    hoverClass: "ui-state-highlight",
                    tolerance: "pointer",
                    greedy: true,
                    drop: function(event, ui) {
                        let sectionId = $(this).data('section');
                        let componentType = ui.draggable.data('type');
                        
                        console.log('Dropping component of type:', componentType, 'in section:', sectionId);
                        
                        // Add the new component to the section
                        $(this).append(
                            createComponentHtml({
                                id: 'new-' + Date.now(),
                                title: 'New ' + componentType.charAt(0).toUpperCase() + componentType.slice(1),
                                type: componentType,
                                section: sectionId
                            })
                        );
                        
                        // Re-initialize sorting on the section that just received a component
                        $(this).sortable("refresh");
                        
                        // Show success notification
                        showNotification('success', 'Component Added', 'Component has been added to the section. Remember to save your changes.');
                    }
                });
                console.log('Sortable initialization complete');
            } catch (error) {
                console.error('Error initializing sortable:', error);
                showNotification('error', 'Initialization Error', 'Error initializing drag and drop functionality: ' + error.message);
            }
        }
        
        // Fix modal interaction issues
        function fixModalIssues() {
            // Override Bootstrap's modal backdrop behavior
            $(document).on('show.bs.modal', '.modal', function () {
                $(this).appendTo('body');
                if ($('.modal-backdrop').length === 0) {
                    $('body').append('<div class="modal-backdrop show"></div>');
                }
                $('body').addClass('modal-open');
            });
            
            $(document).on('hide.bs.modal', '.modal', function () {
                $('.modal-backdrop').remove();
                $('.interactive-backdrop').remove();
                if ($('.modal.show').length === 0) {
                    $('body').removeClass('modal-open');
                }
            });
            
            // Set pointer-events on the content to allow interaction
            $('.modal-content').css('pointer-events', 'auto');
            
            // Make sure jQuery UI elements are above modals when dragging
            $.ui.dialog.prototype._moveToTop = function(event, silent) {
                var moved = !!this.uiDialog.nextAll(":visible").insertBefore(this.uiDialog).length;
                if (moved && !silent) {
                    this._trigger("focus", event);
                }
                return moved;
            };
        }
        
        // Initialize sortable on page load
        initSortable();
        
        // Template card selection
        $('.template-card').click(function() {
            $('.template-card').removeClass('border-primary');
            $(this).addClass('border-primary');
            selectedTemplate = $(this).data('template');
            console.log('Selected template:', selectedTemplate);
        });
        
        // Add selected template
        $('#addSelectedTemplate').click(function() {
            if (!selectedTemplate) {
                showNotification('warning', 'Action Required', 'Please select a template first.');
                return;
            }
            
            // Close the modal
            var addTemplateModal = bootstrap.Modal.getInstance(document.getElementById('addTemplateModal'));
            if (addTemplateModal) {
                addTemplateModal.hide();
            }
            
            console.log('Adding selected template:', selectedTemplate);
            
            // Show saving notification
            const processingNotificationId = showNotification('info', 'Processing Template', 'Adding template to layout...', 3000);
            
            // Create appropriate section based on template type
            if (selectedTemplate === 'hero-basic') {
                let sectionId = 'hero-' + Date.now();
                $("#pageBuilder").prepend(
                    createSectionHtml({
                        title: 'Hero Banner',
                        identifier: sectionId,
                        type: 'hero'
                    })
                );
                
                // Add text component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Hero Text',
                        type: 'text',
                        section: sectionId,
                        content: '<h1 class="display-4">Welcome to Our Site</h1><p class="lead">This is a simple hero unit, a simple component for calling attention to featured content.</p>'
                    })
                );
                
                // Add button component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'Hero Button',
                        type: 'button',
                        section: sectionId
                    })
                );
            } else if (selectedTemplate === 'hero-split') {
                let sectionId = 'hero-split-' + Date.now();
                $("#pageBuilder").prepend(
                    createSectionHtml({
                        title: 'Split Hero',
                        identifier: sectionId,
                        type: 'hero'
                    })
                );
                
                // Add image component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Hero Image',
                        type: 'image',
                        section: sectionId
                    })
                );
                
                // Add text component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'Hero Text',
                        type: 'text',
                        section: sectionId,
                        content: '<h2>Split Hero Section</h2><p>This is a section with image and text side by side.</p>'
                    })
                );
                
                // Add button component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 2),
                        title: 'Hero Button',
                        type: 'button',
                        section: sectionId
                    })
                );
            } else if (selectedTemplate === 'hero-video') {
                let sectionId = 'hero-video-' + Date.now();
                $("#pageBuilder").prepend(
                    createSectionHtml({
                        title: 'Video Hero',
                        identifier: sectionId,
                        type: 'hero'
                    })
                );
                
                // Add video component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Hero Video',
                        type: 'video',
                        section: sectionId
                    })
                );
                
                // Add text overlay
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'Video Overlay',
                        type: 'text',
                        section: sectionId,
                        content: '<h2 class="text-light">Video Background</h2><p class="text-light">Text overlay on video background.</p>'
                    })
                );
            } else if (selectedTemplate === 'content-image-text') {
                let sectionId = 'content-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Image & Text',
                        identifier: sectionId,
                        type: 'content'
                    })
                );
                
                // Add image component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Content Image',
                        type: 'image',
                        section: sectionId
                    })
                );
                
                // Add text component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'Content Text',
                        type: 'text',
                        section: sectionId,
                        content: '<h3>Image with Text</h3><p>This is text content that appears alongside an image.</p>'
                    })
                );
            } else if (selectedTemplate === 'content-rich-text') {
                let sectionId = 'content-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Rich Text',
                        identifier: sectionId,
                        type: 'content'
                    })
                );
                
                // Add rich text component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Rich Text Content',
                        type: 'text',
                        section: sectionId,
                        content: '<h3>Rich Text Heading</h3><p>This is a paragraph of text that demonstrates rich text formatting.</p><ul><li>First list item with important information</li><li>Second list item with additional details</li><li>Third list item concluding the points</li></ul><p>Additional paragraph with <strong>bold text</strong> and <em>italic text</em> for emphasis.</p>'
                    })
                );
            } else if (selectedTemplate === 'content-quote') {
                let sectionId = 'content-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Testimonial',
                        identifier: sectionId,
                        type: 'content'
                    })
                );
                
                // Add quote component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Quote/Testimonial',
                        type: 'text',
                        section: sectionId,
                        content: '<blockquote class="blockquote"><p>"This is a testimonial quote that provides feedback or an important statement."</p><footer class="blockquote-footer">John Smith, <cite title="Source">Company Name</cite></footer></blockquote>'
                    })
                );
            } else if (selectedTemplate === 'grid-3-col') {
                let sectionId = 'grid-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: '3-Column Grid',
                        identifier: sectionId,
                        type: 'columns-3'
                    })
                );
                
                // Add heading
                    $(`.components-container[data-section="${sectionId}"]`).append(
                        createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Grid Heading',
                            type: 'text',
                        column_width: 12,
                            section: sectionId,
                        content: '<h2 class="text-center mb-4">Three Column Grid</h2>'
                    })
                );
                
                // Add column 1
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'Column 1',
                        type: 'card',
                        column_width: 4,
                        section: sectionId
                    })
                );
                
                // Add column 2
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 2),
                        title: 'Column 2',
                        type: 'card',
                        column_width: 4,
                        section: sectionId
                    })
                );
                
                // Add column 3
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 3),
                        title: 'Column 3',
                        type: 'card',
                        column_width: 4,
                        section: sectionId
                    })
                );
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            } else if (selectedTemplate === 'grid-features') {
                let sectionId = 'features-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Feature Grid',
                        identifier: sectionId,
                        type: 'grid'
                    })
                );
                
                // Add feature components
                for (let i = 0; i < 4; i++) {
                    $(`.components-container[data-section="${sectionId}"]`).append(
                        createComponentHtml({
                            id: 'new-' + (Date.now() + i),
                            title: 'Feature ' + (i + 1),
                            type: 'text',
                            section: sectionId,
                            content: '<div class="d-flex align-items-start"><i class="fas fa-check-circle text-success me-2 mt-1"></i><div><h5>Feature ' + (i + 1) + '</h5><p>Description of feature ' + (i + 1) + ' and its benefits.</p></div></div>'
                        })
                    );
                }
            } else if (selectedTemplate === 'masonry-grid') {
                let sectionId = 'masonry-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Masonry Grid',
                        identifier: sectionId,
                        type: 'masonry'
                    })
                );
                
                // Use the template implementation function instead of inline code
                if (typeof addMasonryGridTemplate === 'function') {
                    addMasonryGridTemplate(sectionId);
                } else {
                    // Fallback to basic implementation if function not available
                    $(`.components-container[data-section="${sectionId}"]`).append(
                        createComponentHtml({
                            id: 'new-' + Date.now(),
                            title: 'Masonry Heading',
                            type: 'text',
                            section: sectionId,
                            content: '<h2 class="text-center mb-4">Masonry Grid Layout</h2>'
                        })
                    );
                }
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            } else if (selectedTemplate === 'feature-cards') {
                let sectionId = 'feature-cards-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Feature Cards',
                        identifier: sectionId,
                        type: 'columns-3'
                    })
                );
                
                // Use the template implementation function
                if (typeof addFeatureCardsTemplate === 'function') {
                    addFeatureCardsTemplate(sectionId);
                } else {
                    // Fallback implementation
                    $(`.components-container[data-section="${sectionId}"]`).append(
                        createComponentHtml({
                            id: 'new-' + Date.now(),
                            title: 'Features Heading',
                            type: 'text',
                            column_width: 12,
                            section: sectionId,
                            content: '<h2 class="text-center mb-4">Key Features</h2><p class="text-center mb-5">Explore the key features that make our product/service unique.</p>'
                        })
                    );
                }
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            } else if (selectedTemplate === 'cta-basic') {
                let sectionId = 'cta-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Call to Action',
                        identifier: sectionId,
                        type: 'cta'
                    })
                );
                
                // Add heading
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'CTA Heading',
                        type: 'text',
                        section: sectionId,
                        content: '<h2 class="text-center">Ready to Get Started?</h2><p class="text-center">Join thousands of satisfied customers today</p>'
                    })
                );
                
                // Add button
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'CTA Button',
                        type: 'button',
                        section: sectionId
                    })
                );
            } else if (selectedTemplate === 'cta-newsletter') {
                let sectionId = 'newsletter-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Newsletter Signup',
                        identifier: sectionId,
                        type: 'cta'
                    })
                );
                
                // Add heading
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Newsletter Heading',
                        type: 'text',
                        section: sectionId,
                        content: '<h3 class="text-center">Stay Updated</h3><p class="text-center">Sign up for our newsletter to receive the latest updates</p>'
                    })
                );
                
                // Add form component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'Newsletter Form',
                        type: 'form',
                        section: sectionId
                    })
                );
            } else if (selectedTemplate === 'form-contact') {
                let sectionId = 'contact-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Contact Form',
                        identifier: sectionId,
                        type: 'form'
                    })
                );
                
                // Add heading
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Contact Form Heading',
                        type: 'text',
                        section: sectionId,
                        content: '<h3>Contact Us</h3><p>Fill out the form below to get in touch with our team</p>'
                    })
                );
                
                // Add form component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'Contact Form',
                        type: 'form',
                        section: sectionId
                    })
                );
            } else if (selectedTemplate === 'team-members') {
                let sectionId = 'team-section-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Our Team',
                        identifier: sectionId,
                        type: 'columns-3'
                    })
                );
                
                // Add heading
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Team Heading',
                        type: 'text',
                        column_width: 12,
                        section: sectionId,
                        content: '<h2 class="text-center mb-5">Meet Our Team</h2>'
                    })
                );
                
                // Add team members
                for (let i = 1; i <= 3; i++) {
                    $(`.components-container[data-section="${sectionId}"]`).append(
                        createComponentHtml({
                            id: 'new-' + (Date.now() + i),
                            title: 'Team Member ' + i,
                            type: 'card',
                            column_width: 4,
                            section: sectionId,
                            content: `<div class="text-center"><img src="https://via.placeholder.com/300x300" class="rounded-circle mb-3" width="150" height="150" alt="Team Member"><h4>Team Member ${i}</h4><p class="text-muted">Position</p><p>Brief description about this team member.</p></div>`
                        })
                    );
                }
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            } else if (selectedTemplate === 'faq-accordion') {
                let sectionId = 'faq-section-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'FAQ Section',
                        identifier: sectionId,
                        type: 'content'
                    })
                );
                
                // Add heading
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'FAQ Heading',
                        type: 'text',
                        section: sectionId,
                        content: '<h2 class="text-center mb-5">Frequently Asked Questions</h2>'
                    })
                );
                
                // Add accordion content
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'FAQ Accordion',
                        type: 'text',
                        section: sectionId,
                        content: `<div class="accordion" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne">Question 1?</button>
                                </h2>
                                <div id="faqOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">Answer to question 1 goes here.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo">Question 2?</button>
                                </h2>
                                <div id="faqTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">Answer to question 2 goes here.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThree">Question 3?</button>
                                </h2>
                                <div id="faqThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">Answer to question 3 goes here.</div>
                                </div>
                            </div>
                        </div>`
                    })
                );
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            } else if (selectedTemplate === 'feature-cards') {
                let sectionId = 'feature-cards-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Feature Cards',
                        identifier: sectionId,
                        type: 'columns-3'
                    })
                );
                
                // Add heading
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Features Heading',
                        type: 'text',
                        column_width: 12,
                        section: sectionId,
                        content: '<h2 class="text-center mb-4">Key Features</h2><p class="text-center mb-5">Explore the key features that make our product/service unique.</p>'
                    })
                );
                
                // Add feature card 1
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'Fast Performance',
                        type: 'card',
                        column_width: 4,
                        section: sectionId,
                        content: '<div class="text-center p-4"><div class="feature-icon mb-3"><i class="fas fa-rocket fa-3x text-primary"></i></div><h4>Fast Performance</h4><p>This is a brief description of the feature and how it benefits your users.</p></div>'
                    })
                );
                
                // Add feature card 2
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 2),
                        title: 'Secure & Safe',
                        type: 'card',
                        column_width: 4,
                        section: sectionId,
                        content: '<div class="text-center p-4"><div class="feature-icon mb-3"><i class="fas fa-shield-alt fa-3x text-primary"></i></div><h4>Secure & Safe</h4><p>This is a brief description of the feature and how it benefits your users.</p></div>'
                    })
                );
                
                // Add feature card 3
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 3),
                        title: 'Easy to Customize',
                        type: 'card',
                        column_width: 4,
                        section: sectionId,
                        content: '<div class="text-center p-4"><div class="feature-icon mb-3"><i class="fas fa-cog fa-3x text-primary"></i></div><h4>Easy to Customize</h4><p>This is a brief description of the feature and how it benefits your users.</p></div>'
                    })
                );
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            } else if (selectedTemplate === 'cta-banner') {
                let sectionId = 'cta-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Call to Action',
                        identifier: sectionId,
                        type: 'cta',
                        background_color: '#f8f9fa'
                    })
                );
                
                // Add CTA content
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'CTA Content',
                        type: 'text',
                        section: sectionId,
                        content: '<div class="py-5 text-center"><h2 class="mb-3">Ready to Get Started?</h2><p class="lead mb-4">Join thousands of satisfied customers who have already taken the next step.</p><div class="d-grid gap-2 d-sm-flex justify-content-sm-center"><button type="button" class="btn btn-primary btn-lg px-4 gap-3">Get Started</button><button type="button" class="btn btn-outline-secondary btn-lg px-4">Learn More</button></div></div>'
                    })
                );
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            } else if (selectedTemplate === 'contact-form') {
                let sectionId = 'contact-section-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Contact Us',
                        identifier: sectionId,
                        type: 'content'
                    })
                );
                
                // Add heading component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Contact Form Heading',
                        type: 'text',
                        section: sectionId,
                        content: '<h3>Contact Us</h3><p>Fill out the form below to get in touch with our team</p>'
                    })
                );
                
                // Add form component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'Contact Form',
                        type: 'form',
                        section: sectionId
                    })
                );
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            } else if (selectedTemplate === 'team-members') {
                let sectionId = 'team-section-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Our Team',
                        identifier: sectionId,
                        type: 'columns-3'
                    })
                );
                
                // Add heading
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Team Heading',
                        type: 'text',
                        column_width: 12,
                        section: sectionId,
                        content: '<h2 class="text-center mb-5">Meet Our Team</h2>'
                    })
                );
                
                // Add team members
                for (let i = 1; i <= 3; i++) {
                    $(`.components-container[data-section="${sectionId}"]`).append(
                        createComponentHtml({
                            id: 'new-' + (Date.now() + i),
                            title: 'Team Member ' + i,
                            type: 'card',
                            column_width: 4,
                            section: sectionId,
                            content: `<div class="text-center"><img src="https://via.placeholder.com/300x300" class="rounded-circle mb-3" width="150" height="150" alt="Team Member"><h4>Team Member ${i}</h4><p class="text-muted">Position</p><p>Brief description about this team member.</p></div>`
                        })
                    );
                }
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            } else if (selectedTemplate === 'faq-accordion') {
                let sectionId = 'faq-section-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'FAQ Section',
                        identifier: sectionId,
                        type: 'content'
                    })
                );
                
                // Add heading
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'FAQ Heading',
                        type: 'text',
                        section: sectionId,
                        content: '<h2 class="text-center mb-5">Frequently Asked Questions</h2>'
                    })
                );
                
                // Add accordion content
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'FAQ Accordion',
                        type: 'text',
                        section: sectionId,
                        content: `<div class="accordion" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne">Question 1?</button>
                                </h2>
                                <div id="faqOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">Answer to question 1 goes here.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo">Question 2?</button>
                                </h2>
                                <div id="faqTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">Answer to question 2 goes here.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThree">Question 3?</button>
                                </h2>
                                <div id="faqThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">Answer to question 3 goes here.</div>
                                </div>
                            </div>
                        </div>`
                    })
                );
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            } else if (selectedTemplate === 'split-cta') {
                let sectionId = 'split-cta-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Split Call to Action',
                        identifier: sectionId,
                        type: 'columns-2'
                    })
                );
                
                // Use the template implementation function
                if (typeof addSplitCtaTemplate === 'function') {
                    addSplitCtaTemplate(sectionId);
                } else {
                    // Fallback implementation
                    $(`.components-container[data-section="${sectionId}"]`).append(
                        createComponentHtml({
                            id: 'new-' + Date.now(),
                            title: 'Split CTA Content',
                            type: 'text',
                            section: sectionId,
                            content: '<div class="row align-items-center"><div class="col-md-6"><h2>Call to Action</h2><p>This is a split call to action section with text and buttons.</p></div><div class="col-md-6 text-end"><button class="btn btn-primary">Get Started</button></div></div>'
                        })
                    );
                }
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            } else if (selectedTemplate === 'feedback-form') {
                let sectionId = 'feedback-form-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Feedback Form',
                        identifier: sectionId,
                        type: 'content'
                    })
                );
                
                // Use the template implementation function
                if (typeof addFeedbackFormTemplate === 'function') {
                    addFeedbackFormTemplate(sectionId);
                } else {
                    // Fallback implementation
                    $(`.components-container[data-section="${sectionId}"]`).append(
                        createComponentHtml({
                            id: 'new-' + Date.now(),
                            title: 'Feedback Form Heading',
                            type: 'text',
                            section: sectionId,
                            content: '<h2 class="text-center">Feedback Form</h2>'
                        })
                    );
                    
                    $(`.components-container[data-section="${sectionId}"]`).append(
                        createComponentHtml({
                            id: 'new-' + (Date.now() + 1),
                            title: 'Feedback Form',
                            type: 'form',
                            section: sectionId
                        })
                    );
                }
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            } else if (selectedTemplate === 'booking-form') {
                let sectionId = 'booking-form-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Booking Form',
                        identifier: sectionId,
                        type: 'content'
                    })
                );
                
                // Use the template implementation function
                if (typeof addBookingFormTemplate === 'function') {
                    addBookingFormTemplate(sectionId);
                } else {
                    // Fallback implementation
                    $(`.components-container[data-section="${sectionId}"]`).append(
                        createComponentHtml({
                            id: 'new-' + Date.now(),
                            title: 'Booking Form Heading',
                            type: 'text',
                            section: sectionId,
                            content: '<h2 class="text-center">Booking Form</h2>'
                        })
                    );
                    
                    $(`.components-container[data-section="${sectionId}"]`).append(
                        createComponentHtml({
                            id: 'new-' + (Date.now() + 1),
                            title: 'Booking Form',
                            type: 'form',
                            section: sectionId
                        })
                    );
                }
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            }
            
            // Reset selection
            selectedTemplate = '';
            $('.template-card').removeClass('border-primary');
            
            // Reinitialize sortable
            initSortable();
            
            // Show notification
            showNotification('success', 'Template Added', 'Template has been added to your page. Remember to save your changes.');
        });
        
        // Create HTML for a new component
        function createComponentHtml(component) {
            // Get optional attributes
            const columnWidth = component.column_width || '';
            const template = component.template || '';
            const templateIdentifier = component.template_identifier || '';
            const metaData = component.meta_data || {};
            
            // Create data attributes string
            let dataAttrs = `data-id="${component.id}" data-type="${component.type}" data-section="${component.section || ''}"`;
            
            // Add column width if specified
            if (columnWidth) {
                dataAttrs += ` data-column-width="${columnWidth}"`;
            }
            
            // Add template if specified
            if (template) {
                dataAttrs += ` data-template="${template}"`;
            }
            
            // Add template identifier for new template system
            if (templateIdentifier) {
                dataAttrs += ` data-template-identifier="${templateIdentifier}"`;
            }
            
            // Add meta data attributes
            if (metaData && Object.keys(metaData).length > 0) {
                for (const [key, value] of Object.entries(metaData)) {
                    if (typeof value !== 'object' && typeof value !== 'function') {
                        dataAttrs += ` data-meta-${key}="${value}"`;
                    }
                }
            }
            
            return `
                <div class="component-container" ${dataAttrs}>
                    <div class="component-handle">
                        <span>${component.title} (${component.type.charAt(0).toUpperCase() + component.type.slice(1)})</span>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary component-settings" data-id="${component.id}">
                                <i class="fas fa-cog"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-component">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="component-preview">
                        <div class="p-2">
                            ${component.type.charAt(0).toUpperCase() + component.type.slice(1)} Component
                            ${columnWidth ? `<span class="badge bg-secondary ms-2">Width: ${columnWidth}</span>` : ''}
                            ${templateIdentifier ? `<span class="badge bg-success ms-2">Template: ${templateIdentifier}</span>` : ''}
                        </div>
                    </div>
                </div>
            `;
        }
        
        // Create HTML for a new section
        function createSectionHtml(section) {
            // Format section type for display
            let typeLabel = '';
            if (section.type) {
                if (section.type.startsWith('columns-')) {
                    const numCols = section.type.split('-')[1];
                    typeLabel = `${numCols}-Column Layout`;
                } else {
                    typeLabel = section.type.charAt(0).toUpperCase() + section.type.slice(1);
                }
            }
            
            return `
                <div class="section-container" data-section="${section.identifier}" data-type="${section.type || 'content'}">
                    <div class="section-handle">
                        <span>${section.title} Section</span>
                        ${typeLabel ? `<span class="badge bg-info ms-2">${typeLabel}</span>` : ''}
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary section-settings" data-section="${section.identifier}">
                                <i class="fas fa-cog"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-section">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="components-container" data-section="${section.identifier}">
                        <!-- Components will be added here -->
                    </div>
                </div>
            `;
        }
        
        // Add new section button
        $('#addSection').click(function(e) {
            e.preventDefault();
            console.log('Opening section modal');
            var addSectionModal = new bootstrap.Modal(document.getElementById('addSectionModal'), {
                backdrop: 'static',
                keyboard: false
            });
            addSectionModal.show();
        });
        
        // Confirm add section
        $('#confirmAddSection').click(function() {
            let title = $('#sectionTitle').val();
            let identifier = $('#sectionIdentifier').val();
            let type = $('#sectionType').val();
            
            if (!title) {
                showNotification('warning', 'Action Required', 'Please enter a section title.');
                return;
            }
            
            // Generate identifier if not provided
            if (!identifier) {
                identifier = 'section-' + Date.now();
            }
            
            // Create section HTML
            let sectionHtml = createSectionHtml({
                title: title,
                identifier: identifier,
                type: type
            });
            
            // Add the new section
            let newSection = $(sectionHtml);
            $('#pageBuilder').append(newSection);
            
            // For column-based layouts, add column components
            if (type.startsWith('columns-')) {
                const numColumns = parseInt(type.split('-')[1]);
                const columnWidth = 12 / numColumns; // Bootstrap grid
                
                console.log(`Creating ${numColumns} columns with width ${columnWidth}`);
                
                // Add columns
                for (let i = 0; i < numColumns; i++) {
                    let colId = 'new-col-' + Date.now() + '-' + i;
                    let colHtml = createComponentHtml({
                        id: colId,
                        title: 'Column ' + (i + 1),
                        type: 'column',
                        section: identifier,
                        column_width: columnWidth
                    });
                    
                    // Add column to section
                    newSection.find('.components-container').append(colHtml);
                }
                
                showNotification('success', 'Columns Added', `Added ${numColumns} columns to the section.`);
            }
            
            // Reset form and close modal
            $('#sectionTitle').val('');
            $('#sectionIdentifier').val('');
            $('#sectionType').val('content');
            
            // Close the modal using Bootstrap 5
            var sectionModal = bootstrap.Modal.getInstance(document.getElementById('addSectionModal'));
            if (sectionModal) {
                sectionModal.hide();
            }
            
            // Reinitialize sortable
            initSortable();
        });
        
        // Section settings button
        $(document).on('click', '.section-settings', function() {
            let sectionId = $(this).data('section');
            
            // Check if section exists in database
            $.ajax({
                url: '{{ route("admin.layout.saveLayout", $page->id) }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    action: 'check_section',
                    section_identifier: sectionId
                },
                success: function(response) {
                    if (response.section_id) {
                        // Section exists, redirect to settings page
                        window.location.href = '{{ url("admin/layout/section-settings") }}/' + response.section_id;
                    } else {
                        // Section doesn't exist, save layout first
                        showNotification('warning', 'Action Required', 'Please save the layout first to configure this section.', 8000);
                    }
                },
                error: function(xhr) {
                    console.error('Error checking section:', xhr);
                    showNotification('error', 'Error', 'Error checking section: ' + xhr.statusText);
                }
            });
        });
        
        // Component settings button
        $(document).on('click', '.component-settings', function() {
            let id = $(this).data('id');
            
            // If this is a new component, save the layout first
            if (id.toString().startsWith('new-')) {
                showNotification('warning', 'Action Required', 'Please save the layout first to configure this component.', 8000);
                return;
            }
            
            window.location.href = '{{ url("admin/layout/component-settings") }}/' + id;
        });
        
        // Remove section button
        $(document).on('click', '.remove-section', function() {
            let section = $(this).closest('.section-container');
            
            showConfirm('Remove Section', 'Are you sure you want to remove this section and all its components?', function(confirmed) {
                if (confirmed) {
                    // Add any existing components to deleted items
                    section.find('.component-container[data-id]').each(function() {
                        let id = $(this).data('id');
                        if (!id.toString().startsWith('new-')) {
                            deletedItems.push(id);
                        }
                    });
                    
                    // Get section identifier
                    let sectionId = section.data('section');
                    
                    // Add to deleted sections
                    deletedSections.push(sectionId);
                    
                    // Remove the section
                    section.remove();
                    
                    // Show notification
                    showNotification('success', 'Section Removed', 'Section has been removed. Remember to save your changes.', 5000);
                }
            });
        });
        
        // Remove component button
        $(document).on('click', '.remove-component', function() {
            let component = $(this).closest('.component-container');
            let componentTitle = component.find('.component-handle span').text();
            
            showConfirm('Remove Component', `Are you sure you want to remove "${componentTitle}"?`, function(confirmed) {
                if (confirmed) {
                    let id = component.data('id');
                    
                    // Add to deleted items if it's an existing component
                    if (!id.toString().startsWith('new-')) {
                        deletedItems.push(id);
                    }
                    
                    // Remove the component
                    component.remove();
                    
                    // Show notification
                    showNotification('success', 'Component Removed', 'Component has been removed. Remember to save your changes.', 5000);
                }
            });
        });
        
        // Function to save layout programmatically
        function saveLayout() {
            let layout = [];
            let sectionOrder = [];
            
            // Process each section and its components
            $('.section-container').each(function(sectionIndex) {
                let sectionId = $(this).data('section');
                let sectionType = $(this).data('type') || 'content';
                
                // Add to section order array
                sectionOrder.push(sectionId);
                
                // Process components in this section
                $(this).find('.component-container').each(function(componentIndex) {
                    let componentId = $(this).data('id');
                    let componentType = $(this).data('type');
                    let componentTitle = $(this).find('.component-handle span').text().split(' (')[0];
                    let templateValue = $(this).data('template') || '';
                    let columnWidth = $(this).data('column-width') || '';
                    
                    let component = {
                        section: sectionId,
                        order: componentIndex,
                        type: componentType,
                        section_type: sectionType,
                        template: templateValue,
                        column_width: columnWidth,
                        template_identifier: $(this).data('template-identifier') || null
                    };
                    
                    // Add component ID if it's an existing component
                    if (!componentId.toString().startsWith('new-')) {
                        component.id = componentId;
                    } else {
                        // For new components, add a title
                        component.title = componentTitle;
                    }
                    
                    // Add any additional metadata from data attributes
                    const metaData = {};
                    $.each($(this).data(), function(key, value) {
                        // Skip standard properties already included
                        if (!['id', 'type', 'section', 'template', 'columnWidth'].includes(key) && 
                            typeof value !== 'object' && typeof value !== 'function') {
                            metaData[key] = value;
                        }
                    });
                    
                    if (Object.keys(metaData).length > 0) {
                        component.meta_data = metaData;
                    }
                    
                    layout.push(component);
                });
            });
            
            // Show saving notification
            const savingNotificationId = showNotification('info', 'Saving Layout', 'Saving your page layout...', 0);
            
            // Send the layout to the server
            $.ajax({
                url: '{{ route("admin.layout.saveLayout", $page->id) }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    _token: '{{ csrf_token() }}',
                    layout: layout,
                    deleted_items: deletedItems,
                    section_order: sectionOrder,
                    deleted_sections: $('.section-container').length === 0 ? true : false,
                    deleted_section_ids: deletedSections
                },
                dataType: 'json',
                success: function(response) {
                    // Remove saving notification
                    $(`#${savingNotificationId}`).remove();
                    
                    if (response.success) {
                        // Show success message
                        showNotification('success', 'Layout Saved', 'Your page layout has been saved successfully!');
                        
                        // Reset deleted items and sections
                        deletedItems = [];
                        deletedSections = [];
                        
                        // Reload the page to refresh component IDs
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    } else {
                        // Show error message
                        showNotification('error', 'Save Failed', response.message || 'There was an error saving your layout.');
                    }
                },
                error: function(xhr, status, error) {
                    // Remove saving notification
                    $(`#${savingNotificationId}`).remove();
                    
                    // Show error message with details if available
                    let errorMessage = 'There was an error saving your layout.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ' ' + xhr.responseJSON.message;
                    } else if (error) {
                        errorMessage += ' Error: ' + error;
                    }
                    
                    showNotification('error', 'Save Failed', errorMessage);
                    console.error('Error saving layout:', xhr.responseText);
                }
            });
        }
        
        // Add template to page
        function addTemplateToPage(selectedTemplate) {
            console.log("Adding template:", selectedTemplate);
            
            // Close modal
            $('#addTemplateModal').modal('hide');
            
            // Handle different template types
            if (selectedTemplate === 'hero-centered') {
                let sectionId = 'hero-centered-' + Date.now();
                $("#pageBuilder").prepend(
                    createSectionHtml({
                        title: 'Hero Section',
                        identifier: sectionId,
                        type: 'hero'
                    })
                );
                
                // Add image component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Hero Image',
                        type: 'image',
                        section: sectionId
                    })
                );
                
                // Add text component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'Hero Text',
                        type: 'text',
                        section: sectionId,
                        content: '<h1 class="display-4">Welcome to Our Site</h1><p class="lead">This is a simple hero unit, a simple component for calling attention to featured content.</p>'
                    })
                );
                
                // Add button component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 2),
                        title: 'Hero Button',
                        type: 'button',
                        section: sectionId
                    })
                );
                
                // Save layout after adding template
                setTimeout(function() {
                    saveLayout();
                }, 500);
            } 
            // Hero Split Layout
            else if (selectedTemplate === 'hero-split') {
                let sectionId = 'hero-split-' + Date.now();
                $("#pageBuilder").prepend(
                    createSectionHtml({
                        title: 'Split Hero Section',
                        identifier: sectionId,
                        type: 'columns-2'
                    })
                );
                
                // Add image component to first column
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Hero Image',
                        type: 'image',
                        section: sectionId,
                        column_width: 6
                    })
                );
                
                // Add text component to second column
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'Hero Text',
                        type: 'text',
                        section: sectionId,
                        column_width: 6,
                        content: '<h1 class="display-4">Split Hero Layout</h1><p class="lead">This layout gives equal focus to visuals and text content.</p><button class="btn btn-primary">Learn More</button>'
                    })
                );
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            }
            // Video Background Hero
            else if (selectedTemplate === 'hero-video') {
                let sectionId = 'hero-video-' + Date.now();
                $("#pageBuilder").prepend(
                    createSectionHtml({
                        title: 'Video Hero Section',
                        identifier: sectionId,
                        type: 'hero'
                    })
                );
                
                // Add video component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Background Video',
                        type: 'video',
                        section: sectionId
                    })
                );
                
                // Add text overlay
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'Video Overlay Text',
                        type: 'text',
                        section: sectionId,
                        content: '<h1 class="display-4 text-white">Video Background</h1><p class="lead text-white">Engaging motion background for maximum impact.</p>'
                    })
                );
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            }
            // Content with Image
            else if (selectedTemplate === 'content-image-text') {
                let sectionId = 'content-img-text-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Content With Image',
                        identifier: sectionId,
                        type: 'content'
                    })
                );
                
                // Add title component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Section Heading',
                        type: 'text',
                        section: sectionId,
                        content: '<h2>Image with Text Section</h2>'
                    })
                );
                
                // Add content with image
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'Content with Image',
                        type: 'text',
                        section: sectionId,
                        content: '<div class="row align-items-center"><div class="col-md-4"><img src="https://via.placeholder.com/400x300" class="img-fluid rounded" alt="Image"></div><div class="col-md-8"><h3>Feature Title</h3><p>This is a sample text that would go alongside the image. You can edit this content to add your own description.</p></div></div>'
                    })
                );
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            }
            // Rich Text Content
            else if (selectedTemplate === 'content-rich-text') {
                let sectionId = 'rich-text-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Rich Text Content',
                        identifier: sectionId,
                        type: 'content'
                    })
                );
                
                // Add rich text component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Rich Text Content',
                        type: 'text',
                        section: sectionId,
                        content: '<h2>Rich Text Heading</h2><p>This is a paragraph of content with <strong>formatted text</strong> and <em>styling</em>.</p><ul><li>First list item with information</li><li>Second list item with details</li><li>Third list item with examples</li></ul><p>Additional paragraph with more information below the list.</p>'
                    })
                );
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            }
            // Quote/Testimonial
            else if (selectedTemplate === 'content-quote') {
                let sectionId = 'quote-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Testimonial Section',
                        identifier: sectionId,
                        type: 'content'
                    })
                );
                
                // Add quote component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Testimonial Quote',
                        type: 'text',
                        section: sectionId,
                        content: '<div class="card border-0 shadow-sm"><div class="card-body text-center p-4"><i class="fas fa-quote-left fa-2x text-muted mb-3"></i><p class="lead font-italic">"This is a testimonial quote that highlights the quality of your products or services. It should be impactful and authentic."</p><div class="d-flex justify-content-center align-items-center mt-3"><div class="me-3"><img src="https://via.placeholder.com/60x60" class="rounded-circle" alt="Customer"></div><div class="text-start"><h5 class="mb-1">John Smith</h5><p class="small text-muted mb-0">CEO, Company Name</p></div></div></div></div>'
                    })
                );
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            }
            // 3 Column Grid
            else if (selectedTemplate === 'grid-3-col') {
                let sectionId = 'grid-3-col-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: '3 Column Grid',
                        identifier: sectionId,
                        type: 'columns-3'
                    })
                );
                
                // Add heading
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Grid Heading',
                        type: 'text',
                        column_width: 12,
                        section: sectionId,
                        content: '<h2 class="text-center mb-4">Three Column Grid</h2>'
                    })
                );
                
                // Add column 1
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'Column 1',
                        type: 'card',
                        column_width: 4,
                        section: sectionId
                    })
                );
                
                // Add column 2
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 2),
                        title: 'Column 2',
                        type: 'card',
                        column_width: 4,
                        section: sectionId
                    })
                );
                
                // Add column 3
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 3),
                        title: 'Column 3',
                        type: 'card',
                        column_width: 4,
                        section: sectionId
                    })
                );
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            }
            // 4 Column Grid
            else if (selectedTemplate === 'grid-4-col') {
                let sectionId = 'grid-4-col-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: '4 Column Grid',
                        identifier: sectionId,
                        type: 'columns-4'
                    })
                );
                
                // Add heading
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Grid Heading',
                        type: 'text',
                        column_width: 12,
                        section: sectionId,
                        content: '<h2 class="text-center mb-4">Four Column Grid</h2>'
                    })
                );
                
                // Add columns
                for (let i = 1; i <= 4; i++) {
                    $(`.components-container[data-section="${sectionId}"]`).append(
                        createComponentHtml({
                            id: 'new-' + (Date.now() + i),
                            title: 'Column ' + i,
                            type: 'card',
                            column_width: 3,
                            section: sectionId
                        })
                    );
                }
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            }
            // News Cards with Template System
            else if (selectedTemplate === 'news-cards') {
                let sectionId = 'news-cards-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'News Cards Section',
                        identifier: sectionId,
                        type: 'news'
                    })
                );
                
                // Add heading component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Section Heading',
                        type: 'text',
                        section: sectionId,
                        content: '<h2 class="text-center mb-4">Latest News</h2><p class="text-center mb-5">Stay updated with our latest articles and announcements</p>'
                    })
                );
                
                // Use the template implementation function for news cards
                if (typeof addNewsCardsTemplate === 'function') {
                    addNewsCardsTemplate(sectionId);
                } else {
                    // Fallback implementation if function not available
                    // Add news cards with template
                    for (let i = 1; i <= 3; i++) {
                        $(`.components-container[data-section="${sectionId}"]`).append(
                            createComponentHtml({
                                id: 'new-' + (Date.now() + i),
                                title: 'News Card ' + i,
                                type: 'card',
                                section: sectionId,
                                column_width: 4,
                                template_identifier: 'news-card',
                                meta_data: {
                                    title: 'News Article ' + i,
                                    excerpt: 'This is a sample news excerpt for card ' + i + '. Click to read more about this topic.',
                                    category: 'News',
                                    date: new Date().toLocaleDateString(),
                                    image: 'https://via.placeholder.com/600x400?text=News+' + i,
                                    button_text: 'Read More',
                                    button_url: '#'
                                }
                            })
                        );
                    }
                }
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            }
            // Masonry Grid
            else if (selectedTemplate === 'masonry-grid') {
                let sectionId = 'masonry-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Masonry Grid',
                        identifier: sectionId,
                        type: 'masonry'
                    })
                );
                
                // Use the template implementation function instead of inline code
                if (typeof addMasonryGridTemplate === 'function') {
                    addMasonryGridTemplate(sectionId);
                } else {
                    // Fallback to basic implementation if function not available
                    $(`.components-container[data-section="${sectionId}"]`).append(
                        createComponentHtml({
                            id: 'new-' + Date.now(),
                            title: 'Masonry Heading',
                            type: 'text',
                            section: sectionId,
                            content: '<h2 class="text-center mb-4">Masonry Grid Layout</h2>'
                        })
                    );
                }
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            }
            // Feature Cards
            else if (selectedTemplate === 'feature-cards') {
                let sectionId = 'feature-cards-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Feature Cards',
                        identifier: sectionId,
                        type: 'columns-3'
                    })
                );
                
                // Use the template implementation function
                if (typeof addFeatureCardsTemplate === 'function') {
                    addFeatureCardsTemplate(sectionId);
                } else {
                    // Fallback implementation
                    $(`.components-container[data-section="${sectionId}"]`).append(
                        createComponentHtml({
                            id: 'new-' + Date.now(),
                            title: 'Features Heading',
                            type: 'text',
                            column_width: 12,
                            section: sectionId,
                            content: '<h2 class="text-center mb-4">Key Features</h2><p class="text-center mb-5">Explore the key features that make our product/service unique.</p>'
                        })
                    );
                }
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            }
            // Call to Action
            else if (selectedTemplate === 'cta-banner') {
                let sectionId = 'cta-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Call to Action',
                        identifier: sectionId,
                        type: 'cta',
                        background_color: '#f8f9fa'
                    })
                );
                
                // Add CTA content
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'CTA Content',
                        type: 'text',
                        section: sectionId,
                        content: '<div class="py-5 text-center"><h2 class="mb-3">Ready to Get Started?</h2><p class="lead mb-4">Join thousands of satisfied customers who have already taken the next step.</p><div class="d-grid gap-2 d-sm-flex justify-content-sm-center"><button type="button" class="btn btn-primary btn-lg px-4 gap-3">Get Started</button><button type="button" class="btn btn-outline-secondary btn-lg px-4">Learn More</button></div></div>'
                    })
                );
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            }
            // Contact Form
            else if (selectedTemplate === 'contact-form') {
                let sectionId = 'contact-section-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Contact Us',
                        identifier: sectionId,
                        type: 'content'
                    })
                );
                
                // Add heading component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Contact Form Heading',
                        type: 'text',
                        section: sectionId,
                        content: '<h3>Contact Us</h3><p>Fill out the form below to get in touch with our team</p>'
                    })
                );
                
                // Add form component
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'Contact Form',
                        type: 'form',
                        section: sectionId
                    })
                );
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            }
            // Team Members
            else if (selectedTemplate === 'team-members') {
                let sectionId = 'team-section-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'Our Team',
                        identifier: sectionId,
                        type: 'columns-3'
                    })
                );
                
                // Add heading
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'Team Heading',
                        type: 'text',
                        column_width: 12,
                        section: sectionId,
                        content: '<h2 class="text-center mb-5">Meet Our Team</h2>'
                    })
                );
                
                // Add team members
                for (let i = 1; i <= 3; i++) {
                    $(`.components-container[data-section="${sectionId}"]`).append(
                        createComponentHtml({
                            id: 'new-' + (Date.now() + i),
                            title: 'Team Member ' + i,
                            type: 'card',
                            column_width: 4,
                            section: sectionId,
                            content: `<div class="text-center"><img src="https://via.placeholder.com/300x300" class="rounded-circle mb-3" width="150" height="150" alt="Team Member"><h4>Team Member ${i}</h4><p class="text-muted">Position</p><p>Brief description about this team member.</p></div>`
                        })
                    );
                }
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            }
            // FAQ Accordion
            else if (selectedTemplate === 'faq-accordion') {
                let sectionId = 'faq-section-' + Date.now();
                $("#pageBuilder").append(
                    createSectionHtml({
                        title: 'FAQ Section',
                        identifier: sectionId,
                        type: 'content'
                    })
                );
                
                // Add heading
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + Date.now(),
                        title: 'FAQ Heading',
                        type: 'text',
                        section: sectionId,
                        content: '<h2 class="text-center mb-5">Frequently Asked Questions</h2>'
                    })
                );
                
                // Add accordion content
                $(`.components-container[data-section="${sectionId}"]`).append(
                    createComponentHtml({
                        id: 'new-' + (Date.now() + 1),
                        title: 'FAQ Accordion',
                        type: 'text',
                        section: sectionId,
                        content: `<div class="accordion" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne">Question 1?</button>
                                </h2>
                                <div id="faqOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">Answer to question 1 goes here.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo">Question 2?</button>
                                </h2>
                                <div id="faqTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">Answer to question 2 goes here.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThree">Question 3?</button>
                                </h2>
                                <div id="faqThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">Answer to question 3 goes here.</div>
                                </div>
                            </div>
                        </div>`
                    })
                );
                
                setTimeout(function() {
                    saveLayout();
                }, 500);
            }
            // Other template handlers follow...
            // ...
            
            else {
                console.log("Unknown template:", selectedTemplate);
                showNotification('warning', 'Template Not Found', 'The selected template is not available or has not been implemented yet.');
            }
        }
        
        // Device preview selector
        $('#viewportSize').change(function() {
            let frame = $('#previewFrame');
            let size = $(this).val();
            
            switch(size) {
                case 'mobile':
                    frame.css({width: '375px', height: '667px'});
                    break;
                case 'tablet':
                    frame.css({width: '768px', height: '1024px'});
                    break;
                default:
                    frame.css({width: '100%', height: '600px'});
            }
        });
        
        // User role preview selector
        $('#userRole').change(function() {
            let frame = $('#previewFrame');
            let role = $(this).val();
            let src = frame.attr('src');
            
            // Add or update role parameter
            if (src.includes('?')) {
                if (src.includes('role=')) {
                    src = src.replace(/role=[^&]+/, 'role=' + role);
                } else {
                    src += '&role=' + role;
                }
            } else {
                src += '?role=' + role;
            }
            
            frame.attr('src', src);
        });
        
        // Component search
        $('#componentSearch').on('input', function() {
            let search = $(this).val().toLowerCase();
            $('.component-item').each(function() {
                let text = $(this).text().toLowerCase();
                if (text.includes(search)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
        
        // Show welcome notification if it's a new page
        @if(!$page->contents || $page->contents->count() == 0)
        setTimeout(function() {
            showNotification('info', 'Welcome to Page Builder', 'Start by adding a template or creating sections and components.', 10000);
        }, 1000);
        @endif
        
        // Save layout button
        $('#saveLayout').click(function() {
            // Disable the save button to prevent double-clicking
            $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
            
            // Call the save layout function
            saveLayout();
            
            // Re-enable the button after a delay
            setTimeout(function() {
                $('#saveLayout').prop('disabled', false).html('<i class="fas fa-save"></i> {{ __("Save Layout") }}');
            }, 2000);
        });
    });
</script>
@endsection 