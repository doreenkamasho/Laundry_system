// password addon
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle for login/register password fields
    document.querySelectorAll("[id$='password-addon'], .password-addon").forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            let inputField = this.closest('.auth-pass-inputgroup').querySelector('input');
            let icon = this.querySelector('i');
            
            if (inputField.type === "password") {
                inputField.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                inputField.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        });
    });
});

