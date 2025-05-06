

<?php $__env->startSection('title', 'Add New Service'); ?>

<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    /* Card styling */
    .card {
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
        border: none;
    }
    
    .card-body {
        padding: 2rem;
    }

    /* Form controls */
    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.6rem 1rem;
        border-color: #e9ecef;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #556ee6;
        box-shadow: 0 0 0 0.2rem rgba(85, 110, 230, 0.1);
    }

    .input-group-text {
        border-radius: 8px 0 0 8px;
        background-color: #f8f9fa;
        border-color: #e9ecef;
    }

    /* Price structure items */
    .price-item {
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 1rem !important;
        transition: all 0.3s ease;
    }

    .price-item:hover {
        background-color: #fff;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }

    /* Buttons */
    .btn {
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #556ee6;
        border-color: #556ee6;
    }

    .btn-primary:hover {
        background-color: #4458B8;
        border-color: #4458B8;
        transform: translateY(-1px);
    }

    .btn-success {
        background-color: #34c38f;
        border-color: #34c38f;
    }

    .btn-success:hover {
        background-color: #2ca97f;
        border-color: #2ca97f;
        transform: translateY(-1px);
    }

    .btn-danger {
        background-color: #f46a6a;
        border-color: #f46a6a;
    }

    .btn-danger:hover {
        background-color: #e45555;
        border-color: #e45555;
    }

    .btn-secondary {
        background-color: #74788d;
        border-color: #74788d;
    }

    .btn-secondary:hover {
        background-color: #636678;
        border-color: #636678;
    }

    /* Form labels */
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    /* Switch styling */
    .form-switch {
        padding-left: 3rem;
    }

    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.5em;
        margin-left: -3rem;
    }

    .form-check-input:checked {
        background-color: #34c38f;
        border-color: #34c38f;
    }

    /* Animations */
    .price-item {
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Page title */
    .page-title-box {
        margin-bottom: 1.5rem;
    }

    .page-title-box h4 {
        font-weight: 600;
        color: #495057;
    }

    /* Validation states */
    .is-invalid {
        border-color: #f46a6a !important;
    }

    .invalid-feedback {
        font-size: 0.875em;
        color: #f46a6a;
    }

    /* Description textarea */
    textarea.form-control {
        min-height: 100px;
    }

    /* Icon for required fields */
    .form-label.required::after {
        content: '*';
        color: #f46a6a;
        margin-left: 4px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Add New Service</h4>
                <div class="page-title-right">
                    <a href="<?php echo e(route('laundress.services.index')); ?>" class="btn btn-primary">
                        <i class="las la-arrow-left"></i> Back to Services
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('laundress.services.store')); ?>" method="POST" id="serviceForm">
                        <?php echo csrf_field(); ?>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="category_name" class="form-label">Service Category</label>
                                <select class="form-select <?php $__errorArgs = ['category_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="category_name" 
                                        name="category_name" 
                                        required>
                                    <option value="">Select Category</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category['id']); ?>" 
                                                <?php echo e(old('category_name') == $category['id'] ? 'selected' : ''); ?>

                                                data-icon="<?php echo e($category['icon']); ?>">
                                            <?php echo e($category['name']); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['category_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Service Name</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="name" 
                                       name="name" 
                                       value="<?php echo e(old('name')); ?>" 
                                       required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="description" 
                                      name="description" 
                                      rows="3"><?php echo e(old('description')); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price Structure</label>
                            <div id="price-items-container">
                                <div class="row mb-2 price-item">
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="price_structure[0][item]" placeholder="Item Name (e.g. Shirt)" required>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="number" step="0.01" class="form-control" name="price_structure[0][price]" placeholder="Price" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-price-item" disabled>Remove</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-price-item" class="btn btn-success mt-2">
                                <i class="las la-plus"></i> Add Item
                            </button>
                        </div>

                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Save Service</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
<script>
    // Convert the PHP array to a JavaScript object with items indexed by category ID
    const predefinedItems = {};
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        predefinedItems['<?php echo e($category["id"]); ?>'] = {
            items: <?php echo json_encode($category['items'], 15, 512) ?>,
            name: '<?php echo e($category["name"]); ?>',
            icon: '<?php echo e($category["icon"]); ?>'
        };
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    // Add a hidden input for the category icon
    const form = document.getElementById('serviceForm');
    const iconInput = document.createElement('input');
    iconInput.type = 'hidden';
    iconInput.name = 'category_icon';
    form.appendChild(iconInput);

    document.getElementById('category_name').addEventListener('change', function() {
        const selectedCategory = this.value;
        const categoryData = predefinedItems[selectedCategory] || { items: [] };
        
        // Update the hidden icon input
        iconInput.value = categoryData.icon || '';
        
        // Clear existing items
        const container = document.getElementById('price-items-container');
        container.innerHTML = '';
        
        // Add predefined items
        categoryData.items.forEach((item, index) => {
            const newItem = document.createElement('div');
            newItem.className = 'row mb-2 price-item';
            newItem.innerHTML = `
                <div class="col-md-5">
                    <input type="text" class="form-control" name="price_structure[${index}][item]" value="${item.item}" required>
                </div>
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <input type="number" step="0.01" class="form-control" name="price_structure[${index}][price]" value="${item.price}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-price-item" ${index === 0 ? 'disabled' : ''}>Remove</button>
                </div>
            `;
            container.appendChild(newItem);
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        let itemCounter = 1;
        
        // Add new price item
        document.getElementById('add-price-item').addEventListener('click', function() {
            const container = document.getElementById('price-items-container');
            const newItem = document.createElement('div');
            newItem.className = 'row mb-2 price-item';
            newItem.innerHTML = `
                <div class="col-md-5">
                    <input type="text" class="form-control" name="price_structure[${itemCounter}][item]" placeholder="Item Name (e.g. Shirt)" required>
                </div>
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <input type="number" step="0.01" class="form-control" name="price_structure[${itemCounter}][price]" placeholder="Price" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-price-item">Remove</button>
                </div>
            `;
            container.appendChild(newItem);
            itemCounter++;
            
            // Enable the first remove button if we have more than one item
            if (container.querySelectorAll('.price-item').length > 1) {
                container.querySelector('.remove-price-item').removeAttribute('disabled');
            }
        });
        
        // Remove price item
        document.getElementById('price-items-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-price-item')) {
                const container = document.getElementById('price-items-container');
                e.target.closest('.price-item').remove();
                
                // If only one item remains, disable its remove button
                if (container.querySelectorAll('.price-item').length === 1) {
                    container.querySelector('.remove-price-item').setAttribute('disabled', 'disabled');
                }
                
                // Reindex the remaining items
                const items = container.querySelectorAll('.price-item');
                items.forEach((item, index) => {
                    const itemNameInput = item.querySelector('input[name^="price_structure"][name$="[item]"]');
                    const itemPriceInput = item.querySelector('input[name^="price_structure"][name$="[price]"]');
                    
                    itemNameInput.name = `price_structure[${index}][item]`;
                    itemPriceInput.name = `price_structure[${index}][price]`;
                });
                
                itemCounter = items.length;
            }
        });
        
        // Form submission
        document.getElementById('serviceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate that at least one price item exists
            const priceItems = document.querySelectorAll('.price-item');
            if (priceItems.length === 0) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please add at least one item with price.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            // Submit the form if validation passes
            this.submit();
        });

        // Highlight active price item
        document.getElementById('price-items-container').addEventListener('click', function(e) {
            const priceItems = document.querySelectorAll('.price-item');
            priceItems.forEach(item => item.style.backgroundColor = '#f8f9fa');
            
            const clickedItem = e.target.closest('.price-item');
            if (clickedItem) {
                clickedItem.style.backgroundColor = '#fff';
            }
        });

        // Smooth scroll to validation errors
        const invalidElements = document.querySelectorAll('.is-invalid');
        if (invalidElements.length > 0) {
            invalidElements[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lifemate\Desktop\Velzon_v4.2.0\Laravel\saas\resources\views/Laundress/services/create.blade.php ENDPATH**/ ?>