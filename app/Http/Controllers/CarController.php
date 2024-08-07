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
    public function index(Request $request)
    {

        $params = [
            'price' => [
                '$gte' => $request->min_price,
                '$lte' => $request->max_price,
            ],
            'car_name' => ['$contains' => $request->car_name],
            'brand_name' => ['$contains' => $request->brand_name],
        ];

        if ($request->from_year || $request->to_year) {
            $params['year'] = [
                '$gte' => $request->from_year,
                '$lte' => $request->to_year,
            ];
        }

        if ($request->city_id) {
            $params['city_id'] = ['$eq' => $request->city_id];
        }

        $cars = Car::with(['showroom', 'city'])->whereNull('showroom_id')->filter($params)->get();

        $data = $cars->map(function ($car) {
            return [
                $car->id,
                $car->car_name,
                $car->brand_name,
                $car->description,
                RupiahFormat::currency($car->price),
                $car->year,
                $car->whatsapp_number ?? '-',
                $car->city->city_name ?? '-',
                $car->video ? '<a href="'.$car->video.'" target="_blank">Lihat</a>' : '-',
                $car->general_video ? '<a href="'.$car->general_video.'" target="_blank">Lihat</a>' : '-',
                view('components.switch-button', [
                    'carId' => $car->id,
                    'share' => $car->share,
                ])->render(),
                view('components.action-buttons', [
                    'editRoute' => route('cars.edit', $car->id),
                    'deleteRoute' => route('cars.destroy', $car->id),
                    'showRoute' => route('cars.show', $car->id),
                ])->render(),
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
                null,
                ['orderable' => false],
                ['orderable' => false],
                null,
                ['orderable' => false],
                ['orderable' => false],
                ['orderable' => false],
            ],
        ];

        $heads = [
            ['label' => 'ID'],
            ['label' => 'Nama Mobil', 'width' => '12'],
            ['label' => 'Merk Mobil', 'width' => '12'],
            ['label' => 'Deskripsi', 'width' => '20'],
            ['label' => 'Harga', 'width' => '15'],
            ['label' => 'Tahun'],
            ['label' => 'Nomor WA'],
            ['label' => 'Kota'],
            ['label' => 'Youtube Video'],
            ['label' => 'Video'],
            ['label' => 'Share', 'no-export' => true],
            ['label' => 'Actions', 'no-export' => true],
        ];

        $cities = City::all();

        return view('cars.index', compact('heads', 'config', 'cities'));
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
            'description' => 'required|string|max:1024',
            'price' => 'required|numeric',
            'video' => 'required|string',
            'general_video' => 'required|string',
            'year' => 'required|numeric|digits:4',
            'whatsapp_number' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'images' => 'max:2048',
        ];

        $messages = [
            'string' => 'Input harus berupa text.',
            'max' => 'Input maksimal :max karakter.',
            'car_name.required' => 'Nama Mobil wajib diisi.',
            'description.required' => 'Deskripsi wajib diisi.',
            'brand_name.required' => 'Merk Mobil wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'video.required' => 'Link Video wajib diisi.',
            'general_video.required' => 'Link Video wajib diisi.',
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
            'general_video' => $request->general_video,
            'year' => $request->year,
            'city_id' => $request->city_id,
            'whatsapp_number' => $request->whatsapp_number,
        ]);

        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $imageName = time().'_'.$image->getClientOriginalName();
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
            $path = Storage::url('cars/'.$car->filename);

            return [
                $car->id,
                '<img src="'.$path.'" alt="Car Image" class="img-thumbnail" style="width: 100px;">',
                view('components.only-delete-button', [
                    'deleteRoute' => route('cars.destroyImage', $car->id),
                ])->render(),
            ];
        });

        $config = [
            'data' => $data,
            'searching' => false,
            'columns' => [
                null,
                ['orderable' => false],
                ['orderable' => false],
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
            'description' => 'required|string|max:1024',
            'price' => 'required|numeric',
            'video' => 'required|string',
            'general_video' => 'required|string',
            'year' => 'required|numeric|digits:4',
            'images' => 'max:2048',
            'whatsapp_number' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
        ];

        $messages = [
            'string' => 'Input harus berupa text.',
            'max' => 'Input maksimal :max karakter.',
            'description.required' => 'Deskripsi wajib diisi.',
            'car_name.required' => 'Nama Mobil wajib diisi.',
            'brand_name.required' => 'Merk Mobil wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'video.required' => 'Link Video wajib diisi.',
            'general_video.required' => 'Link Video wajib diisi.',
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
            'description' => $request->description,
            'price' => $request->price,
            'video' => $request->video,
            'general_video' => $request->general_video,
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
            $path = 'cars/'.$carImage->filename;

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $car->delete();

        return redirect()->back()->with('success', 'Mobil berhasil dihapus.');
    }

    public function destroyImage(string $id)
    {
        try {
            $carImage = CarImage::findOrFail($id);
            $path = 'cars/'.$carImage->filename;

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            $carImage->delete();

            return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gambar gagal dihapus.');
        }
    }

    public function createCarImage(string $id)
    {
        return view('cars.create_image', compact('id'));
    }

    public function storeCarImage(Request $request)
    {
        $rules = [
            'images' => 'required|max:2048',
            'car_id' => 'required|exists:cars,id',
        ];

        $messages = [
            'images.required' => 'Gambar wajib dipilih.',
            'images.max' => 'Ukuran gambar maksimal 2MB.',
            'car_id.required' => 'Mobil wajib dipilih.',
            'car_id.exists' => 'Mobil tidak ditemukan.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $car = Car::findOrFail($request->car_id);

        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $imageName = time().'_'.$image->getClientOriginalName();
                $image->storeAs('cars', $imageName, 'public');

                CarImage::create([
                    'car_id' => $car->id,
                    'filename' => $imageName,
                ]);
            }
        }

        return redirect()->route('cars.show', $request->car_id)->with('success', 'Gambar berhasil ditambahkan.');
    }

    public function updateShare(Request $request, string $id)
    {

        try {
            $car = Car::findOrFail($id);
            $car->update([
                'share' => $request->share,
            ]);

            return redirect()->back()->with('success', 'Share berhasil diperbarui.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the case where the car is not found
            return redirect()->back()->with('error', 'Mobil tidak ditemukan.');
        }
    }
}
