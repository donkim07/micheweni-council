<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h4 class="text-center mb-4 fw-bold text-muted">{{ __('Create New Account') }}</h4>

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Full Name') }}</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Enter your full name">
            </div>
            @error('name')
                <div class="text-danger mt-1 small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email Address') }}</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Enter your email address">
            </div>
            @error('email')
                <div class="text-danger mt-1 small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="Create a strong password">
            </div>
            @error('password')
                <div class="text-danger mt-1 small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
            </div>
            @error('password_confirmation')
                <div class="text-danger mt-1 small">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-user-plus me-1"></i> {{ __('Register') }}
            </button>
        </div>

        <div class="text-center mt-4">
            <span class="text-muted">{{ __('Already have an account?') }}</span>
            <a href="{{ route('login') }}" class="link-secondary ms-1">{{ __('Login here') }}</a>
        </div>
    </form>
</x-guest-layout>
