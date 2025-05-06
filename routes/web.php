<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\SettingsController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Laundress\LaundressController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Laundress\EarningsController;
use App\Http\Controllers\Laundress\LaundressProfileController;
use App\Http\Controllers\Laundress\DashboardController as LaundressDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

// Public routes
Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
Route::get('/terms', function () {
    return view('auth.term-conditions');
})->name('terms');
Route::get('lang/{locale}', [App\Http\Controllers\HomeController::class, 'lang'])->name('lang');

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('admin.customers.index');
    Route::get('/admin/laundress', [App\Http\Controllers\Admin\LaundressController::class, 'index'])->name('admin.laundress.index');
    Route::get('/admin/services/categories', [App\Http\Controllers\Admin\ServiceCategoryController::class, 'index'])
        ->name('admin.services.categories.index');
    Route::get('/admin/services/prices', [App\Http\Controllers\Admin\ServicePriceController::class, 'index'])
        ->name('admin.services.prices.index');
    Route::post('/admin/services/categories', [App\Http\Controllers\Admin\ServiceCategoryController::class, 'store'])
        ->name('admin.services.categories.store');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Laundress Routes
    Route::prefix('laundress')->name('laundress.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\LaundressController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\LaundressController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Admin\LaundressController::class, 'store'])->name('store');
        Route::get('/{laundress}', [App\Http\Controllers\Admin\LaundressController::class, 'show'])->name('show');
        Route::get('/{laundress}/edit', [App\Http\Controllers\Admin\LaundressController::class, 'edit'])->name('edit');
        Route::put('/{laundress}', [App\Http\Controllers\Admin\LaundressController::class, 'update'])->name('update');
        Route::delete('/{laundress}', [App\Http\Controllers\Admin\LaundressController::class, 'destroy'])->name('destroy');
        Route::post('/{laundress}/status', [App\Http\Controllers\Admin\LaundressController::class, 'toggleStatus'])->name('status');
    });

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Mark single notification as read
    Route::post('notifications/{notification}/mark-as-read', function ($notification) {
        Auth::user()->notifications()->findOrFail($notification)->markAsRead();
        return back()->with('success', 'Notification marked as read');
    })->name('notifications.markAsRead');

    // Mark all notifications as read
    Route::post('notifications/mark-all-as-read', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read');
    })->name('notifications.markAllAsRead');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'role:admin']], function () {
    Route::get('/bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::put('/bookings/{booking}/status', [App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.update-status');
    
    // Reports Routes
    Route::get('/reports/sales', [App\Http\Controllers\Admin\ReportController::class, 'sales'])
        ->name('reports.sales');
    Route::get('/reports/user-activity', [App\Http\Controllers\Admin\ReportController::class, 'userActivity'])
        ->name('reports.user-activity');

    // Settings Routes - Updated grouping
    Route::prefix('settings')->name('settings.')->group(function () {
        // General Settings
        Route::get('general', [App\Http\Controllers\Admin\SettingsController::class, 'general'])
            ->name('general');
        Route::post('general', [App\Http\Controllers\Admin\SettingsController::class, 'updateGeneral'])
            ->name('general.update');
            
        // System Settings    
        Route::get('system', [App\Http\Controllers\Admin\SettingsController::class, 'system'])
            ->name('system');
        Route::post('system', [App\Http\Controllers\Admin\SettingsController::class, 'updateSystem'])
            ->name('system.update');
    });
});

// Add this in your admin group routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
});

