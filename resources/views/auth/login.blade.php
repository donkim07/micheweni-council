<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h4 class="text-center mb-4 fw-bold text-muted">{{ __('Sign In to Your Account') }}</h4>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Enter your email">
            </div>
            @error('email')
                <div class="text-danger mt-1 small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <div class="d-flex justify-content-between">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                @if (Route::has('password.request'))
                    <a class="small link-secondary" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
            </div>
            @error('password')
                <div class="text-danger mt-1 small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-4">
            <div class="form-check">
                <input id="remember_me" name="remember" type="checkbox" class="form-check-input">
                <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sign-in-alt me-1"></i> {{ __('Log in') }}
            </button>
        </div>

        <div class="text-center mt-4">
            <span class="text-muted">{{ __('Don\'t have an account?') }}</span>
            <a href="{{ route('register') }}" class="link-secondary ms-1">{{ __('Register here') }}</a>
        </div>
    </form>
</x-guest-layout>
