@extends('government.layouts.app')

@section('title', __('Contact Us'))

@section('styles')
<style>
    
</style>

@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Contact Us</h1>
            <p class="lead mb-5">We are here to help and answer any questions you might have.</p>
            
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <i class="fas fa-map-marker-alt fa-3x text-primary mb-3"></i>
                            <h4>Visit Us</h4>
                            <p>{{ $siteContactInfo['address']}}</p>
                                
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <i class="fas fa-phone fa-3x text-primary mb-3"></i>
                            <h4>Call Us</h4>
                            @if(isset($siteContactInfo['phones']) && count($siteContactInfo['phones']) > 0)
                                @foreach($siteContactInfo['phones'] as $phone)
                                    <p><a href="tel:{{ $phone }}">{{ $phone }}</a></p>
                                @endforeach
                                <p>{{ $siteContactInfo['working_hours'] }}</p>
                           @endif
                        </div>
                    </div>
                </div>
                 <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <i class="fas fa-envelope fa-3x text-primary mb-3"></i>
                            <h4>Email Us</h4>
                            @if(isset($siteContactInfo['emails']) && count($siteContactInfo['emails']) > 0)
                                @foreach($siteContactInfo['emails'] as $email)
                                    <p><a href="mailto:{{ $email }}">{{ $email }}</a></p>
                                @endforeach
                            @endif
                            <p>We respond within 24-48 hours</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-4">Send Us a Message</h3>
                    
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    
                    <form action="{{ route('government.contact.submit') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Your Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                 </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Your Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 