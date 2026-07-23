@extends('layouts.admin')

@section('title', __('View Form'))

@section('styles')
<style>
    .field-card {
        margin-bottom: 15px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    
    .field-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .field-meta {
        color: #6c757d;
        font-size: 0.875rem;
    }
    
    .field-options {
        margin-top: 10px;
    }
    
    .field-options-list {
        list-style: none;
        padding-left: 0;
    }
    
    .field-options-list li {
        padding: 5px 0;
        border-bottom: 1px solid #eee;
    }
    
    .field-options-list li:last-child {
        border-bottom: none;
    }
    
    .conditional-logic {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ $form->title }}</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.form-builders.index') }}">{{ __('Form Builders') }}</a></li>
        <li class="breadcrumb-item active">{{ __('View') }}</li>
    </ol>
    
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas {{ $form->icon ?? 'fa-clipboard' }} me-1"></i>
                        {{ __('Form Details') }}
                    </div>
                    <div>
                        <a href="{{ route('admin.form-builders.edit', $form->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> {{ __('Edit Form') }}
                        </a>
                        <a href="{{ route('admin.form-submissions.index', ['form_id' => $form->id]) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-list"></i> {{ __('View Submissions') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('Title') }}</label>
                                <p>{{ $form->title }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('Slug') }}</label>
                                <p>{{ $form->slug }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('Description') }}</label>
                                <p>{{ $form->description ?? __('No description provided.') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('Status') }}</label>
                                <p>
                                    @if($form->is_active)
                                        <span class="badge bg-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ __('Inactive') }}</span>
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('Map Enabled') }}</label>
                                <p>
                                    @if($form->map_enabled)
                                        <span class="badge bg-success">{{ __('Yes') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ __('No') }}</span>
                                    @endif
                                </p>
                            </div>
                            @if($form->map_enabled)
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('Map Icon') }}</label>
                                <p>
                                    @if($form->map_icon)
                                        <i class="fas {{ $form->map_icon }} me-2"></i> {{ $form->map_icon }}
                                    @else
                                        {{ __('Default') }}
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('Map Color') }}</label>
                                <p>
                                    @if($form->map_color)
                                        <span class="badge bg-{{ $form->map_color }}">{{ $form->map_color }}</span>
                                    @else
                                        {{ __('Default') }}
                                    @endif
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-list me-1"></i>
            {{ __('Form Fields') }}
        </div>
        <div class="card-body">
            @if(empty($form->fields) || count($form->fields) === 0)
                <div class="alert alert-info">
                    {{ __('This form does not have any fields defined.') }}
                </div>
            @else
                <div class="row">
                    <div class="col-md-12">
                        @foreach($form->fields as $index => $field)
                            <div class="field-card">
                                <div class="field-header">
                                    <h5>
                                        @if(isset($field['type']))
                                            @php
                                                $iconMap = [
                                                    'text' => 'fa-font',
                                                    'textarea' => 'fa-paragraph',
                                                    'number' => 'fa-hashtag',
                                                    'email' => 'fa-envelope',
                                                    'phone' => 'fa-phone',
                                                    'select' => 'fa-caret-down',
                                                    'multiselect' => 'fa-list-check',
                                                    'checkbox' => 'fa-check-square',
                                                    'radio' => 'fa-circle-dot',
                                                    'date' => 'fa-calendar',
                                                    'time' => 'fa-clock',
                                                    'file' => 'fa-upload',
                                                    'image' => 'fa-image',
                                                    'location' => 'fa-map-marker-alt',
                                                    'heading' => 'fa-heading',
                                                    'divider' => 'fa-minus',
                                                    'html' => 'fa-code',
                                                    'conditional' => 'fa-code-branch',
                                                ];
                                                $icon = $iconMap[$field['type']] ?? 'fa-question';
                                            @endphp
                                            <i class="fas {{ $icon }} me-2"></i>
                                        @endif
                                        {{ $field['label'] }}
                                    </h5>
                                    <span class="badge bg-secondary">{{ $field['type'] ?? 'Unknown Type' }}</span>
                                </div>
                                
                                <div class="field-meta">
                                    <strong>{{ __('Name') }}:</strong> {{ $field['name'] ?? 'unnamed' }}
                                    @if(isset($field['required']) && $field['required'])
                                        <span class="badge bg-danger ms-2">{{ __('Required') }}</span>
                                    @endif
                                </div>
                                
                                @if(isset($field['help_text']) && !empty($field['help_text']))
                                    <div class="mt-2">
                                        <strong>{{ __('Help Text') }}:</strong> {{ $field['help_text'] }}
                                    </div>
                                @endif
                                
                                @if(isset($field['placeholder']) && !empty($field['placeholder']))
                                    <div class="mt-2">
                                        <strong>{{ __('Placeholder') }}:</strong> {{ $field['placeholder'] }}
                                    </div>
                                @endif
                                
                                @if(isset($field['default_value']) && !empty($field['default_value']))
                                    <div class="mt-2">
                                        <strong>{{ __('Default Value') }}:</strong> {{ $field['default_value'] }}
                                    </div>
                                @endif
                                
                                @if(isset($field['options']) && is_array($field['options']) && count($field['options']) > 0)
                                    <div class="field-options">
                                        <strong>{{ __('Options') }}:</strong>
                                        <ul class="field-options-list">
                                            @foreach($field['options'] as $option)
                                                <li>{{ $option['label'] ?? $option }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                
                                @if(isset($field['conditional']) && !empty($field['conditional']))
                                    <div class="conditional-logic">
                                        <strong>{{ __('Conditional Logic') }}:</strong>
                                        <div class="mt-2">
                                            {{ __('Field') }}: {{ $field['conditional']['field'] ?? '' }}
                                            {{ __('Operator') }}: {{ $field['conditional']['operator'] ?? '' }}
                                            {{ __('Value') }}: {{ $field['conditional']['value'] ?? '' }}
                                            @if(isset($field['conditional']['action']))
                                                <br>{{ __('Action') }}: {{ $field['conditional']['action'] }}
                                                @if($field['conditional']['action'] == 'skip-to' && isset($field['conditional']['target']))
                                                    <br>{{ __('Target') }}: {{ $field['conditional']['target'] }}
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection