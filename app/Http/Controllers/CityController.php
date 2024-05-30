<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::with('province')->get();

        $data = $cities->map(function ($city) {
            return [
                $city->id,
                $city->city_name,
                $city->province->province_name,
                view('components.action-buttons', [
                    'editRoute' => route('cities.edit', $city->id),
                    'deleteRoute' => route('cities.destroy', $city->id),
                    'showRoute' => route('cities.show', $city->id),
                ])->render(),
            ];
        });

        $config = [
            'data' => $data,
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, ['orderable' => false]],
        ];

        $heads = [
            ['label' => 'ID', 'width' => 3],
            ['label' => 'Kota', 'width' => 40],
            ['label' => 'Provinsi', 'width' => 40],
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        return view('cities.index', compact('heads', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::all();

        return view('cities.create', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'city_name' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,id',
        ];

        $messages = [
            'province_name.required' => 'Provinsi wajib diisi.',
            'string' => 'Input harus berupa text.',
            'max' => 'Inout maksimal :max karakter.',
            'province_id.exists' => 'Provinsi tidak ditemukan.',
            'province_id.required' => 'Provinsi wajib dipilih.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        City::create([
            'city_name' => $request->city_name,
            'province_id' => $request->province_id,
        ]);

        return redirect()->route('cities.index')->with('success', 'Kota berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $city = City::with('province')->find($id);

        return view('cities.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $city = City::with('province')->find($id);
        $provinces = Province::all();

        return view('cities.edit', compact('city', 'provinces'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'city_name' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,id',
        ];

        $messages = [
            'province_name.required' => 'Provinsi wajib diisi.',
            'string' => 'Input harus berupa text.',
            'max' => 'Inout maksimal :max karakter.',
            'province_id.exists' => 'Provinsi tidak ditemukan.',
            'province_id.required' => 'Provinsi wajib dipilih.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        City::find($id)->update([
            'city_name' => $request->city_name,
            'province_id' => $request->province_id,
        ]);

        return redirect()->route('cities.index')->with('success', 'Kota berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        City::destroy($id);

        return redirect()->route('cities.index')->with('success', 'Kota berhasil dihapus.');
    }
}
