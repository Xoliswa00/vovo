<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ServicesImgController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\QuoteRequestController;
use App\Http\Controllers\DashboardController;
use App\Models\Vendor;
use App\Models\Shipment;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// ─── Public / Guest Routes ───────────────────────────────────────────────────

Route::get('/', [DashboardController::class, 'welcome'])->name('welcome');
Route::get('/about', function () {
    return view('about', [
        'vendorCount'   => Vendor::where('status', 'active')->count(),
        'shipmentCount' => Shipment::where('status', 'delivered')->count(),
        'orderCount'    => Order::where('status', 'completed')->count(),
        'avgRating'     => round(Review::avg('rating') ?? 0, 1),
    ]);
})->name('about');
Route::get('/test', fn() => 'Laravel is working!');

// Marketplace
Route::get('/marketplace', [ProductController::class, 'publicIndex'])->name('marketplace.index');
Route::get('/marketplace/{product}', [ProductController::class, 'publicShow'])->name('marketplace.show');
Route::post('/marketplace/{product}/order', [OrderController::class, 'storeProductOrder'])->name('marketplace.order');

// Services (public)
Route::get('/our-services', [ServicesController::class, 'public'])->name('services.public');
Route::get('/our-services/{service}', [ServicesController::class, 'publicShow'])->name('services.show.public');
Route::post('/our-services/{service}/order', [OrderController::class, 'storeServiceOrder'])->name('services.order');

// Reviews (public submit)
Route::post('/reviews/{type}/{id}', [ReviewController::class, 'store'])->name('reviews.store');

// Order tracking (guest)
Route::get('/track-order', [OrderController::class, 'trackLookup'])->name('orders.track.lookup');
Route::post('/track-order', [OrderController::class, 'trackLookupSubmit'])->name('orders.track.lookup.submit');
Route::get('/orders/{order:order_number}/track', [OrderController::class, 'track'])->name('orders.track');

// Logistics quote (public)
Route::get('/logistics/quote', [QuoteRequestController::class, 'create'])->name('quote.create');
Route::post('/logistics/quote', [QuoteRequestController::class, 'store'])->name('quote.store');

// Sitemap (regenerates sitemap.xml from the current services/products)
Route::get('/generate-sitemap', function () {
    Artisan::call('sitemap:generate-dynamic');
    return 'Sitemap generated!';
});

// ─── Authenticated / Admin Routes ────────────────────────────────────────────

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (any authenticated role)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin + vendor: catalog management (ownership enforced via policies/controllers)
    Route::middleware('role:admin,vendor')->group(function () {
        Route::resource('services', ServicesController::class);
        Route::post('/services/{service}/images', [ServicesImgController::class, 'store'])->name('services.images.store');
        Route::delete('/services/images/{services_img}', [ServicesImgController::class, 'destroy'])->name('services.images.destroy');
        Route::patch('/services/images/{services_img}/primary', [ServicesImgController::class, 'primary'])->name('services.images.primary');
        Route::resource('products', ProductController::class);
    });

    // Admin only: platform-wide operations
    Route::middleware('role:admin')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('vendors', VendorController::class);
        Route::resource('reviews', ReviewController::class)->only(['index', 'destroy']);
        Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);
        Route::resource('vehicles', VehicleController::class);
        Route::resource('shipments', ShipmentController::class);
        Route::resource('quote-requests', QuoteRequestController::class)->except(['create', 'store']);
    });
});

require __DIR__.'/auth.php';

// ─── Xquisite Monitoring – health check endpoint ──────────────────────────────
Route::get('/api/health', function () {
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        $db = true;
    } catch (\Throwable) {
        $db = false;
    }

    try {
        $f = storage_path('framework/.health-check');
        file_put_contents($f, '1');
        unlink($f);
        $storage = true;
    } catch (\Throwable) {
        $storage = false;
    }

    try {
        \Illuminate\Support\Facades\Cache::put('_xq_health', 1, 5);
        $cache = \Illuminate\Support\Facades\Cache::get('_xq_health') === 1;
    } catch (\Throwable) {
        $cache = false;
    }

    $diskTotal = disk_total_space(base_path());
    $diskFree  = disk_free_space(base_path());

    try {
        $failedJobs = \Illuminate\Support\Facades\DB::table('failed_jobs')->count();
    } catch (\Throwable) {
        $failedJobs = null;
    }

    $critical = !$db || !$storage;

    return response()->json([
        'status'            => $critical ? 'down' : 'up',
        'db'                => $db,
        'storage_writable'  => $storage,
        'cache'             => $cache,
        'disk_free_mb'      => (int) ($diskFree / 1024 / 1024),
        'disk_used_percent' => $diskTotal > 0 ? round((($diskTotal - $diskFree) / $diskTotal) * 100, 1) : null,
        'app_key_set'       => !empty(config('app.key')),
        'failed_jobs'       => $failedJobs,
        'timestamp'         => now()->toISOString(),
    ], $critical ? 503 : 200);
})->name('xquisite.health');