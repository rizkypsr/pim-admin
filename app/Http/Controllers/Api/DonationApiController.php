<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Donation;

class DonationApiController extends Controller
{
    public function getAllDonations()
    {
        try {
            $donations = Donation::with('images')->get();

            return ApiResponse::success($donations);
        } catch (\Exception $e) {
            return ApiResponse::error('Internal Server Error', 500, 'Terjadi kesalahan pada server saat mengambil data donasi.');
        }
    }

    public function getDonationById($id)
    {
        try {
            $donation = Donation::with('images')->find($id);

            if (! $donation) {
                return ApiResponse::error('Not Found', 404, 'Data donasi tidak ditemukan.');
            }

            return ApiResponse::success($donation);
        } catch (\Exception $e) {
            return ApiResponse::error('Internal Server Error', 500, 'Terjadi kesalahan pada server saat mengambil data donasi.');
        }
    }
}
