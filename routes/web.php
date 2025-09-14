<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyDetailsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\PropertImgController;

use App\Http\Controllers\ServiceRequestsController;
use App\Http\Controllers\LogisticsDetailsController;
use App\Models\property_details;

use App\Http\Controllers\PropertyController;


Route::get('/', function () {
    // Latest 1 "Premium + Featured"
    $properties = property_details::with('images')->latest()->take(1)->get();

    // Next 3 (skip the first one)
    $mini = property_details::with('images')->latest()->skip(1)->take(3)->get();

    // Next 6 (skip the first 4)
    $exclusive = property_details::with('images')->latest()->skip(4)->take(6)->get();

    return view('welcome', compact('properties', 'mini', 'exclusive'));
})->name('welcome');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});
// Guest property listing

// Guest property detail view




Route::middleware(['auth'])->group(function() {
    Route::resource('property',PropertyDetailsController::class); // property listings
    Route::resource('property-images', PropertImgController::class); // images
    Route::resource('logistics', LogisticsDetailsController::class); // logistics
    Route::resource('services', ServicesController::class);

});

Route::get('/guest/{id}', [PropertyDetailsController::class, 'guestShow'])->name('Guest.show');
Route::get('/listing', [PropertyDetailsController::class, 'listing'])->name('listing');
Route::get('/our-services', [ServicesController::class, 'public'])->name('services.public');
Route::get('/our-services/{service}/request', [ServicesController::class, 'requestForm'])->name('services.request');
Route::post('/our-services/{service}/request', [ServicesController::class, 'requestStore'])->name('services.request.store');


require __DIR__.'/auth.php';
