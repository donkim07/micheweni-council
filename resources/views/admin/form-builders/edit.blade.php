@extends('layouts.admin')

@section('title', __('Edit Form'))

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
    }
    
    .simple-modal-dialog {
        margin: 20px auto;
        width: 90%;
        max-width: 800px;
        background: white;
        border-radius: 5px;
        position: relative;
        top: 50%;
        transform: translateY(-50%);
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
    <h1 class="mt-4">{{ __('Edit Form') }}: {{ $form->title }}</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.form-builders.index') }}">{{ __('Form Builders') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Edit') }}</li>
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
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    
    <form id="formBuilderForm" action="{{ route('admin.form-builders.update', $form->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <input type="hidden" name="fields" id="fields" value="{{ json_encode($form->fields) }}">
        
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="mb-3">
                    <x-input-label for="title" :value="__('Form Title')" />
                    <x-text-input id="title" name="title" type="text" class="form-control" :value="old('title', $form->title)" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <x-input-label for="slug" :value="__('Form Slug')" />
                    <x-text-input id="slug" name="slug" type="text" class="form-control" :value="old('slug', $form->slug)" />
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
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $form->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="icon" class="form-label">{{ __('Form Icon') }}</label>
                            <select class="form-select @error('icon') is-invalid @enderror" id="icon" name="icon">
                                <option value="">{{ __('No icon') }}</option>
                                @foreach($iconOptions as $value => $label)
                                    <option value="{{ $value }}" @selected(old('icon', $form->icon) == $value)>{{ $label }}</option>
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
                            <input class="form-check-input" type="checkbox" id="map_enabled" name="map_enabled" value="1" @checked(old('map_enabled', $form->map_enabled))>
                            <label class="form-check-label" for="map_enabled">{{ __('Show on Map') }}</label>
                            <div class="form-text">{{ __('Enable to display submissions on the public map.') }}</div>
                        </div>
                        
                        <div class="mb-3 map-setting">
                            <label for="map_icon" class="form-label">{{ __('Map Icon') }}</label>
                            <select class="form-select @error('map_icon') is-invalid @enderror" id="map_icon" name="map_icon">
                                <option value="">{{ __('Default marker') }}</option>
                                @foreach($iconOptions as $value => $label)
                                    <option value="{{ $value }}" @selected(old('map_icon', $form->map_icon) == $value)>{{ $label }}</option>
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
                                    <option value="{{ $value }}" @selected(old('map_color', $form->map_color) == $value)>{{ $label }}</option>
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
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" @checked(old('is_active', $form->is_active))>
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
                            {{ __('Form Fields') }}
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-primary" id="addFieldBtn">
                                <i class="fas fa-plus me-1"></i> {{ __('Add Field') }}
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="formFields">
                            <!-- Field list will be populated by JavaScript -->
                        </div>
                        
                        <div class="mt-4 p-3 border rounded bg-light">
                            <h5>{{ __('Debug Information') }}:</h5>
                            <div class="alert alert-warning">
                                {{ __('Fields JSON (should be valid array format):') }}
                            </div>
                            <pre id="fieldsDebug" style="max-height: 200px; overflow-y: auto;"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Field Type Selection Modal -->
