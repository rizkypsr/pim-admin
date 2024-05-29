<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $provinces = Province::all();

        $data = $provinces->map(function ($province) {
            return [
                $province->id,
                $province->province_name,
                view('components.action-buttons', [
                    'editRoute' => route('provinces.edit', $province->id),
                    'deleteRoute' => route('provinces.destroy', $province->id),
                    'showRoute' => route('provinces.show', $province->id),
                ])->render()
            ];
        });

        $config = [
            'data' => $data,
            'order' => [[1, 'asc']],
            'columns' => [null, null, ['orderable' => false]],
        ];

        $heads = [
            ['label' => 'ID', 'width' => 3],
            ['label' => 'Provinsi', 'width' => 50],
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        return view('provinces.index', compact('heads', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('provinces.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'province_name' => 'required|string|max:255',
        ];

        $messages = [
            'province_name.required' => 'Provinsi wajib diisi.',
            'string' => 'Input harus berupa text.',
            'max' => 'Inout maksimal :max karakter.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Province::create([
            'province_name' => $request->province_name,
        ]);

        return redirect()->route('provinces.index')->with('success', 'Provinsi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $province = Province::find($id);

        return view('provinces.show', compact('province'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $province = Province::find($id);

        return view('provinces.edit', compact('province'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'province_name' => 'required|string|max:255',
        ];

        $messages = [
            'province_name.required' => 'Provinsi wajib diisi.',
            'string' => 'Input harus berupa text.',
            'max' => 'Inout maksimal :max karakter.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Province::find($id)->update([
            'province_name' => $request->province_name,
        ]);

        return redirect()->route('provinces.index')->with('success', 'Provinsi berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Province::find($id)->delete();

        return redirect()->route('provinces.index')->with('success', 'Provinsi berhasil dihapus.');
    }
}
