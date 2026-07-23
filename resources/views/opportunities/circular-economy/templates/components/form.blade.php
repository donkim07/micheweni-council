{{-- templates/components/form.blade.php --}}
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
    
    // Get the form if form_id is provided
    $form = null;
    $formFields = [];
    
    if ($formId) {
        try {
            // Try to find the form
            if (class_exists('\App\Models\FormBuilder')) {
                // Look for the form in either $formBuilders (if passed to the view) or by directly querying
                if (isset($formBuilders) && isset($formBuilders[$formId])) {
                    $form = $formBuilders[$formId];
                } else {
                    $form = \App\Models\FormBuilder::find($formId);
                }
                
                // Process form fields to ensure they're in array format
                if ($form) {
                    if (is_string($form->fields)) {
                        $formFields = json_decode($form->fields, true);
                    } elseif (is_object($form->fields)) {
                        $formFields = (array) $form->fields;
                    } elseif (is_array($form->fields)) {
                        $formFields = $form->fields;
                    }
                    
                    // If fields is stored as a JSON string with a fields property
                    if (is_array($formFields) && isset($formFields['fields'])) {
                        $formFields = $formFields['fields'];
                    }
                }
            }
        } catch (\Exception $e) {
            // Log the error
            \Illuminate\Support\Facades\Log::error('Form component error: ' . $e->getMessage());
            $form = null;
            $formFields = [];
        }
    }
@endphp

@if($form)
    <div class="form-standard-wrapper p-4 bg-light rounded-lg shadow-sm border border-light">
        @if($form->title)
            <h4 class="mb-4 fw-bold text-gradient">{{ $form->title }}</h4>
        @endif
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        <form action="{{ $isPreview ? '#' : route('form.submit', $form->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @if(is_array($formFields) && count($formFields) > 0)
                @foreach($formFields as $field)
                    <div class="mb-4 form-group animate-on-scroll" data-delay="{{ $loop->index * 100 }}">
                        <label class="form-label fw-medium">{{ $field['label'] ?? $field->label ?? 'Field' }} 
                            @if(isset($field['required']) && $field['required'] || isset($field->required) && $field->required) 
                                <span class="text-danger">*</span> 
                            @endif
                        </label>
                        
                        @php
                            // Handle accessing fields from either array or object notation
                            $fieldType = isset($field['type']) ? $field['type'] : (isset($field->type) ? $field->type : 'text');
                            $fieldId = isset($field['id']) ? $field['id'] : (isset($field->id) ? $field->id : $loop->index);
                            $fieldName = isset($field['name']) ? $field['name'] : (isset($field->name) ? $field->name : 'field_'.$fieldId);
                            $fieldPlaceholder = isset($field['placeholder']) ? $field['placeholder'] : (isset($field->placeholder) ? $field->placeholder : '');
                            $fieldRequired = (isset($field['required']) && $field['required']) || (isset($field->required) && $field->required);
                            
                            // Handle options field
                            $fieldOptions = [];
                            if (isset($field['options'])) {
                                $fieldOptions = $field['options'];
                            } elseif (isset($field->options)) {
                                $fieldOptions = $field->options;
                            }
                            
                            // Convert object to array if needed
                            if (!is_array($fieldOptions) && is_object($fieldOptions)) {
                                $fieldOptions = (array) $fieldOptions;
                            }
                        @endphp
                        
                        @if($fieldType == 'text' || $fieldType == 'email' || $fieldType == 'number')
                            <input type="{{ $fieldType }}" 
                                   class="form-control form-control-lg shadow-sm" 
                                   name="{{ $fieldName }}" 
                                   placeholder="{{ $fieldPlaceholder }}"
                                   {{ $fieldRequired ? 'required' : '' }}>
                            <div class="invalid-feedback">Please provide a valid {{ strtolower($field['label'] ?? $field->label ?? 'input') }}</div>
                        @elseif($fieldType == 'textarea')
                            <textarea class="form-control shadow-sm" 
                                      name="{{ $fieldName }}" 
                                      rows="4" 
                                      placeholder="{{ $fieldPlaceholder }}"
                                      {{ $fieldRequired ? 'required' : '' }}></textarea>
                            <div class="invalid-feedback">Please provide a valid {{ strtolower($field['label'] ?? $field->label ?? 'input') }}</div>
                        @elseif($fieldType == 'select' && !empty($fieldOptions))
                            <select class="form-select shadow-sm" name="{{ $fieldName }}" {{ $fieldRequired ? 'required' : '' }}>
                                <option value="">{{ $fieldPlaceholder ?: 'Select an option' }}</option>
                                @foreach($fieldOptions as $option)
                                    @php
                                        $optionValue = is_array($option) ? ($option['value'] ?? '') : ($option->value ?? '');
                                        $optionLabel = is_array($option) ? ($option['label'] ?? '') : ($option->label ?? '');
                                    @endphp
                                    <option value="{{ $optionValue }}">{{ $optionLabel }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a valid option</div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ __('No form fields defined. Please configure the form in the admin panel.') }}
                </div>
            @endif
            
            @if($enableCaptcha)
                <div class="mb-3">
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                </div>
            @endif
            
            @if(is_array($formFields) && count($formFields) > 0)
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-{{ $submitButtonStyle }} btn-lg px-5 shadow btn-hover-effect transition-all">
                        <i class="fas fa-paper-plane me-2"></i>{{ $submitButtonText }}
                    </button>
                </div>
            @endif
        </form>
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
                    
                    // Add focus effects
                    var inputs = form.querySelectorAll('input, textarea, select');
                    for (var j = 0; j < inputs.length; j++) {
                        inputs[j].addEventListener('focus', function() {
                            this.parentElement.classList.add('input-focused');
                        });
                        inputs[j].addEventListener('blur', function() {
                            if (this.value === '') {
                                this.parentElement.classList.remove('input-focused');
                            }
                        });
                    }
                }
            });
        </script>
    @endpush
@endif 