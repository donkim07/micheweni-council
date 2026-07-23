@extends('layouts.admin')

@section('title', __('Create News Category'))

@section('styles')
<style>
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .required::after {
        content: " *";
        color: red;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Create News Category') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.news.index') }}">{{ __('News') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.news-categories.index') }}">{{ __('Categories') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Create') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-folder me-1"></i>
            {{ __('Category Information') }}
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('admin.government.news-categories.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name" class="required">{{ __('Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">{{ __('The name of the category as it will appear on the site.') }}</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">{{ __('A brief description of the category (optional).') }}</small>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.government.news-categories.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-times-circle me-1"></i> {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> {{ __('Create Category') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 