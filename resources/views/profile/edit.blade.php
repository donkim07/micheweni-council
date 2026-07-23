@extends('layouts.admin')

@section('title', __('Edit Profile'))

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Edit Profile') }}</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Profile') }}</li>
    </ol>
    
    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user-edit me-1"></i>
                    {{ __('Update Profile Information') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="form-floating mb-3">
                            <input class="form-control @error('name') is-invalid @enderror" id="name" 
                                type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required />
                            <label for="name">{{ __('Name') }}</label>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input class="form-control @error('email') is-invalid @enderror" id="email" 
                                type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required />
                            <label for="email">{{ __('Email Address') }}</label>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mt-4 mb-0">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('Save Changes') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-lock me-1"></i>
                    {{ __('Update Password') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="form-floating mb-3">
                            <input class="form-control @error('current_password') is-invalid @enderror" id="current_password" 
                                type="password" name="current_password" required />
                            <label for="current_password">{{ __('Current Password') }}</label>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input class="form-control @error('password') is-invalid @enderror" id="password" 
                                type="password" name="password" required />
                            <label for="password">{{ __('New Password') }}</label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" 
                                type="password" name="password_confirmation" required />
                            <label for="password_confirmation">{{ __('Confirm New Password') }}</label>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mt-4 mb-0">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('Change Password') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header bg-danger text-white">
            <i class="fas fa-exclamation-triangle me-1"></i>
            {{ __('Delete Account') }}
        </div>
        <div class="card-body">
            <p>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>
            
            <form action="{{ route('admin.profile.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                
                <div class="form-floating mb-3">
                    <input class="form-control @error('password') is-invalid @enderror" id="delete-password" 
                        type="password" name="password" placeholder="{{ __('Password') }}" required />
                    <label for="delete-password">{{ __('Password') }}</label>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div>
                    <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('{{ __('Are you sure you want to delete your account? This action cannot be undone.') }}')">
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 