// Customer routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    // Make find-laundress the index route
    Route::get('/', [App\Http\Controllers\Customer\FindLaundressController::class, 'index'])
        ->name('index');
    
    // Existing find-laundress route can be kept for explicit navigation
    Route::get('/find-laundress', [App\Http\Controllers\Customer\FindLaundressController::class, 'index'])
        ->name('find-laundress');

    // Orders
    Route::resource('orders', OrderController::class);
    Route::patch('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    
    // Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/payment', [BookingController::class, 'payment'])->name('bookings.payment');
    Route::get('/bookings/create/{laundress}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/calculate-total', [BookingController::class, 'calculateTotal'])->name('bookings.calculate-total');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::patch('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Payments
    Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');

    // Profile and Settings
    Route::get('profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('settings', [SettingsController::class, 'edit'])->name('settings');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
    
    // Support
    Route::get('support', function () {
        return view('help');
    })->name('support');
    
    // Laundress profile and reviews
    Route::get('laundress/{laundress}/profile', [App\Http\Controllers\Customer\LaundressController::class, 'profile'])
        ->name('laundress.profile');
    
    // Add the reviews route here
    Route::get('laundress/{laundress}/reviews', [App\Http\Controllers\Customer\LaundressController::class, 'reviews'])
        ->name('laundress.reviews');
    Route::post('laundress/{laundress}/reviews', [App\Http\Controllers\Customer\LaundressController::class, 'storeReview'])
        ->name('laundress.reviews.store');
    Route::post('laundress/reviews/{review}/like', [App\Http\Controllers\Customer\LaundressController::class, 'likeReview'])
        ->name('laundress.reviews.like');
    Route::post('laundress/reviews/{review}/reply', [App\Http\Controllers\Customer\LaundressController::class, 'replyToReview'])
        ->name('laundress.reviews.reply');
    Route::get('laundress/reviews/{review}/replies', [App\Http\Controllers\Customer\LaundressController::class, 'getReviews'])
        ->name('laundress.reviews.replies');
});

// Laundress profile route
Route::get('/customer/laundress/{id}', [\App\Http\Controllers\Customer\LaundressController::class, 'show'])
    ->name('customer.laundress.profile');

Route::group([
    'middleware' => ['auth', 'role:customer'],
    'prefix' => 'customer',
    'as' => 'customer.',
    'namespace' => 'App\Http\Controllers\Customer'
], function () {
    Route::get('orders/create/{laundress}', [OrderController::class, 'create'])->name('orders.create');
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/laundress/{laundress}/reviews', [App\Http\Controllers\Customer\LaundressController::class, 'storeReview'])
        ->name('laundress.reviews.store');
});

// Laundress routes
Route::middleware(['auth', 'role:laundress'])->prefix('laundress')->name('laundress.')->group(function () {
    Route::get('/dashboard', [LaundressDashboardController::class, 'index'])->name('dashboard');
    
    // Laundress Service Routes
    Route::resource('services', \App\Http\Controllers\Laundress\ServiceController::class);

    // Laundress Schedule Routes
    Route::get('/schedule', [\App\Http\Controllers\Laundress\ScheduleController::class, 'index'])->name('schedule.index');
    Route::post('/schedule/update', [\App\Http\Controllers\Laundress\ScheduleController::class, 'update'])->name('schedule.update');
    Route::post('/schedule/availability', [\App\Http\Controllers\Laundress\ScheduleController::class, 'updateAvailability'])->name('schedule.availability');
    
    // Orders routes
    Route::get('/orders', [App\Http\Controllers\Laundress\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\Laundress\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [App\Http\Controllers\Laundress\OrderController::class, 'updateStatus'])->name('orders.update-status');

    // Earnings routes
    Route::prefix('earnings')->name('earnings.')->group(function () {
        Route::get('/overview', [EarningsController::class, 'overview'])->name('overview');
        Route::get('/history', [EarningsController::class, 'history'])->name('history');
    });

    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [LaundressProfileController::class, 'show'])->name('show');
        Route::get('/edit', [LaundressProfileController::class, 'edit'])->name('edit');
        Route::get('/business', [LaundressProfileController::class, 'business'])->name('business');
        Route::put('/update', [LaundressProfileController::class, 'update'])->name('update');
    });

    // Settings routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/edit', [LaundressSettingsController::class, 'edit'])->name('edit');
        Route::put('/update', [LaundressSettingsController::class, 'update'])->name('update');
    });
});

// Theme routes
Route::middleware(['auth'])->group(function () {
    Route::post('/update-theme', [ThemeController::class, 'update'])->name('theme.update');
    Route::post('/save-theme', [ThemeController::class, 'save'])->name('theme.save');

    // Help page route
    Route::get('/help', function () {
        return view('help');
    })->name('help');
});

Route::post('/update-theme', function (Request $request) {
    $validSettings = [
        'theme' => 'data-bs-theme',
        'layoutStyle' => 'data-layout-style',
        'sidebar' => 'data-sidebar',
        'sidebarSize' => 'data-sidebar-size',
        'sidebarImage' => 'data-sidebar-image'
    ];
    
    foreach ($validSettings as $key => $attr) {
        if ($request->has($key)) {
            session([$key => $request->get($key)]);
        }
    }
    
    return response()->json(['success' => true]);
})->middleware(['web', 'auth']);

Route::post('/update-sidebar', function (Request $request) {
    $validSettings = [
        'layoutStyle', 'sidebar', 'sidebarSize', 'sidebarImage'
    ];
    
    foreach ($validSettings as $setting) {
        if ($request->has($setting)) {
            session([$setting => $request->get($setting)]);
        }
    }
    
    return response()->json(['success' => true]);
})->middleware(['web', 'auth']);

Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/debug-storage', function() {
    $paths = [
        'storage_path' => storage_path('app/public'),
        'public_path' => public_path('storage'),
        'link_exists' => file_exists(public_path('storage')),
        'storage_exists' => file_exists(storage_path('app/public')),
        'is_writable' => is_writable(storage_path('app/public')),
        'public_is_writable' => is_writable(public_path('storage')),
    ];

    return response()->json($paths);
});

Route::get('/test-pusher', function() {
    $booking = \App\Models\Booking::first();
    if (!$booking) {
        return 'No bookings found!';
    }
    
    event(new \App\Events\OrderStatusUpdated($booking));
    return 'Event triggered for order #' . $booking->id;
})->middleware('auth');
