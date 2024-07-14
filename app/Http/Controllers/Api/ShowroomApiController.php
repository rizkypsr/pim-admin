<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShowroomResource;
use App\Models\Showroom;

class ShowroomApiController extends Controller
{
    public function getAllShowrooms()
    {
        try {
            $showrooms = Showroom::filter()->sort()->get();

            $showroomsCollection = ShowroomResource::collection($showrooms);

            return ApiResponse::success($showroomsCollection);
        } catch (\Exception $e) {
            return ApiResponse::error('Internal Server Error', 500, 'Terjadi kesalahan pada server saat mengambil data showroom. '.$e->getMessage());
        }
    }

    public function getShowroomById($id)
    {
        try {
            $showroom = Showroom::find($id);

            if (! $showroom) {
                return ApiResponse::error('Not Found', 404, 'Data showroom tidak ditemukan.');
            }

            $showroomResource = new ShowroomResource($showroom);

            return ApiResponse::success($showroomResource);
        } catch (\Exception $e) {
            return ApiResponse::error('Internal Server Error', 500, 'Terjadi kesalahan pada server saat mengambil data showroom.');
        }
    }
}
