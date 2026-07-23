@extends('layouts.admin')

@section('title', __('Form Builders'))

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Form Builders') }}</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Form Builders') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-clipboard-list me-1"></i>
                {{ __('Custom Forms') }}
            </div>
            <div>
                <a href="{{ route('admin.form-builders.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> {{ __('Create New Form') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($forms->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-1"></i>
                    {{ __('No custom forms have been created yet.') }}
                </div>
                <p>{{ __('Custom forms allow you to collect specific data from users that can be displayed on maps and in reports.') }}</p>
                <a href="{{ route('admin.form-builders.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> {{ __('Create Your First Form') }}
                </a>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Fields') }}</th>
                                <th>{{ __('Submissions') }}</th>
                                <th>{{ __('Map Enabled') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($forms as $form)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($form->icon)
                                                <i class="fas {{ $form->icon }} me-2 text-primary"></i>
                                            @endif
                                            <div>
                                                <strong>{{ $form->title }}</strong>
                                                <div class="small text-muted">{{ $form->slug }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ Str::limit($form->description, 100) }}</td>
                                    <td>{{ count($form->fields) }}</td>
                                    <td>
                                        <a href="{{ route('admin.form-submissions.index', ['form_id' => $form->id]) }}">
                                            {{ $form->submissions_count }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($form->map_enabled)
                                            <span class="badge bg-success">{{ __('Yes') }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ __('No') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($form->is_active)
                                            <span class="badge bg-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ __('Inactive') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-action-group" role="group">
                                            <a href="{{ route('admin.form-builders.show', $form->id) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye me-1"></i> 
                                            </a>
                                            <a href="{{ route('admin.form-builders.edit', $form->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit me-1"></i> 
                                            </a>
                                            <a href="{{ route('admin.form-submissions.index', ['form_id' => $form->id]) }}" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-list me-1"></i> 
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="if(confirm('{{ __('Are you sure you want to delete this form?') }}')) document.getElementById('delete-form-{{ $form->id }}').submit();">
                                                <i class="fas fa-trash"></i> 
                                            </button>
                                            <form id="delete-form-{{ $form->id }}" action="{{ route('admin.form-builders.destroy', $form->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $forms->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 