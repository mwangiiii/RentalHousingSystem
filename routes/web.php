<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HunterController;
use App\Http\Controllers\LockScreenController;
use App\Http\Controllers\LandlordController;
use App\Http\Controllers\TenantController;
use App\Http\Middleware\LockScreenMiddleware;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TenantsController;
use App\Http\Controllers\MessageTenantController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AddHousesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Auth;
use App\Models\House;

Route::get('/', [AddHousesController::class, 'homeImages'])->name('homeImages');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'is-suspended'
])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
});

Route::middleware(['auth', LockScreenMiddleware::class])->group(function () {
    Route::prefix('landlord')->group(function () {

        Route::get('/dashboard', [LandlordController::class, 'dashboard'])->name('admin.dashboard');
        // Route::get('/payments/dashboard', [LandlordController::class, 'payments'])->name('admin.payments');

        // Landlord property routes
        Route::get('/properties', [PropertyController::class, 'index'])->name('landlord.properties.index');
        Route::get('/properties/create', [PropertyController::class, 'create'])->name('landlord.properties.create');
        Route::post('/properties', [PropertyController::class, 'store'])->name('landlord.properties.store');
        Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('landlord.properties.edit');
        Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('landlord.properties.update');
        Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('landlord.properties.destroy');

        // Landlord room routes
        Route::resource('rooms', RoomController::class)->names([
            'index' => 'landlord.rooms.index',
            'create' => 'landlord.rooms.create',
            'store' => 'landlord.rooms.store',
            'edit' => 'landlord.rooms.edit',
            'update' => 'landlord.rooms.update',
            'destroy' => 'landlord.rooms.destroy',
        ]);


        // Landlord tenant routes
        Route::resource('tenants', TenantController::class)->names([
            'index' => 'landlord.tenants.index',
            'create' => 'landlord.tenants.create',
            'store' => 'landlord.tenants.store',
            'edit' => 'landlord.tenants.edit',
            'update' => 'landlord.tenants.update',
            'destroy' => 'landlord.tenants.destroy',
        ]);
        Route::patch('/tenants/{tenant}/checkout', [TenantController::class, 'checkout'])->name('landlord.tenants.checkout');
        Route::patch('/tenants/{tenant}/checkin', [TenantController::class, 'checkin'])->name('landlord.tenants.checkin');

        // Landlord Payment routes
        Route::get('/payments', [PaymentController::class, 'index'])->name('landlord.payments.index');
        Route::get('/payments/filter', [PaymentController::class, 'filter'])->name('landlord.payments.filter');


        // Landlord role routes
        Route::get('roles', [RoleController::class, 'index'])->name('landlord.roles.index');
        Route::get('roles/create', [RoleController::class, 'create'])->name('landlord.roles.create');
        Route::post('roles', [RoleController::class, 'store'])->name('landlord.roles.store');
        Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('landlord.roles.edit');
        Route::put('roles/{role}', [RoleController::class, 'update'])->name('landlord.roles.update');
        Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('landlord.roles.destroy');


        // Landlord user routes
        Route::resource('users', UserController::class)->names([
            'index' => 'landlord.users.index',
            'create' => 'landlord.users.create',
            'store' => 'landlord.users.store',
            'edit' => 'landlord.users.edit',
            'update' => 'landlord.users.update',
            'destroy' => 'landlord.users.destroy',
        ]);

        // Landlord messages routes
        Route::get('messages', [MessageTenantController::class, 'index'])->name('landlord.messages.index');
        Route::get('messages/create', [MessageTenantController::class, 'create'])->name('landlord.messages.create');
        Route::post('messages/send', [MessageTenantController::class, 'sendMessage'])->name('landlord.send.message');
    });

    Route::prefix('tenant')->group(function () {
        Route::get('/dashboard', [TenantsController::class, 'dashboard'])->name('tenant.dashboard');
        Route::get('/property', [TenantsController::class, 'property'])->name('tenant.property');
        Route::get('/payments', [TenantsController::class, 'payments'])->name('tenant.payments');
        Route::post('/payments/response', [TenantsController::class, 'callback'])->withoutMiddleware('auth')->name('mpesa.callback');
        Route::post('/payment', [TenantsController::class, 'storePayment'])->name('tenant.payments.store');
        Route::get('/maintenance', [TenantsController::class, 'maintenance'])->name('tenant.maintenance');
        Route::post('/tenant/maintenance/submit', [TenantsController::class, 'submitMaintenanceRequest'])->name('tenants.maintenance.store');
    });

    Route::get('/lister/list-house', [AddHousesController::class, 'listingView'])->name('lister.listingForm');

    // Add houses related routes
    Route::post('/saveHouse', [AddHousesController::class, 'store'])->name('addListing.store');
    Route::delete('/house/destroy/{id}', [AddHousesController::class, 'destroy'])->name('house.destroy');

    // Lister specific routes
    Route::get('/lister/dashboard', function () {
        // Fetch houses listed by this user
        $houses = House::where('user_id', Auth::user()->id)->get();
        return view('lister.dashboard', compact('houses')); // Replace with your lister dashboard view
    })->name('lister.dashboard');

    Route::get('/lister/houses', [AddHousesController::class, 'getListerHouses'])->name('lister.houses');
  Route::get('/houses/{id}/edit', [AddHousesController::class, 'edit'])->name('houses.edit');
Route::post('/houses/{id}/update', [AddHousesController::class, 'update'])->name('houses.update');
Route::get('/houses/{id}/is-booked', [BookingController::class, 'isHouseBooked'])->name('houses.is-booked');
Route::get('/houses/{id}/booking-status', [BookingController::class, 'showBookingStatus'])->name('houses.bookingStatus');

Route::resource('houses', AddHousesController::class);

// Route::get('/houses', [AddHousesController::class, 'methodName'])->name('houses.index')

    Route::get('/hunter/dashboard', [HunterController::class, 'dashboard'])->name('hunter.dashboard');
    Route::post('/houses/{houseId}/save', [HunterController::class, 'saveHouse'])->name('houses.save');

   
    Route::get('/lister/house/{id}', [AddHousesController::class, 'show'])->name('houses.show');
    Route::get('/hunter/viewing/a/house/{id}', [HunterController::class, 'show'])->name('houseshunter.show');
    Route::post('/contact-agent/{houseId}', [HunterController::class, 'contactAgent'])->name('contact.agent');


    // Routes for booking houses
 
    Route::get('/houses/{houseId}/book', [BookingController::class, 'showBookingForm'])->name('booking.form');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/hunter/booking', [BookingController::class, 'store'])->name('hunter.bookings');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::resource('bookings', BookingController::class);
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/booking/{id}/edit', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('/booking/{id}', [BookingController::class, 'update'])->name('booking.update');
    Route::delete('/booking/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');
Route::put('/bookings/{id}', [BookingController::class, 'update'])->name('bookings.update');

});

// In web.php
Route::get('/test-storage', function () {
    Storage::disk('local')->put('test.txt', 'This is a test.');
    return response()->json(['success' => true]);
});


//Lockscreen routes

Route::middleware(['auth'])->group(function () {
    Route::get('/lock-screen', [LockScreenController::class, 'lockscreen'])->name('lock-screen');
    Route::post('/manual-lock', [LockScreenController::class, 'manualLock'])->name('manual-lock');
    Route::post('/unlock', [LockScreenController::class, 'unlock'])->name('unlock');
});

Route::post('/auto_screen', [LockScreenController::class, 'autoLock'])->name('auto-lock');
Route::get('/is-locked', [LockScreenController::class, 'isLocked'])->name('is-locked');


// Public routes

Route::get('/houses/{house}', [AddHousesController::class, 'show'])->name('house.show');
Route::view('/house', 'houses-info')->name('house.view');
Route::get('/search', [PropertyController::class, 'search'])->name('property.search');
// Route::get('/property/category/{category}', [PropertyController::class, 'category'])->name('property.category');

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



Route::get('/heh',function(){
    return view('houses-info');
});