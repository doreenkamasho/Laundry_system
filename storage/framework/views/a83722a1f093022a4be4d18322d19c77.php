
<?php $__env->startSection('title'); ?> Laundress Management <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Admin <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Laundress Management <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Laundress List</h4>
            <div class="page-title-right">
                <a href="<?php echo e(route('admin.laundress.create')); ?>" class="btn btn-primary">
                    <i class="las la-plus me-1"></i> Add Laundress
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Laundress</h5>
                    <div class="d-flex gap-2">
                        <!-- Search -->
                        <div class="search-box">
                            <form action="<?php echo e(route('admin.laundress.index')); ?>" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                        placeholder="Search name or email..." value="<?php echo e(request('search')); ?>">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="las la-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- Filter Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-soft-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="las la-filter me-1"></i> 
                                <?php echo e(request('status') ? ucfirst(request('status')) : 'All Status'); ?>

                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item <?php echo e(!request('status') ? 'active' : ''); ?>" 
                                    href="<?php echo e(route('admin.laundress.index')); ?>">All</a>
                                <a class="dropdown-item <?php echo e(request('status') === 'active' ? 'active' : ''); ?>" 
                                    href="<?php echo e(route('admin.laundress.index', ['status' => 'active'])); ?>">Active</a>
                                <a class="dropdown-item <?php echo e(request('status') === 'inactive' ? 'active' : ''); ?>" 
                                    href="<?php echo e(route('admin.laundress.index', ['status' => 'inactive'])); ?>">Inactive</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-nowrap align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Joined Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $laundresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laundress): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($laundress->id); ?></td>
                                <td>
                                    <div class="d-flex gap-2 align-items-center">
                                        <?php if($laundress->avatar): ?>
                                            <img src="<?php echo e(\App\Helpers\AvatarHelper::getAvatarUrl($laundress->avatar)); ?>" 
                                                alt="<?php echo e($laundress->name); ?>" 
                                                class="avatar-xs rounded-circle"
                                                onerror="this.onerror=null; this.src='<?php echo e(asset('build/images/users/default-avatar.png')); ?>'">
                                        <?php else: ?>
                                            <div class="avatar-xs">
                                                <span class="avatar-title rounded-circle bg-primary text-white text-uppercase">
                                                    <?php echo e(substr($laundress->name, 0, 1)); ?>

                                                </span>
                                            </div>
                                        <?php endif; ?>
                                        <span class="fw-medium"><?php echo e($laundress->name); ?></span>
                                    </div>
                                </td>
                                <td><?php echo e($laundress->email); ?></td>
                                <td><?php echo e($laundress->laundressDetail->phone_number ?? '-'); ?></td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" 
                                            id="statusSwitch<?php echo e($laundress->id); ?>"
                                            <?php echo e($laundress->is_active ? 'checked' : ''); ?>

                                            data-id="<?php echo e($laundress->id); ?>"
                                            onchange="updateStatus(this)">
                                    </div>
                                </td>
                                <td><?php echo e($laundress->created_at->format('M d, Y')); ?></td>
                                <td>
                                    <div class="hstack gap-2">
                                        <a href="<?php echo e(route('admin.laundress.show', $laundress->id)); ?>" 
                                            class="btn btn-sm btn-soft-info">
                                            <i class="las la-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.laundress.edit', $laundress->id)); ?>" 
                                            class="btn btn-sm btn-soft-warning">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-soft-danger" 
                                            onclick="confirmDelete(<?php echo e($laundress->id); ?>)">
                                            <i class="las la-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center">No laundress found</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <?php echo e($laundresses->appends(request()->query())->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/sweetalert.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/laundress.init.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lifemate\Desktop\Velzon_v4.2.0\Laravel\saas\resources\views/admin/users/laundress/index.blade.php ENDPATH**/ ?>