<div class="simple-modal" id="fieldTypeModal">
    <div class="simple-modal-dialog">
        <div class="simple-modal-content">
            <div class="simple-modal-header">
                <h5 class="modal-title">{{ __('Select Field Type') }}</h5>
                <span class="simple-close" id="closeFieldTypeModal">&times;</span>
            </div>
            <div class="simple-modal-body">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach($fieldTypes as $type => $fieldType)
                    <div class="col">
                        <div class="card field-type-card" data-field-type="{{ $type }}">
                            <div class="card-body text-center">
                                <i class="fas {{ $fieldType['icon'] }} fa-2x mb-2"></i>
                                <h5 class="card-title">{{ $fieldType['name'] }}</h5>
                                <p class="card-text small">{{ $fieldType['description'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Field Editor Modal -->
<div class="simple-modal" id="fieldEditorModal">
    <div class="simple-modal-dialog">
        <div class="simple-modal-content">
            <div class="simple-modal-header">
                <h5 class="modal-title" id="fieldEditorTitle">{{ __('Edit Field') }}</h5>
                <span class="simple-close" id="closeFieldEditorModal">&times;</span>
            </div>
            <div class="simple-modal-body">
                <!-- Field editor form will be dynamically populated -->
                <div id="fieldEditorContent"></div>
            </div>
            <div class="simple-modal-footer">
                <button type="button" class="btn btn-danger me-2" id="deleteFieldBtn">{{ __('Delete Field') }}</button>
                <button type="button" class="btn btn-secondary me-2" id="cancelFieldBtn">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" id="saveFieldBtn">{{ __('Save Field') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // DOM elements
    const formFieldsContainer = document.getElementById('formFields');
    const fieldsInput = document.getElementById('fields');
    const fieldsDebug = document.getElementById('fieldsDebug');
    const addFieldBtn = document.getElementById('addFieldBtn');
    const fieldTypeModal = document.getElementById('fieldTypeModal');
    const closeFieldTypeModal = document.getElementById('closeFieldTypeModal');
    const fieldEditorModal = document.getElementById('fieldEditorModal');
    const closeFieldEditorModal = document.getElementById('closeFieldEditorModal');
    const deleteFieldBtn = document.getElementById('deleteFieldBtn');
    const cancelFieldBtn = document.getElementById('cancelFieldBtn');
    const saveFieldBtn = document.getElementById('saveFieldBtn');
    
    // Initialize fields array from the form data
    let fields = [];
    try {
        const initialFields = JSON.parse(fieldsInput.value || '[]');
        
        // Add temporary IDs to each field for UI manipulation
        fields = initialFields.map(field => {
            return {
                ...field,
                id: 'field_' + Math.random().toString(36).substr(2, 9)
            };
        });
        
        // Update debug display
        if (fieldsDebug) {
            fieldsDebug.textContent = JSON.stringify(fields, null, 2);
        }
    } catch (error) {
        console.error('Error initializing fields:', error);
        fields = [];
    }
    
    // Render all existing fields
    fields.forEach(field => renderField(field));
    
    // Initialize drag and drop
    const drake = dragula([formFieldsContainer], {
        moves: function(el, container, handle) {
            return handle.classList.contains('drag-handle') || 
                   handle.parentElement.classList.contains('drag-handle');
        }
    });
    
    drake.on('drop', updateFieldsOrder);
    
    // Add field button event
    addFieldBtn.addEventListener('click', function() {
        showModal(fieldTypeModal);
    });
    
    // Field type selection
    document.querySelectorAll('.field-type-card').forEach(card => {
        card.addEventListener('click', function() {
            const fieldType = this.dataset.fieldType;
            const field = createNewField(fieldType);
            hideModal(fieldTypeModal);
            openFieldEditor(field);
        });
    });
    
    // Close modal buttons
    closeFieldTypeModal.addEventListener('click', () => hideModal(fieldTypeModal));
    closeFieldEditorModal.addEventListener('click', () => hideModal(fieldEditorModal));
    
    // Delete field button
    deleteFieldBtn.addEventListener('click', function() {
        const fieldId = this.dataset.fieldId;
        if (fieldId) {
            deleteField(fieldId);
            hideModal(fieldEditorModal);
        }
    });
    
    // Cancel button
    cancelFieldBtn.addEventListener('click', () => hideModal(fieldEditorModal));
    
    // Save field button - direct click handler
    saveFieldBtn.addEventListener('click', saveFieldChanges);
    
    // Create a new field object
    function createNewField(type) {
        return {
            id: 'field_' + Math.random().toString(36).substr(2, 9),
            type: type,
            name: '',
            label: '',
            required: false,
            placeholder: '',
            help_text: '',
            options: type === 'select' || type === 'radio' || type === 'checkbox' ? 
                [{ label: 'Option 1', value: 'option_1' }] : [],
            condition: type === 'conditional' ? { field: '', operator: '==', value: '' } : null,
            action: type === 'conditional' ? 'show' : null
        };
    }
    
    // Render a field in the form builder
    function renderField(field) {
        const fieldElement = document.createElement('div');
        fieldElement.className = 'card mb-3 form-field';
        fieldElement.dataset.fieldId = field.id;
        fieldElement.dataset.fieldType = field.type;
        
        let iconClass = 'fa-question';
        switch (field.type) {
            case 'text': iconClass = 'fa-font'; break;
            case 'textarea': iconClass = 'fa-paragraph'; break;
            case 'number': iconClass = 'fa-hashtag'; break;
            case 'email': iconClass = 'fa-envelope'; break;
            case 'select': iconClass = 'fa-caret-down'; break;
            case 'checkbox': iconClass = 'fa-check-square'; break;
            case 'radio': iconClass = 'fa-circle-dot'; break;
            case 'date': iconClass = 'fa-calendar'; break;
            case 'file': iconClass = 'fa-upload'; break;
            case 'conditional': iconClass = 'fa-code-branch'; break;
            // Add more cases as needed
        }
        
        fieldElement.innerHTML = `
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <span class="drag-handle"><i class="fas fa-grip-vertical"></i></span>
                    <i class="fas ${iconClass} me-1"></i>
                    <strong>${field.label || 'Unnamed Field'}</strong>
                    ${field.required ? '<span class="badge bg-danger ms-2">Required</span>' : ''}
                </div>
                <div>
                    <button type="button" class="btn btn-sm btn-outline-primary edit-field-btn" data-field-id="${field.id}">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div><strong>Type:</strong> ${field.type}</div>
                <div><strong>Name:</strong> ${field.name}</div>
                ${field.help_text ? `<div><strong>Help Text:</strong> ${field.help_text}</div>` : ''}
                ${field.placeholder ? `<div><strong>Placeholder:</strong> ${field.placeholder}</div>` : ''}
                ${field.options && field.options.length > 0 ? 
                    `<div><strong>Options:</strong> ${field.options.map(o => o.label).join(', ')}</div>` : ''}
                ${field.condition ? `<div><strong>Condition:</strong> ${field.condition.field} ${field.condition.operator} ${field.condition.value}</div>` : ''}
                ${field.action ? `<div><strong>Action:</strong> ${field.action}</div>` : ''}
                ${field.target_field ? `<div><strong>Target Field:</strong> ${field.target_field}</div>` : ''}
            </div>
        `;
        
        // Add edit button event
        const editBtn = fieldElement.querySelector('.edit-field-btn');
        if (editBtn) {
            editBtn.addEventListener('click', function() {
                openFieldEditor(field);
            });
        }
        
        formFieldsContainer.appendChild(fieldElement);
    }
    
    // Open field editor
    function openFieldEditor(field) {
        deleteFieldBtn.dataset.fieldId = field.id;
        
        // Set modal title
        document.getElementById('fieldEditorTitle').textContent = field.label ? 
            `Edit Field: ${field.label}` : 'Add New Field';
        
        // Build the editor form based on field type
        const editorContent = document.getElementById('fieldEditorContent');
        
        let html = `
            <form id="fieldEditorForm">
                <input type="hidden" id="fieldId" value="${field.id}">
                <input type="hidden" id="fieldType" value="${field.type}">
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="fieldLabel" class="form-label">Field Label</label>
                        <input type="text" class="form-control" id="fieldLabel" value="${field.label || ''}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="fieldName" class="form-label">Field Name</label>
                        <input type="text" class="form-control" id="fieldName" value="${field.name || ''}" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="fieldRequired" ${field.required ? 'checked' : ''}>
                        <label class="form-check-label" for="fieldRequired">Required Field</label>
                    </div>
                </div>
        `;
        
        // Add field type specific options
        if (['text', 'textarea', 'email', 'number', 'tel', 'url', 'date', 'time', 'select'].includes(field.type)) {
            html += `
                <div class="mb-3">
                    <label for="fieldPlaceholder" class="form-label">Placeholder Text</label>
                    <input type="text" class="form-control" id="fieldPlaceholder" value="${field.placeholder || ''}">
                </div>
            `;
        }
        
        // Number specific fields
        if (field.type === 'number') {
            html += `
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="fieldMin" class="form-label">Min Value</label>
                        <input type="number" class="form-control" id="fieldMin" value="${field.min || ''}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fieldMax" class="form-label">Max Value</label>
                        <input type="number" class="form-control" id="fieldMax" value="${field.max || ''}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fieldStep" class="form-label">Step</label>
                        <input type="number" class="form-control" id="fieldStep" value="${field.step || '1'}" step="0.01">
                    </div>
                </div>
            `;
        }
        
        // Help text
        html += `
            <div class="mb-3">
                <label for="fieldHelpText" class="form-label">Help Text</label>
                <textarea class="form-control" id="fieldHelpText" rows="2">${field.help_text || ''}</textarea>
            </div>
        `;
        
        // Add options for select, radio, checkbox
        if (['select', 'radio', 'checkbox'].includes(field.type)) {
            html += `
                <div class="mb-3">
                    <label class="form-label">Options</label>
                    <div id="optionsContainer">
                        ${field.options && field.options.length > 0 ? 
                            field.options.map((option, index) => `
                                <div class="input-group mb-2 option-row">
                                    <span class="input-group-text">Label</span>
                                    <input type="text" class="form-control option-label" value="${option.label || ''}">
                                    <span class="input-group-text">Value</span>
                                    <input type="text" class="form-control option-value" value="${option.value || ''}">
                                    <button type="button" class="btn btn-outline-danger remove-option-btn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            `).join('') : 
                            `<div class="input-group mb-2 option-row">
                                <span class="input-group-text">Label</span>
                                <input type="text" class="form-control option-label" value="Option 1">
                                <span class="input-group-text">Value</span>
                                <input type="text" class="form-control option-value" value="option_1">
                                <button type="button" class="btn btn-outline-danger remove-option-btn">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>`
                        }
                    </div>
                    <button type="button" class="btn btn-outline-secondary mt-2" id="addOptionBtn">
                        <i class="fas fa-plus"></i> Add Option
                    </button>
                </div>
            `;
        }
        
        // Conditional fields
        if (field.type === 'conditional' || field.condition) {
            // Get list of available fields to target
            const fieldOptions = fields
                .filter(f => f.id !== field.id)
                .map(f => `<option value="${f.name}" ${field.condition && field.condition.field === f.name ? 'selected' : ''}>${f.label}</option>`)
                .join('');
                
            html += `
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong>Condition</strong>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="conditionField" class="form-label">When field</label>
                            <select class="form-control" id="conditionField">
                                <option value="">Select field</option>
                                ${fieldOptions}
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="conditionOperator" class="form-label">Operator</label>
                            <select class="form-control" id="conditionOperator">
                                <option value="==" ${field.condition && field.condition.operator === '==' ? 'selected' : ''}>equals (==)</option>
                                <option value="!=" ${field.condition && field.condition.operator === '!=' ? 'selected' : ''}>not equals (!=)</option>
                                <option value=">" ${field.condition && field.condition.operator === '>' ? 'selected' : ''}>greater than (>)</option>
                                <option value=">=" ${field.condition && field.condition.operator === '>=' ? 'selected' : ''}>greater than or equal (>=)</option>
                                <option value="<" ${field.condition && field.condition.operator === '<' ? 'selected' : ''}>less than (<)</option>
                                <option value="<=" ${field.condition && field.condition.operator === '<=' ? 'selected' : ''}>less than or equal (<=)</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="conditionValue" class="form-label">Value</label>
                            <input type="text" class="form-control" id="conditionValue" value="${field.condition ? field.condition.value : ''}">
                        </div>
                    </div>
                </div>
                
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong>Action</strong>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="fieldAction" class="form-label">Action Type</label>
                            <select class="form-control" id="fieldAction">
                                <option value="show" ${!field.action || field.action === 'show' ? 'selected' : ''}>Show field(s)</option>
                                <option value="hide" ${field.action === 'hide' ? 'selected' : ''}>Hide field(s)</option>
                                <option value="skip_to" ${field.action === 'skip_to' ? 'selected' : ''}>Skip to field</option>
                            </select>
                        </div>
                        
                        <div class="mb-3 ${field.action === 'skip_to' ? '' : 'd-none'}" id="targetFieldContainer">
                            <label for="targetField" class="form-label">Skip to</label>
                            <select class="form-control" id="targetField">
                                <option value="">Select target field</option>
                                ${fieldOptions}
                            </select>
                        </div>
                    </div>
                </div>
            `;
        }
        
        html += `</form>`;
        
        editorContent.innerHTML = html;
        
        // Add option button event
        const addOptionBtn = document.getElementById('addOptionBtn');
        if (addOptionBtn) {
            addOptionBtn.addEventListener('click', function() {
                const optionsContainer = document.getElementById('optionsContainer');
                const newOption = document.createElement('div');
                newOption.className = 'input-group mb-2 option-row';
                newOption.innerHTML = `
                    <span class="input-group-text">Label</span>
                    <input type="text" class="form-control option-label" value="">
                    <span class="input-group-text">Value</span>
                    <input type="text" class="form-control option-value" value="">
                    <button type="button" class="btn btn-outline-danger remove-option-btn">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                
                optionsContainer.appendChild(newOption);
                
                // Add remove button event
                const removeBtn = newOption.querySelector('.remove-option-btn');
                if (removeBtn) {
                    removeBtn.addEventListener('click', function() {
                        newOption.remove();
                    });
                }
            });
        }
        
        // Add remove option button events
        document.querySelectorAll('.remove-option-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (document.querySelectorAll('.option-row').length > 1) {
                    this.closest('.option-row').remove();
                }
            });
        });
        
        // Add action type change handler
        const fieldAction = document.getElementById('fieldAction');
        const targetFieldContainer = document.getElementById('targetFieldContainer');
        if (fieldAction && targetFieldContainer) {
            fieldAction.addEventListener('change', function() {
                targetFieldContainer.classList.toggle('d-none', this.value !== 'skip_to');
            });
        }
        
        showModal(fieldEditorModal);
    }
    
    // Save field changes
    function saveFieldChanges() {
        const fieldId = document.getElementById('fieldId').value;
        const fieldType = document.getElementById('fieldType').value;
        
        // Find the field in the array
        const fieldIndex = fields.findIndex(f => f.id === fieldId);
        if (fieldIndex === -1) return;
        
        // Get field values
        const label = document.getElementById('fieldLabel').value;
        const name = document.getElementById('fieldName').value || label.toLowerCase().replace(/[^a-z0-9]+/g, '_');
        const required = document.getElementById('fieldRequired').checked;
        const helpText = document.getElementById('fieldHelpText').value;
        
        // Update field
        fields[fieldIndex] = {
            ...fields[fieldIndex],
            label: label,
            name: name,
            required: required,
            help_text: helpText
        };
        
        // Get placeholder if applicable
        const placeholderField = document.getElementById('fieldPlaceholder');
        if (placeholderField) {
            fields[fieldIndex].placeholder = placeholderField.value || '';
        }
        
        // Get number specific fields
        if (fieldType === 'number') {
            const min = document.getElementById('fieldMin');
            const max = document.getElementById('fieldMax');
            const step = document.getElementById('fieldStep');
            
            if (min) fields[fieldIndex].min = min.value;
            if (max) fields[fieldIndex].max = max.value;
            if (step) fields[fieldIndex].step = step.value || '1';
        }
        
        // Get options if applicable
        if (['select', 'radio', 'checkbox'].includes(fieldType)) {
            const optionRows = document.querySelectorAll('.option-row');
            const options = [];
            
            optionRows.forEach(row => {
                const labelInput = row.querySelector('.option-label');
                const valueInput = row.querySelector('.option-value');
                
                if (labelInput && labelInput.value.trim()) {
                    const label = labelInput.value;
                    const value = valueInput && valueInput.value.trim() 
                        ? valueInput.value 
                        : label.toLowerCase().replace(/[^a-z0-9]+/g, '_');
                    
                    options.push({
                        label: label,
                        value: value
                    });
                }
            });
            
            // Ensure at least one option
            if (options.length === 0) {
                options.push({
                    label: 'Option 1',
                    value: 'option_1'
                });
            }
            
            fields[fieldIndex].options = options;
        }
        
        // Get conditional field values
        const conditionField = document.getElementById('conditionField');
        if (conditionField) {
            const conditionOperator = document.getElementById('conditionOperator');
            const conditionValue = document.getElementById('conditionValue');
            const fieldAction = document.getElementById('fieldAction');
            
            // Only set condition if a field is selected
            if (conditionField.value) {
                fields[fieldIndex].condition = {
                    field: conditionField.value,
                    operator: conditionOperator.value,
                    value: conditionValue.value
                };
                
                fields[fieldIndex].action = fieldAction.value;
                
                // For skip_to action, get the target field
                if (fieldAction.value === 'skip_to') {
                    const targetField = document.getElementById('targetField');
                    if (targetField && targetField.value) {
                        fields[fieldIndex].target_field = targetField.value;
                    }
                }
            }
        }
        
        // Remove the existing field element
        const fieldElement = document.querySelector(`.form-field[data-field-id="${fieldId}"]`);
        if (fieldElement) fieldElement.remove();
        
        // Render the updated field
        renderField(fields[fieldIndex]);
        
        // Update hidden input
        updateFieldsInput();
        
        // Close the modal
        hideModal(fieldEditorModal);
    }
    
    // Delete a field
    function deleteField(fieldId) {
        const fieldIndex = fields.findIndex(f => f.id === fieldId);
        if (fieldIndex === -1) return;
        
        fields.splice(fieldIndex, 1);
        
        const fieldElement = document.querySelector(`.form-field[data-field-id="${fieldId}"]`);
        if (fieldElement) fieldElement.remove();
        
        updateFieldsInput();
    }
    
    // Update fields hidden input
    function updateFieldsInput() {
        // Make a clean copy of fields without the temporary id
        const cleanFields = fields.map(field => {
            const cleanField = { ...field };
            delete cleanField.id; // Remove the temporary id used for UI only
            return cleanField;
        });
        
        fieldsInput.value = JSON.stringify(cleanFields);
        
        // Update debug display
        if (fieldsDebug) {
            fieldsDebug.textContent = JSON.stringify(cleanFields, null, 2);
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
    
    // Show modal
    function showModal(modal) {
        if (modal) modal.style.display = 'block';
    }
    
    // Hide modal
    function hideModal(modal) {
        if (modal) modal.style.display = 'none';
    }
    
    // Submit form handler
    document.getElementById('formBuilderForm').addEventListener('submit', function(e) {
        // Make sure we have at least one field
        if (fields.length === 0) {
            e.preventDefault();
            alert('Please add at least one field to your form');
            return false;
        }
        
        // Update the fields input before submitting
        updateFieldsInput();
    });
});
</script>
@endsection 