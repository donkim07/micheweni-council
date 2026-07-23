@extends('layouts.admin')

@section('title', __('Edit News Tag'))

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
    <h1 class="mt-4">{{ __('Edit News Tag') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.news.index') }}">{{ __('News') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.news-tags.index') }}">{{ __('Tags') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Edit') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-tag me-1"></i>
            {{ __('Tag Information') }}
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
            
            <form action="{{ route('admin.government.news-tags.update', $tag) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name" class="required">{{ __('Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $tag->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">{{ __('The name of the tag as it will appear on the site.') }}</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="slug" class="required">{{ __('Slug') }}</label>
                            <input type="text" class="form-control" id="slug" value="{{ $tag->slug }}" disabled>
                            <small class="form-text text-muted">{{ __('The slug is automatically generated from the name and cannot be edited directly.') }}</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                {{ __('Status Information') }}
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-0">
                                    <label>{{ __('News Count') }}</label>
                                    <p class="mb-0">{{ $tag->news_count ?? $tag->news->count() }} {{ __('articles') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.government.news-tags.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-times-circle me-1"></i> {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> {{ __('Update Tag') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection