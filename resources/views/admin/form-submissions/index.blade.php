@extends('layouts.admin')

@section('title', __('Form Submissions'))

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Form Submissions') }}</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Form Submissions') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-database me-1"></i>
                {{ __('Form Data Submissions') }}
            </div>
            <div>
                <form action="{{ route('admin.form-submissions.export') }}" method="GET" class="d-inline-block me-2">
                    <div class="input-group">
                        <select name="form_id" class="form-select">
                            <option value="">{{ __('Select form to export') }}</option>
                            @foreach($forms as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-file-export me-1"></i> {{ __('Export CSV') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-8">
                    <form action="{{ route('admin.form-submissions.index') }}" method="GET" class="row g-3">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text">{{ __('Form') }}</span>
                                <select name="form_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">{{ __('All Forms') }}</option>
                                    @foreach($forms as $id => $title)
                                        <option value="{{ $id }}" @selected(request('form_id') == $id)>{{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text">{{ __('Status') }}</span>
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="">{{ __('All Statuses') }}</option>
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" @selected(request('status') == $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            @if($submissions->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-1"></i>
                    {{ __('No submissions found.') }}
                </div>
            @else
                <div class="table-responsive admin-form-submissions-table">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Form') }}</th>
                                <th>{{ __('User') }}</th>
                                <th>{{ __('Location') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submissions as $submission)
                                <tr>
                                    <td>{{ $submission->id }}</td>
                                    <td>{{ $submission->form->title ?? 'Unknown Form' }}</td>
                                    <td>{{ $submission->user->name ?? 'Guest User' }}</td>
                                    <td>
                                        @if($submission->latitude && $submission->longitude)
                                            <span class="d-inline-block text-truncate" style="max-width: 150px;" title="{{ $submission->latitude }}, {{ $submission->longitude }}">
                                                {{ $submission->latitude }}, {{ $submission->longitude }}
                                            </span>
                                        @else
                                            <span class="text-muted">{{ __('No location') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-warning',
                                                'approved' => 'bg-success',
                                                'rejected' => 'bg-danger',
                                                'archived' => 'bg-secondary'
                                            ];
                                            $statusColor = $statusColors[$submission->status] ?? 'bg-secondary';
                                        @endphp
                                        <span class="badge {{ $statusColor }}">{{ $statuses[$submission->status] ?? $submission->status }}</span>
                                    </td>
                                    <td>{{ $submission->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group btn-action-group" role="group">
                                            <a href="{{ route('admin.form-submissions.show', $submission->id) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye me-1"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="if(confirm('{{ __('Are you sure you want to delete this submission?') }}')) document.getElementById('delete-submission-{{ $submission->id }}').submit();">
                                                <i class="fas fa-trash me-1"></i> 
                                            </button>
                                            <form id="delete-submission-{{ $submission->id }}" action="{{ route('admin.form-submissions.destroy', $submission->id) }}" method="POST" class="d-none">
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
                    {{ $submissions->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 