<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DonationResource;
use App\Models\Donation;

class DonationApiController extends Controller
{
    public function getAllDonations()
    {
        try {
            $donations = Donation::all();
            $donationsResource = DonationResource::collection($donations);

            return ApiResponse::success($donationsResource);
        } catch (\Exception $e) {
            return ApiResponse::error('Internal Server Error', 500, 'Terjadi kesalahan pada server saat mengambil data donasi.');
        }
    }

    public function getDonationById($id)
    {
        try {
            $donation = Donation::find($id);

            if (! $donation) {
                return ApiResponse::error('Not Found', 404, 'Data donasi tidak ditemukan.');
            }

            $donationResource = new DonationResource($donation);

            return ApiResponse::success($donationResource);
        } catch (\Exception $e) {
            return ApiResponse::error('Internal Server Error', 500, 'Terjadi kesalahan pada server saat mengambil data donasi.');
        }
    }
}
