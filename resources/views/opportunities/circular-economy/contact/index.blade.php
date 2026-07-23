<x-app-layout>
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">{{ __('Contact Us') }}</h1>
                
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 mb-4 mb-lg-0">
                                <div class="card h-100 border-0">
                                    <div class="card-body">
                                        <h4 class="mb-4">{{ __('Contact Information') }}</h4>
                                        
                                        <div class="d-flex mb-4">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h5 class="mb-1">{{ __('Address') }}</h5>
                                                <p class="mb-0">
                                                    {{ __('Micheweni District Council') }}<br>
                                                    {{ __('P.O. Box 123') }}<br>
                                                    {{ __('Micheweni, Pemba Island') }}<br>
                                                    {{ __('Zanzibar, Tanzania') }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex mb-4">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-phone fa-2x text-primary"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h5 class="mb-1">{{ __('Phone') }}</h5>
                                                <p class="mb-0">
                                                    {{ __('Main Office:') }} +255 (0) 777 123 456<br>
                                                    {{ __('Waste Department:') }} +255 (0) 777 789 012<br>
                                                    {{ __('Emergency:') }} +255 (0) 777 111 000
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex mb-4">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-envelope fa-2x text-primary"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h5 class="mb-1">{{ __('Email') }}</h5>
                                                <p class="mb-0">
                                                    {{ __('General Inquiries:') }} info@micheweni.go.tz<br>
                                                    {{ __('Waste Services:') }} waste@micheweni.go.tz<br>
                                                    {{ __('Website Support:') }} support@micheweni.go.tz
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex mb-4">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-clock fa-2x text-primary"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h5 class="mb-1">{{ __('Office Hours') }}</h5>
                                                <p class="mb-0">
                                                    {{ __('Monday - Friday:') }} 8:00 AM - 4:00 PM<br>
                                                    {{ __('Saturday:') }} 9:00 AM - 12:00 PM<br>
                                                    {{ __('Sunday:') }} Closed
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <h5 class="mb-3">{{ __('Follow Us') }}</h5>
                                            <div class="d-flex">
                                                <a href="#" class="me-3 text-primary">
                                                    <i class="fab fa-facebook-square fa-2x"></i>
                                                </a>
                                                <a href="#" class="me-3 text-primary">
                                                    <i class="fab fa-twitter-square fa-2x"></i>
                                                </a>
                                                <a href="#" class="me-3 text-primary">
                                                    <i class="fab fa-instagram fa-2x"></i>
                                                </a>
                                                <a href="#" class="text-primary">
                                                    <i class="fab fa-youtube fa-2x"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-8">
                                <div class="card h-100 border-0">
                                    <div class="card-body">
                                        <h4 class="mb-4">{{ __('Send Us a Message') }}</h4>
                                        
                                        <form action="{{ route('opportunities.circular-economy.contact.submit') }}" method="POST" class="row g-3 needs-validation" novalidate>
                                            @csrf
                                            
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">{{ __('Full Name') }}</label>
                                                <input type="text" class="form-control" id="name" name="name" required>
                                                <div class="invalid-feedback">
                                                    {{ __('Please provide your name.') }}
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                                <div class="invalid-feedback">
                                                    {{ __('Please provide a valid email address.') }}
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                                                <input type="tel" class="form-control" id="phone" name="phone">
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label for="subject" class="form-label">{{ __('Subject') }}</label>
                                                <select class="form-select" id="subject" name="subject" required>
                                                    <option value="">{{ __('Choose...') }}</option>
                                                    <option value="general">{{ __('General Inquiry') }}</option>
                                                    <option value="collection">{{ __('Waste Collection') }}</option>
                                                    <option value="recycling">{{ __('Recycling Services') }}</option>
                                                    <option value="complaint">{{ __('Complaint') }}</option>
                                                    <option value="feedback">{{ __('Feedback') }}</option>
                                                    <option value="other">{{ __('Other') }}</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ __('Please select a subject.') }}
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <label for="message" class="form-label">{{ __('Message') }}</label>
                                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                                <div class="invalid-feedback">
                                                    {{ __('Please provide a message.') }}
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="privacy" name="privacy" required>
                                                    <label class="form-check-label" for="privacy">
                                                        {{ __('I agree to the') }} <a href="{{ route('opportunities.circular-economy.privacy') }}">{{ __('privacy policy') }}</a>
                                                    </label>
                                                    <div class="invalid-feedback">
                                                        {{ __('You must agree before submitting.') }}
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 mt-4">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-paper-plane me-2"></i> {{ __('Send Message') }}
                                                </button>
                                            </div>
                                        </form>
                                        
                                        @if(session('success'))
                                            <div class="alert alert-success mt-4">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="mb-4">{{ __('Find Us') }}</h4>
                        <div id="contact-map" style="height: 400px;" class="rounded"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize map centered on Micheweni, Pemba
            const map = L.map('contact-map').setView([-5.0561, 39.7303], 15);
            
            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // Add marker for Micheweni District Council
            L.marker([-5.0561, 39.7303])
                .addTo(map)
                .bindPopup('<strong>Micheweni District Council</strong><br>P.O. Box 123<br>Micheweni, Pemba Island')
                .openPopup();
        });
    </script>
    @endpush
</x-app-layout> 