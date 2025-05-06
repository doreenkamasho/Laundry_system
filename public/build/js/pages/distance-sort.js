function sortLaundressesByDistance(userLat, userLng) {
    const laundressItems = document.getElementsByClassName('laundress-item');
    const itemsArray = Array.from(laundressItems);
    
    // Calculate distances and create array of objects with distance info
    const itemsWithDistance = itemsArray.map(item => {
        const lat = parseFloat(item.dataset.latitude);
        const lng = parseFloat(item.dataset.longitude);
        const distance = calculateDistance(userLat, userLng, lat, lng);
        
        return {
            element: item,
            distance: distance
        };
    });

    // Sort by distance
    itemsWithDistance.sort((a, b) => a.distance - b.distance);

    // Reorder elements in DOM
    const container = document.getElementById('laundressList');
    itemsWithDistance.forEach(item => {
        container.appendChild(item.element);
    });

    // Update UI to show sorting is complete
    Swal.fire({
        icon: 'success',
        title: 'Sorted by Distance',
        text: `Showing nearest laundresses first`,
        timer: 1500,
        showConfirmButton: false
    });

    // Highlight closest laundress
    if (itemsWithDistance.length > 0) {
        const closest = itemsWithDistance[0];
        closest.element.querySelector('.card').classList.add('border-primary');
        
        // Show distance comparison info
        itemsWithDistance.forEach((item, index) => {
            if (index > 0) {
                const differenceKm = (item.distance - closest.distance).toFixed(1);
                const distanceInfo = item.element.querySelector('.distance-info');
                if (distanceInfo) {
                    const currentText = distanceInfo.innerHTML;
                    distanceInfo.innerHTML = `
                        ${currentText}
                        <span class="text-muted ms-2">
                            <i class="ri-arrow-right-line align-middle"></i> 
                            ${differenceKm}km further than nearest
                        </span>
                    `;
                }
            }
        });
    }
}

// Update your existing locationFilter click handler in index.blade.php
document.getElementById('locationFilter').addEventListener('click', function() {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;
            
            Swal.fire({
                title: 'Sorting by distance...',
                timer: 1000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                }
            }).then(() => {
                sortLaundressesByDistance(userLat, userLng);
            });
        }, function(error) {
            Swal.fire({
                icon: 'error',
                title: 'Location Access Denied',
                text: 'Please enable location services to sort by distance.'
            });
        });
    }
});

// Helper function to calculate distance using Haversine formula
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