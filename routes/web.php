<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\CarImageController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ShowroomController;
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

Auth::routes();

// wrap all routes with auth middleware
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('provinces', ProvinceController::class);
    Route::resource('cities', CityController::class);
    Route::resource('showrooms', ShowroomController::class);
    Route::resource('cars', CarController::class);
    Route::resource('carImage', CarImageController::class);
    Route::resource('donations', DonationController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('services', ServiceController::class);

    Route::get('showrooms/car/create/{id}', [ShowroomController::class, 'createCar'])->name('showrooms.createCar');
    Route::post('showrooms/car/store', [ShowroomController::class, 'storeCar'])->name('showrooms.storeCar');
    Route::get('showrooms/car/edit/{id}', [ShowroomController::class, 'editCar'])->name('showrooms.editCar');
    Route::put('showrooms/car/update/{id}', [ShowroomController::class, 'updateCar'])->name('showrooms.updateCar');
    Route::delete('showrooms/image/delete/{id}', [ShowroomController::class, 'destroyImage'])->name('showrooms.destroyImage');
    Route::get('showrooms/image/create/{id}', [ShowroomController::class, 'createShowroomImage'])->name('showrooms.createImage');
    Route::post('showrooms/image/store', [ShowroomController::class, 'storeShowroomImage'])->name('showrooms.storeImage');

    Route::get('cars/image/create/{id}', [CarController::class, 'createCarImage'])->name('cars.createImage');
    Route::post('cars/image/store', [CarController::class, 'storeCarImage'])->name('cars.storeImage');
    Route::delete('cars/image/delete/{id}', [CarController::class, 'destroyImage'])->name('cars.destroyImage');

    Route::get('donations/image/create/{id}', [DonationController::class, 'createDonationImage'])->name('donations.createImage');
    Route::post('donations/image/store', [DonationController::class, 'storeDonationImage'])->name('donations.storeImage');
    Route::delete('donations/image/delete/{id}', [DonationController::class, 'destroyImage'])->name('donations.destroyImage');

    Route::get('/notification', [PushNotificationController::class, 'index'])->name('notification.index');
    Route::post('/send-notification', [PushNotificationController::class, 'sendPushNotification'])->name('notification.send');
});
