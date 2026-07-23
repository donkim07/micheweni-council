<x-app-layout>
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">{{ __('Waste Locations') }}</h1>
                
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <p class="lead">{{ __('Find waste collection points and recycling centers in Micheweni, Pemba.') }}</p>
                        
                        <div id="waste-map" style="height: 500px;" class="mb-4 border rounded"></div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">{{ __('Collection Points') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    @foreach($locations->where('type', 'collection') as $location)
                                        <div class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">{{ $location->name }}</h5>
                                                <small>{{ $location->distance ? $location->distance . ' km' : '' }}</small>
                                            </div>
                                            <p class="mb-1">{{ $location->address }}</p>
                                            <small>{{ $location->operating_hours }}</small>
                                            
                                            <div class="mt-2">
                                                <button class="btn btn-sm btn-outline-primary location-btn" 
                                                        data-lat="{{ $location->latitude }}" 
                                                        data-lng="{{ $location->longitude }}"
                                                        data-name="{{ $location->name }}">
                                                    <i class="fas fa-map-marker-alt"></i> {{ __('View on Map') }}
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">{{ __('Recycling Centers') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    @foreach($locations->where('type', 'recycling') as $location)
                                        <div class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">{{ $location->name }}</h5>
                                                <small>{{ $location->distance ? $location->distance . ' km' : '' }}</small>
                                            </div>
                                            <p class="mb-1">{{ $location->address }}</p>
                                            <small>{{ $location->operating_hours }}</small>
                                            
                                            <div class="mt-2">
                                                <button class="btn btn-sm btn-outline-success location-btn" 
                                                        data-lat="{{ $location->latitude }}" 
                                                        data-lng="{{ $location->longitude }}"
                                                        data-name="{{ $location->name }}">
                                                    <i class="fas fa-map-marker-alt"></i> {{ __('View on Map') }}
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        // Fetch Google Maps API key from the server
        function fetchGoogleMapsApiKey() {
            // Use window.location.origin to get the full base URL
            const baseUrl = window.location.origin;
            const apiUrl = `${baseUrl}/api/google-maps-api-key`;
            
            console.log('Fetching Google Maps API key from:', apiUrl);
            
            return fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('API key received:', data.api_key ? 'Yes (key hidden for security)' : 'No key found');
                    return data.api_key || '';
                })
                .catch(error => {
                    console.error('Error fetching Google Maps API key:', error);
                    return '';
                });
        }

        // Initialize Google Maps
        async function initMap() {
            try {
                const apiKey = await fetchGoogleMapsApiKey();
                
                // Load Google Maps API dynamically
                if (!window.google || !window.google.maps) {
                    const script = document.createElement('script');
                    script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initializeGoogleMap`;
                    script.async = true;
                    script.defer = true;
                    document.head.appendChild(script);
                    
                    // Define the callback function
                    window.initializeGoogleMap = function() {
                        createGoogleMap();
                    };
                } else {
                    createGoogleMap();
                }
            } catch (error) {
                console.error('Error initializing map:', error);
            }
        }

        // Create Google Map with markers
        function createGoogleMap() {
            // Initialize Google Map centered on Micheweni, Pemba
            var weteCoordinates = { lat: -5.0561, lng: 39.7303 };
            var map = new google.maps.Map(document.getElementById('waste-map'), {
                center: weteCoordinates,
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.TOP_RIGHT
                },
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_CENTER
                },
                scaleControl: true,
                streetViewControl: true,
                fullscreenControl: true
            });
            
            // Store map instance globally
            window.googleMap = map;
            
            // Add markers for each location
            var locations = {!! json_encode($locations) !!};
            var markers = {};
            var infoWindow = new google.maps.InfoWindow();
            
            for (var i = 0; i < locations.length; i++) {
                var location = locations[i];
                var position = { 
                    lat: parseFloat(location.latitude), 
                    lng: parseFloat(location.longitude) 
                };
                
                // Choose marker color based on location type
                var iconUrl = 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'; // default
                if (location.type === 'recycling') {
                    iconUrl = 'https://maps.google.com/mapfiles/ms/icons/green-dot.png';
                } else if (location.type === 'transfer') {
                    iconUrl = 'https://maps.google.com/mapfiles/ms/icons/red-dot.png';
                }
                
                var marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: location.name,
                    icon: {
                        url: iconUrl
                    }
                });
                
                // Create closure for event listener
                attachInfoWindow(marker, location);
                
                markers[location.id] = marker;
            }
            
            // Function to attach info window to marker
            function attachInfoWindow(marker, location) {
                var contentString = 
                    '<strong>' + location.name + '</strong><br>' +
                    location.address + '<br>' +
                    '<small>' + (location.operating_hours || '') + '</small>';
                
                marker.addListener('click', function() {
                    infoWindow.setContent(contentString);
                    infoWindow.open(map, marker);
                });
            }
            
            // Location buttons click handler
            var buttons = document.querySelectorAll('.location-btn');
            for (var j = 0; j < buttons.length; j++) {
                buttons[j].addEventListener('click', function() {
                    var lat = parseFloat(this.getAttribute('data-lat'));
                    var lng = parseFloat(this.getAttribute('data-lng'));
                    var name = this.getAttribute('data-name');
                    
                    map.setCenter({ lat: lat, lng: lng });
                    map.setZoom(16);
                    
                    // Find the marker and open its popup
                    for (var id in markers) {
                        if (markers.hasOwnProperty(id)) {
                            var marker = markers[id];
                            var markerPosition = marker.getPosition();
                            if (markerPosition.lat() === lat && markerPosition.lng() === lng) {
                                google.maps.event.trigger(marker, 'click');
                                break;
                            }
                        }
                    }
                    
                    // Scroll to map
                    document.getElementById('waste-map').scrollIntoView({ behavior: 'smooth' });
                });
            }
        }

        // Initialize map when DOM is loaded
        document.addEventListener('DOMContentLoaded', initMap);
    </script>
    @endpush
</x-app-layout> 