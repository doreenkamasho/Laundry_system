
<?php $__env->startSection('title'); ?>
    Edit Profile
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Edit Profile</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <div class="position-relative d-inline-block">
                                    <div class="avatar-xl">
                                        <?php if(auth()->user()->avatar): ?>
                                            <img src="<?php echo e(\App\Helpers\AvatarHelper::getAvatarUrl(auth()->user()->avatar)); ?>" 
                                                alt="<?php echo e(auth()->user()->name); ?>" 
                                                class="rounded-circle img-thumbnail"
                                                style="width: 100px; height: 100px; object-fit: cover;"
                                                id="preview-avatar">
                                        <?php else: ?>
                                            <div class="avatar-xl rounded-circle bg-primary text-white">
                                                <span class="avatar-title" style="font-size: 48px;">
                                                    <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="avatar-xs position-absolute bottom-0 end-0">
                                        <button type="button" 
                                            class="btn btn-light btn-sm rounded-circle" 
                                            onclick="document.getElementById('avatar-input').click();">
                                            <i class="ri-camera-fill"></i>
                                        </button>
                                    </div>
                                </div>
                                <h5 class="fs-16 mt-3 mb-1">Profile Picture</h5>
                                <p class="text-muted mb-0">Max file size 2MB</p>
                                <form id="avatar-form" action="<?php echo e(route('customer.profile.update')); ?>" method="POST" enctype="multipart/form-data" class="d-none">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <input type="file" 
                                        id="avatar-input" 
                                        name="avatar" 
                                        accept="image/*"
                                        onchange="submitAvatarForm()">
                                </form>
                                <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <form action="<?php echo e(route('customer.profile.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                    value="<?php echo e(old('name', auth()->user()->name)); ?>" required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-lg-6">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" 
                                    value="<?php echo e(old('email', auth()->user()->email)); ?>" required>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">+255</span>
                                    <input type="text" class="form-control" id="phone" name="phone" 
                                        value="<?php echo e(old('phone', auth()->user()->phone)); ?>" 
                                        required
                                        pattern="[0-9]{9}"
                                        title="Please enter 9 digits (e.g., 712345678)"
                                        placeholder="712345678">
                                </div>
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-lg-6">
                                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address" name="address" 
                                    value="<?php echo e(old('address', auth()->user()->address)); ?>" 
                                    required
                                    placeholder="Enter your full address">
                                <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="<?php echo e(route('customer.profile')); ?>" class="btn btn-light me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/profile-avatar.init.js')); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Profile avatar script loaded');
            
            // Debug image path
            <?php if(auth()->user()->avatar): ?>
                console.log('Avatar path:', '<?php echo e(auth()->user()->avatar); ?>');
                console.log('Full URL:', '<?php echo e(Storage::url(auth()->user()->avatar)); ?>');
                console.log('Exists:', '<?php echo e(Storage::disk("public")->exists(auth()->user()->avatar) ? "Yes" : "No"); ?>');
            <?php else: ?>
                console.log('No avatar set');
            <?php endif; ?>
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\fyp\Ldms\resources\views/customer/profile/edit.blade.php ENDPATH**/ ?>