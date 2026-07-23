<x-app-layout>
    <!-- Hero Section -->
    <div class="py-5 bg-gradient-to-r from-green-800 to-green-600 text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold mb-3">{{ __('Waste Trading Marketplace') }}</h1>
                    <p class="lead mb-4">{{ __('Connect with waste management professionals, traders, and service providers in Micheweni, Pemba.') }}</p>
                    
                    @guest
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i> {{ __('Login to Trade') }}
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-user-plus me-2"></i> {{ __('Register') }}
                        </a>
                    </div>
                    <p class="small mt-3"><i class="fas fa-info-circle me-1"></i> {{ __('Login or register to post listings and contact traders') }}</p>
                    @else
                    <div class="d-flex flex-wrap gap-3">
                        <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#createListingModal">
                            <i class="fas fa-plus-circle me-2"></i> {{ __('Create Listing') }}
                        </button>
                        <a href="{{ route('opportunities.circular-economy.waste.my-listings') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-bookmark me-2"></i> {{ __('My Listings') }}
                        </a>
                    </div>
                    @endguest
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="{{ asset('images/waste-marketplace.svg') }}" alt="Waste Marketplace" class="img-fluid rounded-3" onerror="this.src='https://placehold.co/600x400/198754/white?text=Waste+Marketplace'">
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <!-- Search and Filter Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('opportunities.circular-economy.waste.marketplace') }}" method="GET" id="searchForm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="searchKeyword" name="search" placeholder="{{ __('Search listings...') }}" value="{{ request('search') }}">
                                <label for="searchKeyword">{{ __('Search keywords') }}</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <select class="form-select" id="categoryFilter" name="category">
                                    <option value="">{{ __('All Categories') }}</option>
                                    @foreach($categories as $key => $category)
                                        <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $category }}</option>
                                    @endforeach
                                </select>
                                <label for="categoryFilter">{{ __('Category') }}</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <select class="form-select" id="locationFilter" name="location">
                                    <option value="">{{ __('All Locations') }}</option>
                                    <option value="micheweni" {{ request('location') == 'micheweni' ? 'selected' : '' }}>{{ __('Micheweni') }}</option>
                                    <option value="chake-chake" {{ request('location') == 'chake-chake' ? 'selected' : '' }}>{{ __('Chake Chake') }}</option>
                                    <option value="mkoani" {{ request('location') == 'mkoani' ? 'selected' : '' }}>{{ __('Mkoani') }}</option>
                                    <option value="pemba" {{ request('location') == 'pemba' ? 'selected' : '' }}>{{ __('Pemba (All)') }}</option>
                                    <option value="zanzibar" {{ request('location') == 'zanzibar' ? 'selected' : '' }}>{{ __('Zanzibar') }}</option>
                                </select>
                                <label for="locationFilter">{{ __('Location') }}</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success h-100 w-100">
                                <i class="fas fa-search me-2"></i> {{ __('Search') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Category Quick Links -->
        <div class="category-links mb-4">
            <div class="d-flex flex-wrap gap-2">
                @foreach($categories as $key => $category)
                    <a href="{{ route('opportunities.circular-economy.waste.marketplace', ['category' => $key]) }}" class="btn {{ request('category') == $key ? 'btn-success' : 'btn-outline-success' }} category-btn" data-category="{{ $key }}">
                        <i class="fas fa-{{ $key == 'recyclable_materials' ? 'recycle' : 
                                         ($key == 'equipment_machinery' ? 'tools' : 
                                         ($key == 'collection_services' ? 'truck' : 
                                         ($key == 'consulting_services' ? 'briefcase' : 
                                         ($key == 'training_education' ? 'graduation-cap' : 'leaf')))) }} me-2"></i>
                        {{ $category }}
                    </a>
                @endforeach
            </div>
        </div>
        
        <!-- Featured Listings -->
        <h2 class="section-title mb-4">{{ __('Featured Listings') }}</h2>
        
        <div class="row g-4 mb-5">
            @foreach($listings as $listing)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 listing-card">
                    <div class="listing-image">
                        <img src="{{ asset($listing['image']) }}" class="card-img-top" alt="{{ $listing['title'] }}" onerror="this.src='https://placehold.co/600x400/198754/white?text=Listing'">
                        <div class="listing-category">{{ $categories[$listing['category']] ?? $listing['category'] }}</div>
                        @if($listing['is_available'])
                            <div class="listing-status">{{ __('Available') }}</div>
                        @else
                            <div class="listing-status unavailable">{{ __('Unavailable') }}</div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset($listing['user']['avatar']) }}" class="avatar-sm rounded-circle me-2" alt="{{ $listing['user']['name'] }}" onerror="this.src='https://placehold.co/50x50/198754/white?text=User'">
                            <div>
                                <div class="d-flex align-items-center">
                                    <span class="fw-medium">{{ $listing['user']['name'] }}</span>
                                    @if($listing['user']['verified'])
                                        <span class="ms-1 text-primary" data-bs-toggle="tooltip" title="{{ __('Verified Provider') }}">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                    @endif
                                </div>
                                <div class="user-rating small">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($listing['user']['rating']))
                                            <i class="fas fa-star text-warning"></i>
                                        @elseif($i - 0.5 <= $listing['user']['rating'])
                                            <i class="fas fa-star-half-alt text-warning"></i>
                                        @else
                                            <i class="far fa-star text-warning"></i>
                                        @endif
                                    @endfor
                                    <span class="ms-1">{{ $listing['user']['rating'] }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <h5 class="card-title">{{ $listing['title'] }}</h5>
                        <p class="card-text text-muted">{{ $listing['description'] }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="listing-price">
                                <span class="price-amount">{{ number_format($listing['price']) }} TZS</span>
                                <span class="price-unit small">{{ $listing['price_unit'] }}</span>
                            </div>
                            <div class="listing-location small">
                                <i class="fas fa-map-marker-alt me-1"></i> {{ $listing['location'] }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">
                                <i class="far fa-clock me-1"></i> {{ $listing['created_at']->diffForHumans() }}
                            </span>
                            
                            <div class="btn-group">
                                @auth
                                <form action="{{ route('opportunities.circular-economy.waste.toggle-listing', $listing['id']) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                        <i class="far fa-bookmark me-1"></i> {{ __('Save') }}
                                    </button>
                                </form>
                                <a href="{{ route('opportunities.circular-economy.waste.show-listing', $listing['id']) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-comment-alt me-1"></i> {{ __('Contact') }}
                                </a>
                                @else
                                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="far fa-bookmark me-1"></i> {{ __('Save') }}
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-sign-in-alt me-1"></i> {{ __('Login to Contact') }}
                                </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Service Providers Section -->
        <h2 class="section-title mb-4">{{ __('Featured Service Providers') }}</h2>
        
        <div class="row g-4 mb-5">
            @if(count($serviceProviders) > 0)
                @foreach($serviceProviders as $provider)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 provider-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset($provider->profile->avatar ?? 'images/avatars/default.jpg') }}" class="avatar rounded-circle me-3" alt="{{ $provider->name }}" onerror="this.src='https://placehold.co/80x80/198754/white?text=Provider'">
                                <div>
                                    <h5 class="mb-1">{{ $provider->name }}</h5>
                                    <div class="provider-meta">
                                        <span class="badge bg-success-subtle text-success me-2">{{ $provider->profile->service_type ?? __('Waste Services') }}</span>
                                        @if($provider->email_verified_at)
                                            <span class="badge bg-primary-subtle text-primary">{{ __('Verified') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <p class="card-text">{{ $provider->profile->bio ?? __('Professional waste management service provider in Pemba. Specializing in collection, recycling, and sustainable waste solutions.') }}</p>
                            
                            <div class="provider-details mt-3">
                                <div class="provider-detail">
                                    <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                    <span>{{ $provider->profile->location ?? __('Micheweni, Pemba') }}</span>
                                </div>
                                <div class="provider-detail">
                                    <i class="fas fa-briefcase text-muted me-2"></i>
                                    <span>{{ $provider->profile->experience ?? __('5+ years experience') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            @auth
                            <a href="#" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-comment-alt me-1"></i> {{ __('Contact Provider') }}
                            </a>
                            @else
                            <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-sign-in-alt me-1"></i> {{ __('Login to Contact') }}
                            </a>
                            @endauth
                            <a href="#" class="btn btn-link btn-sm text-muted">
                                <i class="fas fa-external-link-alt me-1"></i> {{ __('View Profile') }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                @for($i = 0; $i < 3; $i++)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 provider-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset('images/avatars/default.jpg') }}" class="avatar rounded-circle me-3" alt="Service Provider" onerror="this.src='https://placehold.co/80x80/198754/white?text=Provider'">
                                <div>
                                    <h5 class="mb-1">{{ __('Eco Solutions Ltd') }}</h5>
                                    <div class="provider-meta">
                                        <span class="badge bg-success-subtle text-success me-2">{{ __('Waste Services') }}</span>
                                        <span class="badge bg-primary-subtle text-primary">{{ __('Verified') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="card-text">{{ __('Professional waste management service provider in Pemba. Specializing in collection, recycling, and sustainable waste solutions.') }}</p>
                            
                            <div class="provider-details mt-3">
                                <div class="provider-detail">
                                    <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                    <span>{{ __('Micheweni, Pemba') }}</span>
                                </div>
                                <div class="provider-detail">
                                    <i class="fas fa-briefcase text-muted me-2"></i>
                                    <span>{{ __('5+ years experience') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            @auth
                            <a href="#" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-comment-alt me-1"></i> {{ __('Contact Provider') }}
                            </a>
                            @else
                            <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-sign-in-alt me-1"></i> {{ __('Login to Contact') }}
                            </a>
                            @endauth
                            <a href="#" class="btn btn-link btn-sm text-muted">
                                <i class="fas fa-external-link-alt me-1"></i> {{ __('View Profile') }}
                            </a>
                        </div>
                    </div>
                </div>
                @endfor
            @endif
        </div>
        
        <!-- How It Works Section -->
        <div class="card bg-light border-0 rounded-4 mb-5">
            <div class="card-body p-4">
                <h3 class="card-title mb-4">{{ __('How the Marketplace Works') }}</h3>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="how-it-works-icon mb-3">
                                <i class="fas fa-user-plus fa-2x text-success"></i>
                            </div>
                            <h5>{{ __('1. Create an Account') }}</h5>
                            <p class="text-muted">{{ __('Register to join our marketplace of waste management professionals.') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="how-it-works-icon mb-3">
                                <i class="fas fa-list-alt fa-2x text-success"></i>
                            </div>
                            <h5>{{ __('2. Create Listings') }}</h5>
                            <p class="text-muted">{{ __('Post your waste materials, services, or equipment you want to trade.') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="how-it-works-icon mb-3">
                                <i class="fas fa-handshake fa-2x text-success"></i>
                            </div>
                            <h5>{{ __('3. Connect & Trade') }}</h5>
                            <p class="text-muted">{{ __('Message other traders, negotiate, and complete transactions safely.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- CTA Section -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card bg-success text-white border-0 rounded-4 h-100">
                    <div class="card-body p-4">
                        <h3>{{ __('Are You a Waste Service Provider?') }}</h3>
                        <p>{{ __('Join our marketplace to connect with customers looking for waste management services.') }}</p>
                        <a href="{{ route('register') }}" class="btn btn-light">
                            <i class="fas fa-user-plus me-2"></i> {{ __('Register as Provider') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-primary text-white border-0 rounded-4 h-100">
                    <div class="card-body p-4">
                        <h3>{{ __('Looking to Buy or Sell Materials?') }}</h3>
                        <p>{{ __('Create an account to start trading recyclable materials, equipment, and more.') }}</p>
                        <a href="{{ route('register') }}" class="btn btn-light">
                            <i class="fas fa-shopping-cart me-2"></i> {{ __('Start Trading Now') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @auth
    <!-- Create Listing Modal -->
    <div class="modal fade" id="createListingModal" tabindex="-1" aria-labelledby="createListingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createListingModalLabel">{{ __('Create New Listing') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('opportunities.circular-economy.waste.store-listing') }}" method="POST" enctype="multipart/form-data" id="createListingForm">
                        @csrf
                        <div class="mb-3">
                            <label for="listingTitle" class="form-label">{{ __('Title') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="listingTitle" name="title" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="listingCategory" class="form-label">{{ __('Category') }} <span class="text-danger">*</span></label>
                            <select class="form-select" id="listingCategory" name="category" required>
                                <option value="">{{ __('Select a category') }}</option>
                                @foreach($categories as $key => $category)
                                    <option value="{{ $key }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="listingPrice" class="form-label">{{ __('Price (TZS)') }} <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="listingPrice" name="price" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="listingPriceUnit" class="form-label">{{ __('Price Unit') }}</label>
                                    <select class="form-select" id="listingPriceUnit" name="price_unit">
                                        <option value="per ton">{{ __('per ton') }}</option>
                                        <option value="per kg">{{ __('per kg') }}</option>
                                        <option value="for lot">{{ __('for lot') }}</option>
                                        <option value="per day">{{ __('per day') }}</option>
                                        <option value="per hour">{{ __('per hour') }}</option>
                                        <option value="monthly">{{ __('monthly') }}</option>
                                        <option value="per project">{{ __('per project') }}</option>
                                        <option value="negotiable">{{ __('negotiable') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="listingDescription" class="form-label">{{ __('Description') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="listingDescription" name="description" rows="4" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="listingLocation" class="form-label">{{ __('Location') }} <span class="text-danger">*</span></label>
                            <select class="form-select" id="listingLocation" name="location" required>
                                <option value="Micheweni, Pemba">{{ __('Micheweni, Pemba') }}</option>
                                <option value="Chake Chake, Pemba">{{ __('Chake Chake, Pemba') }}</option>
                                <option value="Mkoani, Pemba">{{ __('Mkoani, Pemba') }}</option>
                                <option value="Zanzibar">{{ __('Zanzibar') }}</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="listingImage" class="form-label">{{ __('Image') }}</label>
                            <input type="file" class="form-control" id="listingImage" name="image">
                            <div class="form-text">{{ __('Upload an image of your item or service (optional)') }}</div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn-success">{{ __('Create Listing') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endauth
    
    <style>
        .listing-card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .listing-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .listing-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }
        
        .listing-image img {
            height: 100%;
            object-fit: cover;
            width: 100%;
        }
        
        .listing-category {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        
        .listing-status {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #198754;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        
        .listing-status.unavailable {
            background-color: #dc3545;
        }
        
        .avatar-sm {
            width: 40px;
            height: 40px;
            object-fit: cover;
        }
        
        .avatar {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
        
        .listing-price {
            color: #198754;
            font-weight: 600;
        }
        
        .price-unit {
            color: #6c757d;
            font-weight: normal;
        }
        
        .category-btn {
            border-radius: 30px;
            padding: 8px 15px;
            font-size: 0.9rem;
        }
        
        .provider-card {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .provider-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .provider-detail {
            margin-bottom: 5px;
            color: #6c757d;
        }
        
        .how-it-works-icon {
            width: 80px;
            height: 80px;
            background-color: rgba(25, 135, 84, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }
    </style>
    
    @push('scripts')
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Category filter buttons
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const category = this.getAttribute('data-category');
                    document.getElementById('categoryFilter').value = category;
                    document.getElementById('searchForm').submit();
                });
            });
        });
    </script>
    @endpush
</x-app-layout> 