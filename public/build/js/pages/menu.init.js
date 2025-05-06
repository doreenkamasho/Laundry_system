document.addEventListener('DOMContentLoaded', function() {
    // Get menu elements
    const hamburgerBtn = document.getElementById('topnav-hamburger-icon');
    const body = document.getElementsByTagName('body')[0];
    const appMenu = document.querySelector('.app-menu');

    // Toggle menu on hamburger click
    hamburgerBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        if (body.classList.contains('vertical-sidebar-enable')) {
            // Close menu
            body.classList.remove('vertical-sidebar-enable');
        } else {
            // Open menu
            body.classList.add('vertical-sidebar-enable');
        }

        // For larger screens, toggle the sidebar mode
        if (window.innerWidth >= 768) {
            if (document.documentElement.getAttribute('data-sidebar-size') === 'sm') {
                document.documentElement.setAttribute('data-sidebar-size', 'lg');
            } else {
                document.documentElement.setAttribute('data-sidebar-size', 'sm');
            }
        }
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (body.classList.contains('vertical-sidebar-enable')) {
            if (!hamburgerBtn.contains(e.target) && !appMenu.contains(e.target)) {
                body.classList.remove('vertical-sidebar-enable');
            }
        }
    });

    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (body.classList.contains('vertical-sidebar-enable')) {
                body.classList.remove('vertical-sidebar-enable');
            }
        }
    });
});