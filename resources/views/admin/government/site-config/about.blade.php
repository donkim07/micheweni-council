@extends('layouts.admin')

@section('title', __('Edit About Information'))

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
    .icon-option {
        transition: all 0.2s;
    }
    .icon-option:hover {
        background-color: #f8f9fa;
        transform: scale(1.05);
    }
    .icon-option.selected {
        background-color: #e9f2ff;
        border-color: #3490dc !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Edit About Information') }}</h4>
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
                    
                    <form action="{{ route('admin.government.site-config.update-about') }}" method="POST" class="form">
                        @csrf
                        
                        <div class="mb-4">
                            <h5>{{ __('Mission Statement') }}</h5>
                            <textarea name="mission" id="mission" class="form-control summernote @error('mission') is-invalid @enderror" rows="5">{{ old('mission', $aboutInfo['mission'] ?? '') }}</textarea>
                            @error('mission')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">{{ __("Enter your organization's mission statement") }}</small>
                        </div>
                        
                        <div class="mb-4">
                            <h5>{{ __('Vision Statement') }}</h5>
                            <textarea name="vision" id="vision" class="form-control summernote @error('vision') is-invalid @enderror" rows="5">{{ old('vision', $aboutInfo['vision'] ?? '') }}</textarea>
                            @error('vision')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">{{ __("Enter your organization's vision statement") }}</small>
                        </div>
                        
                        <div class="mb-4">
                            <h5>{{ __('Core Values') }}</h5>
                            
                            <div class="core-values">
                                @if(isset($aboutInfo['core_values']) && count($aboutInfo['core_values']) > 0)
                                    @foreach($aboutInfo['core_values'] as $index => $value)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('Value Title') }}</label>
                                                    <input type="text" name="core_values[{{ $index }}][title]" value="{{ old('core_values.'.$index.'.title', $value['title'] ?? '') }}" class="form-control @error('core_values.'.$index.'.title') is-invalid @enderror" placeholder="{{ __('e.g., Integrity, Excellence, etc.') }}">
                                                    @error('core_values.'.$index.'.title')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('Value Icon') }}</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas {{ $value['icon'] ?? 'fa-star' }}"></i></span>
                                                        <input type="text" name="core_values[{{ $index }}][icon]" value="{{ old('core_values.'.$index.'.icon', $value['icon'] ?? 'fa-star') }}" class="form-control icon-input @error('core_values.'.$index.'.icon') is-invalid @enderror" placeholder="{{ __('e.g., fa-star, fa-users, etc.') }}">
                                                        <button type="button" class="btn btn-outline-secondary icon-selector-btn">
                                                            <i class="fas fa-icons"></i> {{ __('Select Icon') }}
                                                        </button>
                                                        @error('core_values.'.$index.'.icon')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <small class="text-muted">{{ __('Click the button to select an icon or enter a FontAwesome icon class directly') }}</small>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('Value Description') }}</label>
                                                    <textarea name="core_values[{{ $index }}][description]" class="form-control @error('core_values.'.$index.'.description') is-invalid @enderror" rows="3" placeholder="{{ __('Describe this core value...') }}">{{ old('core_values.'.$index.'.description', $value['description'] ?? '') }}</textarea>
                                                    @error('core_values.'.$index.'.description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="text-end">
                                                    <button type="button" class="btn btn-danger btn-sm remove-value">
                                                        <i class="fas fa-trash"></i> {{ __('Remove') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                
                                <!-- Template for new core value -->
                                <template id="core-value-template">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Value Title') }}</label>
                                                <input type="text" name="core_values[INDEX][title]" class="form-control" placeholder="{{ __('e.g., Integrity, Excellence, etc.') }}">
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Value Icon') }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-star"></i></span>
                                                    <input type="text" name="core_values[INDEX][icon]" class="form-control icon-input" value="fa-star" placeholder="{{ __('e.g., fa-star, fa-users, etc.') }}">
                                                    <button type="button" class="btn btn-outline-secondary icon-selector-btn">
                                                        <i class="fas fa-icons"></i> {{ __('Select Icon') }}
                                                    </button>
                                                </div>
                                                <small class="text-muted">{{ __('Click the button to select an icon or enter a FontAwesome icon class directly') }}</small>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Value Description') }}</label>
                                                <textarea name="core_values[INDEX][description]" class="form-control" rows="3" placeholder="{{ __('Describe this core value...') }}"></textarea>
                                            </div>
                                            
                                            <div class="text-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-value">
                                                    <i class="fas fa-trash"></i> {{ __('Remove') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            
                            <button type="button" class="btn btn-outline-primary btn-sm" id="add-core-value">
                                <i class="fas fa-plus"></i> {{ __('Add Core Value') }}
                            </button>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
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

<!-- Icon Selector Modal -->
<div class="modal fade" id="iconSelectorModal" tabindex="-1" aria-labelledby="iconSelectorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="iconSelectorModalLabel">{{ __('Select an Icon') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="iconSearchInput" placeholder="{{ __('Search icons...') }}">
                </div>
                <div class="row" id="iconsContainer">
                    @php
                        $icons = [
                            'fa-star', 'fa-heart', 'fa-trophy', 'fa-award', 'fa-medal', 
                            'fa-crown', 'fa-gem', 'fa-certificate', 'fa-check-circle',
                            'fa-thumbs-up', 'fa-handshake', 'fa-hands-helping',
                            'fa-users', 'fa-user-friends', 'fa-user-shield', 'fa-user-tie',
                            'fa-balance-scale', 'fa-gavel', 'fa-shield-alt', 'fa-lock',
                            'fa-lightbulb', 'fa-brain', 'fa-graduation-cap', 'fa-book',
                            'fa-chart-line', 'fa-chart-bar', 'fa-chart-pie', 'fa-chart-area',
                            'fa-rocket', 'fa-flag', 'fa-bullseye', 'fa-compass',
                            'fa-clock', 'fa-calendar', 'fa-calendar-check', 'fa-calendar-alt',
                            'fa-comments', 'fa-comment-dots', 'fa-envelope', 'fa-phone',
                            'fa-globe', 'fa-map-marker-alt', 'fa-building', 'fa-home',
                            'fa-briefcase', 'fa-tools', 'fa-wrench', 'fa-cog',
                            'fa-leaf', 'fa-seedling', 'fa-tree', 'fa-recycle',
                            'fa-hand-holding-heart', 'fa-hands', 'fa-hand-holding-usd', 'fa-hand-holding-medical'
                        ];
                    @endphp
                    
                    @foreach($icons as $icon)
                        <div class="col-3 col-md-2 mb-3 icon-item">
                            <div class="icon-option p-3 text-center border rounded" data-icon="{{ $icon }}">
                                <i class="fas {{ $icon }} fa-2x"></i>
                                <div class="small mt-2">{{ $icon }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Summernote

        
        // Icon selector functionality
        let currentIconInput;
        const iconModal = new bootstrap.Modal(document.getElementById('iconSelectorModal'));
        
        // Add click event to icon selector buttons
        document.querySelectorAll('.icon-selector-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Store reference to the input field and preview
                const inputGroup = this.closest('.input-group');
                currentIconInput = inputGroup.querySelector('.icon-input');
                currentIconPreview = inputGroup.querySelector('.input-group-text i');
                
                // Show the modal
                iconModal.show();
            });
        });
        
        // Handle icon selection
        document.querySelectorAll('.icon-option').forEach(option => {
            option.addEventListener('click', function() {
                const iconClass = this.dataset.icon;
                
                // Update the input value and preview
                if (currentIconInput) {
                    currentIconInput.value = iconClass;
                    currentIconPreview.className = 'fas ' + iconClass;
                    
                    // Hide the modal
                    iconModal.hide();
                }
            });
        });
        
        // Icon search functionality
        document.getElementById('iconSearchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            document.querySelectorAll('.icon-item').forEach(item => {
                const iconName = item.querySelector('.small').textContent.toLowerCase();
                if (iconName.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
        
        // Add new core value
        let valueIndex = {{ isset($aboutInfo['core_values']) ? count($aboutInfo['core_values']) : 0 }};
        
        document.getElementById('add-core-value').addEventListener('click', function() {
            const template = document.getElementById('core-value-template').innerHTML;
            const newValue = template.replace(/INDEX/g, valueIndex);
            
            document.querySelector('.core-values').insertAdjacentHTML('beforeend', newValue);
            valueIndex++;
            
            // Attach handlers to new elements
            attachEventHandlers();
        });
        
        // Function to handle remove buttons and attach icon selector functionality
        function attachEventHandlers() {
            // Remove value handlers
            document.querySelectorAll('.remove-value').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (confirm('{{ __("Are you sure you want to remove this core value?") }}')) {
                        this.closest('.card').remove();
                    }
                });
            });
            
            // Icon selector handlers for new elements
            document.querySelectorAll('.icon-selector-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const inputGroup = this.closest('.input-group');
                    currentIconInput = inputGroup.querySelector('.icon-input');
                    currentIconPreview = inputGroup.querySelector('.input-group-text i');
                    iconModal.show();
                });
            });
            
            // Update icon preview when input changes
            document.querySelectorAll('.icon-input').forEach(input => {
                input.addEventListener('input', function() {
                    const preview = this.closest('.input-group').querySelector('.input-group-text i');
                    preview.className = 'fas ' + this.value;
                });
            });
        }
        
        // Attach handlers to existing elements
        attachEventHandlers();
    });
</script>
@endsection 