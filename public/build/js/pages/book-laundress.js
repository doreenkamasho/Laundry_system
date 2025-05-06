function bookNow(laundressId) {
    // Get the laundress card element
    const laundressCard = document.querySelector(`.laundress-item[data-laundress-id="${laundressId}"]`);
    const isAvailable = laundressCard.querySelector('.ribbon-success') !== null;

    if (!isAvailable) {
        Swal.fire({
            icon: 'warning',
            title: 'Laundress Unavailable',
            text: 'This laundress is currently busy. Please try another laundress or check back later.',
            confirmButtonClass: 'btn btn-primary'
        });
        return;
    }

    // Show booking confirmation
    Swal.fire({
        title: 'Create New Order',
        text: 'Would you like to proceed with booking this laundress?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Book Now',
        cancelButtonText: 'No, Cancel',
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-light',
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `/customer/orders/create?laundress=${laundressId}`;
        }
    });
}