/**
 * Maps initialization script for Micheweni Waste Portal
 * Handles both world map (JVectorMap) and waste locations map (Leaflet)
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize JVectorMap for world map
    initWorldMap();
    
    // Initialize Leaflet map for waste locations
    initWasteMap();
});

/**
 * Initialize the World Map with JVectorMap
 */
function initWorldMap() {
    if (!document.getElementById('world-map')) return;
    
    try {
        // Define color data for countries
        var mapData = {
            "FI": 87, // Finland
            "NL": 85, // Netherlands
            "DE": 81, // Germany
            "DK": 79, // Denmark
            "SE": 78, // Sweden
            "JP": 75, // Japan
            "AT": 74, // Austria
            "BE": 73, // Belgium
            "FR": 73, // France
            "KE": 72, // Kenya
            "UK": 71, // United Kingdom
            "NO": 70, // Norway
            "CA": 68, // Canada
            "TZ": 65, // Tanzania
            "US": 62, // United States
            "ZA": 60, // South Africa
            "IN": 55, // India
            "BR": 50, // Brazil
            "CN": 48, // China
            "RU": 45  // Russia
        };
        
        // Generate colors based on values
        function getColor(value) {
            if (value >= 80) return '#1e7e34';
            else if (value >= 60) return '#28a745';
            else if (value >= 40) return '#66bb6a';
            else return '#e9ecef';
        }
        
        var colors = {};
        for (var code in mapData) {
            colors[code] = getColor(mapData[code]);
        }
        
        // Initialize the map
        $('#world-map').vectorMap({
            map: 'world_mill',
            backgroundColor: 'transparent',
            zoomOnScroll: false,
            series: {
                regions: [{
                    values: mapData,
                    scale: ['#e9ecef', '#1e7e34'],
                    normalizeFunction: 'linear',
                    attribute: 'fill'
                }]
            },
            onRegionTipShow: function(e, el, code) {
                if (mapData[code]) {
                    el.html(el.html() + ': ' + mapData[code] + '%');
                } else {
                    el.html(el.html() + ': No data');
                }
            },
            regionStyle: {
                initial: {
                    fill: '#e9ecef',
                    "fill-opacity": 1,
                    stroke: 'none',
                    "stroke-width": 0,
                    "stroke-opacity": 1
                },
                hover: {
                    "fill-opacity": 0.8,
                    cursor: 'pointer'
                },
                selected: {
                    fill: '#2ca25f'
                },
                selectedHover: {}
            },
            regionsSelectable: true,
            onRegionSelected: function(event, code, isSelected, selectedRegions) {
                document.querySelector('.country-profiles').classList.remove('d-none');
                
                // Show specific country profile
                const countryProfiles = document.querySelectorAll('.country-profile-card');
                countryProfiles.forEach(profile => {
                    profile.classList.add('d-none');
                });
                
                // Show the selected country's profile
                const selectedCountryProfile = document.querySelector('.country-profile-card[data-country="' + code + '"]');
                if (selectedCountryProfile) {
                    selectedCountryProfile.classList.remove('d-none');
                } else {
                    // Default to the first profile if specific country not found
                    if (countryProfiles.length > 0) {
                        countryProfiles[0].classList.remove('d-none');
                    }
                }
            }
        });
        
        // Manually set colors for countries
        setTimeout(function() {
            for (var code in colors) {
                if ($('.jvectormap-region.jvmap-element[data-code="' + code + '"]').length) {
                    $('.jvectormap-region.jvmap-element[data-code="' + code + '"]').css('fill', colors[code]);
                }
            }
        }, 500);
    } catch (error) {
        console.error('Error initializing world map:', error);
    }
}

/**
 * Initialize the Waste Locations Map with Leaflet
 */
function initWasteMap() {
    if (!document.getElementById('wasteMap')) return;
    
    try {
        var map = L.map('wasteMap').setView([-5.055833, 39.726944], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 18
        }).addTo(map);
        
        // Collection points in Micheweni
        var collectionPoints = [
            { lat: -5.055833, lng: 39.726944, name: 'Micheweni Central Collection Center', type: 'collection' },
            { lat: -5.059217, lng: 39.729431, name: 'Micheweni Market Collection Point', type: 'collection' },
            { lat: -5.053102, lng: 39.724509, name: 'Northern District Collection Point', type: 'collection' }
        ];
        
        // Recycling center
        var recyclingCenters = [
            { lat: -5.061394, lng: 39.731908, name: 'Micheweni Recycling Facility', type: 'recycling' }
        ];
        
        // Transfer stations
        var transferStations = [
            { lat: -5.048671, lng: 39.728104, name: 'Micheweni Transfer Station', type: 'transfer' }
        ];
        
        // Custom icons
        var collectionIcon = L.divIcon({
            className: 'custom-map-marker collection',
            html: '<i class="fas fa-map-marker-alt" style="color: #28a745; font-size: 24px;"></i>',
            iconSize: [24, 24],
            iconAnchor: [12, 24]
        });
        
        var recyclingIcon = L.divIcon({
            className: 'custom-map-marker recycling',
            html: '<i class="fas fa-recycle" style="color: #17a2b8; font-size: 24px;"></i>',
            iconSize: [24, 24],
            iconAnchor: [12, 24]
        });
        
        var transferIcon = L.divIcon({
            className: 'custom-map-marker transfer',
            html: '<i class="fas fa-trash-alt" style="color: #ffc107; font-size: 24px;"></i>',
            iconSize: [24, 24],
            iconAnchor: [12, 24]
        });
        
        // Add collection points to the map
        collectionPoints.forEach(function(point) {
            var marker = L.marker([point.lat, point.lng], {icon: collectionIcon}).addTo(map);
            marker.bindPopup("<b>" + point.name + "</b><br>Collection Point");
        });
        
        // Add recycling centers to the map
        recyclingCenters.forEach(function(point) {
            var marker = L.marker([point.lat, point.lng], {icon: recyclingIcon}).addTo(map);
            marker.bindPopup("<b>" + point.name + "</b><br>Recycling Center");
        });
        
        // Add transfer stations to the map
        transferStations.forEach(function(point) {
            var marker = L.marker([point.lat, point.lng], {icon: transferIcon}).addTo(map);
            marker.bindPopup("<b>" + point.name + "</b><br>Transfer Station");
        });
        
        // Update the stats on page
        document.querySelector('.stat-item:nth-child(1) .stat-value').textContent = collectionPoints.length;
        document.querySelector('.stat-item:nth-child(2) .stat-value').textContent = recyclingCenters.length;
        document.querySelector('.stat-item:nth-child(3) .stat-value').textContent = transferStations.length;
    } catch (error) {
        console.error('Error initializing waste map:', error);
    }
} 