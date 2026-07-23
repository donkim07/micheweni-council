@extends('layouts.admin')

@section('title', 'Edit Social Media Links')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Social Media Links</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.site-config.index') }}">Site Configuration</a></li>
        <li class="breadcrumb-item active">Social Media Links</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-share-alt me-1"></i>
            Social Media Links
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.government.site-config.update-social') }}">
                @csrf
                
                <div class="mb-3">
                    <label for="facebook" class="form-label">
                        <i class="fab fa-facebook me-1"></i> Facebook
                    </label>
                    <input type="url" class="form-control @error('facebook') is-invalid @enderror" 
                           id="facebook" name="facebook" 
                           value="{{ old('facebook', $socialLinks['facebook'] ?? '') }}"
                           placeholder="https://facebook.com/yourpage">
                    @error('facebook')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="twitter" class="form-label">
                        <i class="fab fa-twitter me-1"></i> Twitter
                    </label>
                    <input type="url" class="form-control @error('twitter') is-invalid @enderror" 
                           id="twitter" name="twitter" 
                           value="{{ old('twitter', $socialLinks['twitter'] ?? '') }}"
                           placeholder="https://twitter.com/yourhandle">
                    @error('twitter')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="instagram" class="form-label">
                        <i class="fab fa-instagram me-1"></i> Instagram
                    </label>
                    <input type="url" class="form-control @error('instagram') is-invalid @enderror" 
                           id="instagram" name="instagram" 
                           value="{{ old('instagram', $socialLinks['instagram'] ?? '') }}"
                           placeholder="https://instagram.com/yourhandle">
                    @error('instagram')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="linkedin" class="form-label">
                        <i class="fab fa-linkedin me-1"></i> LinkedIn
                    </label>
                    <input type="url" class="form-control @error('linkedin') is-invalid @enderror" 
                           id="linkedin" name="linkedin" 
                           value="{{ old('linkedin', $socialLinks['linkedin'] ?? '') }}"
                           placeholder="https://linkedin.com/company/yourcompany">
                    @error('linkedin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="youtube" class="form-label">
                        <i class="fab fa-youtube me-1"></i> YouTube
                    </label>
                    <input type="url" class="form-control @error('youtube') is-invalid @enderror" 
                           id="youtube" name="youtube" 
                           value="{{ old('youtube', $socialLinks['youtube'] ?? '') }}"
                           placeholder="https://youtube.com/channel/yourchannel">
                    @error('youtube')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Save Social Media Links</button>
            </form>
        </div>
    </div>
</div>
@endsection
