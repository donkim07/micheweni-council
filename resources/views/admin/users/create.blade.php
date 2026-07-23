@extends('layouts.admin')

@section('title', __('Create User'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h2 class="section-heading">{{ __('Create New User') }}</h2>
                            <p class="text-muted">{{ __('Add a new user to the system') }}</p>
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Users') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('User Information') }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="form-label">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="form-label">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label">{{ __('Password') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">{{ __('Assign Roles') }}</label>
                            <div class="row">
                                @foreach($roles as $id => $name)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="role{{ $id }}" name="roles[]" value="{{ $id }}" {{ in_array($id, old('roles', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="role{{ $id }}">
                                                {{ $name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('roles')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light">
                                {{ __('Reset') }}
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus me-2"></i>{{ __('Create User') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Password Requirements') }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info border-0">
                        <h6 class="alert-heading fw-bold mb-1">
                            <i class="fas fa-info-circle me-2"></i>{{ __('Password Guidelines') }}
                        </h6>
                        <ul class="mb-0 ps-3 mt-2">
                            <li>{{ __('At least 8 characters long') }}</li>
                            <li>{{ __('Include at least one uppercase letter') }}</li>
                            <li>{{ __('Include at least one lowercase letter') }}</li>
                            <li>{{ __('Include at least one number') }}</li>
                            <li>{{ __('Include at least one special character') }}</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-warning border-0 mt-3">
                        <h6 class="alert-heading fw-bold mb-1">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ __('Important Notes') }}
                        </h6>
                        <ul class="mb-0 ps-3 mt-2">
                            <li>{{ __('Users will have access based on their assigned roles.') }}</li>
                            <li>{{ __('Make sure to assign appropriate roles to ensure proper access control.') }}</li>
                            <li>{{ __('Users can change their passwords after logging in.') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const toggleButtons = document.querySelectorAll('.toggle-password');
        
        toggleButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    });
</script>
@endsection 