<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'service_type' => 'required|string|max:255',
            'car_description' => 'required|string|max:255',
        ];

        $messages = [
            'city_id.required' => 'Kota wajib dipilih.',
            'city_id.exists' => 'Kota tidak ditemukan.',
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'address.string' => 'Alamat harus berupa teks.',
            'address.max' => 'Alamat maksimal 255 karakter.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.string' => 'Nomor telepon harus berupa teks.',
            'phone.max' => 'Nomor telepon maksimal 255 karakter.',
            'service_type.required' => 'Tipe layanan wajib diisi.',
            'service_type.string' => 'Tipe layanan harus berupa teks.',
            'car_description.required' => 'Deskripsi mobil wajib diisi.',
            'car_description.string' => 'Deskripsi mobil harus berupa teks.',
            'car_description.max' => 'Deskripsi mobil maksimal 255 karakter.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return ApiResponse::error('Pastikan semua data terisi dengan benar.', 422, $validator->errors());
        }

        try {
            $service = Service::create([
                'city_id' => $request->city_id,
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'service_type' => $request->service_type,
                'car_description' => $request->car_description,
            ]);

            return ApiResponse::success('Data layanan berhasil dikirim.');
        } catch (\Exception $e) {
            return ApiResponse::error('Internal Server Error', 500, 'Terjadi kesalahan pada server saat menambahkan data layanan. '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
