
<?php $__env->startSection('title'); ?>
    Profile Settings
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('build/libs/swiper/swiper-bundle.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="profile-foreground position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg">
            <img src="<?php echo e(URL::asset('build/images/profile-bg.jpg')); ?>" alt="" class="profile-wid-img" />
        </div>
    </div>
    <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
        <div class="row g-4">
            <div class="col-auto">
                <div class="profile-user position-relative d-inline-block mx-auto">
                    <img src="<?php echo e(auth()->user()->avatar 
                        ? Storage::disk('public')->exists(auth()->user()->avatar) 
                            ? Storage::url(auth()->user()->avatar) 
                            : asset('build/images/users/avatar-1.jpg')
                        : asset('build/images/users/avatar-1.jpg')); ?>"
                        class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                        alt="user-profile-image">
                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit position-absolute end-0 bottom-0">
                        <form id="avatar-form" action="<?php echo e(route('customer.profile.update')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <input id="profile-img-file-input" name="avatar" type="file" class="profile-img-file-input d-none" 
                                accept="image/*" onchange="document.getElementById('avatar-form').submit();">
                            <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                <span class="avatar-title rounded-circle bg-light text-body">
                                    <i class="ri-camera-fill"></i>
                                </span>
                            </label>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="p-2">
                    <h3 class="text-white mb-1"><?php echo e(auth()->user()->name); ?></h3>
                    <p class="text-white-75">Customer</p>
                    <div class="hstack text-white-50 gap-1">
                        <div class="me-2"><i class="ri-map-pin-user-line me-1 text-white-75 fs-16 align-middle"></i><?php echo e(auth()->user()->address); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div>
                <div class="d-flex justify-content-end mb-4">
                    <a href="<?php echo e(route('customer.profile.edit')); ?>" class="btn btn-success"><i class="ri-edit-box-line align-bottom"></i> Edit Profile</a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Personal Information</h5>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th class="ps-0" scope="row">Full Name:</th>
                                        <td class="text-muted"><?php echo e(auth()->user()->name); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Mobile:</th>
                                        <td class="text-muted"><?php echo e(auth()->user()->phone); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">E-mail:</th>
                                        <td class="text-muted"><?php echo e(auth()->user()->email); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Location:</th>
                                        <td class="text-muted"><?php echo e(auth()->user()->address); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Joined Date:</th>
                                        <td class="text-muted"><?php echo e(auth()->user()->created_at->format('M d, Y')); ?></td>
                                    </tr>
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
    <script src="<?php echo e(URL::asset('build/libs/swiper/swiper-bundle.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/profile.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\fyp\Ldms\resources\views/customer/profile/show.blade.php ENDPATH**/ ?>