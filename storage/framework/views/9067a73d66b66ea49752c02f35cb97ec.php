<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
    data-bs-theme="<?php echo e(session('user_' . auth()->id() . '_theme', 'light')); ?>"
    data-layout-style="<?php echo e(session('user_' . auth()->id() . '_layoutStyle', 'default')); ?>"
    data-sidebar="<?php echo e(session('user_' . auth()->id() . '_sidebar', 'light')); ?>"
    data-sidebar-size="<?php echo e(session('user_' . auth()->id() . '_sidebarSize', 'lg')); ?>"
    data-sidebar-image="<?php echo e(session('user_' . auth()->id() . '_sidebarImage', 'none')); ?>">

<head>
    <meta charset="utf-8" />
    <title><?php echo $__env->yieldContent('title'); ?> | LaundryHub Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="user-avatar" content="<?php echo e(auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : ''); ?>">
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(URL::asset('build/images/favicon.ico')); ?>">
    <?php echo $__env->make('layouts.head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<?php $__env->startSection('body'); ?>
    <?php echo $__env->make('layouts.body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldSection(); ?>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <?php if(auth()->guard()->check()): ?>
            <?php switch(auth()->user()->role->name):
                case ('admin'): ?>
                    <?php echo $__env->make('admin.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php break; ?>
                <?php case ('customer'): ?>
                    <?php echo $__env->make('customer.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php break; ?>
                <?php case ('laundress'): ?>
                    <?php echo $__env->make('laundress.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php break; ?>
                <?php default: ?>
                    <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endswitch; ?>
        <?php endif; ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <?php echo $__env->make('layouts.customizer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- JAVASCRIPT -->
    <?php echo $__env->make('layouts.vendor-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Load settings from session first, fallback to localStorage
    const settings = {
        theme: '<?php echo e(session("user_" . auth()->id() . "_theme", "light")); ?>' || localStorage.getItem('theme'),
        layoutStyle: '<?php echo e(session("user_" . auth()->id() . "_layoutStyle", "default")); ?>' || localStorage.getItem('layout-style'),
        sidebar: '<?php echo e(session("user_" . auth()->id() . "_sidebar", "light")); ?>' || localStorage.getItem('sidebar'),
        sidebarSize: '<?php echo e(session("user_" . auth()->id() . "_sidebarSize", "lg")); ?>' || localStorage.getItem('sidebar-size'),
        sidebarImage: '<?php echo e(session("user_" . auth()->id() . "_sidebarImage", "none")); ?>' || localStorage.getItem('sidebar-image')
    };
    
    // Track if settings have changed
    let settingsChanged = false;

    // Clear localStorage to ensure session values take precedence
    localStorage.clear();

    // Store current session values in localStorage
    Object.entries(settings).forEach(([key, value]) => {
        localStorage.setItem(key, value);
    });

    // Apply initial settings
    applySettings(settings);

    // Theme switcher
    document.querySelectorAll('input[name="data-bs-theme"]').forEach(input => {
        input.addEventListener('change', (e) => updateSetting('theme', e.target.value, false));
    });

    // Layout style switcher
    document.querySelectorAll('input[name="data-layout-style"]').forEach(input => {
        input.addEventListener('change', (e) => updateSetting('layoutStyle', e.target.value, false));
    });

    // Sidebar color switcher
    document.querySelectorAll('input[name="data-sidebar"]').forEach(input => {
        input.addEventListener('change', (e) => updateSetting('sidebar', e.target.value, false));
    });

    // Sidebar size switcher
    document.querySelectorAll('input[name="data-sidebar-size"]').forEach(input => {
        input.addEventListener('change', (e) => updateSetting('sidebarSize', e.target.value, false));
    });

    // Sidebar image switcher
    document.querySelectorAll('input[name="data-sidebar-image"]').forEach(input => {
        input.addEventListener('change', (e) => updateSetting('sidebarImage', e.target.value, false));
    });

    // Find existing save button in the customizer
    // Look for buttons with common save button classes or text content
    const existingSaveButton = document.querySelector('.customizer-setting .btn-primary, .customizer-setting button[type="submit"], .offcanvas-footer .btn-primary');
    
    if (existingSaveButton) {
        // Use the existing button
        existingSaveButton.id = 'save-customization';
        existingSaveButton.addEventListener('click', function(e) {
            e.preventDefault();
            saveSettings();
        });
    } else {
        // If no save button exists, add one to the customizer footer
        const customizerFooter = document.querySelector('.offcanvas-footer, .customizer-footer');
        if (customizerFooter) {
            const saveBtn = document.createElement('button');
            saveBtn.id = 'save-customization';
            saveBtn.className = 'btn btn-primary w-100';
            saveBtn.textContent = 'Save Changes';
            saveBtn.addEventListener('click', saveSettings);
            customizerFooter.appendChild(saveBtn);
        }
    }

    function updateSetting(key, value, saveToServer = false) {
        // Update localStorage
        localStorage.setItem(key, value);
        
        // Update settings object
        settings[key] = value;
        
        // Apply changes immediately to preview
        applySettings(settings);
        
        // Mark that settings have changed
        settingsChanged = true;
        
        // Show save button or indicator that changes need to be saved
        const saveButton = document.querySelector('#save-customization');
        if (saveButton) {
            saveButton.classList.add('btn-pulse');
            if (!saveButton.querySelector('.badge')) {
                const badge = document.createElement('span');
                badge.className = 'badge bg-danger ms-1';
                badge.textContent = 'Unsaved';
                saveButton.appendChild(badge);
            }
        }
        
        // If saveToServer is true, save to server
        if (saveToServer) {
            saveSettings();
        }
    }
    
    async function saveSettings() {
        if (!settingsChanged) return;
        
        try {
            // Show loading state
            const saveButton = document.querySelector('#save-customization');
            if (saveButton) {
                const originalText = saveButton.textContent;
                saveButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
                saveButton.disabled = true;
            }
            
            const response = await fetch('/update-theme', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(settings)
            });
            
            if (!response.ok) {
                throw new Error('Failed to save theme settings');
            }
            
            // Reset changed flag
            settingsChanged = false;
            
            // Show success message
            Swal.fire({
                title: 'Success!',
                text: 'Your theme settings have been saved.',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                // Reload the page to ensure session values are applied
                window.location.reload();
            });
        } catch (error) {
            console.error('Error saving theme settings:', error);
            
            // Show error message
            Swal.fire({
                title: 'Error!',
                text: 'Failed to save theme settings.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            
            // Reset button state
            const saveButton = document.querySelector('#save-customization');
            if (saveButton) {
                saveButton.innerHTML = 'Save Changes';
                saveButton.disabled = false;
            }
        }
    }

    function applySettings(settings) {
        const html = document.documentElement;
        const sidebar = document.querySelector('.app-menu');
        
        // Apply theme
        html.setAttribute('data-bs-theme', settings.theme);
        
        // Apply sidebar settings
        html.setAttribute('data-layout-style', settings.layoutStyle);
        html.setAttribute('data-sidebar', settings.sidebar);
        html.setAttribute('data-sidebar-size', settings.sidebarSize);
        
        // Handle sidebar images
        if (settings.sidebarImage && settings.sidebarImage !== 'none') {
            html.setAttribute('data-sidebar-image', settings.sidebarImage);
            if (sidebar) {
                sidebar.style.backgroundImage = `url("${window.location.origin}/build/images/sidebar/${settings.sidebarImage}.jpg")`;
            }
        } else {
            html.removeAttribute('data-sidebar-image');
            if (sidebar) {
                sidebar.style.backgroundImage = 'none';
            }
        }

        // Handle gradient backgrounds
        if (settings.sidebar && settings.sidebar.startsWith('gradient')) {
            html.setAttribute('data-sidebar', settings.sidebar);
            if (sidebar) {
                sidebar.style.background = ''; // Remove any inline background to let CSS handle it
            }
        }

        // Update radio buttons
        const inputs = {
            'data-bs-theme': settings.theme,
            'data-layout-style': settings.layoutStyle,
            'data-sidebar': settings.sidebar,
            'data-sidebar-size': settings.sidebarSize,
            'data-sidebar-image': settings.sidebarImage
        };

        Object.entries(inputs).forEach(([attr, value]) => {
            if (value) {
                const radio = document.querySelector(`input[name="${attr}"][value="${value}"]`);
                if (radio) radio.checked = true;
            }
        });
    }
});

    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php echo $__env->yieldContent('script'); ?>
    <script src="<?php echo e(URL::asset('build/libs/apexcharts/apexcharts.min.js')); ?>"></script>ild/libs/apexcharts/apexcharts.min.js') }}"></script>
    <!-- ... other scripts ... -->
    <script src="<?php echo e(URL::asset('build/js/pages/menu.init.js')); ?>"></script>    <script src="<?php echo e(URL::asset('build/js/pages/menu.init.js')); ?>"></script>

</body>
</html></html>

<?php /**PATH C:\Users\Lifemate\Desktop\Velzon_v4.2.0\Laravel\saas\resources\views/layouts/master.blade.php ENDPATH**/ ?>