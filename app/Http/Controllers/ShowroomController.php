<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarImage;
use App\Models\City;
use App\Models\Showroom;
use App\Models\ShowroomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Laraindo\RupiahFormat;

class ShowroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $showrooms = Showroom::with('city')->get();

        $data = $showrooms->map(function ($showroom) {
            return [
                $showroom->id,
                $showroom->showroom_name,
                $showroom->video,
                '<a href="https://wa.me/' . "62" . substr($showroom->whatsapp_number, 1) . '" target="_blank">' . $showroom->whatsapp_number . '</a>',
                $showroom->city->city_name,
                view('components.action-buttons', [
                    'editRoute' => route('showrooms.edit', $showroom->id),
                    'deleteRoute' => route('showrooms.destroy', $showroom->id),
                    'showRoute' => route('showrooms.show', $showroom->id),
                ])->render()
            ];
        });

        $config = [
            'data' => $data,
            'columns' => [null, null, ['orderable' => false], ['orderable' => false], null, ['orderable' => false]],
        ];

        $heads = [
            ['label' => 'ID', 'width' => 3],
            ['label' => 'Showroom', 'width' => 30],
            ['label' => 'Video', 'width' => 10],
            ['label' => 'Nomor WA', 'width' => 10],
            ['label' => 'Kota', 'width' => 10],
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        return view('showrooms.index', compact('heads', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::all();

        return view('showrooms.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'showroom_name' => 'required|string|max:255',
            'video' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'images' => 'max:2048'
        ];

        $messages = [
            'showroom_name.required' => 'Showroom wajib diisi.',
            'string' => 'Input harus berupa text.',
            'max' => 'Input maksimal :max karakter.',
            'city_id.exists' => 'Kota tidak ditemukan.',
            'city_id.required' => 'Kota wajib dipilih.',
            'video.required' => 'Video wajib diisi.',
            'whatsapp_number.required' => 'Nomor WA wajib diisi.',
            'images.max' => 'Ukuran gambar maksimal 2MB.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $showroom = Showroom::create([
            'showroom_name' => $request->showroom_name,
            'video' => $request->video,
            'whatsapp_number' => $request->whatsapp_number,
            'city_id' => $request->city_id,
        ]);

        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('showroom', $imageName, 'public');

                ShowroomImage::create([
                    'showroom_id' => $showroom->id,
                    'filename' => $imageName,
                ]);
            }
        }

        return redirect()->route('showrooms.index')->with('success', 'Showroom berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $showroom = Showroom::with('city', 'showroomImages', 'cars')->findOrFail($id);

        $data = $showroom->cars->map(function ($car) {
            return [
                $car->id,
                $car->car_name,
                $car->brand_name,
                RupiahFormat::currency($car->price),
                $car->year,
                $car->whatsapp_number ?? "-",
                '<a href="' . $car->video . '" target="_blank">' . $car->video . '</a>',
                view('components.action-buttons', [
                    'editRoute' => route('showrooms.editCar', $car->id),
                    'deleteRoute' => route('cars.destroy', $car->id),
                    'showRoute' => route('cars.show', $car->id),
                ])->render()
            ];
        });

        $config = [
            'data' => $data,
            'order' => [[1, 'asc']],
            'columns' => [
                null,
                null,
                null,
                null,
                null,
                ['orderable' => false],
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
            ['label' => 'Link Video', 'width' => 5],
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        $dataImage = $showroom->showroomImages->map(function ($showroom) {
            $path = Storage::url('showroom/' . $showroom->filename);

            return [
                $showroom->id,
                '<img src="' . $path . '" alt="Gambar Showroom" class="img-thumbnail" style="width: 100px;">',
                view('components.only-delete-button', [
                    'deleteRoute' => route('showrooms.destroyImage', $showroom->id),
                ])->render()
            ];
        });

        $configImage = [
            'data' => $dataImage,
            'searching' => false,
            'columns' => [
                null,
                ['orderable' => false],
                ['orderable' => false]
            ],
        ];

        $headsImage = [
            ['label' => 'ID', 'width' => 1],
            ['label' => 'Gambar', 'width' => 20],
            ['label' => 'Actions', 'no-export' => true, 'width' => 1],
        ];

        return view('showrooms.show', compact('showroom', 'heads', 'config', 'headsImage', 'configImage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cities = City::all();
        $showroom = Showroom::with('city')->findOrFail($id);

        return view('showrooms.edit', compact('cities', 'showroom'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'showroom_name' => 'required|string|max:255',
            'video' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
        ];

        $messages = [
            'showroom_name.required' => 'Showroom wajib diisi.',
            'string' => 'Input harus berupa text.',
            'max' => 'Input maksimal :max karakter.',
            'city_id.exists' => 'Kota tidak ditemukan.',
            'city_id.required' => 'Kota wajib dipilih.',
            'video.required' => 'Video wajib diisi.',
            'whatsapp_number.required' => 'Nomor WA wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $showroom = Showroom::findOrFail($id);
        $showroom->update([
            'showroom_name' => $request->showroom_name,
            'video' => $request->video,
            'whatsapp_number' => $request->whatsapp_number,
            'city_id' => $request->city_id,
        ]);

        return redirect()->route('showrooms.index')->with('success', 'Showroom berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $showroom = Showroom::with('showroomImages')->findOrFail($id);

        foreach ($showroom->showroomImages as $showroomImage) {
            $path = 'showroom/' . $showroomImage->filename;

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $showroom->delete();

        return redirect()->back()->with('success', 'Showroom berhasil dihapus.');
    }

    public function destroyImage(string $id)
    {
        $showroomImage = ShowroomImage::findOrFail($id);

        $path = 'showroom/' . $showroomImage->filename;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);


            $showroomImage->delete();

            return redirect()->back()->with('success', 'Gambar Showroom berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Gambar Showroom gagal dihapus.');
    }

    public function createCar(string $id)
    {
        return view('showrooms.create_car', compact('id'));
    }

    public function storeCar(Request $request)
    {
        $rules = [
            'car_name' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'video' => 'required|string|max:255',
            'year' => 'required|numeric|digits:4',
            'whatsapp_number' => 'required|string|max:255',
            'showroom_id' => 'required|exists:showrooms,id',
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
            'images.max' => 'Ukuran gambar maksimal 2MB.',
            'showroom_id.required' => 'Showroom wajib dipilih.',
            'showroom_id.exists' => 'Showroom tidak ditemukan.',
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
            'whatsapp_number' => $request->whatsapp_number,
            'showroom_id' => $request->showroom_id,
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

        return redirect()->route('showrooms.show', $request->showroom_id)->with('success', 'Mobil berhasil ditambahkan.');
    }

    public function editCar(string $id)
    {
        $car = Car::with('showroom')->findOrFail($id);
        $showrooms = Showroom::all();

        return view('showrooms.edit_car', compact('car', 'showrooms'));
    }

    public function updateCar(Request $request, string $id)
    {
        $rules = [
            'car_name' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'video' => 'required|string|max:255',
            'year' => 'required|numeric|digits:4',
            'whatsapp_number' => 'required|string|max:255',
            'showroom_id' => 'required',
        ];

        $car = Car::findOrFail($id);

        if ($request->showroom_id != $car->showroom_id) {
            $rules['showroom_id'] = 'required|exists:showrooms,id';
        }

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
            'showroom_id.required' => 'Showroom wajib dipilih.',
            'showroom_id.exists' => 'Showroom tidak ditemukan.',
            'whatsapp_number.required' => 'Nomor WA wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            dd($validator->errors());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $car->update([
            'car_name' => $request->car_name,
            'brand_name' => $request->brand_name,
            'description' => $request->description,
            'price' => $request->price,
            'video' => $request->video,
            'year' => $request->year,
            'whatsapp_number' => $request->whatsapp_number,
            'showroom_id' => $request->showroom_id,
        ]);


        return redirect()->route('showrooms.show', $request->showroom_id)->with('success', 'Mobil berhasil diubah.');
    }
}
