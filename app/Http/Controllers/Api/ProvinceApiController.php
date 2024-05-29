<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Province;

class ProvinceApiController extends Controller
{
    public function getAllProvinces()
    {
        try {
            $provinces = Province::all();

            return ApiResponse::success($provinces);
        } catch (\Exception $e) {
            return ApiResponse::error('Internal Server Error', 500, 'Terjadi kesalahan pada server saat mengambil data provinsi.');
        }
    }
}
