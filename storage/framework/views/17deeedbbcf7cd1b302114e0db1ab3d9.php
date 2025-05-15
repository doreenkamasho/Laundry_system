

<?php $__env->startSection('title', 'My Services'); ?>

<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    .card {
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        border: none;
    }
    
    .card-body {
        padding: 2rem;
    }
    
    .table thead th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
        border-bottom: 2px solid #e9ecef;
    }
    
    .table td {
        vertical-align: middle;
        padding: 1rem;
        border-color: #f8f9fa;
    }
    
    .service-category {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .service-category i {
        font-size: 1.2rem;
        color: #6c757d;
    }
    
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 30px;
        font-weight: 500;
    }
    
    .badge.bg-success {
        background-color: #0ab39c !important;
    }
    
    .badge.bg-danger {
        background-color: #f06548 !important;
    }
    
    .btn-sm {
        padding: 0.4rem 1rem;
        border-radius: 30px;
        font-size: 0.8rem;
    }
    
    .alert {
        border-radius: 10px;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .alert-success {
        background-color: #0ab39c20;
        color: #0ab39c;
    }
    
    .alert-danger {
        background-color: #f0654820;
        color: #f06548;
    }
    
    .page-title-box {
        margin-bottom: 1.5rem;
    }

    /* SweetAlert2 Custom Styles */
    .swal2-popup {
        border-radius: 15px !important;
        padding: 2rem !important;
    }

    .swal2-title {
        font-size: 1.5rem !important;
        color: #495057 !important;
        font-weight: 600 !important;
    }

    .swal2-html-container {
        font-size: 1rem !important;
        color: #6c757d !important;
        margin: 1rem 0 !important;
    }

    .swal2-actions {
        gap: 0.5rem !important;
    }

    .swal2-styled {
        padding: 0.5rem 1.5rem !important;
        font-size: 0.9rem !important;
        border-radius: 30px !important;
        font-weight: 500 !important;
    }

    .swal2-icon {
        border-width: 3px !important;
    }

    .swal2-icon.swal2-warning {
        border-color: #f1b44c !important;
        color: #f1b44c !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 text-primary">My Services</h4>
                <div class="page-title-right">
                    <a href="<?php echo e(route('laundress.services.create')); ?>" class="btn btn-primary">
                        <i class="las la-plus me-1"></i>Add New Service
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php if(session()->has('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="las la-check-circle me-2"></i>
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session()->has('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="las la-exclamation-circle me-2"></i>
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-centered table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Service Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <div class="service-category">
                                            <i class="<?php echo e($service->category_icon); ?>"></i>
                                            <span><?php echo e($service->category_name); ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo e($service->name); ?></td>
                                    <td><?php echo e(Str::limit($service->description, 50)); ?></td>
                                    <td>
                                        <?php if($service->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="<?php echo e(route('laundress.services.edit', $service->id)); ?>" 
                                               class="btn btn-sm btn-info">
                                                <i class="las la-edit me-1"></i>Edit
                                            </a>
                                            <form action="<?php echo e(route('laundress.services.destroy', $service->id)); ?>" 
                                                  method="POST" 
                                                  class="delete-form d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="las la-trash me-1"></i>Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="las la-folder-open display-4 d-block mb-2"></i>
                                        No services found
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle delete confirmation with custom styling
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Delete Service?',
                text: "This action cannot be undone",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-soft-primary',
                    cancelButton: 'btn btn-soft-secondary',
                    popup: 'shadow-lg',
                    title: 'fw-medium',
                    htmlContainer: 'text-muted',
                    actions: 'd-flex gap-2',
                },
                buttonsStyling: false,
                reverseButtons: true,
                padding: '2rem',
                background: '#fff',
                showClass: {
                    popup: 'animate__animated animate__fadeIn animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });

    // Add Animate.css for smoother animations
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css';
    document.head.appendChild(link);

    // Smooth alert animations
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.transition = 'all 0.5s ease-in-out';
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\fyp\Ldms\resources\views/Laundress/services/index.blade.php ENDPATH**/ ?>