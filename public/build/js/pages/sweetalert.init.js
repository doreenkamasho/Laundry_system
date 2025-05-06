document.addEventListener('DOMContentLoaded', function() {
    // Toast notification configuration
    window.Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    window.showDeleteConfirmation = function(id, url) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
            showClass: {
                popup: 'animate__animated animate__fadeIn'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOut'
            },
            background: '#fff',
            iconColor: '#f7b84b',
            reverseButtons: true,
            padding: '2rem'
        }).then(function(result) {
            if (result.value) {
                deleteRecord(id, url);
            }
        });
    };

    window.showSuccessMessage = function(message) {
        Toast.fire({
            icon: 'success',
            title: message,
            background: '#eef2f7',
            iconColor: '#0ab39c'
        });
    };

    window.showErrorMessage = function(message) {
        Toast.fire({
            icon: 'error',
            title: message,
            background: '#eef2f7',
            iconColor: '#f06548'
        });
    };
});