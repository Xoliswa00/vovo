<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\QuoteRequestController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

// ─── Public / Guest Routes ───────────────────────────────────────────────────

Route::get('/', [DashboardController::class, 'welcome'])->name('welcome');
Route::get('/about', fn() => view('about'))->name('about');
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
Route::get('/orders/{order}/track', [OrderController::class, 'track'])->name('orders.track');

// Logistics quote (public)
Route::get('/logistics/quote', [QuoteRequestController::class, 'create'])->name('quote.create');
Route::post('/logistics/quote', [QuoteRequestController::class, 'store'])->name('quote.store');

// Sitemap
Route::get('/generate-sitemap', function () {
    $sitemap = Sitemap::create()
        ->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
        ->add(Url::create('/about')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
        ->add(Url::create('/our-services')->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
        ->add(Url::create('/marketplace')->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
        ->add(Url::create('/logistics/quote')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

    $sitemap->writeToFile(public_path('sitemap.xml'));
    return 'Sitemap generated!';
});

// ─── Authenticated / Admin Routes ────────────────────────────────────────────

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Services (admin CRUD)
    Route::resource('services', ServicesController::class);

    // Marketplace admin
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('vendors', VendorController::class);
    Route::resource('reviews', ReviewController::class)->only(['index', 'destroy']);

    // Orders (admin)
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);

    // Logistics admin
    Route::resource('vehicles', VehicleController::class);
    Route::resource('shipments', ShipmentController::class);
    Route::resource('quote-requests', QuoteRequestController::class)->except(['create', 'store']);
});

require __DIR__.'/auth.php';
