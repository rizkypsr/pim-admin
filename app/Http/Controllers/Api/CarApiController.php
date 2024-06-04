<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Models\Car;

class CarApiController extends Controller
{
    public function getAllCars()
    {
        try {
            $cars = Car::filter()->sort()->whereNull('showroom_id')->get();
            $carsCollection = CarResource::collection($cars);

            return ApiResponse::success($carsCollection);
        } catch (\Exception $e) {
            return ApiResponse::error('Internal Server Error', 500, 'Terjadi kesalahan pada server saat mengambil data mobil.'.$e->getMessage());
        }
    }

    public function getCarById($id)
    {
        try {
            $car = Car::find($id);

            if (! $car) {
                return ApiResponse::error('Not Found', 404, 'Data mobil tidak ditemukan.');
            }

            $carResource = new CarResource($car);

            return ApiResponse::success($carResource);
        } catch (\Exception $e) {
            return ApiResponse::error('Internal Server Error', 500, 'Terjadi kesalahan pada server saat mengambil data mobil.');
        }
    }

    public function getCarByShowroomId($id)
    {
        try {
            $car = Car::with(['showroom', 'carImages'])->where('showroom_id', $id)->get();

            if (! $car) {
                return ApiResponse::error('Not Found', 404, 'Data mobil tidak ditemukan.');
            }

            return ApiResponse::success($car);
        } catch (\Exception $e) {
            return ApiResponse::error('Internal Server Error', 500, 'Terjadi kesalahan pada server saat mengambil data mobil.');
        }
    }
}
