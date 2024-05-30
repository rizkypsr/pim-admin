<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarImage;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Laraindo\RupiahFormat;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::with(['showroom', 'city'])->whereNull('showroom_id')->filter()->get();

        $data = $cars->map(function ($car) {
            return [
                $car->id,
                $car->car_name,
                $car->brand_name,
                RupiahFormat::currency($car->price),
                $car->year,
                $car->whatsapp_number ?? "-",
                $car->city->city_name ?? "-",
                '<a href="' . $car->video . '" target="_blank">' . $car->video . '</a>',
                view('components.action-buttons', [
                    'editRoute' => route('cars.edit', $car->id),
                    'deleteRoute' => route('cars.destroy', $car->id),
                    'showRoute' => route('cars.show', $car->id),
                ])->render()
            ];
        });

        $config = [
            'data' => $data,
            'columns' => [
                null,
                null,
                null,
                null,
                null,
                ['orderable' => false],
                null,
                ['orderable' => false],
                ['orderable' => false]
            ],
        ];


        $heads = [
            ['label' => 'ID', 'width' => 3],
            ['label' => 'Nama Mobil', 'width' => 20],
            ['label' => 'Merk Mobil', 'width' => 15],
            ['label' => 'Harga', 'width' => 20],
            ['label' => 'Tahun', 'width' => 10],
            ['label' => 'Nomor WA', 'width' => 10],
            ['label' => 'Kota', 'width' => 10],
            ['label' => 'Link Video', 'width' => 5],
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        return view('cars.index', compact('heads', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::all();

        return view('cars.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'car_name' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'video' => 'required|string|max:255',
            'year' => 'required|numeric|digits:4',
            'whatsapp_number' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'images' => 'max:2048'
        ];

        $messages = [
            'string' => 'Input harus berupa text.',
            'max' => 'Input maksimal :max karakter.',
            'car_name.required' => 'Nama Mobil wajib diisi.',
            'description.required' => 'Deskripsi wajib diisi.',
            'brand_name.required' => 'Merk Mobil wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'video.required' => 'Link Video wajib diisi.',
            'year.required' => 'Tahun Mobil wajib diisi.',
            'year.numeric' => 'Tahun Mobil harus berupa angka.',
            'year.digits' => 'Tahun Mobil harus 4 digit.',
            'city_id.required' => 'Kota wajib diisi.',
            'city_id.exists' => 'Kota tidak ditemukan.',
            'images.max' => 'Ukuran gambar maksimal 2MB.',
            'whatsapp_number.required' => 'Nomor WA wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $car = Car::create([
            'car_name' => $request->car_name,
            'brand_name' => $request->brand_name,
            'description' => $request->description,
            'price' => $request->price,
            'video' => $request->video,
            'year' => $request->year,
            'city_id' => $request->city_id,
            'whatsapp_number' => $request->whatsapp_number,
        ]);

        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('cars', $imageName, 'public');

                CarImage::create([
                    'car_id' => $car->id,
                    'filename' => $imageName,
                ]);
            }
        }

        return redirect()->route('cars.index')->with('success', 'Mobil berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = Car::with('showroom', 'carImages')->findOrFail($id);

        $carImages = CarImage::where('car_id', $id)->get();

        $data = $carImages->map(function ($car) {
            $path = Storage::url('cars/' . $car->filename);

            return [
                $car->id,
                '<img src="' . $path . '" alt="Car Image" class="img-thumbnail" style="width: 100px;">',
                view('components.only-delete-button', [
                    'deleteRoute' => route('cars.destroyImage', $car->id),
                ])->render()
            ];
        });

        $config = [
            'data' => $data,
            'searching' => false,
            'columns' => [
                null,
                ['orderable' => false],
                ['orderable' => false]
            ],
        ];


        $heads = [
            ['label' => 'ID', 'width' => 1],
            ['label' => 'Gambar', 'width' => 20],
            ['label' => 'Actions', 'no-export' => true, 'width' => 1],
        ];

        $num = 14000000;

        return view('cars.show', compact('car', 'heads', 'config', 'num'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $car = Car::findOrFail($id);
        $cities = City::all();

        return view('cars.edit', compact('car', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'car_name' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'video' => 'required|string|max:255',
            'year' => 'required|numeric|digits:4',
            'images' => 'max:2048',
            'whatsapp_number' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
        ];

        $messages = [
            'string' => 'Input harus berupa text.',
            'max' => 'Input maksimal :max karakter.',
            'car_name.required' => 'Nama Mobil wajib diisi.',
            'brand_name.required' => 'Merk Mobil wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'video.required' => 'Link Video wajib diisi.',
            'year.required' => 'Tahun Mobil wajib diisi.',
            'year.numeric' => 'Tahun Mobil harus berupa angka.',
            'year.digits' => 'Tahun Mobil harus 4 digit.',
            'images.max' => 'Ukuran gambar maksimal 2MB.',
            'whatsapp_number.required' => 'Nomor WA wajib diisi.',
            'city_id.required' => 'Kota wajib diisi.',
            'city_id.exists' => 'Kota tidak ditemukan.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $car = Car::findOrFail($id);
        $car->update([
            'car_name' => $request->car_name,
            'brand_name' => $request->brand_name,
            'price' => $request->price,
            'video' => $request->video,
            'year' => $request->year,
            'showroom_id' => $request->showroom_id,
            'whatsapp_number' => $request->whatsapp_number,
            'city_id' => $request->city_id,
        ]);

        return redirect()->route('cars.index')->with('success', 'Mobil berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Car::with('carImages')->findOrFail($id);

        foreach ($car->carImages as $carImage) {
            $path = 'cars/' . $carImage->filename;

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $car->delete();

        return redirect()->back()->with('success', 'Mobil berhasil dihapus.');
    }

    public function destroyImage(string $id)
    {
        $carImage = CarImage::findOrFail($id);

        $path = 'cars/' . $carImage->filename;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);

            $carImage->delete();

            return redirect()->back()->with('success', 'Gambar Mobil berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Gambar Mobil gagal dihapus.');
    }
}
