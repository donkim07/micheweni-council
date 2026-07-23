@extends('opportunities.layouts.app')

@section('title', __('Contact Us'))

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-md-10 offset-md-1 text-center">
            <h1 class="display-4 mb-4">{{ __('Contact Us') }}</h1>
            <p class="lead">{{ __('Have questions about opportunities? Get in touch with our team and we\'ll be happy to help.') }}</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-5 mb-4 mb-lg-0">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h2 class="h4 mb-4">{{ __('Get in Touch') }}</h2>
                    
                    <div class="contact-info mb-4">
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <div class="icon-box bg-primary text-white">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h5 class="h6 mb-1">{{ __('Address') }}</h5>
                                <p class="text-muted mb-0">Micheweni Municipal Office, Pemba Island, Zanzibar, Tanzania</p>
                            </div>
                        </div>
                        
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <div class="icon-box bg-primary text-white">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h5 class="h6 mb-1">{{ __('Phone') }}</h5>
                                <p class="text-muted mb-0">+255 777 123 456</p>
                            </div>
                        </div>
                        
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <div class="icon-box bg-primary text-white">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h5 class="h6 mb-1">{{ __('Email') }}</h5>
                                <p class="text-muted mb-0">info@weteportal.org</p>
                            </div>
                        </div>
                        
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="icon-box bg-primary text-white">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h5 class="h6 mb-1">{{ __('Working Hours') }}</h5>
                                <p class="text-muted mb-0">Monday - Friday: 8:00 AM - 5:00 PM</p>
                            </div>
                        </div>
                    </div>
                    
                    <h5 class="mb-3">{{ __('Follow Us') }}</h5>
                    <div class="social-links">
                        <a href="#" class="btn btn-outline-primary me-2" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn btn-outline-info me-2" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-outline-danger me-2" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-outline-primary" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h4 mb-4">{{ __('Send Us a Message') }}</h2>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form action="{{ route('opportunities.contact') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="{{ __('Your Name') }}" value="{{ old('name') }}" required>
                                    <label for="name">{{ __('Your Name') }}</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="{{ __('Your Email') }}" value="{{ old('email') }}" required>
                                    <label for="email">{{ __('Your Email') }}</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="{{ __('Subject') }}" value="{{ old('subject') }}" required>
                                    <label for="subject">{{ __('Subject') }}</label>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select @error('inquiry_type') is-invalid @enderror" id="inquiry_type" name="inquiry_type" required>
                                        <option value="" selected disabled>{{ __('Select an option') }}</option>
                                        <option value="general" {{ old('inquiry_type') == 'general' ? 'selected' : '' }}>{{ __('General Inquiry') }}</option>
                                        <option value="circular_economy" {{ old('inquiry_type') == 'circular_economy' ? 'selected' : '' }}>{{ __('Circular Economy') }}</option>
                                        <option value="business" {{ old('inquiry_type') == 'business' ? 'selected' : '' }}>{{ __('Business Opportunities') }}</option>
                                        <option value="agriculture" {{ old('inquiry_type') == 'agriculture' ? 'selected' : '' }}>{{ __('Agricultural Initiatives') }}</option>
                                        <option value="tourism" {{ old('inquiry_type') == 'tourism' ? 'selected' : '' }}>{{ __('Tourism & Culture') }}</option>
                                    </select>
                                    <label for="inquiry_type">{{ __('Inquiry Type') }}</label>
                                    @error('inquiry_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" placeholder="{{ __('Your Message') }}" style="height: 150px" required>{{ old('message') }}</textarea>
                                    <label for="message">{{ __('Your Message') }}</label>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i> {{ __('Send Message') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="ratio ratio-21x9">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31691.310089905876!2d39.71121368032503!3d-5.055974472171505!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x183e8164d4b1601f%3A0xf28091d93d5c0833!2sWete%2C%20Tanzania!5e0!3m2!1sen!2sus!4v1656038400000!5m2!1sen!2sus" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-box {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection 