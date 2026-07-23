{{-- templates/components/form-card.blade.php --}}
@php
    // Check if we're in preview mode
    $isPreview = Request::is('*preview*') || isset($request) && $request->has('preview_mode');
    
    // Get form data from content
    $meta = is_string($content->meta) ? json_decode($content->meta, true) : [];
    if (empty($meta) && is_object($content->meta)) {
        $meta = (array) $content->meta;
    }
    
    // Extract properties with defaults
    $formId = $meta['form_id'] ?? null;
    $submitButtonText = $meta['submit_button_text'] ?? 'Submit';
    $submitButtonStyle = $meta['submit_button_style'] ?? 'primary';
    $successMessage = $meta['success_message'] ?? 'Thank you for your submission!';
    $enableCaptcha = $meta['enable_captcha'] ?? false;
    $cardHeaderText = $meta['card_header_text'] ?? 'Complete the Form';
    
    // Get the form if form_id is provided
    $form = null;
    $formFields = [];
    if ($formId) {
        try {
            // Try to find the form
            if (class_exists('\App\Models\FormBuilder')) {
                $form = \App\Models\FormBuilder::find($formId);
                if ($form && isset($form->fields) && is_string($form->fields)) {
                    $formFields = json_decode($form->fields);
                    if (!is_array($formFields) && !is_object($formFields)) {
                        $formFields = [];
                    }
                }
            }
        } catch (\Exception $e) {
            // Form not found or error
            $form = null;
            $formFields = [];
        }
    }
@endphp

@if($form)
    <div class="card form-card shadow-sm border-0 rounded-lg overflow-hidden">
        <div class="card-header form-header bg-gradient-primary text-white">
            <h5 class="mb-0 fw-bold">{{ $form->title ?? $cardHeaderText }}</h5>
        </div>
        <div class="card-body form-body p-4">
            <form action="{{ $isPreview ? '#' : route('form.submit', $form->id) }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @if(is_array($formFields) || is_object($formFields))
                    @foreach($formFields as $field)
                        <div class="mb-3 form-group animate-on-scroll" data-delay="{{ $loop->index * 100 }}">
                            <label class="form-label fw-medium">{{ $field->label ?? 'Field' }} @if(isset($field->required) && $field->required) <span class="text-danger">*</span> @endif</label>
                            
                            @if(isset($field->type) && ($field->type == 'text' || $field->type == 'email' || $field->type == 'number'))
                                <input type="{{ $field->type }}" 
                                      class="form-control form-control-lg" 
                                      name="field_{{ $field->id ?? $loop->index }}" 
                                      placeholder="{{ $field->placeholder ?? '' }}"
                                      {{ isset($field->required) && $field->required ? 'required' : '' }}>
                                <div class="invalid-feedback">Please provide a valid {{ strtolower($field->label ?? 'input') }}</div>
                            @elseif(isset($field->type) && $field->type == 'textarea')
                                <textarea class="form-control" 
                                         name="field_{{ $field->id ?? $loop->index }}" 
                                         rows="4" 
                                         placeholder="{{ $field->placeholder ?? '' }}"
                                         {{ isset($field->required) && $field->required ? 'required' : '' }}></textarea>
                                <div class="invalid-feedback">Please provide a valid {{ strtolower($field->label ?? 'input') }}</div>
                            @elseif(isset($field->type) && $field->type == 'select' && isset($field->options))
                                <select class="form-select form-select-lg" name="field_{{ $field->id ?? $loop->index }}" {{ isset($field->required) && $field->required ? 'required' : '' }}>
                                    <option value="">{{ $field->placeholder ?? 'Select an option' }}</option>
                                    @foreach($field->options as $option)
                                        <option value="{{ $option->value ?? '' }}">{{ $option->label ?? '' }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a valid option</div>
                            @endif
                        </div>
                    @endforeach
                @endif
                
                @if($enableCaptcha)
                    <div class="mb-3">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                    </div>
                @endif
                
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-{{ $submitButtonStyle }} btn-lg shadow-sm btn-hover-effect">
                        <i class="fas fa-paper-plane me-2"></i>{{ $submitButtonText }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@else
    <div class="alert alert-info shadow-sm rounded-lg">
        <i class="fas fa-info-circle me-2"></i>
        {{ __('Please select a form in the component settings.') }}
    </div>
@endif

@if($form && !$isPreview)
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var formSelector = 'form[action="{{ route('opportunities.circular-economy.form.submit', $form->id) }}"]';
                var form = document.querySelector(formSelector);
                
                if (form) {
                    form.addEventListener('submit', function(event) {
                        if (!this.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        
                        this.classList.add('was-validated');
                    });
                }
            });
        </script>
    @endpush
@endif 