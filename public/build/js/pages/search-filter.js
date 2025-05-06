function initializeSearch() {
    const searchInput = document.getElementById('searchInput');
    const laundressItems = document.getElementsByClassName('laundress-item');
    let debounceTimer;

    searchInput.addEventListener('input', function(e) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const searchText = e.target.value.toLowerCase().trim();
            const visibleCount = filterLaundresses(searchText);
            updateResults(searchText, visibleCount);
        }, 300);
    });

    function filterLaundresses(searchText) {
        let visibleCount = 0;

        Array.from(laundressItems).forEach(item => {
            const name = item.querySelector('h5').innerText.toLowerCase();
            const address = item.querySelector('.text-muted').innerText.toLowerCase();
            const isVisible = searchText === '' || 
                            name.includes(searchText) || 
                            address.includes(searchText);

            item.style.display = isVisible ? '' : 'none';
            
            // Also update marker visibility on map
            const lat = parseFloat(item.dataset.latitude);
            const lng = parseFloat(item.dataset.longitude);
            updateMarkerVisibility(lat, lng, isVisible);

            if (isVisible) visibleCount++;

            // Highlight matching text
            if (isVisible && searchText !== '') {
                highlightText(item.querySelector('h5'), searchText);
                highlightText(item.querySelector('.text-muted'), searchText);
            } else {
                removeHighlight(item.querySelector('h5'));
                removeHighlight(item.querySelector('.text-muted'));
            }
        });

        return visibleCount;
    }

    function updateResults(searchText, count) {
        const badge = document.querySelector('.badge.bg-primary');
        badge.textContent = count;

        // Show/hide no results message
        let noResults = document.querySelector('.no-results-message');
        if (count === 0 && searchText !== '') {
            if (!noResults) {
                noResults = document.createElement('div');
                noResults.className = 'col-12 no-results-message';
                noResults.innerHTML = `
                    <div class="alert alert-info">
                        <i class="ri-information-line me-2 align-middle fs-16"></i>
                        No laundresses found matching "${searchText}"
                        <button class="btn btn-link btn-sm float-end" onclick="clearSearch()">
                            Clear Search
                        </button>
                    </div>
                `;
                document.getElementById('laundressList').appendChild(noResults);
            }
        } else if (noResults) {
            noResults.remove();
        }

        // Add clear button when there's text
        const searchBox = document.querySelector('.search-box');
        let clearButton = searchBox.querySelector('.search-clear');
        
        if (searchText !== '') {
            if (!clearButton) {
                clearButton = document.createElement('button');
                clearButton.className = 'search-clear btn btn-link btn-sm position-absolute end-0 top-50 translate-middle-y';
                clearButton.innerHTML = '<i class="ri-close-line"></i>';
                clearButton.onclick = clearSearch;
                searchBox.appendChild(clearButton);
            }
        } else if (clearButton) {
            clearButton.remove();
        }
    }

    function highlightText(element, searchText) {
        const originalText = element.innerText;
        const regex = new RegExp(`(${searchText})`, 'gi');
        element.innerHTML = originalText.replace(regex, '<mark class="highlight">$1</mark>');
    }

    function removeHighlight(element) {
        element.innerHTML = element.innerText;
    }

    function updateMarkerVisibility(lat, lng, isVisible) {
        // This function will be implemented in map.js to handle marker visibility
        if (typeof window.updateMapMarker === 'function') {
            window.updateMapMarker(lat, lng, isVisible);
        }
    }
}

function clearSearch() {
    const searchInput = document.getElementById('searchInput');
    searchInput.value = '';
    searchInput.dispatchEvent(new Event('input'));
    searchInput.focus();
}

// Initialize search when DOM is ready
document.addEventListener('DOMContentLoaded', initializeSearch);