@extends('layouts.admin')

@section('title', __('Section Settings'))

@section('styles')
<style>
    .color-picker-container {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .color-preview {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 15px;
        border: 1px solid #ddd;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .style-preset {
        display: inline-block;
        width: 100%;
        height: 100px;
        margin-bottom: 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    
    .style-preset:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .style-preset.selected {
        border: 2px solid #0d6efd;
        box-shadow: 0 0 0 3px rgba(13,110,253,0.25);
    }
    
    .style-preset-label {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 5px 10px;
        font-size: 12px;
        text-align: center;
    }
    
    /* Live preview enhancements */
    .preview-container {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .preview-controls {
        position: sticky;
        top: 0;
        background: white;
        padding: 10px;
        border-bottom: 1px solid #eee;
        z-index: 10;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .device-selector {
        display: flex;
        align-items: center;
    }
    
    .device-btn {
        border: none;
        background: transparent;
        color: #6c757d;
        padding: 5px 10px;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .device-btn:hover {
        color: #0d6efd;
    }
    
    .device-btn.active {
        color: #0d6efd;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Section Settings') }}: {{ $section->title ?? ucfirst($section->identifier) }}</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.pages.index') }}">{{ __('Pages') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.layout.builder', $section->page_id) }}">{{ __('Page Builder') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Section Settings') }}</li>
    </ol>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-sliders-h me-1"></i>
                    {{ __('Section Style & Settings') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.layout.saveSectionSettings', $section->id) }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input class="form-control @error('title') is-invalid @enderror" id="title" 
                                        type="text" name="title" value="{{ old('title', $section->title) }}" placeholder="{{ __('Section Title') }}" />
                                    <label for="title">{{ __('Title') }}</label>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-paint-brush me-1"></i>
                                    {{ __('Styling') }}
                                </div>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="toggleAdvancedSettings">
                                        <i class="fas fa-code me-1"></i> {{ __('Advanced Settings') }}
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="card preview-container">
                                            <div class="preview-controls">
                                                <h5 class="mb-0">{{ __('Live Preview') }}</h5>
                                                <div class="device-selector">
                                                    <button type="button" class="device-btn active" data-device="desktop">
                                                        <i class="fas fa-desktop"></i>
                                                    </button>
                                                    <button type="button" class="device-btn" data-device="tablet">
                                                        <i class="fas fa-tablet-alt"></i>
                                                    </button>
                                                    <button type="button" class="device-btn" data-device="mobile">
                                                        <i class="fas fa-mobile-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div id="section-preview" class="p-3 border rounded" style="
                                                    background-color: {{ old('background_color', $section->background_color ?? '#ffffff') }};
                                                    color: {{ old('text_color', $section->text_color ?? '#000000') }};
                                                    padding: {{ old('padding', $section->padding ?? '20px') }};
                                                    margin: {{ old('margin', $section->margin ?? '0px') }};
                                                    {{ old('css_style', $section->css_style ?? '') }}
                                                ">
                                                    <h3>{{ __('Section Preview') }}</h3>
                                                    <p>{{ __('This is a preview of how your section will look with the current styling options.') }}</p>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="card-title">{{ __('Sample Component') }}</h5>
                                                                    <p class="card-text">{{ __('This shows how components will appear within this section.') }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="card-title">{{ __('Sample Component') }}</h5>
                                                                    <p class="card-text">{{ __('This shows how components will appear within this section.') }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <h5 class="mb-3">{{ __('Color Settings') }}</h5>
                                
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="background_color">{{ __('Background Color') }}</label>
                                        <div class="color-picker-container">
                                            <div class="color-preview" id="background_preview" style="background-color: {{ old('background_color', $section->background_color ?? '#ffffff') }};"></div>
                                            <input class="form-control @error('background_color') is-invalid @enderror" id="background_color" 
                                                type="color" name="background_color" value="{{ old('background_color', $section->background_color ?? '#ffffff') }}" />
                                        </div>
                                        @error('background_color')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="text_color">{{ __('Text Color') }}</label>
                                        <div class="color-picker-container">
                                            <div class="color-preview" id="text_preview" style="background-color: {{ old('text_color', $section->text_color ?? '#000000') }};"></div>
                                            <input class="form-control @error('text_color') is-invalid @enderror" id="text_color" 
                                                type="color" name="text_color" value="{{ old('text_color', $section->text_color ?? '#000000') }}" />
                                        </div>
                                        @error('text_color')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <h5 class="mb-3">{{ __('Spacing') }}</h5>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control @error('padding') is-invalid @enderror" id="padding" 
                                                type="text" name="padding" value="{{ old('padding', $section->padding ?? '20px') }}" placeholder="{{ __('Padding') }}" />
                                            <label for="padding">{{ __('Padding') }}</label>
                                            @error('padding')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">{{ __('Format: 20px or 10px 20px 10px 20px (top, right, bottom, left)') }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control @error('margin') is-invalid @enderror" id="margin" 
                                                type="text" name="margin" value="{{ old('margin', $section->margin ?? '0px') }}" placeholder="{{ __('Margin') }}" />
                                            <label for="margin">{{ __('Margin') }}</label>
                                            @error('margin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">{{ __('Format: 20px or 10px 20px 10px 20px (top, right, bottom, left)') }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <h5 class="mb-3">{{ __('Style Presets') }}</h5>
                                
                                <div class="row mb-4">
                                    <div class="col-md-3 mb-3">
                                        <div class="style-preset bg-white text-dark @if(!$section->css_class || $section->css_class == '') selected @endif" data-style="">
                                            <div class="style-preset-label">Default</div>
                                            <input type="radio" name="style_preset" id="style_default" value="" class="d-none" @checked(!$section->css_class || $section->css_class == '')>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="style-preset bg-primary text-white @if($section->css_class == 'bg-primary text-white') selected @endif" data-style="bg-primary text-white">
                                            <div class="style-preset-label">Primary</div>
                                            <input type="radio" name="style_preset" id="style_primary" value="bg-primary text-white" class="d-none" @checked($section->css_class == 'bg-primary text-white')>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="style-preset bg-secondary text-white @if($section->css_class == 'bg-secondary text-white') selected @endif" data-style="bg-secondary text-white">
                                            <div class="style-preset-label">Secondary</div>
                                            <input type="radio" name="style_preset" id="style_secondary" value="bg-secondary text-white" class="d-none" @checked($section->css_class == 'bg-secondary text-white')>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="style-preset bg-light @if($section->css_class == 'bg-light') selected @endif" data-style="bg-light">
                                            <div class="style-preset-label">Light</div>
                                            <input type="radio" name="style_preset" id="style_light" value="bg-light" class="d-none" @checked($section->css_class == 'bg-light')>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="advanced-settings" style="display: none;">
                                    <h5 class="mb-3">{{ __('Advanced Settings') }}</h5>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <input class="form-control @error('css_class') is-invalid @enderror" id="css_class" 
                                                    type="text" name="css_class" value="{{ old('css_class', $section->css_class) }}" placeholder="{{ __('CSS Classes') }}" />
                                                <label for="css_class">{{ __('CSS Classes') }}</label>
                                                @error('css_class')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">{{ __('Separate multiple classes with spaces') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <label for="css_style">{{ __('Custom CSS') }}</label>
                                        <textarea class="form-control @error('css_style') is-invalid @enderror" id="css_style" 
                                            name="css_style" rows="5" style="font-family: monospace;">{{ old('css_style', $section->css_style) }}</textarea>
                                        @error('css_style')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">{{ __('Enter custom CSS styles for this section') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 mb-0">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('admin.layout.builder', $section->page_id) }}" class="btn btn-outline-secondary">
                                    {{ __('Cancel') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save Section Settings') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    {{ __('Section Information') }}
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6>{{ __('Section Type') }}</h6>
                        <p>{{ ucfirst($section->type ?? 'Standard') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6>{{ __('Identifier') }}</h6>
                        <p><code>{{ $section->identifier }}</code></p>
                    </div>
                    
                    <div class="mb-3">
                        <h6>{{ __('Position') }}</h6>
                        <p>{{ $section->order ?? 'Not set' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-question-circle me-1"></i>
                    {{ __('Help & Tips') }}
                </div>
                <div class="card-body">
                    <h6>{{ __('Styling Your Section') }}</h6>
                    <ul class="small">
                        <li>{{ __('Use the color pickers to set the background and text colors.') }}</li>
                        <li>{{ __('Padding controls the space inside the section.') }}</li>
                        <li>{{ __('Margin controls the space around the section.') }}</li>
                        <li>{{ __('For more advanced styling, use the CSS Classes or Custom CSS fields.') }}</li>
                    </ul>
                    
                    <h6 class="mt-3">{{ __('CSS Classes Examples') }}</h6>
                    <ul class="small">
                        <li><code>bg-primary</code> - {{ __('Sets primary background color') }}</li>
                        <li><code>text-white</code> - {{ __('Sets white text color') }}</li>
                        <li><code>shadow</code> - {{ __('Adds box shadow') }}</li>
                        <li><code>rounded</code> - {{ __('Adds rounded corners') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Update the preview when any input changes
        $('#background_color, #text_color, #padding, #margin, #css_style, #css_class').on('input change', updatePreview);
        
        // Toggle advanced settings
        $('#toggleAdvancedSettings').click(function() {
            $('#advanced-settings').toggle();
        });
        
        // Update color preview when color inputs change
        $('#background_color').on('input change', function() {
            $('#background_preview').css('background-color', $(this).val());
        });
        
        $('#text_color').on('input change', function() {
            $('#text_preview').css('background-color', $(this).val());
        });
        
        // Style preset selection
        $('.style-preset').click(function() {
            $('.style-preset').removeClass('selected');
            $(this).addClass('selected');
            
            // Find and check the associated radio button
            $(this).find('input[type="radio"]').prop('checked', true);
            
            // Update CSS class input
            let style = $(this).data('style');
            $('#css_class').val(style);
            
            // Update preview
            updatePreview();
        });
        
        // Device preview selector
        $('.device-btn').click(function() {
            $('.device-btn').removeClass('active');
            $(this).addClass('active');
            
            let device = $(this).data('device');
            let preview = $('#section-preview');
            
            switch(device) {
                case 'mobile':
                    preview.css('max-width', '375px');
                    break;
                case 'tablet':
                    preview.css('max-width', '768px');
                    break;
                default:
                    preview.css('max-width', 'none');
            }
        });
        
        // Initial update
        updatePreview();
        
        function updatePreview() {
            var preview = $('#section-preview');
            var backgroundColor = $('#background_color').val();
            var textColor = $('#text_color').val();
            var padding = $('#padding').val();
            var margin = $('#margin').val();
            var cssClass = $('#css_class').val();
            var customCSS = $('#css_style').val();
            
            // Update the preview
            preview.css({
                'background-color': backgroundColor,
                'color': textColor,
                'padding': padding,
                'margin': margin
            });
            
            // Apply classes
            preview.removeClass(); // Remove all classes
            preview.addClass('p-3 border rounded'); // Add base classes
            
            if (cssClass) {
                cssClass.split(' ').forEach(function(cls) {
                    if (cls.trim()) {
                        preview.addClass(cls.trim());
                    }
                });
            }
            
            // Add any custom CSS if needed
            if (customCSS) {
                try {
                    // Extract specific properties from custom CSS
                    var cssProps = customCSS.split(';');
                    cssProps.forEach(function(prop) {
                        if (prop.trim()) {
                            var parts = prop.split(':');
                            if (parts.length === 2) {
                                var propName = parts[0].trim();
                                var propValue = parts[1].trim();
                                preview.css(propName, propValue);
                            }
                        }
                    });
                } catch (e) {
                    console.error('Error parsing custom CSS:', e);
                }
            }
        }
    });
</script>
@endsection 