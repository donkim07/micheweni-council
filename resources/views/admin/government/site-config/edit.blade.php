@extends('layouts.admin')

@section('title', 'Edit Site Configuration')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Site Configuration</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.site-config.index') }}">Site Configuration</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-cog me-1"></i>
            Edit Configuration
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.government.site-config.update', $config->id) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="config_key" class="form-label">Configuration Key</label>
                    <input type="text" class="form-control @error('config_key') is-invalid @enderror" id="config_key" name="config_key" value="{{ old('config_key', $config->config_key) }}" required>
                    @error('config_key')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="config_value" class="form-label">Configuration Value</label>
                    <textarea class="form-control @error('config_value') is-invalid @enderror" id="config_value" name="config_value" rows="3" required>{{ old('config_value', $config->raw_value) }}</textarea>
                    @error('config_value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="config_group" class="form-label">Group</label>
                    <input type="text" class="form-control @error('config_group') is-invalid @enderror" id="config_group" name="config_group" value="{{ old('config_group', $config->config_group) }}" required>
                    @error('config_group')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_json" name="is_json" value="1" {{ old('is_json', $config->is_json) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_json">Is JSON Value</label>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ old('description', $config->description) }}">
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Update Configuration</button>
                <a href="{{ route('admin.government.site-config.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
