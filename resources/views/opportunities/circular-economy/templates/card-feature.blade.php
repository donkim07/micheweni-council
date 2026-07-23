@php
    // Get template settings
    $settings = $content->getTemplateSettings();
    
    // Extract settings with defaults
    $iconPosition = $settings['icon_position'] ?? 'top';
    $textAlignment = $settings['text_alignment'] ?? 'center';
    $cardPadding = $settings['card_padding'] ?? '2rem';
    $borderRadius = $settings['border_radius'] ?? '0.75rem';
    $shadow = $settings['shadow'] ?? 'shadow';
    
    // Content values
    $title = $content->meta->title ?? $content->title ?? '';
    $subtitle = $content->meta->subtitle ?? '';
    $icon = $content->meta->icon ?? 'fas fa-star';
    $description = $content->meta->content ?? $content->value ?? '';
    $buttonText = $content->meta->button_text ?? '';
    $buttonUrl = $content->meta->button_url ?? '#';
    
    // Generate inline styles
    $cardStyles = "border-radius: {$borderRadius}; padding: {$cardPadding}; text-align: {$textAlignment};";
    
    // Card classes
    $cardClasses = "{$shadow} border-0 h-100 feature-card-container";
@endphp

<div class="card {{ $cardClasses }}" style="{{ $cardStyles }}">
    @if($iconPosition == 'top')
        <div class="feature-icon mb-4">
            <i class="{{ $icon }}"></i>
        </div>
    @endif
    
    <div class="card-body p-0">
        <h5 class="card-title feature-title mb-3">{{ $title }}</h5>
        
        @if($subtitle)
            <h6 class="card-subtitle text-muted mb-3">{{ $subtitle }}</h6>
        @endif
        
        @if($iconPosition == 'inline')
            <div class="feature-icon-inline mb-3">
                <i class="{{ $icon }}"></i>
            </div>
        @endif
        
        <p class="card-text">{{ $description }}</p>
        
        @if($buttonText)
            <a href="{{ $buttonUrl }}" class="btn btn-primary mt-3 feature-button">
                {{ $buttonText }}
            </a>
        @endif
    </div>
</div>

<style>
    .feature-card-container {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        will-change: transform;
        background-color: #fff;
        overflow: hidden;
        position: relative;
        z-index: 1;
    }
    
    .feature-card-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(25, 135, 84, 0.05) 0%, rgba(32, 201, 151, 0.05) 100%);
        opacity: 0.5;
        transition: opacity 2.9s ease;
        z-index: -1;
    }
    
    .feature-card-container:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }
    
    .feature-card-container:hover::before {
        opacity: 1;
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
        font-size: 2rem;
        border-radius: 50%;
        transition: all 0.4s ease;
    }
    
    .feature-card-container:hover .feature-icon {
        transform: rotateY(180deg);
        background-color: #198754;
        color: white;
    }
    
    .feature-icon-inline {
        font-size: 2.5rem;
        color: #198754;
        transition: transform 0.4s ease;
        display: inline-block;
    }
    
    .feature-card-container:hover .feature-icon-inline {
        transform: scale(1.2);
    }
    
    .feature-title {
        font-weight: 700;
        color: #212529;
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
    }
    
    .feature-title::after {
        content: '';
        position: absolute;
        width: 40px;
        height: 3px;
        background-color: #198754;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        transition: width 0.4s ease;
    }
    
    .feature-card-container:hover .feature-title::after {
        width: 60px;
    }
    
    .feature-button {
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
        z-index: 1;
    }
    
    .feature-button::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.2);
        transition: left 0.4s ease;
        z-index: -1;
    }
    
    .feature-button:hover::after {
        left: 100%;
    }
</style> 