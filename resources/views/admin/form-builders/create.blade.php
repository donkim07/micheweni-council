@extends('layouts.admin')

@section('title', __('Create Form'))

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.css">
<style>
    .field-card {
        cursor: move;
    }
    .field-card.gu-mirror {
        cursor: grabbing;
    }
    .field-list-empty {
        border: 2px dashed #ccc;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        color: #999;
    }
    
    /* Simple modal styling - fixed positioning for visibility */
    .simple-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
        overflow-y: auto;
        pointer-events: auto;
    }
    
    .simple-modal-dialog {
        margin: 20px auto;
        width: 90%;
        max-width: 800px;
        background: white;
        border-radius: 5px;
        position: relative;
        max-height: 90vh;
        overflow-y: auto;
    }
    
    .simple-modal-content {
        position: relative;
    }
    
    .simple-modal-header {
        padding: 10px 20px;
        border-bottom: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        background: white;
        z-index: 10;
    }
    
    .simple-modal-body {
        padding: 20px;
        overflow-y: auto;
    }
    
    .simple-modal-footer {
        padding: 10px 20px;
        border-top: 1px solid #ddd;
        text-align: right;
        position: sticky;
        bottom: 0;
        background: white;
        z-index: 10;
    }
    
    .simple-close {
        cursor: pointer;
        font-size: 1.5rem;
        font-weight: bold;
    }
    
    /* Style for form fields */
    .field-type-card {
        cursor: pointer;
        transition: all 0.2s;
        border: 1px solid #ddd;
        border-radius: 5px;
        height: 100%;
    }
    
    .field-type-card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transform: translateY(-3px);
    }
    
    .form-field {
        margin-bottom: 15px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        position: relative;
    }
    
    .form-field-actions {
        position: absolute;
        right: 10px;
        top: 10px;
    }
    
    .drag-handle {
        cursor: move;
        margin-right: 5px;
    }
    
    /* Disable Bootstrap's modal backdrop */
    .modal-backdrop {
        display: none !important;
    }
    
    /* Ensure body remains scrollable when modal is open */
    body.simple-modal-open {
        overflow: auto !important;
    }
    
    /* Skip logic visualization */
    .skip-logic-arrow {
        text-align: center;
        margin: 10px 0;
        color: #6c757d;
    }
    
    .skip-logic-arrow i {
        transform: rotate(90deg);
        font-size: 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Create New Form') }}</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.form-builders.index') }}">{{ __('Form Builders') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Create') }}</li>
    </ol>
    
    @if($errors->any())
    <div class="alert alert-danger">
        <h5>Form Submission Errors:</h5>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    
    <form id="formBuilderForm" action="{{ route('admin.form-builders.store') }}" method="POST">
        @csrf
        
        <input type="hidden" name="fields" id="fields" value="[]">
        
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="mb-3">
                    <x-input-label for="title" :value="__('Form Title')" />
                    <x-text-input id="title" name="title" type="text" class="form-control" :value="old('title')" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <x-input-label for="slug" :value="__('Form Slug')" />
                    <x-text-input id="slug" name="slug" type="text" class="form-control" :value="old('slug')" />
                    <small class="form-text text-muted">{{ __('Auto-generated if left blank. Used in form URLs.') }}</small>
                    <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Form Details -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-info-circle me-1"></i>
                        {{ __('Form Details') }}
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="icon" class="form-label">{{ __('Form Icon') }}</label>
                            <select class="form-select @error('icon') is-invalid @enderror" id="icon" name="icon">
                                <option value="">{{ __('No icon') }}</option>
                                @foreach($iconOptions as $value => $label)
                                    <option value="{{ $value }}" @selected(old('icon') == $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        {{ __('Map Settings') }}
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="map_enabled" name="map_enabled" value="1" @checked(old('map_enabled'))>
                            <label class="form-check-label" for="map_enabled">{{ __('Show on Map') }}</label>
                            <div class="form-text">{{ __('Enable to display submissions on the public map.') }}</div>
                        </div>
                        
                        <div class="mb-3 map-setting">
                            <label for="map_icon" class="form-label">{{ __('Map Icon') }}</label>
                            <select class="form-select @error('map_icon') is-invalid @enderror" id="map_icon" name="map_icon">
                                <option value="">{{ __('Default marker') }}</option>
                                @foreach($iconOptions as $value => $label)
                                    <option value="{{ $value }}" @selected(old('map_icon') == $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('map_icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 map-setting">
                            <label for="map_color" class="form-label">{{ __('Map Color') }}</label>
                            <select class="form-select @error('map_color') is-invalid @enderror" id="map_color" name="map_color">
                                <option value="">{{ __('Default color') }}</option>
                                @foreach($colorOptions as $value => $label)
                                    <option value="{{ $value }}" @selected(old('map_color') == $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('map_color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-cog me-1"></i>
                        {{ __('Form Settings') }}
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" @checked(old('is_active', true))>
                            <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> {{ __('Save Form') }}
                            </button>
                            <a href="{{ route('admin.form-builders.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i> {{ __('Cancel') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Builder -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-edit me-1"></i>
                            {{ __('Form Builder') }}
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#simpleAddFieldModal">
                                <i class="fas fa-plus me-1"></i> {{ __('Add Field') }}
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-1"></i>
                            {{ __('Drag and drop fields to rearrange them. Click on a field to edit its properties.') }}
                        </div>
                        
                        <div id="formFields" class="field-list">
                            <div class="field-list-empty">
                                <i class="fas fa-arrow-up fa-2x mb-2"></i>
                                <p>{{ __('Click "Add Field" to start building your form.') }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-4 p-3 border rounded bg-light">
                            <h5>Debug Info:</h5>
                            <div class="alert alert-warning">
                                <strong>IMPORTANT:</strong> When submitting, make sure the JSON below is a valid array, not empty or corrupted.
                                If you see "The fields field must be an array" error, check this section first.
                            </div>
                            <p>Fields JSON (should be valid array format):</p>
                            <pre id="fieldsDebug" style="white-space: pre-wrap; max-height: 150px; overflow: auto; font-size: 12px; background: #f8f9fa; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">[]</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    <!-- Add Field Modal -->
    <div class="simple-modal" id="simpleAddFieldModal">
        <div class="simple-modal-dialog">
            <div class="simple-modal-content">
                <div class="simple-modal-header">
                    <h5>{{ __('Add Form Field') }}</h5>
                    <span class="simple-close" id="closeAddFieldModal">&times;</span>
                </div>
                <div class="simple-modal-body">
                    <div class="row">
                        @foreach($fieldTypes as $type => $field)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 field-type-card" data-field-type="{{ $type }}">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas {{ $field['icon'] }} me-2"></i>
                                            {{ $field['name'] }}
                                        </h5>
                                        <p class="card-text small">{{ $field['description'] }}</p>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <button type="button" class="btn btn-sm btn-primary w-100 add-field-btn" data-field-type="{{ $type }}">
                                            {{ __('Add') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="simple-modal-footer">
                    <button type="button" class="btn btn-secondary close-simple-modal" data-modal="simpleAddFieldModal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Field Properties Modal -->
    <div class="simple-modal" id="simpleFieldPropertiesModal">
        <div class="simple-modal-dialog">
            <div class="simple-modal-content">
                <div class="simple-modal-header">
                    <h5>{{ __('Field Properties') }}</h5>
                    <span class="simple-close" id="closeFieldPropertiesModal">&times;</span>
                </div>
                <div class="simple-modal-body" id="fieldPropertiesForm">
                    <!-- Field properties will be dynamically loaded here -->
                </div>
                <div class="simple-modal-footer">
                    <button type="button" class="btn btn-secondary close-simple-modal" data-modal="simpleFieldPropertiesModal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-primary" id="saveFieldProperties">{{ __('Save Changes') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Basic elements
    const formBuilderForm = document.getElementById('formBuilderForm');
    const formFieldsContainer = document.getElementById('formFields');
    
    // Modal elements
    const addFieldModal = document.getElementById('simpleAddFieldModal');
    const fieldPropertiesModal = document.getElementById('simpleFieldPropertiesModal');
    const fieldPropertiesForm = document.getElementById('fieldPropertiesForm');
    const saveFieldPropertiesBtn = document.getElementById('saveFieldProperties');
    
    // Initialize debug element
    const debugElement = document.getElementById('fieldsDebug');
    
    // Control variables
    let fields = [];
    let fieldCounter = 0;
    let editingFieldId = null;
    
    // Get the existing fields input element
    let fieldsInput = document.getElementById('fields');
    
    // Update debug display with empty array
    if (debugElement) {
        debugElement.textContent = JSON.stringify([], null, 2);
    }
    
    // Make sure the fields input has a valid empty array
    if (fieldsInput) {
        fieldsInput.value = JSON.stringify([]);
    }

    // ====== MODAL HANDLING ======
    
    // Open modal by ID
    function openModal(modalId) {
        // Open modal
        const modal = document.getElementById(modalId);
        if (modal) {
            // Store current scroll position
            const scrollY = window.scrollY;
            
            modal.style.display = 'block';
            document.body.classList.add('simple-modal-open');
            
            // Ensure body scrolling is preserved
            document.body.style.overflow = 'auto';
            document.body.style.height = 'auto';
            
            // Restore scroll position
            window.scrollTo(0, scrollY);
        }
    }
    
    // Close modal by ID
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
            document.body.classList.remove('simple-modal-open');
            // Ensure body scrolling is restored
            document.body.style.overflow = '';
            document.body.style.height = '';
        }
    }
    
    // Add Field button click
    const addFieldBtn = document.querySelector('[data-bs-target="#simpleAddFieldModal"]');
    if (addFieldBtn) {
        addFieldBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openModal('simpleAddFieldModal');
        });
    }
    
    // Close Add Field modal
    document.getElementById('closeAddFieldModal').addEventListener('click', function() {
        closeModal('simpleAddFieldModal');
    });
    
    // Close Field Properties modal
    document.getElementById('closeFieldPropertiesModal').addEventListener('click', function() {
        closeModal('simpleFieldPropertiesModal');
    });
    
    // Close buttons in modal footers
    document.querySelectorAll('.close-simple-modal').forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal');
            closeModal(modalId);
        });
    });
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (document.getElementById('simpleAddFieldModal').style.display === 'block') {
                closeModal('simpleAddFieldModal');
            }
            if (document.getElementById('simpleFieldPropertiesModal').style.display === 'block') {
                closeModal('simpleFieldPropertiesModal');
            }
            // Extra safety: ensure body scrolling is restored
            document.body.style.overflow = '';
            document.body.style.height = '';
        }
    });
    
    // ====== FIELD TYPE BUTTONS ======
    
    // Add field button clicks
    const addFieldButtons = document.querySelectorAll('.add-field-btn');
    addFieldButtons.forEach(button => {
        button.addEventListener('click', function() {
            const fieldType = this.getAttribute('data-field-type');
            addField(fieldType);
            closeModal('simpleAddFieldModal');
        });
    });
    
    // Field type card clicks (whole card clickable)
    const fieldTypeCards = document.querySelectorAll('.field-type-card');
    fieldTypeCards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Only trigger if not clicking a button directly
            if (!e.target.classList.contains('btn') && !e.target.closest('.btn')) {
                const fieldType = this.getAttribute('data-field-type');
                addField(fieldType);
                closeModal('simpleAddFieldModal');
            }
        });
    });
    
    // ====== FORM HANDLING ======
    
    // Initialize dragula for drag and drop 
    const drake = dragula([formFieldsContainer], {
        moves: function(el, container, handle) {
            return handle.classList.contains('drag-handle') || handle.parentElement.classList.contains('drag-handle');
        }
    });
    
    drake.on('drop', function() {
        updateFieldsOrder();
    });
    
    // Add new field to form
    function addField(type) {
        const fieldId = 'field_' + fieldCounter++;
        const fieldName = type + '_' + Date.now();
        
        // Create field object with type-specific properties
        const field = {
            id: fieldId,
            name: fieldName,
            type: type,
            label: getDefaultLabel(type),
            required: false,
            help_text: ''
        };
        
        // Add type-specific properties
        if (['text', 'textarea', 'email', 'number', 'tel', 'url', 'date', 'time', 'select'].includes(type)) {
            field.placeholder = '';
        }
        
        if (['select', 'radio', 'checkboxes'].includes(type)) {
            field.options = [
                { label: 'Option 1', value: 'option_1' },
                { label: 'Option 2', value: 'option_2' }
            ];
        }
        
        if (type === 'conditional') {
            field.condition = {
                field: '',
                operator: '==',
                value: ''
            };
            field.action = 'show'; // show, hide, skip_to
            field.target_field = '';
        }
        
        if (type === 'html') {
            field.html_content = '<div class="alert alert-info">Custom HTML content here</div>';
        }
        
        if (type === 'number') {
            field.min = '';
            field.max = '';
            field.step = '1';
        }
        
        if (type === 'file') {
            field.accept = '.pdf,.doc,.docx,image/*';
            field.multiple = false;
        }
        
        fields.push(field); // Add to fields array
        renderField(field); // Create UI element
        updateFieldsInput(); // Update hidden input
        checkEmptyState(); // Check if we should show empty message
    }
    
    // Get default label for field type
    function getDefaultLabel(type) {
        const labels = {
            'text': 'Text Field',
            'textarea': 'Text Area',
            'select': 'Dropdown',
            'radio': 'Radio Buttons',
            'checkbox': 'Checkbox',
            'checkboxes': 'Multiple Checkboxes',
            'email': 'Email Address',
            'number': 'Number',
            'date': 'Date',
            'time': 'Time',
            'tel': 'Phone Number',
            'url': 'Website URL',
            'file': 'File Upload',
            'html': 'HTML Content',
            'conditional': 'Conditional Field'
        };
        
        return labels[type] || 'New Field';
    }
    
    // Render field in the form builder
    function renderField(field) {
        const fieldElement = document.createElement('div');
        fieldElement.className = 'form-field';
        fieldElement.dataset.fieldId = field.id;
        
        let fieldPreview = '';
        
        // Build HTML based on field type
        switch (field.type) {
            case 'text':
            case 'email':
            case 'number':
            case 'tel':
            case 'url':
            case 'date':
            case 'time':
                fieldPreview = `
                    <label class="form-label">${field.label}${field.required ? ' <span class="text-danger">*</span>' : ''}</label>
                    <input type="${field.type}" class="form-control" placeholder="${field.placeholder || ''}" disabled>
                    ${field.help_text ? `<div class="form-text">${field.help_text}</div>` : ''}
                `;
                break;
            case 'textarea':
                fieldPreview = `
                    <label class="form-label">${field.label}${field.required ? ' <span class="text-danger">*</span>' : ''}</label>
                    <textarea class="form-control" rows="3" placeholder="${field.placeholder || ''}" disabled></textarea>
                    ${field.help_text ? `<div class="form-text">${field.help_text}</div>` : ''}
                `;
                break;
            case 'select':
                let options = '';
                if (field.options && field.options.length) {
                    field.options.forEach(option => {
                        options += `<option>${option.label}</option>`;
                    });
                }
                
                fieldPreview = `
                    <label class="form-label">${field.label}${field.required ? ' <span class="text-danger">*</span>' : ''}</label>
                    <select class="form-select" disabled>
                        <option>${field.placeholder || '-- Select --'}</option>
                        ${options}
                    </select>
                    ${field.help_text ? `<div class="form-text">${field.help_text}</div>` : ''}
                `;
                break;
            case 'radio':
            case 'checkboxes':
                let optionsHtml = '';
                if (field.options && field.options.length) {
                    field.options.forEach(option => {
                        optionsHtml += `
                            <div class="form-check">
                                <input class="form-check-input" type="${field.type === 'radio' ? 'radio' : 'checkbox'}" disabled>
                                <label class="form-check-label">${option.label}</label>
                            </div>
                        `;
                    });
                }
                
                fieldPreview = `
                    <label class="form-label">${field.label}${field.required ? ' <span class="text-danger">*</span>' : ''}</label>
                    ${optionsHtml}
                    ${field.help_text ? `<div class="form-text">${field.help_text}</div>` : ''}
                `;
                break;
            case 'checkbox':
                fieldPreview = `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" disabled>
                        <label class="form-check-label">${field.label}${field.required ? ' <span class="text-danger">*</span>' : ''}</label>
                    </div>
                    ${field.help_text ? `<div class="form-text">${field.help_text}</div>` : ''}
                `;
                break;
            case 'file':
                fieldPreview = `
                    <label class="form-label">${field.label}${field.required ? ' <span class="text-danger">*</span>' : ''}</label>
                    <input type="file" class="form-control" disabled>
                    <small>${field.accept || ''}</small>
                    ${field.help_text ? `<div class="form-text">${field.help_text}</div>` : ''}
                `;
                break;
            case 'html':
                fieldPreview = `
                    <div class="alert alert-secondary">
                        <i class="fas fa-code me-2"></i>HTML Content: ${field.label}
                    </div>
                    <div class="form-text">This will render custom HTML in your form</div>
                `;
                break;
            case 'conditional':
                let actionText = '';
                if (field.action === 'show') {
                    actionText = 'Show fields when condition is met';
                } else if (field.action === 'hide') {
                    actionText = 'Hide fields when condition is met';
                } else if (field.action === 'skip_to') {
                    const targetField = fields.find(f => f.name === field.target_field);
                    const targetLabel = targetField ? targetField.label : field.target_field;
                    actionText = `Skip to "${targetLabel}" when condition is met`;
                }
                
                fieldPreview = `
                    <div class="alert alert-info">
                        <i class="fas fa-code-branch me-2"></i>Conditional Logic: ${field.label}
                        <div class="mt-2 small">
                            When <strong>${field.condition.field}</strong> 
                            ${field.condition.operator} 
                            <strong>${field.condition.value}</strong>: 
                            ${actionText}
                        </div>
                    </div>
                `;
                break;
        }
        
        // Build the complete field element
        fieldElement.innerHTML = `
            <div class="d-flex align-items-center mb-2">
                <span class="drag-handle"><i class="fas fa-grip-vertical text-muted"></i></span>
                <small class="text-muted">${field.type.charAt(0).toUpperCase() + field.type.slice(1)}</small>
            </div>
            <div class="field-preview">
                ${fieldPreview}
            </div>
            <div class="form-field-actions">
                <button type="button" class="btn btn-sm btn-outline-primary edit-field-btn" data-field-id="${field.id}">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger delete-field-btn" data-field-id="${field.id}">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        
        // Add to the form
        formFieldsContainer.appendChild(fieldElement);
        
        // Add event listeners
        const editBtn = fieldElement.querySelector('.edit-field-btn');
        const deleteBtn = fieldElement.querySelector('.delete-field-btn');
        
        editBtn.addEventListener('click', function() {
            const fieldId = this.getAttribute('data-field-id');
            editField(fieldId);
        });
        
        deleteBtn.addEventListener('click', function() {
            const fieldId = this.getAttribute('data-field-id');
            deleteField(fieldId);
        });
    }
    
    // Edit a field
    function editField(fieldId) {
        const field = fields.find(f => f.id === fieldId);
        if (!field) return;
        
        editingFieldId = fieldId;
        
        // Build properties form - common fields for all types
        let propertiesForm = `
            <div class="mb-3">
                <label for="field_label" class="form-label">Field Label</label>
                <input type="text" class="form-control" id="field_label" value="${field.label || ''}">
            </div>
            
            <div class="mb-3">
                <label for="field_name" class="form-label">Field Name</label>
                <input type="text" class="form-control" id="field_name" value="${field.name || ''}">
                <div class="form-text">Used for database storage. Use only letters, numbers, and underscores.</div>
            </div>
        `;
        
        // Add type-specific properties
        if (['text', 'textarea', 'email', 'number', 'tel', 'url', 'date', 'time', 'select'].includes(field.type)) {
            propertiesForm += `
                <div class="mb-3">
                    <label for="field_placeholder" class="form-label">Placeholder</label>
                    <input type="text" class="form-control" id="field_placeholder" value="${field.placeholder || ''}">
                </div>
            `;
        }
        
        // Number field specific options
        if (field.type === 'number') {
            propertiesForm += `
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="field_min" class="form-label">Min Value</label>
                            <input type="number" class="form-control" id="field_min" value="${field.min || ''}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="field_max" class="form-label">Max Value</label>
                            <input type="number" class="form-control" id="field_max" value="${field.max || ''}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="field_step" class="form-label">Step</label>
                            <input type="number" class="form-control" id="field_step" value="${field.step || '1'}" step="0.01">
                        </div>
                    </div>
                </div>
            `;
        }
        
        // File field specific options
        if (field.type === 'file') {
            propertiesForm += `
                <div class="mb-3">
                    <label for="field_accept" class="form-label">Accepted File Types</label>
                    <input type="text" class="form-control" id="field_accept" value="${field.accept || ''}">
                    <div class="form-text">E.g., .pdf,.doc,.docx,image/*</div>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="field_multiple" ${field.multiple ? 'checked' : ''}>
                    <label class="form-check-label" for="field_multiple">Allow multiple files</label>
                </div>
            `;
        }
        
        // Options for select, radio, and checkboxes
        if (['select', 'radio', 'checkboxes'].includes(field.type)) {
            propertiesForm += `
                <div class="mb-3">
                    <label class="form-label">Options</label>
                    <div id="options_container">
            `;
            
            if (field.options && field.options.length) {
                field.options.forEach(option => {
                    propertiesForm += `
                        <div class="input-group mb-2 option-row">
                            <input type="text" class="form-control option-label" placeholder="Label" value="${option.label || ''}">
                            <input type="text" class="form-control option-value" placeholder="Value" value="${option.value || ''}">
                            <button type="button" class="btn btn-outline-danger remove-option-btn"><i class="fas fa-times"></i></button>
                        </div>
                    `;
                });
            }
            
            propertiesForm += `
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="add_option_btn">
                        <i class="fas fa-plus me-1"></i> Add Option
                    </button>
                </div>
            `;
        }
        
        // HTML content field
        if (field.type === 'html') {
            propertiesForm += `
                <div class="mb-3">
                    <label for="field_html_content" class="form-label">HTML Content</label>
                    <textarea class="form-control" id="field_html_content" rows="8">${field.html_content || ''}</textarea>
                    <div class="form-text">Enter custom HTML to be displayed in the form</div>
                </div>
            `;
        }
        
        // Conditional field properties - IMPROVED with skip functionality
        if (field.type === 'conditional') {
            // Get list of available fields to use for conditions
            let fieldOptions = '';
            fields.forEach(f => {
                if (f.id !== fieldId && f.type !== 'html' && f.type !== 'conditional') {
                    fieldOptions += `<option value="${f.name}" ${field.condition && field.condition.field === f.name ? 'selected' : ''}>${f.label}</option>`;
                }
            });
            
            // Get list of fields that can be skipped to
            let targetFieldOptions = '';
            fields.forEach(f => {
                if (f.id !== fieldId) {
                    targetFieldOptions += `<option value="${f.name}" ${field.target_field === f.name ? 'selected' : ''}>${f.label}</option>`;
                }
            });
            
            propertiesForm += `
                <div class="alert alert-info">
                    <strong>Conditional Logic Setup</strong>
                    <p class="mb-0">Use this to control form flow based on user input.</p>
                </div>
                
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong>Condition</strong>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="condition_field" class="form-label">When field</label>
                            <select class="form-control" id="condition_field">
                                <option value="">Select a field</option>
                                ${fieldOptions}
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="condition_operator" class="form-label">Operator</label>
                            <select class="form-control" id="condition_operator">
                                <option value="==" ${field.condition && field.condition.operator === '==' ? 'selected' : ''}>equals</option>
                                <option value="!=" ${field.condition && field.condition.operator === '!=' ? 'selected' : ''}>not equals</option>
                                <option value=">" ${field.condition && field.condition.operator === '>' ? 'selected' : ''}>greater than</option>
                                <option value=">=" ${field.condition && field.condition.operator === '>=' ? 'selected' : ''}>greater than or equal</option>
                                <option value="<" ${field.condition && field.condition.operator === '<' ? 'selected' : ''}>less than</option>
                                <option value="<=" ${field.condition && field.condition.operator === '<=' ? 'selected' : ''}>less than or equal</option>
                                <option value="contains" ${field.condition && field.condition.operator === 'contains' ? 'selected' : ''}>contains</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="condition_value" class="form-label">Value</label>
                            <input type="text" class="form-control" id="condition_value" value="${field.condition ? field.condition.value : ''}">
                        </div>
                    </div>
                </div>
                
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong>Action</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input condition-action" type="radio" id="action_show" name="condition_action" value="show" ${!field.action || field.action === 'show' ? 'checked' : ''}>
                            <label class="form-check-label" for="action_show">Show the next field(s)</label>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input condition-action" type="radio" id="action_hide" name="condition_action" value="hide" ${field.action === 'hide' ? 'checked' : ''}>
                            <label class="form-check-label" for="action_hide">Hide the next field(s)</label>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input condition-action" type="radio" id="action_skip" name="condition_action" value="skip_to" ${field.action === 'skip_to' ? 'checked' : ''}>
                            <label class="form-check-label" for="action_skip">Skip to a specific field</label>
                        </div>
                        
                        <div id="skip_to_field_container" class="mb-3 ${field.action === 'skip_to' ? '' : 'd-none'}">
                            <label for="target_field" class="form-label">Skip to field</label>
                            <select class="form-control" id="target_field">
                                <option value="">Select target field</option>
                                ${targetFieldOptions}
                            </select>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // Help text and required fields for most field types
        if (field.type !== 'html') {
            propertiesForm += `
                <div class="mb-3">
                    <label for="field_help_text" class="form-label">Help Text</label>
                    <input type="text" class="form-control" id="field_help_text" value="${field.help_text || ''}">
                </div>
                
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="field_required" ${field.required ? 'checked' : ''}>
                    <label class="form-check-label" for="field_required">Required field</label>
                </div>
            `;
        }
        
        // Set the form content and show modal
        fieldPropertiesForm.innerHTML = propertiesForm;
        openModal('simpleFieldPropertiesModal');
        
        // Toggle skip-to field visibility based on action selection
        const actionRadios = document.querySelectorAll('.condition-action');
        const skipToContainer = document.getElementById('skip_to_field_container');
        
        if (actionRadios.length && skipToContainer) {
            actionRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    skipToContainer.classList.toggle('d-none', this.value !== 'skip_to');
                });
            });
        }
        
        // Add option button event listener
        const addOptionBtn = document.getElementById('add_option_btn');
        if (addOptionBtn) {
            addOptionBtn.addEventListener('click', function() {
                const optionsContainer = document.getElementById('options_container');
                const optionRow = document.createElement('div');
                optionRow.className = 'input-group mb-2 option-row';
                optionRow.innerHTML = `
                    <input type="text" class="form-control option-label" placeholder="Label">
                    <input type="text" class="form-control option-value" placeholder="Value">
                    <button type="button" class="btn btn-outline-danger remove-option-btn"><i class="fas fa-times"></i></button>
                `;
                optionsContainer.appendChild(optionRow);
                
                // Add remove button event listener
                const removeBtn = optionRow.querySelector('.remove-option-btn');
                removeBtn.addEventListener('click', function() {
                    optionRow.remove();
                });
            });
        }
        
        // Add event listeners to existing remove option buttons
        document.querySelectorAll('.remove-option-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('.option-row');
                if (row) row.remove();
            });
        });
    }
    
    // Save field properties
    if (saveFieldPropertiesBtn) {
        saveFieldPropertiesBtn.addEventListener('click', function() {
            // This is the main save function for field properties
            const field = fields.find(f => f.id === editingFieldId);
            if (!field) return;
            
            // Get basic values
            field.label = document.getElementById('field_label').value || 'Field';
            field.name = document.getElementById('field_name').value || field.name;
            
            if (field.type !== 'html') {
                field.required = document.getElementById('field_required').checked;
                field.help_text = document.getElementById('field_help_text').value || '';
            }
            
            // Get placeholder if applicable
            const placeholderField = document.getElementById('field_placeholder');
            if (placeholderField) {
                field.placeholder = placeholderField.value || '';
            }
            
            // Get number field specific values
            if (field.type === 'number') {
                field.min = document.getElementById('field_min').value;
                field.max = document.getElementById('field_max').value;
                field.step = document.getElementById('field_step').value || '1';
            }
            
            // Get file field specific values
            if (field.type === 'file') {
                field.accept = document.getElementById('field_accept').value;
                field.multiple = document.getElementById('field_multiple').checked;
            }
            
            // Get HTML content
            if (field.type === 'html') {
                field.html_content = document.getElementById('field_html_content').value;
            }
            
            // Get conditional field values
            if (field.type === 'conditional') {
                field.condition = {
                    field: document.getElementById('condition_field').value,
                    operator: document.getElementById('condition_operator').value,
                    value: document.getElementById('condition_value').value
                };
                
                // Get action type
                if (document.getElementById('action_show').checked) {
                    field.action = 'show';
                } else if (document.getElementById('action_hide').checked) {
                    field.action = 'hide';
                } else if (document.getElementById('action_skip').checked) {
                    field.action = 'skip_to';
                    field.target_field = document.getElementById('target_field').value;
                }
            }
            
            // Get options if applicable
            if (['select', 'radio', 'checkboxes'].includes(field.type)) {
                const optionRows = document.querySelectorAll('.option-row');
                field.options = [];
                
                optionRows.forEach(row => {
                    const labelInput = row.querySelector('.option-label');
                    const valueInput = row.querySelector('.option-value');
                    
                    if (labelInput && labelInput.value.trim()) {
                        const label = labelInput.value;
                        const value = valueInput && valueInput.value.trim() 
                            ? valueInput.value 
                            : label.toLowerCase().replace(/[^a-z0-9]+/g, '_');
                        
                        field.options.push({
                            label: label,
                            value: value
                        });
                    }
                });
                
                // Ensure at least one option
                if (field.options.length === 0) {
                    field.options.push({
                        label: 'Option 1',
                        value: 'option_1'
                    });
                }
            }
            
            // Update UI & data
            const fieldElement = document.querySelector(`.form-field[data-field-id="${field.id}"]`);
            if (fieldElement) {
                fieldElement.remove();
                renderField(field);
            }
            
            updateFieldsInput();
            closeModal('simpleFieldPropertiesModal');
        });
    }
    
    // Delete a field
    function deleteField(fieldId) {
        if (!confirm('Are you sure you want to delete this field?')) return;
        
        const fieldIndex = fields.findIndex(f => f.id === fieldId);
        if (fieldIndex === -1) return;
        
        fields.splice(fieldIndex, 1);
        
        const fieldElement = document.querySelector(`.form-field[data-field-id="${fieldId}"]`);
        if (fieldElement) fieldElement.remove();
        
        updateFieldsInput();
        checkEmptyState();
    }
    
    // Update hidden input with JSON data
    function updateFieldsInput() {
        try {
            // Make a clean copy of fields without the temporary id
            const cleanFields = fields.map(field => {
                const cleanField = { ...field };
                delete cleanField.id; // Remove the temporary id used for UI only
                return cleanField;
            });
            
            // Update hidden input
            fieldsInput.value = JSON.stringify(cleanFields);
            
            // Update debug display
            const debugElement = document.getElementById('fieldsDebug');
            if (debugElement) {
                debugElement.textContent = JSON.stringify(cleanFields, null, 2);
            }
            
            console.log("Fields updated:", cleanFields);
        } catch (error) {
            console.error("Error updating fields input:", error);
        }
    }
    
    // Update field order after drag and drop
    function updateFieldsOrder() {
        const fieldElements = formFieldsContainer.querySelectorAll('.form-field');
        const newFields = [];
        
        fieldElements.forEach(element => {
            const fieldId = element.dataset.fieldId;
            const field = fields.find(f => f.id === fieldId);
            if (field) newFields.push(field);
        });
        
        fields = newFields;
        updateFieldsInput();
    }
    
    // Check for empty state and display message if needed
    function checkEmptyState() {
        // Remove existing message if any
        const existingMessage = formFieldsContainer.querySelector('.field-list-empty');
        if (existingMessage) existingMessage.remove();
        
        // Show message if no fields
        if (fields.length === 0) {
            const message = document.createElement('div');
            message.className = 'field-list-empty';
            message.innerHTML = '<i class="fas fa-arrow-up fa-2x mb-2"></i><p>Click "Add Field" to start building your form.</p>';
            formFieldsContainer.appendChild(message);
        }
    }
    
    // Initialize - check empty state at startup
    checkEmptyState();
    
    // Add form submission validation and ensure fields is an array
    if (formBuilderForm) {
        formBuilderForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default submission
            
            try {
                // Prevent submission if fields array is empty
                if (fields.length === 0) {
                    alert('Please add at least one field to your form');
                    return false;
                }
                
                // Make a clean copy of fields without the temporary id
                const cleanFields = fields.map(field => {
                    const cleanField = {...field};
                    delete cleanField.id; // Remove the temporary id used for UI only
                    return cleanField;
                });
                
                // Update the hidden input with the clean fields data
                fieldsInput.value = JSON.stringify(cleanFields);
                
                // Create a FormData object from the form
                const formData = new FormData(formBuilderForm);
                
                // Log the form data for debugging
                console.log("Submitting form with fields:", fieldsInput.value);
                
                // Submit using fetch API
                fetch(formBuilderForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Form submission failed');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.location.href = data.redirect || '/admin/form-builders';
                    } else {
                        alert(data.message || 'Error saving form');
                    }
                })
                .catch(error => {
                    console.error('Submission error:', error);
                    alert('Error: ' + error.message);
                });
            } catch (error) {
                console.error('Form preparation error:', error);
                alert('Error: ' + error.message);
            }
        });
    }
});
</script>
@endsection 


