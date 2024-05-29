<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\City;

class CityApiController extends Controller
{
    public function getAllCities()
    {
        try {
            $cities = City::with('province')->get();

            return ApiResponse::success($cities);
        } catch (\Exception $e) {
            return ApiResponse::error('Internal Server Error', 500, 'Terjadi kesalahan pada server saat mengambil data kota.');
        }
    }
}
