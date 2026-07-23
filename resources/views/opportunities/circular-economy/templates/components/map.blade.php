{{-- templates/components/map.blade.php --}}
@php
    // Get map data from content
    $meta = is_string($content->meta) ? json_decode($content->meta, true) : [];
    if (empty($meta) && is_object($content->meta)) {
        $meta = (array) $content->meta;
    }
    
    // Extract properties with proper fallbacks
    $latitude = $meta['latitude'] ?? '-6.369';  // Default to Tanzania
    $longitude = $meta['longitude'] ?? '34.8888';  // Default to Tanzania
    $zoom = $meta['zoom'] ?? 10;
    $height = $meta['height'] ?? '400px';
    $mapType = $meta['map_type'] ?? 'roadmap';
    $title = $meta['title'] ?? '';
    $description = $meta['description'] ?? '';
    $apiKey = config('services.google_maps.api_key', '');
    
    // Generate a unique ID for the map
    $mapId = 'map-' . md5(json_encode($meta) . time() . rand(1000, 9999));
@endphp

<div class="map-component">
    @if($title)
        <h5 class="map-title">{{ $title }}</h5>
    @endif
    
    <div id="{{ $mapId }}" class="map-container rounded shadow-sm" style="height: {{ $height }};">
        @if(!$apiKey)
            <div class="alert alert-warning h-100 d-flex flex-column justify-content-center align-items-center text-center">
                <i class="fas fa-map-marked-alt fa-3x mb-3"></i>
                <h5>{{ __('Map API Key Not Configured') }}</h5>
                <p class="mb-0">{{ __('Please configure your Google Maps API key in the settings.') }}</p>
            </div>
        @endif
    </div>
    
    @if($description)
        <div class="map-description text-muted small mt-2">{{ $description }}</div>
    @endif
</div>

@if($apiKey)
    @push('scripts')
    <script>
        function initMap{{ str_replace('-', '_', $mapId) }}() {
            const mapOptions = {
                center: { lat: {{ $latitude }}, lng: {{ $longitude }} },
                zoom: {{ $zoom }},
                mapTypeId: '{{ $mapType }}',
                mapTypeControl: true,
                streetViewControl: false,
                fullscreenControl: true
            };
            
            const map = new google.maps.Map(document.getElementById('{{ $mapId }}'), mapOptions);
            
            const marker = new google.maps.Marker({
                position: { lat: {{ $latitude }}, lng: {{ $longitude }} },
                map: map,
                animation: google.maps.Animation.DROP,
                title: '{{ $title }}'
            });
            
            @if($description)
            const infoWindow = new google.maps.InfoWindow({
                content: '<div class="map-info-window"><p>{{ $description }}</p></div>'
            });
            
            marker.addListener('click', function() {
                infoWindow.open(map, marker);
            });
            @endif
        }

        // Load Google Maps API and initialize the map
        if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
            // Only load the API if it hasn't been loaded yet
            const script = document.createElement('script');
            script.src = 'https://maps.googleapis.com/maps/api/js?key={{ $apiKey }}&callback=initMap{{ str_replace('-', '_', $mapId) }}';
            script.async = true;
            script.defer = true;
            document.head.appendChild(script);
        } else {
            // If already loaded, just initialize the map
            initMap{{ str_replace('-', '_', $mapId) }}();
        }
    </script>
    @endpush
@endif

<style>
.map-container {
    min-height: 300px;
    width: 100%;
}

.map-title {
    margin-bottom: 0.5rem;
}

.map-description {
    font-style: italic;
}

.map-info-window {
    padding: 5px;
    max-width: 250px;
}
</style> 