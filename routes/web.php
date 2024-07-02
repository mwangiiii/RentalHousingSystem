<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LockScreenController;
use App\Http\Controllers\AddHousesController;
use App\Http\Controllers\ListerController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Auth;
use App\Models\House;
use App\Models\User;

// Public routes
Route::get('/', [AddHousesController::class, 'homeImages'])->name('homeImages');
Route::get('/houses/{house}', [AddHousesController::class, 'show'])->name('house.show');
Route::view('/house', 'houses-info')->name('house.view');
Route::get('/search', [PropertyController::class, 'search'])->name('property.search');
// Route::get('/property/category/{category}', [PropertyController::class, 'category'])->name('property.category');



// Routes for the lock screen
Route::get('/lock_screen', [LockScreenController::class, 'lockscreen'])->name('lock-screen');
Route::post('/unlock_screen', [LockScreenController::class, 'unlock'])->name('unlock');
Route::post('/manual-lock', [LockScreenController::class, 'lock'])->name('manual-lock');
Route::post('/auto-lock', [LockScreenController::class, 'autoLock'])->name('auto-lock');

// Authenticated routes
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/lister/list-house', [AddHousesController::class,'listingView'])->name('lister.listingForm');
    
    // Add houses related routes
    Route::post('/saveHouse', [AddHousesController::class, 'store'])->name('addListing.store');

    // Test route to verify mass assignment
    Route::get('/test-mass-assignment', [AddHousesController::class, 'testMassAssignment'])->name('testMassAssignment');

    // Lister specific routes
    Route::get('/lister/dashboard', function () {
        // Fetch houses listed by this user
        $houses = House::where('user_id', Auth::user()->id)->get();
        return view('lister.dashboard', compact('houses')); // Replace with your lister dashboard view
    })->name('lister.dashboard');
        
    Route::get('/lister/houses', [AddHousesController::class, 'getListerHouses'])->name('lister.houses');
    Route::get('/lister/dashboard/house/edit', [AddHousesController::class, 'edit'])->name('houses.edit');
    Route::put('/lister/dashboard/house/update', [AddHousesController::class, 'update'])->name('houses.update');
    

    // Hunter specific routes
    Route::middleware('role:hunter')->group(function () {
        Route::get('/hunter/dashboard', function () {
            return view('hunter.dashboard'); // Replace with your hunter dashboard view
        })->name('hunter.dashboard');
        
        Route::get('/hunter/dashboard', [AddHousesController::class, 'hunter'])->name('houses.hunter');
    });
});

// Property routes by location
Route::get('/property/location/nairobi', [PropertyController::class, 'showNairobi']);
Route::get('/property/location/nakuru', [PropertyController::class, 'showNakuru']);
Route::get('/property/location/mombasa', [PropertyController::class, 'showMombasa']);
Route::get('/property/location/kirinyaga', [PropertyController::class, 'showKirinyaga']);
Route::get('/property/location/eldoret', [PropertyController::class, 'showEldoret']);
Route::get('/property/location/embu', [PropertyController::class, 'showEmbu']);

// Property routes by category
Route::get('/property/category/apartment', [PropertyController::class, 'showApartments']);
Route::get('/property/category/own-compound', [PropertyController::class, 'showOwnCompound']);
Route::get('/property/category/gated-community', [PropertyController::class, 'showGatedCommunity']);
Route::get('/property/category/townhouses', [PropertyController::class, 'showTownhouses']);
Route::get('/property/category/commercial-properties', [PropertyController::class, 'showCommercialProperties']);
Route::get('/property/category/short-term-rentals', [PropertyController::class, 'showShortTermRentals']);
Route::get('/property/category/luxury-villas', [PropertyController::class, 'showLuxuryVillas']);
Route::get('/property/category/property-management-services', [PropertyController::class, 'showPropertyManagementServices']);



Route::get('/hunter-dashboard', [HomeController::class, 'hunter'])->name('hunter.dashboard');
// routes/web.php



Route::middleware(['auth'])->group(function () {
    Route::get('/booking/{houseId}', [BookingController::class, 'showBookingForm'])->name('booking');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/booking/{id}/edit', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('/booking/{id}', [BookingController::class, 'update'])->name('booking.update');
    Route::delete('/booking/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');
});


