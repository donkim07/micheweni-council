@extends('government.layouts.app')

@section('title', __($title ?? 'Coming Soon'))

@section('styles')
<style>
    .page-hero {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8)), url('/images/government/placeholder-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
    }
    
    .placeholder-content {
        padding: 60px 0;
        text-align: center;
    }
    
    .placeholder-icon {
        font-size: 6rem;
        color: var(--primary);
        margin-bottom: 30px;
        opacity: 0.7;
    }
</style>
@endsection

@section('content')
<!-- Page Hero -->
<div class="page-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ url('/government') }}" class="text-white">Home</a></li>
                        @if(isset($parentRoute) && isset($parentName))
                            <li class="breadcrumb-item"><a href="{{ url($parentRoute) }}" class="text-white">{{ $parentName }}</a></li>
                        @endif
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ $title ?? 'Coming Soon' }}</li>
                    </ol>
                </nav>
                
                <h1 class="display-4 fw-bold mb-3">{{ $title ?? 'Coming Soon' }}</h1>
                <p class="lead mb-4">{{ $subtitle ?? 'This content is currently being developed. Please check back later.' }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="placeholder-content">
                <div class="placeholder-icon">
                    <i class="fas {{ $icon ?? 'fa-tools' }}"></i>
                </div>
                <h2 class="mb-4">{{ $message ?? 'We\'re working on this section' }}</h2>
                <p class="lead mb-5">{{ $description ?? 'This section is under development and content will be available soon. Thank you for your patience as we continue to improve our website.' }}</p>
                
                <a href="{{ url('/government') }}" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i> Return to Home
                </a>
                
                @if(isset($contactButton) && $contactButton)
                    <a href="{{ url('/government/contact') }}" class="btn btn-outline-primary ms-3">
                        <i class="fas fa-envelope me-2"></i> Contact Us
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 