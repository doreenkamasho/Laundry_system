/**
 * Rating sort functionality for laundress list
 */
document.addEventListener('DOMContentLoaded', function() {
    // Add event listener to the rating filter button
    const ratingFilterBtn = document.getElementById('ratingFilter');
    if (ratingFilterBtn) {
        ratingFilterBtn.addEventListener('click', function() {
            // Show loading animation
            Swal.fire({
                title: 'Sorting by rating...',
                timer: 1000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                },
                willClose: () => {
                    sortLaundressesByRating();
                }
            });
        });
    }
});

function sortLaundressesByRating() {
    const laundressItems = document.getElementsByClassName('laundress-item');
    const itemsArray = Array.from(laundressItems);
    
    // Parse rating and review count from each laundress card
    const itemsWithRating = itemsArray.map(item => {
        // Find the rating section which has the structure:
        // <i class="ri-star-fill text-warning"></i>
        // <span>4.5</span>
        // <span class="text-muted">(10 reviews)</span>
        
        let rating = 0;
        let reviewCount = 0;
        
        // Target the exact element structure based on your HTML
        const ratingDiv = item.querySelector('.d-flex.align-items-center.justify-content-center.gap-1');
        if (ratingDiv) {
            // Get rating (it's in the first span after the star icon)
            const ratingSpan = ratingDiv.querySelector('i.ri-star-fill + span');
            if (ratingSpan) {
                rating = parseFloat(ratingSpan.textContent.trim()) || 0;
            }
            
            // Get review count (it's in parentheses in the next span)
            const reviewSpan = ratingDiv.querySelector('span.text-muted');
            if (reviewSpan) {
                const matches = reviewSpan.textContent.match(/\((\d+)\s+reviews\)/);
                if (matches && matches[1]) {
                    reviewCount = parseInt(matches[1]) || 0;
                }
            }
        }
        
        console.log(`Laundress: ${item.querySelector('h5')?.textContent}, Rating: ${rating}, Reviews: ${reviewCount}`);
        
        return {
            element: item,
            rating: rating,
            reviewCount: reviewCount
        };
    });

    // Sort by rating (primary) and review count (secondary)
    itemsWithRating.sort((a, b) => {
        if (b.rating === a.rating) {
            return b.reviewCount - a.reviewCount; // If ratings are equal, sort by review count
        }
        return b.rating - a.rating;
    });

    // Reorder elements in DOM
    const container = document.getElementById('laundressList');
    if (container) {
        // Remove all items first
        while (container.firstChild) {
            container.removeChild(container.firstChild);
        }
        
        // Add items back in sorted order
        itemsWithRating.forEach((item, index) => {
            container.appendChild(item.element);
            
            // Add ranking badge for top 3
            const card = item.element.querySelector('.card');
            if (card) {
                const existingBadge = card.querySelector('.ranking-badge');
                if (existingBadge) {
                    existingBadge.remove();
                }
                
                if (index < 3 && item.rating > 0) {
                    const badge = document.createElement('div');
                    badge.className = 'position-absolute top-0 start-0 mt-2 ms-2 ranking-badge';
                    const medals = ['🥇', '🥈', '🥉'];
                    badge.innerHTML = `
                        <span class="badge bg-warning rounded-pill">
                            ${medals[index]} Top ${index + 1}
                        </span>
                    `;
                    card.appendChild(badge);
                }
            }
        });
    }

    // Change button styles to indicate active filter
    const ratingBtn = document.getElementById('ratingFilter');
    const locationBtn = document.getElementById('locationFilter');
    
    if (ratingBtn && locationBtn) {
        ratingBtn.classList.remove('btn-light');
        ratingBtn.classList.add('btn-primary');
        
        locationBtn.classList.remove('btn-primary');
        locationBtn.classList.add('btn-light');
    }

    // Show success message
    Swal.fire({
        icon: 'success',
        title: 'Sorted by Rating',
        text: 'Showing highest rated laundresses first',
        timer: 1500,
        showConfirmButton: false
    });
}