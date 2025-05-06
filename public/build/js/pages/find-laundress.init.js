let map, userMarker, laundressMarkers = [];
const maxDistance = 10; // km - changed from 10km to 2km

function initMap() {
    // Initialize map with default center (Dar es Salaam)
    map = L.map('map').setView([-6.7924, 39.2083], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Request user's location
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;
            
            // Get user's avatar from meta tag
            const userAvatar = document.querySelector('meta[name="user-avatar"]')?.content;
            
            // Create user marker with enhanced styling
            let markerHtml;
            if (userAvatar) {
                markerHtml = `
                    <div class="user-marker-container">
                        <div class="user-pulse"></div>
                        <div class="user-marker">
                            <img src="${userAvatar}" alt="You" />
                        </div>
                    </div>
                `;
            } else {
                markerHtml = `
                    <div class="user-marker-container">
                        <div class="user-pulse"></div>
                        <div class="user-marker">
                            <i class="ri-user-location-fill user-icon"></i>
                        </div>
                    </div>
                `;
            }
            
            userMarker = L.marker([userLat, userLng], {
                icon: L.divIcon({
                    html: markerHtml,
                    className: 'user-marker-icon',
                    iconSize: [50, 50],
                    iconAnchor: [25, 50]
                }),
                zIndexOffset: 1000
            }).addTo(map);

            // Add popup for user marker
            userMarker.bindPopup(`
                <div class="custom-popup">
                    <p class="name">Your Location</p>
                </div>
            `);

            // Center map on user location
            map.setView([userLat, userLng], 13);

            // Show nearby laundresses
            showNearbyLaundresses(userLat, userLng);
        }, function(error) {
            Swal.fire({
                icon: 'error',
                title: 'Location Access Denied',
                text: 'Please enable location services to find nearby laundresses.'
            });
        });
    }
}



// Rest of the code remains the same until showNearbyLaundresses function

function showNearbyLaundresses(userLat, userLng) {
    const laundressItems = document.getElementsByClassName('laundress-item');
    let visibleCount = 0;

    Array.from(laundressItems).forEach(item => {
        const lat = parseFloat(item.dataset.latitude);
        const lng = parseFloat(item.dataset.longitude);
        const laundressId = item.dataset.id || '';
        
        if (lat && lng) {
            const distance = calculateDistance(userLat, userLng, lat, lng);
            
            // Only show laundresses within maxDistance (2km)
            if (distance <= maxDistance) {
                item.style.display = '';
                visibleCount++;

                // Get laundress avatar element
                const avatarElement = item.querySelector('.avatar-lg');
                const laundressName = item.querySelector('h5').innerText;
                
                // Create enhanced marker HTML
                let markerHtml;
                if (avatarElement.tagName === 'IMG') {
                    markerHtml = `
                        <div class="laundress-marker-container" data-laundress-id="${laundressId}">
                            <div class="laundress-marker">
                                <img src="${avatarElement.src}" alt="${laundressName}" />
                            </div>
                        </div>
                    `;
                } else {
                    const initials = avatarElement.querySelector('.avatar-title').innerText;
                    markerHtml = `
                        <div class="laundress-marker-container" data-laundress-id="${laundressId}">
                            <div class="laundress-marker">
                                <div class="avatar-fallback">${initials}</div>
                            </div>
                        </div>
                    `;
                }

                // Add marker with enhanced styling
                const marker = L.marker([lat, lng], {
                    icon: L.divIcon({
                        html: markerHtml,
                        className: 'laundress-marker-icon',
                        iconSize: [45, 45],
                        iconAnchor: [22, 45]
                    })
                }).addTo(map);

                // Store laundress ID with marker
                marker.laundressId = laundressId;
                laundressMarkers.push(marker);

                // Add route with custom styling
                const routeControl = L.Routing.control({
                    waypoints: [
                        L.latLng(userLat, userLng),
                        L.latLng(lat, lng)
                    ],
                    routeWhileDragging: false,
                    lineOptions: {
                        styles: [
                            { color: '#4361ee', opacity: 0.8, weight: 5 },
                            { color: '#ffffff', opacity: 0.5, weight: 9 }
                        ],
                        extendToWaypoints: true,
                        missingRouteTolerance: 0
                    },
                    show: false,
                    addWaypoints: false,
                    draggableWaypoints: false,
                    fitSelectedRoutes: false,
                    showAlternatives: false,
                    createMarker: function() { return null; }, // Disable default markers
                    router: L.Routing.osrmv1({
                        serviceUrl: 'https://router.project-osrm.org/route/v1',
                        profile: 'walking' // Use 'driving', 'walking', or 'cycling'
                    })
                }).addTo(map);

                // Store route control with marker
                marker._routeControl = routeControl;

                // Update distance info when route is calculated
                routeControl.on('routesfound', function(e) {
                    const route = e.routes[0];
                    const distance = (route.summary.totalDistance / 1000).toFixed(1);
                    const duration = Math.round(route.summary.totalTime / 60);
                    
                    // Update card info
                    item.querySelector('.distance-info').innerHTML = `
                        <i class="ri-route-line align-middle"></i> ${distance}km 
                        <i class="ri-time-line align-middle ms-2"></i> ${duration}min
                    `;
                    
                    // Add ETA badge to marker
                    const markerElement = marker.getElement();
                    const etaBadge = document.createElement('div');
                    etaBadge.className = 'eta-badge';
                    etaBadge.innerHTML = `<i class="ri-time-line"></i> ${duration} min`;
                    
                    // Remove existing badge if any
                    const existingBadge = markerElement.querySelector('.eta-badge');
                    if (existingBadge) {
                        existingBadge.remove();
                    }
                    
                    markerElement.querySelector('.laundress-marker-container').appendChild(etaBadge);
                    
                    // Store route instructions for later use
                    marker._routeInstructions = route.instructions;
                    marker._routeSummary = {
                        distance: distance,
                        duration: duration
                    };
                });

                // Add popup with enhanced info and directions button
                marker.bindPopup(`
                    <div class="custom-popup">
                        <h6 class="name">${laundressName}</h6>
                        <p class="small text-muted mb-1">
                            <i class="ri-map-pin-line"></i> ${distance.toFixed(1)}km away
                        </p>
                        <p class="small text-muted mb-2">
                            <i class="ri-star-fill text-warning"></i> 
                            ${item.querySelector('.mb-3')?.innerText || '4.5'}
                        </p>
                        <button class="btn btn-sm btn-primary show-directions w-100" data-laundress-id="${laundressId}">
                            <i class="ri-route-line me-1"></i> Show Directions
                        </button>
                    </div>
                `);

                // Add click event for the marker to show route
                marker.on('click', function() {
                    // Highlight the route when marker is clicked
                    highlightRoute(marker);
                });
            } else {
                // Hide laundresses beyond the max distance
                item.style.display = 'none';
            }
        }
    });

    // Update counter badge with total count
    document.querySelector('.badge.bg-primary').textContent = visibleCount;
    
    // Show message if no laundresses found within range
    if (visibleCount === 0) {
        Swal.fire({
            icon: 'info',
            title: 'No Laundresses Nearby',
            text: `There are no laundresses available within ${maxDistance}km of your location.`
        });
    }
}


