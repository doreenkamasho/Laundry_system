document.addEventListener('DOMContentLoaded', function() {
    // Initialize settings
    const settings = {
        layoutStyle: localStorage.getItem('layout-style') || 'default',
        sidebar: localStorage.getItem('sidebar') || 'light',
        sidebarSize: localStorage.getItem('sidebar-size') || 'lg',
        sidebarImage: localStorage.getItem('sidebar-image') || 'none'
    };

    // Apply initial settings
    applySidebarSettings(settings);

    // Add event listeners for all sidebar controls
    document.querySelectorAll('[name="data-layout-style"]').forEach(input => {
        input.addEventListener('change', (e) => updateSetting('layoutStyle', e.target.value));
    });

    document.querySelectorAll('[name="data-sidebar"]').forEach(input => {
        input.addEventListener('change', (e) => updateSetting('sidebar', e.target.value));
    });

    document.querySelectorAll('[name="data-sidebar-size"]').forEach(input => {
        input.addEventListener('change', (e) => updateSetting('sidebarSize', e.target.value));
    });

    document.querySelectorAll('[name="data-sidebar-image"]').forEach(input => {
        input.addEventListener('change', (e) => updateSetting('sidebarImage', e.target.value));
    });

    function updateSetting(key, value) {
        // Update localStorage
        localStorage.setItem(key, value);
        
        // Update settings object
        settings[key] = value;

        // Apply changes
        applySidebarSettings(settings);

        // Send to server
        fetch('/update-sidebar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ [key]: value })
        });
    }

    function applySidebarSettings(settings) {
        const html = document.documentElement;
        const sidebar = document.querySelector('.app-menu');

        // Apply layout style
        html.setAttribute('data-layout-style', settings.layoutStyle);
        
        // Apply sidebar color
        html.setAttribute('data-sidebar', settings.sidebar);
        
        // Apply sidebar size
        html.setAttribute('data-sidebar-size', settings.sidebarSize);
        
        // Apply sidebar image
        if (settings.sidebarImage !== 'none' && sidebar) {
            sidebar.style.backgroundImage = `url("/build/images/sidebar/${settings.sidebarImage}.jpg")`;
        } else if (sidebar) {
            sidebar.style.backgroundImage = 'none';
        }

        // Update radio buttons
        document.querySelector(`[name="data-layout-style"][value="${settings.layoutStyle}"]`)?.checked = true;
        document.querySelector(`[name="data-sidebar"][value="${settings.sidebar}"]`)?.checked = true;
        document.querySelector(`[name="data-sidebar-size"][value="${settings.sidebarSize}"]`)?.checked = true;
        document.querySelector(`[name="data-sidebar-image"][value="${settings.sidebarImage}"]`)?.checked = true;
    }
});