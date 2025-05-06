import L from 'leaflet';

document.addEventListener('DOMContentLoaded', function() {
    const mapElement = document.getElementById('map');
    if (!mapElement) return;

    // Initialize map centered on Philippines
    const map = L.map('map').setView([14.5995, 120.9842], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    let marker;

    // Try to get user's location
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            map.setView([lat, lng], 15);
            
            marker = L.marker([lat, lng], {draggable: true}).addTo(map);
            updateLatLng(lat, lng);

            marker.on('dragend', function(e) {
                const pos = marker.getLatLng();
                updateLatLng(pos.lat, pos.lng);
            });
        });
    }

    // Handle map clicks
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], {draggable: true}).addTo(map);
            marker.on('dragend', function(e) {
                const pos = marker.getLatLng();
                updateLatLng(pos.lat, pos.lng);
            });
        }
        updateLatLng(lat, lng);
    });

    function updateLatLng(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lng.toFixed(6);
    }
});