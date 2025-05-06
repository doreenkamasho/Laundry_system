document.addEventListener('DOMContentLoaded', function() {
    // Toast configuration
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: '#eef2f7',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // Status update handler
    window.updateStatus = function(element) {
        const id = element.dataset.id;
        const status = element.checked;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch(`/admin/laundress/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Toast.fire({
                    icon: 'success',
                    title: 'Status updated successfully',
                    iconColor: '#0ab39c'
                });
            } else {
                element.checked = !status;
                Toast.fire({
                    icon: 'error',
                    title: data.message || 'Failed to update status',
                    iconColor: '#f06548'
                });
            }
        })
        .catch(error => {
            element.checked = !status;
            Toast.fire({
                icon: 'error',
                title: 'Something went wrong',
                iconColor: '#f06548'
            });
        });
    };

    // Delete confirmation handler
    window.confirmDelete = function(id) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            iconColor: '#f7b84b',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            customClass: {
                confirmButton: 'btn btn-primary w-xs me-2',
                cancelButton: 'btn btn-danger w-xs'
            },
            buttonsStyling: false,
            padding: '2rem',
            showClass: {
                popup: 'animate__animated animate__fadeIn'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOut'
            }
        }).then(function(result) {
            if (result.value) {
                fetch(`/admin/laundress/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Laundress has been deleted.',
                            icon: 'success',
                            iconColor: '#0ab39c',
                            customClass: {
                                confirmButton: 'btn btn-primary w-xs'
                            },
                            buttonsStyling: false,
                            timer: 2000,
                            timerProgressBar: true
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                });
            }
        });
    };
});