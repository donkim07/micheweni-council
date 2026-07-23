{{-- resources/views/admin/layout/components/render-wrapper.blade.php --}}
@php
    // Import necessary classes
    use App\Helpers\TemplateHelper;
    
    // Default values
    $isPreview = $isPreview ?? false;
    $formBuilders = $formBuilders ?? null;
    
    // Get content object
    $content = $content ?? null;
    
    if (!$content) {
        $errorMessage = 'No content object provided to render-wrapper';
    }
    
    // Get template data
    $templateData = $templateData ?? TemplateHelper::getTemplateData($content);
    
    // Get component CSS classes
    $componentClasses = $content->getCssClasses();
    
    // Get inline styles
    $inlineStyles = [];
    if ($content->margin) {
        $inlineStyles[] = "margin: {$content->margin}";
    }
    if ($content->padding) {
        $inlineStyles[] = "padding: {$content->padding}";
    }
    if (isset($content->meta->css_style)) {
        $inlineStyles[] = $content->meta->css_style;
    }
    $inlineStyleString = implode('; ', $inlineStyles);
    
    // Determine view path
    $componentViewPath = 'admin.layout.components.' . $content->type;
    $componentExists = view()->exists($componentViewPath);
@endphp

@if(isset($errorMessage))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle me-2"></i>
        {{ $errorMessage }}
    </div>
@elseif(!$componentExists)
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle me-2"></i>
        Component type "{{ $content->type }}" does not have a view.
    </div>
@else
    <div class="component {{ $componentClasses }}" @if($inlineStyleString) style="{{ $inlineStyleString }}" @endif>
        @include($componentViewPath, [
            'content' => $content,
            'isPreview' => $isPreview,
            'formBuilders' => $formBuilders,
            'templateData' => $templateData
        ])
    </div>
@endif 