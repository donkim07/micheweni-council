@extends('layouts.admin')

@section('title', __('Submission Details'))

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Submission Details') }}</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.form-submissions.index') }}">{{ __('Form Submissions') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Details') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-clipboard-list me-1"></i>
                {{ __('Submission #:id for :form', ['id' => $submission->id, 'form' => $submission->form->title ?? 'Unknown Form']) }}
            </div>
            <div>
                <div class="btn-group" role="group">
                    <a href="{{ route('admin.form-submissions.index', ['form_id' => $submission->form_builder_id]) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> {{ __('Back to Submissions') }}
                    </a>
                    <button type="button" class="btn btn-outline-danger" 
                        onclick="if(confirm('{{ __('Are you sure you want to delete this submission?') }}')) document.getElementById('delete-submission-form').submit();">
                        <i class="fas fa-trash me-1"></i> {{ __('Delete') }}
                    </button>
                    <form id="delete-submission-form" action="{{ route('admin.form-submissions.destroy', $submission->id) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-info-circle me-1"></i>
                            {{ __('Submission Information') }}
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 30%">{{ __('Form') }}</th>
                                    <td>
                                        @if($submission->form)
                                            <a href="{{ route('admin.form-builders.show', $submission->form_builder_id) }}">
                                                {{ $submission->form->title }}
                                            </a>
                                        @else
                                            {{ __('Unknown Form') }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Submitted By') }}</th>
                                    <td>
                                        @if($submission->user)
                                            <a href="{{ route('admin.users.show', $submission->user_id) }}">
                                                {{ $submission->user->name }}
                                            </a>
                                        @else
                                            {{ __('Guest') }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Submission Date') }}</th>
                                    <td>{{ $submission->created_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Status') }}</th>
                                    <td>
                                        <form action="{{ route('admin.form-submissions.update-status', $submission->id) }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            <select name="status" class="form-select form-select-sm me-2" style="width: auto">
                                                @foreach($statuses as $value => $label)
                                                    <option value="{{ $value }}" @selected($submission->status === $value)>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary">{{ __('Update') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($submission->latitude && $submission->longitude)
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ __('Location') }}
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <strong>{{ __('Coordinates') }}:</strong> 
                                    {{ $submission->latitude }}, {{ $submission->longitude }}
                                </div>
                                @if($submission->address)
                                    <div class="mb-3">
                                        <strong>{{ __('Address') }}:</strong> 
                                        {{ $submission->address }}
                                    </div>
                                @endif
                                <div class="ratio ratio-16x9">
                                    <iframe 
                                        src="https://maps.google.com/maps?q={{ $submission->latitude }},{{ $submission->longitude }}&z=15&output=embed" 
                                        width="100%" 
                                        height="400" 
                                        style="border:0;" 
                                        allowfullscreen="" 
                                        loading="lazy" 
                                        referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-list-alt me-1"></i>
                            {{ __('Form Data') }}
                        </div>
                        <div class="card-body">
                            @if(!$submission->data || empty($submission->data))
                                <div class="alert alert-info">
                                    {{ __('No form data available.') }}
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Field') }}</th>
                                                <th>{{ __('Value') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                // Ensure we have array data
                                                $formData = $submission->data;
                                                if (is_string($formData)) {
                                                    $formData = json_decode($formData, true) ?? [];
                                                }
                                            @endphp
                                            
                                            @if(is_array($formData))
                                                @foreach($formData as $key => $value)
                                                    <tr>
                                                        <th>
                                                            @if($submission->form && isset($submission->form->fields))
                                                                @php
                                                                    $fieldConfig = collect($submission->form->fields)->firstWhere('name', $key);
                                                                @endphp
                                                                {{ $fieldConfig['label'] ?? $key }}
                                                            @else
                                                                {{ $key }}
                                                            @endif
                                                        </th>
                                                        <td>
                                                            @if(is_array($value))
                                                                <ul class="mb-0 ps-3">
                                                                    @foreach($value as $item)
                                                                        <li>{{ $item }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            @else
                                                                @if(filter_var($value, FILTER_VALIDATE_URL))
                                                                    <a href="{{ $value }}" target="_blank">{{ $value }}</a>
                                                                @elseif(is_string($value) && preg_match('/\.(jpg|jpeg|png|gif|bmp|webp)$/i', $value))
                                                                    <a href="{{ asset('images/' . $value) }}" target="_blank">
                                                                        <img src="{{ asset('images/' . $value) }}" class="img-thumbnail" style="max-height: 100px;">
                                                                    </a>
                                                                @elseif(is_string($value) && preg_match('/\.(pdf|doc|docx|xls|xlsx|txt)$/i', $value))
                                                                    <a href="{{ asset('images/' . $value) }}" target="_blank">
                                                                        <i class="fas fa-file me-1"></i> {{ basename($value) }}
                                                                    </a>
                                                                @else
                                                                    {{ $value }}
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="2" class="text-center">
                                                        <div class="alert alert-warning">
                                                            {{ __('Unable to display form data. Invalid format.') }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 