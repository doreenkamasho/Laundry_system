

<?php $__env->startSection('title', 'My Schedule'); ?>

<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<style>
    .fc {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }
    
    .fc-event {
        cursor: pointer;
        border-radius: 4px;
        padding: 3px 5px;
    }
    
    .fc-toolbar-title {
        font-size: 1.2rem !important;
        font-weight: 600;
    }
    
    .fc-button-primary {
        background-color: #556ee6 !important;
        border-color: #556ee6 !important;
    }
    
    .fc-button-primary:hover {
        background-color: #4458b8 !important;
        border-color: #4458b8 !important;
    }
    
    .fc-day-today {
        background-color: #f8f9fa !important;
    }
    
    .fc-event-title {
        font-size: 0.85em;
        font-weight: 500;
    }
    
    .day-schedule {
        border: 1px solid #e9e9ef;
        border-radius: 4px;
        padding: 15px;
        margin-bottom: 15px;
    }
    .day-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">My Schedule</h4>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Availability Status</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('laundress.schedule.availability')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                            <input type="checkbox" class="form-check-input" id="is_available" name="is_available" 
                                <?php echo e($user->schedule->is_available ? 'checked' : ''); ?> onchange="this.form.submit()">
                            <label class="form-check-label" for="is_available">
                                I am <?php echo e($user->schedule->is_available ? 'available' : 'not available'); ?> for bookings
                            </label>
                        </div>
                        <p class="text-muted">
                            Toggle this switch to indicate whether you are currently accepting new bookings.
                        </p>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Upcoming Bookings</h5>
                </div>
                <div class="card-body">
                    <?php if($upcomingBookings->count() > 0): ?>
                        <div class="list-group">
                            <?php $__currentLoopData = $upcomingBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1"><?php echo e($booking->customer->name); ?></h5>
                                        <small class="badge bg-<?php echo e($booking->status_color); ?>"><?php echo e(ucfirst($booking->status)); ?></small>
                                    </div>
                                    <p class="mb-1"><?php echo e($booking->service_name); ?></p>
                                    <small><?php echo e(\Carbon\Carbon::parse($booking->scheduled_date)->format('M d, Y')); ?> at <?php echo e(\Carbon\Carbon::parse($booking->scheduled_time)->format('h:i A')); ?></small>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-center text-muted">No upcoming bookings</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Working Hours</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('laundress.schedule.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <?php $__currentLoopData = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6">
                                    <div class="day-schedule">
                                        <div class="day-header">
                                            <h5 class="mb-0"><?php echo e(ucfirst($day)); ?></h5>
                                            <div class="form-check form-switch">
                                                <input type="hidden" name="working_days[<?php echo e($day); ?>][is_available]" value="0">
                                                <input class="form-check-input day-toggle" type="checkbox" 
                                                    id="<?php echo e($day); ?>_available" 
                                                    name="working_days[<?php echo e($day); ?>][is_available]" 
                                                    value="1"
                                                    data-day="<?php echo e($day); ?>"
                                                    <?php echo e($user->schedule->working_days[$day]['is_available'] ? 'checked' : ''); ?>>
                                                <label class="form-check-label" for="<?php echo e($day); ?>_available">Available</label>
                                            </div>
                                        </div>
                                        <div class="time-slots <?php echo e($user->schedule->working_days[$day]['is_available'] ? '' : 'd-none'); ?>" id="<?php echo e($day); ?>_time_slots">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Start Time</label>
                                                        <input type="time" class="form-control" 
                                                            name="working_days[<?php echo e($day); ?>][start_time]" 
                                                            value="<?php echo e($user->schedule->working_days[$day]['start_time']); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">End Time</label>
                                                        <input type="time" class="form-control" 
                                                            name="working_days[<?php echo e($day); ?>][end_time]" 
                                                            value="<?php echo e($user->schedule->working_days[$day]['end_time']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Save Schedule</button>
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
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add this console log to verify the script is running
    console.log('Initializing calendar...');

    var calendarEl = document.getElementById('calendar');
    
    if (!calendarEl) {
        console.error('Calendar element not found!');
        return;
    }

    try {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            plugins: ['dayGrid', 'timeGrid'],
            height: 650,
            slotMinTime: '06:00:00',
            slotMaxTime: '22:00:00',
            allDaySlot: false,
            slotDuration: '00:30:00',
            nowIndicator: true,
            navLinks: true,
            dayMaxEvents: true,
            weekends: true,
            selectable: false,
            businessHours: <?php echo json_encode(collect(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])
                ->map(function($day, $index) use ($user) {
                    if ($user->schedule->working_days[$day]['is_available']) {
                        return [
                            'daysOfWeek' => [$index],
                            'startTime' => $user->schedule->working_days[$day]['start_time'],
                            'endTime' => $user->schedule->working_days[$day]['end_time']
                        ];
                    }
                    return null;
                })->filter()); ?>,
            events: <?php echo json_encode($upcomingBookings->map(function($booking) {
                return [
                    'id' => $booking->id,
                    'title' => $booking->service_name . ' - ' . $booking->customer->name,
                    'start' => $booking->scheduled_date . 'T' . $booking->scheduled_time,
                    'end' => $booking->scheduled_date . 'T' . \Carbon\Carbon::parse($booking->scheduled_time)->addHours(2)->format('H:i:s'),
                    'backgroundColor' => $booking->status === 'confirmed' ? '#0ab39c' : ($booking->status === 'pending' ? '#f7b84b' : '#405189'),
                    'borderColor' => $booking->status === 'confirmed' ? '#0ab39c' : ($booking->status === 'pending' ? '#f7b84b' : '#405189'),
                    'extendedProps' => [
                        'status' => $booking->status,
                        'customer' => $booking->customer->name,
                        'service' => $booking->service_name
                    ]
                ];
            })); ?>

        });

        calendar.render();
        console.log('Calendar rendered successfully');
        
        // Remove loader after successful render
        const loader = document.querySelector('.calendar-loader');
        if (loader) {
            loader.remove();
        }
    } catch (error) {
        console.error('Error initializing calendar:', error);
    }

    // Toggle time slots visibility when day availability changes
    document.querySelectorAll('.day-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const timeSlots = document.getElementById(`${this.dataset.day}_time_slots`);
            if (timeSlots) {
                timeSlots.classList.toggle('d-none', !this.checked);
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\fyp\Ldms\resources\views/Laundress/schedule/index.blade.php ENDPATH**/ ?>