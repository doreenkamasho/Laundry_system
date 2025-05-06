document.addEventListener('DOMContentLoaded', function() {
    // Avatar preview functionality
    const avatarInput = document.getElementById('avatar-input');
    const previewAvatar = document.getElementById('preview-avatar');
    
    if (avatarInput && previewAvatar) {
        avatarInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewAvatar.src = e.target.result;
                }
                
                reader.readAsDataURL(this.files[0]);
                
                // Trigger the form submission through our existing function
                submitAvatarForm();
            }
        });
    }

    // Avatar upload functionality
    function submitAvatarForm() {
        const input = document.getElementById('avatar-input');
        const form = document.getElementById('avatar-form');
        
        // Debug information
        console.log('Form elements:', {
            input: input ? 'Found' : 'Not found',
            form: form ? 'Found' : 'Not found',
            files: input?.files?.length || 0
        });

        if (!input || !form) {
            console.error('Required elements not found');
            return;
        }
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Log file details
            console.log('File details:', {
                name: file.name,
                type: file.type,
                size: `${(file.size / 1024 / 1024).toFixed(2)}MB`
            });

            // Check file size (2MB limit)
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    title: 'Error!',
                    text: 'File size must be less than 2MB',
                    icon: 'error',
                    confirmButtonClass: 'btn btn-primary'
                });
                input.value = '';
                return;
            }

            // Check file type
            const fileType = file.type;
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            
            if (!allowedTypes.includes(fileType)) {
                console.warn('Invalid file type:', fileType);
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select a valid image file (JPEG, PNG, or JPG)',
                    icon: 'error',
                    confirmButtonClass: 'btn btn-primary'
                });
                input.value = '';
                return;
            }

            // Show confirmation dialog
            Swal.fire({
                title: 'Upload Profile Picture?',
                text: 'Are you sure you want to upload this image?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Upload!',
                cancelButtonText: 'No, Cancel',
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-danger',
            }).then((result) => {
                if (result.isConfirmed) {
                    try {
                        console.log('Submitting form...');
                        form.submit();
                    } catch (error) {
                        console.error('Form submission failed:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to upload image. Please try again.',
                            icon: 'error',
                            confirmButtonClass: 'btn btn-primary'
                        });
                    }
                } else {
                    console.log('Upload cancelled by user');
                    input.value = '';
                }
            });
        } else {
            console.warn('No file selected');
            Swal.fire({
                title: 'Error!',
                text: 'Please select an image file',
                icon: 'error',
                confirmButtonClass: 'btn btn-primary'
            });
        }
    }

    // Expose the function globally
    window.submitAvatarForm = submitAvatarForm;

    // Add form submission event listener
    const avatarForm = document.getElementById('avatar-form');
    if (avatarForm) {
        avatarForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent double submission
            console.log('Form submission started');
        });
    }

    console.log('Profile avatar script initialized with preview functionality');
});