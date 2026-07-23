@php
    // Get template identifier or fallback to old template system
    $templateIdentifier = $content->template_identifier ?? $content->template ?? 'standard';
    
    // Add extra CSS classes
    $extraClasses = $content->getCssClasses();
    
    // Get margin and padding styles
    $margin = $content->margin ?? '';
    $padding = $content->padding ?? '';
    
    // Generate inline style based on margin and padding
    $styleArray = [];
    if (!empty($margin)) {
        $styleArray[] = "margin: {$margin}";
    }
    if (!empty($padding)) {
        $styleArray[] = "padding: {$padding}";
    }
    $styleString = implode('; ', $styleArray);
    if (!empty($styleString)) {
        $styleString .= ';';
    }
    
    // Check if the content has a valid template
    $hasTemplate = !empty($content->template_identifier) && $content->template;
    
    // Debug info for admins
    $isAdminPreview = Request::is('*preview*') || Request::is('*admin*');
@endphp

<div class="template-component {{ $extraClasses }}" style="{{ $styleString }}" 
     @if($hasTemplate && $content->template->animation)
         data-animation="{{ $content->template->animation }}"
     @endif>
    
    {{-- Try to include the template by identifier first --}}
    @if(view()->exists('templates.' . $templateIdentifier))
        @include('templates.' . $templateIdentifier, ['content' => $content])
    
    {{-- Try to include by type and template as fallback --}}
    @elseif(view()->exists('templates.' . $content->type . '-' . $templateIdentifier))
        @include('templates.' . $content->type . '-' . $templateIdentifier, ['content' => $content])
    
    {{-- Fallback to type only --}}
    @elseif(view()->exists('templates.' . $content->type))
        @include('templates.' . $content->type, ['content' => $content])
    
    {{-- Fallback to old component system --}}
    @elseif(view()->exists('admin.layout.components.' . $content->type))
        @include('admin.layout.components.' . $content->type, ['content' => $content])
    
    {{-- Error state for missing template --}}
    @else
        <div class="alert alert-warning">
            @if($isAdminPreview)
                Template not found: "{{ $templateIdentifier }}" or "{{ $content->type }}"
            @else
                Content could not be displayed.
            @endif
        </div>
    @endif
</div>

@if($isAdminPreview)
    <script>
        // Enable animation preview for admin
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-animation]').forEach(el => {
                el.classList.add(el.dataset.animation);
            });
        });
    </script>
@endif 