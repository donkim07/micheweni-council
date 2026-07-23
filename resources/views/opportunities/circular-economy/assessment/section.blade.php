<x-app-layout>
    <div class="py-5 bg-gradient-to-r from-green-800 to-green-600 text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-5 fw-bold mb-3">{{ $sectionTitle }}</h1>
                    <p class="lead mb-4">{{ __('Complete this assessment to evaluate your current status and receive recommendations.') }}</p>
                    
                    <div class="d-flex">
                        <a href="{{ route('opportunities.circular-economy.assessment.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-2"></i> {{ __('Back to Assessment List') }}
                        </a>
                    </div>
                </div>
                <div class="col-md-4 d-none d-md-block">
                    <img src="{{ asset('images/assessment-' . $sectionKey . '.svg') }}" alt="{{ $sectionTitle }}" class="img-fluid" onerror="this.src='https://placehold.co/400x300/198754/white?text={{ $sectionTitle }}'">
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 card-title">{{ __('Section') }}: {{ $sectionTitle }}</h5>
            </div>
            <div class="card-body p-4">
                <!-- Form Content -->
                @if($form && isset($form->fields) && !empty($form->fields))
                <form action="{{ route('opportunities.circular-economy.assessment.submit', ['section' => $sectionKey]) }}" method="POST" id="assessmentForm">
                    @csrf
                    
                    <div class="form-fields">
                        @foreach($form->fields as $index => $field)
                            <div class="form-field mb-4 p-3 border rounded bg-light">
                                <div class="mb-3">
                                    <label for="{{ $field['name'] ?? 'field_'.$index }}" class="form-label fw-bold">
                                        {{ $field['label'] ?? 'Question ' . ($index + 1) }}
                                        @if(isset($field['required']) && $field['required'])
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    
                                    @if(!empty($field['description']))
                                        <p class="text-muted small">{{ $field['description'] }}</p>
                                    @endif
                                </div>
                                
                                @if(isset($field['type']) && $field['type'] === 'text')
                                    <input type="text" 
                                        class="form-control @error($field['name'] ?? '') is-invalid @enderror" 
                                        id="{{ $field['name'] ?? 'field_'.$index }}" 
                                        name="{{ $field['name'] ?? 'field_'.$index }}" 
                                        value="{{ old($field['name'] ?? '', $previousSubmission ? json_decode($previousSubmission->data, true)[$field['name'] ?? ''] ?? '' : '') }}"
                                        @if(isset($field['required']) && $field['required']) required @endif>
                                @elseif(isset($field['type']) && $field['type'] === 'textarea')
                                    <textarea 
                                        class="form-control @error($field['name'] ?? '') is-invalid @enderror" 
                                        id="{{ $field['name'] ?? 'field_'.$index }}" 
                                        name="{{ $field['name'] ?? 'field_'.$index }}" 
                                        rows="3"
                                        @if(isset($field['required']) && $field['required']) required @endif>{{ old($field['name'] ?? '', $previousSubmission ? json_decode($previousSubmission->data, true)[$field['name'] ?? ''] ?? '' : '') }}</textarea>
                                @elseif(isset($field['type']) && $field['type'] === 'radio')
                                    @foreach($field['options'] ?? [] as $option)
                                        <div class="form-check">
                                            <input 
                                                class="form-check-input @error($field['name'] ?? '') is-invalid @enderror" 
                                                type="radio" 
                                                name="{{ $field['name'] ?? 'field_'.$index }}" 
                                                id="{{ ($field['name'] ?? 'field_'.$index) }}_{{ $option['value'] ?? '' }}" 
                                                value="{{ $option['value'] ?? '' }}"
                                                @if(old($field['name'] ?? '', $previousSubmission ? json_decode($previousSubmission->data, true)[$field['name'] ?? ''] ?? '' : '') == ($option['value'] ?? '')) checked @endif
                                                @if(isset($field['required']) && $field['required']) required @endif>
                                            <label class="form-check-label" for="{{ ($field['name'] ?? 'field_'.$index) }}_{{ $option['value'] ?? '' }}">
                                                {{ $option['label'] ?? $option['value'] ?? '' }}
                                            </label>
                                        </div>
                                    @endforeach
                                @elseif(isset($field['type']) && $field['type'] === 'checkbox')
                                    @foreach($field['options'] ?? [] as $option)
                                        <div class="form-check">
                                            <input 
                                                class="form-check-input @error($field['name'] ?? '') is-invalid @enderror" 
                                                type="checkbox" 
                                                name="{{ $field['name'] ?? 'field_'.$index }}[]" 
                                                id="{{ ($field['name'] ?? 'field_'.$index) }}_{{ $option['value'] ?? '' }}" 
                                                value="{{ $option['value'] ?? '' }}"
                                                @php
                                                    $oldValue = old($field['name'] ?? '', $previousSubmission ? json_decode($previousSubmission->data, true)[$field['name'] ?? ''] ?? [] : []);
                                                    $oldArray = is_array($oldValue) ? $oldValue : [$oldValue];
                                                @endphp
                                                @if(in_array($option['value'] ?? '', $oldArray)) checked @endif>
                                            <label class="form-check-label" for="{{ ($field['name'] ?? 'field_'.$index) }}_{{ $option['value'] ?? '' }}">
                                                {{ $option['label'] ?? $option['value'] ?? '' }}
                                            </label>
                                        </div>
                                    @endforeach
                                @elseif(isset($field['type']) && $field['type'] === 'select')
                                    <select 
                                        class="form-select @error($field['name'] ?? '') is-invalid @enderror" 
                                        id="{{ $field['name'] ?? 'field_'.$index }}" 
                                        name="{{ $field['name'] ?? 'field_'.$index }}"
                                        @if(isset($field['required']) && $field['required']) required @endif>
                                        <option value="">{{ __('Select an option') }}</option>
                                        @foreach($field['options'] ?? [] as $option)
                                            <option 
                                                value="{{ $option['value'] ?? '' }}"
                                                @if(old($field['name'] ?? '', $previousSubmission ? json_decode($previousSubmission->data, true)[$field['name'] ?? ''] ?? '' : '') == ($option['value'] ?? '')) selected @endif>
                                                {{ $option['label'] ?? $option['value'] ?? '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                @elseif(isset($field['type']) && $field['type'] === 'range')
                                    <div class="range-field">
                                        @php
                                            $minVal = $field['min'] ?? 0;
                                            $maxVal = $field['max'] ?? 100;
                                            $defaultValue = old($field['name'] ?? '', $previousSubmission ? json_decode($previousSubmission->data, true)[$field['name'] ?? ''] ?? $minVal : $minVal);
                                        @endphp
                                        <input 
                                            type="range" 
                                            class="form-range @error($field['name'] ?? '') is-invalid @enderror" 
                                            id="{{ $field['name'] ?? 'field_'.$index }}" 
                                            name="{{ $field['name'] ?? 'field_'.$index }}" 
                                            min="{{ $minVal }}" 
                                            max="{{ $maxVal }}" 
                                            step="{{ $field['step'] ?? 1 }}"
                                            value="{{ $defaultValue }}"
                                            @if(isset($field['required']) && $field['required']) required @endif>
                                        <div class="d-flex justify-content-between">
                                            <span>{{ $field['min_label'] ?? $minVal }}</span>
                                            <span id="{{ ($field['name'] ?? 'field_'.$index) }}_value">{{ $defaultValue }}</span>
                                            <span>{{ $field['max_label'] ?? $maxVal }}</span>
                                        </div>
                                    </div>
                                @else
                                    <input type="text" 
                                        class="form-control @error($field['name'] ?? '') is-invalid @enderror" 
                                        id="{{ $field['name'] ?? 'field_'.$index }}" 
                                        name="{{ $field['name'] ?? 'field_'.$index }}" 
                                        value="{{ old($field['name'] ?? '', $previousSubmission ? json_decode($previousSubmission->data, true)[$field['name'] ?? ''] ?? '' : '') }}"
                                        @if(isset($field['required']) && $field['required']) required @endif>
                                @endif
                                
                                @error($field['name'] ?? '')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="form-actions mt-4 d-flex justify-content-between">
                        <a href="{{ route('opportunities.circular-economy.assessment.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i> {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-2"></i> {{ __('Submit Assessment') }}
                        </button>
                    </div>
                </form>
                @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ __('The assessment form is not available at this time. Please try again later.') }}
                </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update range input value display
            const rangeInputs = document.querySelectorAll('input[type="range"]');
            rangeInputs.forEach(function(input) {
                const valueDisplay = document.getElementById(input.id + '_value');
                if (valueDisplay) {
                    input.addEventListener('input', function() {
                        valueDisplay.textContent = this.value;
                    });
                }
            });
        });
    </script>
    @endpush
</x-app-layout>