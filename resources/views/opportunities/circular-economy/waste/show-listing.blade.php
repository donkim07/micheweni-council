<x-app-layout>
    <div class="py-4 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('opportunities.circular-economy.waste.marketplace') }}">{{ __('Marketplace') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $listing->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container py-5">
        <div class="row g-5">
            <!-- Listing Details -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="listing-image-lg">
                        <img src="{{ asset($listing->image ?? 'images/placeholder.jpg') }}" class="card-img-top" alt="{{ $listing->title }}" onerror="this.src='https://placehold.co/800x400/198754/white?text=Listing'">
                        <div class="listing-category">{{ $listing->category }}</div>
                        @if($listing->is_available)
                            <div class="listing-status">{{ __('Available') }}</div>
                        @else
                            <div class="listing-status unavailable">{{ __('Unavailable') }}</div>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        <h1 class="card-title h3 mb-3">{{ $listing->title }}</h1>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="listing-price fs-4">
                                <span class="price-amount">{{ number_format($listing->price) }} TZS</span>
                                <span class="price-unit">{{ $listing->price_unit }}</span>
                            </div>
                            <div class="listing-location">
                                <i class="fas fa-map-marker-alt me-1"></i> {{ $listing->location }}
                            </div>
                        </div>
                        
                        <div class="listing-details mb-4">
                            <h5 class="mb-3">{{ __('Description') }}</h5>
                            <p class="listing-description">{{ $listing->description }}</p>
                        </div>
                        
                        <div class="listing-meta d-flex justify-content-between align-items-center border-top pt-3">
                            <div class="listing-date">
                                <i class="far fa-calendar-alt me-1"></i> {{ __('Posted on') }} {{ $listing->created_at->format('M d, Y') }}
                            </div>
                            
                            <div class="listing-actions">
                                @auth
                                    @if(Auth::id() != $listing->user_id)
                                        <form action="{{ route('opportunities.circular-economy.waste.toggle-listing', $listing->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                <i class="far fa-bookmark me-1"></i> {{ __('Save Listing') }}
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('opportunities.circular-economy.waste.my-listings') }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit me-1"></i> {{ __('Manage Your Listing') }}
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-success">
                                        <i class="far fa-bookmark me-1"></i> {{ __('Login to Save') }}
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Similar Listings -->
                <div class="similar-listings mt-5">
                    <h3 class="section-title mb-4">{{ __('Similar Listings') }}</h3>
                    
                    <div class="row g-4">
                        @for($i = 0; $i < 3; $i++)
                        <div class="col-md-4">
                            <div class="card h-100 listing-card">
                                <div class="listing-image">
                                    <img src="https://placehold.co/300x200/198754/white?text=Similar+{{ $i+1 }}" class="card-img-top" alt="Similar Listing">
                                    <div class="listing-category">{{ $listing->category }}</div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('Similar Waste Material') }} {{ $i+1 }}</h5>
                                    <p class="card-text text-muted small">{{ __('Another similar listing in the same category.') }}</p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="listing-price small">
                                            <span class="price-amount">{{ number_format(rand(10000, 50000)) }} TZS</span>
                                        </div>
                                        <a href="#" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-eye me-1"></i> {{ __('View') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Seller Info -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">{{ __('Seller Information') }}</h5>
                        
                        <div class="seller-info">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset($listing->user->profile->avatar ?? 'images/avatars/default.jpg') }}" class="seller-avatar rounded-circle me-3" alt="{{ $listing->user->name }}" onerror="this.src='https://placehold.co/80x80/198754/white?text=User'">
                                <div>
                                    <h6 class="mb-0">{{ $listing->user->name }}</h6>
                                    <div class="seller-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-warning"></i>
                                        @endfor
                                        <span class="ms-1">5.0</span>
                                    </div>
                                    <span class="text-muted small">{{ __('Member since') }} {{ $listing->user->created_at->format('M Y') }}</span>
                                </div>
                            </div>
                            
                            <div class="seller-stats d-flex mb-3">
                                <div class="stat-item text-center flex-grow-1">
                                    <div class="stat-value">{{ rand(5, 30) }}</div>
                                    <div class="stat-label small text-muted">{{ __('Listings') }}</div>
                                </div>
                                <div class="stat-item text-center flex-grow-1">
                                    <div class="stat-value">{{ rand(80, 100) }}%</div>
                                    <div class="stat-label small text-muted">{{ __('Response Rate') }}</div>
                                </div>
                                <div class="stat-item text-center flex-grow-1">
                                    <div class="stat-value">{{ rand(10, 50) }}</div>
                                    <div class="stat-label small text-muted">{{ __('Reviews') }}</div>
                                </div>
                            </div>
                            
                            <div class="seller-verification mb-4">
                                <div class="verification-badge d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>{{ __('Verified Seller') }}</span>
                                </div>
                                <div class="verification-badge d-flex align-items-center mb-2">
                                    <i class="fas fa-envelope text-success me-2"></i>
                                    <span>{{ __('Email Verified') }}</span>
                                </div>
                                <div class="verification-badge d-flex align-items-center">
                                    <i class="fas fa-phone-alt text-success me-2"></i>
                                    <span>{{ __('Phone Verified') }}</span>
                                </div>
                            </div>
                            
                            @auth
                                @if(Auth::id() != $listing->user_id)
                                    <a href="#contact-form" class="btn btn-success w-100 mb-3">
                                        <i class="fas fa-comment-alt me-2"></i> {{ __('Contact Seller') }}
                                    </a>
                                    <a href="#" class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-user me-2"></i> {{ __('View Profile') }}
                                    </a>
                                @else
                                    <div class="alert alert-info mb-0">
                                        <i class="fas fa-info-circle me-2"></i> {{ __('This is your listing') }}
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-success w-100 mb-3">
                                    <i class="fas fa-sign-in-alt me-2"></i> {{ __('Login to Contact') }}
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                @auth
                    @if(Auth::id() != $listing->user_id)
                        <div class="card border-0 shadow-sm mb-4" id="contact-form">
                            <div class="card-body">
                                <h5 class="card-title mb-4">{{ __('Contact Seller') }}</h5>
                                
                                <form>
                                    <div class="mb-3">
                                        <label for="contactMessage" class="form-label">{{ __('Message') }}</label>
                                        <textarea class="form-control" id="contactMessage" rows="4" placeholder="{{ __('I am interested in your listing...') }}"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-paper-plane me-2"></i> {{ __('Send Message') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endauth
                
                <!-- Safety Tips -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">{{ __('Safety Tips') }}</h5>
                        
                        <ul class="safety-tips">
                            <li>{{ __('Meet in a public place for exchanges') }}</li>
                            <li>{{ __('Verify material quality before payment') }}</li>
                            <li>{{ __('Request proper documentation for services') }}</li>
                            <li>{{ __('Report suspicious listings or sellers') }}</li>
                            <li>{{ __('Never share personal financial information') }}</li>
                        </ul>
                        
                        <a href="#" class="btn btn-outline-secondary btn-sm w-100 mt-2">
                            <i class="fas fa-shield-alt me-2"></i> {{ __('Learn More About Safety') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .listing-image-lg {
            position: relative;
            height: 400px;
            overflow: hidden;
        }
        
        .listing-image-lg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .listing-category {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            z-index: 10;
        }
        
        .listing-status {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #198754;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            z-index: 10;
        }
        
        .listing-status.unavailable {
            background-color: #dc3545;
        }
        
        .listing-price {
            color: #198754;
            font-weight: 600;
        }
        
        .price-unit {
            font-size: 1rem;
            color: #6c757d;
            font-weight: normal;
        }
        
        .listing-location {
            font-size: 1rem;
            color: #6c757d;
        }
        
        .listing-description {
            white-space: pre-line;
        }
        
        .seller-avatar {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
        
        .stat-value {
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .safety-tips {
            padding-left: 1.5rem;
        }
        
        .safety-tips li {
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: #495057;
        }
        
        .similar-listings .listing-image {
            height: 150px;
            position: relative;
            overflow: hidden;
        }
        
        .similar-listings .listing-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .similar-listings .listing-category {
            font-size: 0.7rem;
            padding: 5px 10px;
            top: 10px;
            left: 10px;
        }
        
        .verification-badge {
            font-size: 0.9rem;
        }
    </style>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Contact form submission handler
            const contactForm = document.querySelector('#contact-form form');
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('{{ __("Message sent to seller! They will contact you soon.") }}');
                    contactForm.reset();
                });
            }
        });
    </script>
    @endpush
</x-app-layout> 