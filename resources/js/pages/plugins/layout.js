document.addEventListener('DOMContentLoaded', function() {
    // Initialize all settings from localStorage or defaults
    const settings = {
        theme: localStorage.getItem('theme') || 'light',
        layout: localStorage.getItem('layout') || 'semibox',
        layoutStyle: localStorage.getItem('layoutStyle') || 'default',
        sidebar: localStorage.getItem('sidebar') || 'light',
        sidebarImage: localStorage.getItem('sidebarImage') || 'none'
    };

    // Apply initial settings
    applySettings(settings);

    // Theme switcher
    document.querySelectorAll('input[name="data-bs-theme"]').forEach(input => {
        input.addEventListener('change', (e) => {
            updateSetting('theme', e.target.value);
        });
    });

    // Layout switcher
    document.querySelectorAll('input[name="data-layout"]').forEach(input => {
        input.addEventListener('change', (e) => {
            updateSetting('layout', e.target.value);
        });
    });

    // Sidebar style switcher
    document.querySelectorAll('input[name="data-layout-style"]').forEach(input => {
        input.addEventListener('change', (e) => {
            updateSetting('layoutStyle', e.target.value);
        });
    });

    // Sidebar color switcher
    document.querySelectorAll('input[name="data-sidebar"]').forEach(input => {
        input.addEventListener('change', (e) => {
            updateSetting('sidebar', e.target.value);
        });
    });

    // Sidebar image switcher
    document.querySelectorAll('input[name="data-sidebar-image"]').forEach(input => {
        input.addEventListener('change', (e) => {
            updateSetting('sidebarImage', e.target.value);
        });
    });

    function updateSetting(key, value) {
        // Update localStorage
        localStorage.setItem(key, value);
        
        // Update settings object
        settings[key] = value;
        
        // Apply changes
        applySettings(settings);

        // Send to server
        fetch('/update-theme', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(settings)
        });
    }

    function applySettings(settings) {
        // Apply theme
        document.documentElement.setAttribute('data-bs-theme', settings.theme);
        document.querySelector(`input[name="data-bs-theme"][value="${settings.theme}"]`).checked = true;

        // Apply layout
        document.body.setAttribute('data-layout', settings.layout);
        document.querySelector(`input[name="data-layout"][value="${settings.layout}"]`).checked = true;

        // Apply sidebar style
        document.body.setAttribute('data-layout-style', settings.layoutStyle);
        document.querySelector(`input[name="data-layout-style"][value="${settings.layoutStyle}"]`).checked = true;

        // Apply sidebar color
        document.body.setAttribute('data-sidebar', settings.sidebar);
        document.querySelector(`input[name="data-sidebar"][value="${settings.sidebar}"]`).checked = true;

        // Apply sidebar image
        document.body.setAttribute('data-sidebar-image', settings.sidebarImage);
        document.querySelector(`input[name="data-sidebar-image"][value="${settings.sidebarImage}"]`).checked = true;

        // Handle special cases for sidebar appearance
        const sidebar = document.querySelector('.app-menu');
        if (sidebar) {
            // Clear existing classes
            sidebar.className = 'app-menu navbar-menu';

            // Add theme-specific classes
            if (settings.theme === 'dark') {
                sidebar.classList.add('navbar-dark');
            } else {
                sidebar.classList.add('navbar-light');
            }

            // Add sidebar color classes
            if (settings.sidebar === 'dark') {
                sidebar.classList.add('sidebar-dark');
            } else if (settings.sidebar.startsWith('gradient')) {
                sidebar.classList.add(`sidebar-${settings.sidebar}`);
            }

            // Handle sidebar images
            if (settings.sidebarImage !== 'none') {
                sidebar.style.backgroundImage = `url("${window.location.origin}/build/images/sidebar/${settings.sidebarImage}.jpg")`;
                sidebar.style.backgroundSize = 'cover';
            } else {
                sidebar.style.backgroundImage = 'none';
            }
        }
    }
});