// Setup event delegation for direction buttons
document.addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('show-directions') || 
        e.target.parentElement && e.target.parentElement.classList.contains('show-directions')) {
        
        const button = e.target.classList.contains('show-directions') ? 
            e.target : e.target.parentElement;
        
        const laundressId = button.dataset.laundressId;
        showDirections(laundressId);
        
        // Close the popup
        map.closePopup();
    }
});

function highlightRoute(marker) {
    // Reset all routes first
    laundressMarkers.forEach(m => {
        const routeElement = m._routeControl?.getContainer();
        if (routeElement) {
            routeElement.classList.remove('route-highlighted');
            routeElement.classList.add('route-dimmed');
        }
    });
    
    // Highlight this route
    const routeElement = marker._routeControl?.getContainer();
    if (routeElement) {
        routeElement.classList.remove('route-dimmed');
        routeElement.classList.add('route-highlighted');
    }
}

function showDirections(laundressId) {
    // Find the marker for this laundress
    const marker = laundressMarkers.find(m => m.laundressId === laundressId);
    
    if (!marker || !marker._routeInstructions) return;
    
    // Highlight this route
    highlightRoute(marker);
    
    // Create directions panel
    const directionsPanel = document.createElement('div');
    directionsPanel.className = 'directions-panel';
    directionsPanel.innerHTML = `
        <div class="directions-header">
            <h6>Directions to ${marker.getPopup().getContent().match(/<h6 class="name">(.*?)<\/h6>/)[1]}</h6>
            <button type="button" class="btn-close close-directions"></button>
        </div>
        <div class="directions-summary">
            <div class="summary-item">
                <i class="ri-route-line"></i>
                <span>${marker._routeSummary.distance} km</span>
            </div>
            <div class="summary-item">
                <i class="ri-time-line"></i>
                <span>${marker._routeSummary.duration} min</span>
            </div>
        </div>
        <div class="directions-steps">
            ${marker._routeInstructions.map((instruction, i) => `
                <div class="direction-step">
                    <div class="step-icon">
                        <i class="${getDirectionIcon(instruction.type)}"></i>
                    </div>
                    <div class="step-content">
                        <p>${instruction.text}</p>
                        <small>${(instruction.distance/1000).toFixed(1)} km</small>
                    </div>
                </div>
            `).join('')}
        </div>
    `;
    
    // Remove existing panel if any
    const existingPanel = document.querySelector('.directions-panel');
    if (existingPanel) {
        existingPanel.remove();
    }
    
    // Add to map
    document.querySelector('#map').appendChild(directionsPanel);
    
    // Add close button event
    directionsPanel.querySelector('.close-directions').addEventListener('click', function() {
        directionsPanel.remove();
        
        // Reset route highlighting
        laundressMarkers.forEach(m => {
            const routeElement = m._routeControl?.getContainer();
            if (routeElement) {
                routeElement.classList.remove('route-highlighted');
                routeElement.classList.remove('route-dimmed');
            }
        });
    });
}

function getDirectionIcon(type) {
    switch(type) {
        case 'StartRight':
        case 'StartLeft':
            return 'ri-flag-line';
        case 'DestinationReached':
            return 'ri-map-pin-line';
        case 'TurnRight':
            return 'ri-corner-right-down-line';
        case 'TurnLeft':
            return 'ri-corner-left-down-line';
        case 'TurnSlightRight':
            return 'ri-corner-right-up-line';
        case 'TurnSlightLeft':
            return 'ri-corner-left-up-line';
        case 'TurnSharpRight':
            return 'ri-corner-right-down-line';
        case 'TurnSharpLeft':
            return 'ri-corner-left-down-line';
        case 'UturnRight':
        case 'UturnLeft':
            return 'ri-arrow-go-back-line';
        case 'Continue':
            return 'ri-arrow-up-line';
        default:
            return 'ri-road-map-line';
    }
}

function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; // Earth's radius in km
    const dLat = toRad(lat2 - lat1);
    const dLon = toRad(lon2 - lon1);
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
              Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) * 
              Math.sin(dLon/2) * Math.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

function toRad(value) {
    return value * Math.PI / 180;
}

// Initialize map when DOM is ready
document.addEventListener('DOMContentLoaded', initMap);
