<x-app-layout>
    <!-- Hero Section -->
    <div class="py-5 bg-gradient-to-r from-green-800 to-green-600 text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold mb-3">{{ __('Waste Management Map') }}</h1>
                    <p class="lead mb-4">{{ __('Find waste collection points, recycling centers, and other waste management facilities in Micheweni.') }}</p>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="{{ asset('images/waste-map-illustration.png') }}" alt="Waste Management Map" class="img-fluid rounded-3" onerror="this.src='https://placehold.co/600x400/198754/white?text=Waste+Management+Map'">
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="section-title">{{ __('Waste Collection Map') }}</h1>
                <p class="section-description">{{ __('Find waste collection points, recycling centers, and transfer stations near you.') }}</p>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div id="waste-map" style="height: 500px; width: 100%;"></div>
                    </div>
                    <div class="card-footer bg-white p-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-3">
                            <div class="stats-item">
                                <span class="stats-value">{{ $collectionPoints ?? 2 }}</span>
                                <span class="stats-label">{{ __('Collection Points') }}</span>
                            </div>
                            <div class="stats-item">
                                <span class="stats-value">{{ $recyclingCenters ?? 1 }}</span>
                                <span class="stats-label">{{ __('Recycling Centers') }}</span>
                            </div>
                            <div class="stats-item">
                                <span class="stats-value">{{ $transferStations ?? 1 }}</span>
                                <span class="stats-label">{{ __('Transfer Stations') }}</span>
                            </div>
                        </div>
                        <button id="find-nearest" class="btn btn-primary">
                            <i class="fas fa-map-marker-alt me-2"></i>{{ __('Find Nearest') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nearest Location Notification Area -->
        <div id="nearest-location-notification" class="mb-4"></div>
        
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title">{{ __('Map Legend') }}</h5>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="map-legend-item">
                                <span class="legend-dot bg-primary"></span>
                                <span class="legend-text">{{ __('Collection Points') }}</span>
                            </div>
                            <div class="map-legend-item">
                                <span class="legend-dot bg-success"></span>
                                <span class="legend-text">{{ __('Recycling Centers') }}</span>
                            </div>
                            <div class="map-legend-item">
                                <span class="legend-dot bg-danger"></span>
                                <span class="legend-text">{{ __('Transfer Stations') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Facility Listings Section -->
        <h2 class="section-title mt-5 mb-4">{{ __('Featured Facilities') }}</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="collection-point-card fade-in-up delay-1">
                    <div class="collection-point-img">
                        <img src="{{ asset('images/collection-point.jpg') }}" alt="Collection Point" onerror="this.src='https://placehold.co/600x400/198754/white?text=Collection+Point'">
                        <div class="collection-point-type">{{ __('Collection Point') }}</div>
                    </div>
                    <div class="collection-point-content">
                        <h5 class="collection-point-title">{{ __('Micheweni Town Collection') }}</h5>
                        <div class="collection-point-info">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>{{ __('Main Street, Micheweni Town Center') }}</div>
                        </div>
                        <div class="collection-point-info">
                            <i class="fas fa-clock"></i>
                            <div>{{ __('Open daily: 8am - 6pm') }}</div>
                        </div>
                        <div class="collection-point-info">
                            <i class="fas fa-trash"></i>
                            <div>{{ __('Accepts: General waste, Paper, Plastic') }}</div>
                        </div>
                    </div>
                    <div class="collection-point-footer">
                        <div class="collection-point-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <div class="collection-point-status status-open">{{ __('Open') }}</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="collection-point-card fade-in-up delay-2">
                    <div class="collection-point-img">
                        <img src="{{ asset('images/recycling-center.jpg') }}" alt="Recycling Center" onerror="this.src='https://placehold.co/600x400/28a745/white?text=Recycling+Center'">
                        <div class="collection-point-type">{{ __('Recycling Center') }}</div>
                    </div>
                    <div class="collection-point-content">
                        <h5 class="collection-point-title">{{ __('Micheweni Recycling Center') }}</h5>
                        <div class="collection-point-info">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>{{ __('Industrial Area, Micheweni') }}</div>
                        </div>
                        <div class="collection-point-info">
                            <i class="fas fa-clock"></i>
                            <div>{{ __('Mon-Sat: 9am - 5pm') }}</div>
                        </div>
                        <div class="collection-point-info">
                            <i class="fas fa-recycle"></i>
                            <div>{{ __('Accepts: Plastic, Metal, Glass, Paper') }}</div>
                        </div>
                    </div>
                    <div class="collection-point-footer">
                        <div class="collection-point-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <div class="collection-point-status status-open">{{ __('Open') }}</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="collection-point-card fade-in-up delay-3">
                    <div class="collection-point-img">
                        <img src="{{ asset('images/transfer-station.jpg') }}" alt="Transfer Station" onerror="this.src='https://placehold.co/600x400/dc3545/white?text=Transfer+Station'">
                        <div class="collection-point-type">{{ __('Transfer Station') }}</div>
                    </div>
                    <div class="collection-point-content">
                        <h5 class="collection-point-title">{{ __('Chake Chake Transfer Station') }}</h5>
                        <div class="collection-point-info">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>{{ __('Outskirts of Chake Chake') }}</div>
                        </div>
                        <div class="collection-point-info">
                            <i class="fas fa-clock"></i>
                            <div>{{ __('Mon-Fri: 8am - 4pm') }}</div>
                        </div>
                        <div class="collection-point-info">
                            <i class="fas fa-trash-restore"></i>
                            <div>{{ __('Accepts: Large waste, Construction debris') }}</div>
                        </div>
                    </div>
                    <div class="collection-point-footer">
                        <div class="collection-point-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <div class="collection-point-status status-closed">{{ __('Closed') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .map-legend-item {
            display: flex;
            align-items: center;
            margin-right: 1rem;
        }
        
        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 6px;
        }
        
        .legend-text {
            font-size: 0.9rem;
            color: var(--text-muted);
        }
        
        .custom-marker {
            display: flex !important;
            align-items: center;
            justify-content: center;
            width: 36px !important;
            height: 36px !important;
            background-color: #fff;
            border-radius: 50%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .custom-marker i {
            font-size: 18px;
        }
    </style>
    
    @push('scripts')
    <!-- Google Maps API script will be loaded dynamically by wasteMap.js -->
    <script>
        // Load waste locations from the backend
        window.wasteLocations = @json($wasteLocations ?? []);

        document.addEventListener('DOMContentLoaded', function() {
            // Update the counter values with animation
            const statsValues = document.querySelectorAll('.stats-value');
            const targetValues = [
                {{ $collectionPoints ?? 2 }}, 
                {{ $recyclingCenters ?? 1 }}, 
                {{ $transferStations ?? 1 }}
            ];
            
            statsValues.forEach((element, index) => {
                const targetValue = targetValues[index];
                
                let currentValue = 0;
                const duration = 1500; // Animation duration in ms
                const interval = 50; // Update interval in ms
                const steps = duration / interval;
                const increment = targetValue / steps;
                
                const counter = setInterval(() => {
                    currentValue += increment;
                    if (currentValue >= targetValue) {
                        element.textContent = targetValue;
                        clearInterval(counter);
                    } else {
                        element.textContent = Math.floor(currentValue);
                    }
                }, interval);
            });
        });
    </script>
    
    <!-- Load the waste map script -->
    <script src="{{ asset('js/maps/wasteMap.js') }}"></script>
    @endpush
</x-app-layout> 