<!-- Map Component -->
@php
    $map_address = $content->meta->map_address ?? '';
    $map_lat = $content->meta->map_lat ?? '-6.1620164';
    $map_lng = $content->meta->map_lng ?? '39.1914893';
    $map_zoom = $content->meta->map_zoom ?? 15;
    $map_height = $content->meta->map_height ?? '400px';
    $map_type = $content->meta->map_type ?? 'roadmap';
    $marker_title = $content->meta->marker_title ?? '';
    $template = $content->template ?? 'standard';
    $class = $content->meta->css_class ?? '';
@endphp

<div class="map-component {{ $class }}">
    <div class="map-container" style="height: {{ $map_height }}">
        @if($map_lat && $map_lng)
            <div id="map-{{ $content->id }}" class="google-map w-100 h-100"></div>
            
            <script>
                // Function to fetch Google Maps API key from the server
                function fetchGoogleMapsApiKey() {
                    return fetch('/api/google-maps-api-key')
                        .then(response => response.json())
                        .then(data => data.api_key)
                        .catch(error => {
                            console.error('Error fetching Google Maps API key:', error);
                            return '';
                        });
                }

                document.addEventListener('DOMContentLoaded', async function() {
                    // Fetch API key and load Google Maps
                    try {
                        const apiKey = await fetchGoogleMapsApiKey();
                        
                        // Load Google Maps API dynamically
                        if (!window.google || !window.google.maps) {
                            const script = document.createElement('script');
                            script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initMap{{ $content->id }}`;
                            script.async = true;
                            script.defer = true;
                            document.head.appendChild(script);
                        } else {
                            // If API is already loaded, initialize map directly
                            initMap{{ $content->id }}();
                        }
                    } catch (error) {
                        console.error('Error loading Google Maps:', error);
                    }
                });
                
                function initMap{{ $content->id }}() {
                    const mapElement = document.getElementById('map-{{ $content->id }}');
                    
                    if (mapElement) {
                        const position = { lat: {{ $map_lat }}, lng: {{ $map_lng }} };
                        const mapOptions = {
                            zoom: {{ $map_zoom }},
                            center: position,
                            mapTypeId: '{{ $map_type }}'
                        };
                        
                        const map = new google.maps.Map(mapElement, mapOptions);
                        
                        // Add marker
                        const marker = new google.maps.Marker({
                            position: position,
                            map: map,
                            title: '{{ $marker_title }}'
                        });
                    }
                }
            </script>
        @else
            <div class="alert alert-info">
                Please configure map coordinates in the component settings.
            </div>
        @endif
    </div>
    
    @if($map_address)
        <div class="map-address mt-2">
            <strong>Address:</strong> {{ $map_address }}
        </div>
    @endif
</div> 