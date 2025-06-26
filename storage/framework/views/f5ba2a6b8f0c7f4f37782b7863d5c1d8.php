
<?php $__env->startSection('title'); ?> Customer Reviews <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Laundress <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Customer Reviews <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">All Reviews</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Rating</th>
                                    <th>Comment</th>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($review->customer->name); ?></td>
                                        <td>
                                            <div class="text-warning">
                                                <?php for($i = 1; $i <= 5; $i++): ?>
                                                    <i class="ri-star-<?php echo e($i <= $review->rating ? 'fill' : 'line'); ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </td>
                                        <td><?php echo e(Str::limit($review->comment, 100)); ?></td>
                                        <td>
                                            <?php if($review->booking): ?>
                                                <a href="<?php echo e(route('laundress.orders.show', $review->booking)); ?>" 
                                                   class="link-primary">#<?php echo e($review->booking->id); ?></a>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($review->created_at->format('M d, Y')); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo e($review->is_published ? 'success' : 'warning'); ?>">
                                                <?php echo e($review->is_published ? 'Published' : 'Pending'); ?>

                                            </span>
                                        </td>
                                        
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No reviews found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <?php echo e($reviews->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\fyp\Ldms\resources\views/laundress/reviews/index.blade.php ENDPATH**/ ?>