<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\SpaceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Models\Space;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserBookingController::class,'create']);
Route::post('/book', [UserBookingController::class,'store'])->name('user.book.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified','admin'])->name('dashboard');

Route::middleware(['auth','admin'])->group(function () {

    Route::resource('spaces', SpaceController::class);
    Route::resource('bookings', BookingController::class);
    Route::get('/getDays/{id}', [BookingController::class,'getDays']);
    
    Route::get('/changestatus', [BookingController::class,'status'])->name('change-status');
    Route::get('/search', [BookingController::class,'search'])->name('search');

});






require __DIR__.'/auth.php';
