<?php

use App\Http\Controllers\Api\CarApiController;
use App\Http\Controllers\Api\CityApiController;
use App\Http\Controllers\Api\DonationApiController;
use App\Http\Controllers\Api\ProvinceApiController;
use App\Http\Controllers\Api\ServiceApiController;
use App\Http\Controllers\Api\ShowroomApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// wrap the route with a auth:sanctum middleware

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/user', function (Request $request) {
//         return $request->user();
//     });
// });

Route::get('/provinces', [ProvinceApiController::class, 'getAllProvinces']);
Route::get('/cities', [CityApiController::class, 'getAllCities']);

Route::get('/showrooms', [ShowroomApiController::class, 'getAllShowrooms']);
Route::get('/showroom/{id}', [ShowroomApiController::class, 'getShowroomById']);

Route::get('/cars', [CarApiController::class, 'getAllCars']);
Route::get('/car/{id}', [CarApiController::class, 'getCarById']);
Route::get('/car/showroom/{id}', [CarApiController::class, 'getCarByShowroomId']);

Route::get('/donations', [DonationApiController::class, 'getAllDonations']);
Route::get('/donation/{id}', [DonationApiController::class, 'getDonationById']);

Route::post('/service', [ServiceApiController::class, 'store']);

Route::get('/test', function () {
    return response()->json(['message' => 'Test successful']);
});
