let map, marker;

function initMap() {
    try {
        // Check if map container exists
        const mapElement = document.getElementById('map');
        if (!mapElement) {
            console.error('Map container not found');
            return;
        }

        // Dar es Salaam coordinates
        const defaultLocation = [-6.7924, 39.2083];
        
        // Initialize map
        map = L.map('map').setView(defaultLocation, 13);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Create marker
        marker = L.marker(defaultLocation, {
            draggable: true
        }).addTo(map);

        // Initialize geocoder
        const geocoder = L.Control.geocoder({
            defaultMarkGeocode: false,
            placeholder: 'Search address...',
            errorMessage: 'Address not found.'
        })
        .on('markgeocode', function(e) {
            const center = e.geocode.center;
            map.setView(center, 16);
            marker.setLatLng(center);
            updateCoordinates(center);
        })
        .addTo(map);

        // Handle marker drag
        marker.on('dragend', function() {
            const position = marker.getLatLng();
            updateCoordinates(position);
            reverseGeocode(position);
        });

        // Force map to refresh
        setTimeout(() => {
            map.invalidateSize();
        }, 100);

    } catch (error) {
        console.error('Map initialization error:', error);
        showMapError();
    }
}

// Helper functions
function updateCoordinates(latlng) {
    document.getElementById('latitude').value = latlng.lat;
    document.getElementById('longitude').value = latlng.lng;
}

function reverseGeocode(latlng) {
    const geocoder = L.Control.Geocoder.nominatim();
    geocoder.reverse(latlng, map.getZoom(), function(results) {
        if (results && results.length > 0) {
            document.getElementById('address-input').value = results[0].name;
        }
    });
}

function showMapError() {
    const mapDiv = document.getElementById('map');
    if (mapDiv) {
        mapDiv.innerHTML = '<div class="alert alert-danger">Error loading map. Please refresh the page.</div>';
    }
}

// Initialize map when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Set map container styles
    const mapDiv = document.getElementById('map');
    if (mapDiv) {
        mapDiv.style.minHeight = '400px';
        mapDiv.style.width = '100%';
        mapDiv.style.border = '1px solid #ddd';
        mapDiv.style.borderRadius = '4px';
    }

    // Initialize map with slight delay to ensure container is ready
    setTimeout(initMap, 100);
});

// Handle tab changes if map is in a tab
document.addEventListener('shown.bs.tab', function() {
    if (map) {
        map.invalidateSize();
    }
});