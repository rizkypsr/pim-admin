<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarApiController extends Controller
{
    public function getAllCars()
    {
        try {
            $cars = Car::filter()->with(['showroom', 'carImages', 'showroom.showroomImages', 'showroom.city'])->sort()->get();

            return ApiResponse::success($cars);
        } catch (\Exception $e) {
            return ApiResponse::error('Internal Server Error', 500, 'Terjadi kesalahan pada server saat mengambil data mobil.');
        }
    }

    public function getCarById($id)
    {
        try {
            $car = Car::with(['showroom', 'carImages'])->find($id);

            if (!$car) {
                return ApiResponse::error('Not Found', 404, 'Data mobil tidak ditemukan.');
            }

            return ApiResponse::success($car);
        } catch (\Exception $e) {
            return ApiResponse::error('Internal Server Error', 500, 'Terjadi kesalahan pada server saat mengambil data mobil.');
        }
    }

    public function getCarByShowroomId($id)
    {
        try {
            $car = Car::with(['showroom', 'carImages'])->where('showroom_id', $id)->get();

            if (!$car) {
                return ApiResponse::error('Not Found', 404, 'Data mobil tidak ditemukan.');
            }

            return ApiResponse::success($car);
        } catch (\Exception $e) {
            return ApiResponse::error('Internal Server Error', 500, 'Terjadi kesalahan pada server saat mengambil data mobil.');
        }
    }
}
