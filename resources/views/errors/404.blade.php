@extends('government.layouts.app')

@section('title', __('Page Not Found'))

@section('styles')
<style>
    .error-container {
        padding: 80px 0;
        text-align: center;
    }
    
    .error-code {
        font-size: 120px;
        font-weight: 800;
        color: var(--primary);
        line-height: 1;
        margin-bottom: 20px;
        opacity: 0.8;
    }
    
    .error-message {
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: var(--dark);
    }
    
    .error-details {
        font-size: 1.1rem;
        color: var(--gray);
        max-width: 600px;
        margin: 0 auto 30px;
    }
    
    .error-image {
        max-width: 400px;
        margin-bottom: 40px;
    }
    
    .action-buttons .btn {
        margin: 0 10px;
        padding: 10px 24px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="error-container">
        <img src="/images/government/404-illustration.svg" alt="Page not found" class="error-image">
        <div class="error-code">404</div>
        <h1 class="error-message">Page Not Found</h1>
        <p class="error-details">
            The page you are looking for might have been removed, had its name changed, 
            or is temporarily unavailable. Please check the URL or try one of the following options:
        </p>
        
        <div class="action-buttons">
            <a href="{{ url('/government') }}" class="btn btn-primary">
                <i class="fas fa-home me-2"></i> Return to Home
            </a>
            <a href="{{ url('/government/contact') }}" class="btn btn-outline-primary">
                <i class="fas fa-envelope me-2"></i> Contact Us
            </a>
        </div>
    </div>
</div>
@endsection 