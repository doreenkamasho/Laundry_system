document.addEventListener('DOMContentLoaded', function() {
    // Initialize the map with Leaflet
    const mapElement = document.getElementById('map');
    
    if (!mapElement) return;
    
    // Get initial coordinates from hidden inputs
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const addressInput = document.getElementById('address-input');
    
    // Default coordinates if none are set
    let initialLat = latInput.value ? parseFloat(latInput.value) : -6.7924;
    let initialLng = lngInput.value ? parseFloat(lngInput.value) : 39.2083;
    
    // Initialize map
    const map = L.map('map').setView([initialLat, initialLng], 13);
    
    // Add tile layer (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Add a marker at the initial position
    let marker = L.marker([initialLat, initialLng], {
        draggable: true
    }).addTo(map);
    
    // Update coordinates when marker is dragged
    marker.on('dragend', function(event) {
        const position = marker.getLatLng();
        latInput.value = position.lat;
        lngInput.value = position.lng;
        
        // Reverse geocode to get address
        reverseGeocode(position.lat, position.lng);
    });
    
    // Function to handle geocoding from address to coordinates
    function geocodeAddress() {
        const address = addressInput.value;
        if (!address) return;
        
        // Use Nominatim for geocoding
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lng = parseFloat(data[0].lon);
                    
                    // Update marker and map
                    marker.setLatLng([lat, lng]);
                    map.setView([lat, lng], 13);
                    
                    // Update hidden inputs
                    latInput.value = lat;
                    lngInput.value = lng;
                }
            })
            .catch(error => {
                console.error('Geocoding error:', error);
            });
    }
    
    // Function to handle reverse geocoding (coordinates to address)
    function reverseGeocode(lat, lng) {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.display_name) {
                    addressInput.value = data.display_name;
                }
            })
            .catch(error => {
                console.error('Reverse geocoding error:', error);
            });
    }
    
    // Add event listener to address input
    addressInput.addEventListener('blur', geocodeAddress);
    
    // Try to get user's current location
    document.querySelector('button[name="get-current-location"]')?.addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                // Update marker and map
                marker.setLatLng([lat, lng]);
                map.setView([lat, lng], 13);
                
                // Update hidden inputs
                latInput.value = lat;
                lngInput.value = lng;
                
                // Update address
                reverseGeocode(lat, lng);
            }, function(error) {
                console.error('Geolocation error:', error);
                alert('Could not get your location. Please ensure location services are enabled.');
            });
        } else {
            alert('Geolocation is not supported by your browser.');
        }
    });
});