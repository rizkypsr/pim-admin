<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Showroom;

class ShowroomApiController extends Controller
{
    public function getAllShowrooms()
    {
        try {
            $showrooms = Showroom::with(['city', 'city.province', 'showroomImages', 'cars'])->get();

            return ApiResponse::success($showrooms);
        } catch (\Exception $e) {
            return ApiResponse::error('Internal Server Error', 500, 'Terjadi kesalahan pada server saat mengambil data showroom.');
        }
    }

    public function getShowroomById($id)
    {
        try {
            $showroom = Showroom::with(['city', 'showroomImages', 'cars'])->find($id);

            if (! $showroom) {
                return ApiResponse::error('Not Found', 404, 'Data showroom tidak ditemukan.');
            }

            return ApiResponse::success($showroom);
        } catch (\Exception $e) {
            return ApiResponse::error('Internal Server Error', 500, 'Terjadi kesalahan pada server saat mengambil data showroom.');
        }
    }
}
