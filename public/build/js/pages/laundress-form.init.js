document.addEventListener('DOMContentLoaded', function() {
    // Phone number formatting
    const phoneInput = document.querySelector('input[name="phone_number"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        });
    }

    // Form validation
    const form = document.getElementById('laundressForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!document.getElementById('latitude').value || !document.getElementById('longitude').value) {
                e.preventDefault();
                alert('Please select a valid address on the map');
            }
        });
    }
});