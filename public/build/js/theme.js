document.addEventListener('DOMContentLoaded', function() {
    // Get theme from localStorage or default to 'light'
    const currentTheme = localStorage.getItem('theme') || document.documentElement.getAttribute('data-bs-theme') || 'light';
    setTheme(currentTheme);

    // Theme switching function
    function setTheme(theme) {
        // Update HTML theme attribute
        document.documentElement.setAttribute('data-bs-theme', theme);
        localStorage.setItem('theme', theme);
        
        // Update radio buttons
        document.querySelectorAll('input[name="data-bs-theme"]').forEach(radio => {
            radio.checked = radio.value === theme;
        });

        // Handle logo visibility and colors
        const navbar = document.querySelector('.navbar-menu');
        if (navbar) {
            if (theme === 'dark') {
                navbar.classList.add('navbar-dark');
                navbar.classList.remove('navbar-light');
            } else {
                navbar.classList.add('navbar-light');
                navbar.classList.remove('navbar-dark');
            }
        }

        // Send theme preference to server
        fetch('/update-theme', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ theme: theme })
        });
    }

    // Add event listeners to radio buttons
    document.querySelectorAll('input[name="data-bs-theme"]').forEach(radio => {
        radio.addEventListener('change', (e) => setTheme(e.target.value));
    });
});