<?php

namespace App\Http\Controllers;

use App\Helpers\ServiceType;
use App\Helpers\WhatsappFormat;
use App\Models\City;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();

        $data = $services->map(function ($service) {
            $actionViews = [
                'deleteRoute' => route('services.destroy', $service->id),
            ];

            if ($service->status == 'pending') {
                $actionViews['approveRoute'] = route('services.update', $service->id);
            }

            return [
                $service->id,
                ServiceType::getLabel($service->service_type),
                $service->name,
                $service->city->city_name,
                $service->address,
                WhatsappFormat::formatHtml($service->phone),
                $service->car_description,
                ServiceType::getStatus($service->status),
                view('components.action-buttons', $actionViews)->render(),
            ];
        });

        $config = [
            'data' => $data,
            'columns' => [
                null,
                null,
                null,
                null,
                ['orderable' => false],
                ['orderable' => false],
                ['orderable' => false],
                null,
                null,
            ],
        ];

        $heads = [
            ['label' => 'ID', 'width' => 3],
            ['label' => 'Jenis Layanan', 'width' => 10],
            ['label' => 'Nama', 'width' => 20],
            ['label' => 'Kota', 'width' => 10],
            ['label' => 'Alamat', 'width' => 20],
            ['label' => 'No Hp', 'width' => 10],
            ['label' => 'Deskripsi Mobil', 'width' => 40],
            ['label' => 'Status', 'width' => 10],
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        return view('services.index', compact('heads', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::all();

        return view('services.create', compact('cities'));
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
            'car_description' => 'required|string|max:255',
            'service_type' => 'required|string|max:255',
        ];

        $messages = [
            'city_id.required' => 'Kota wajib diisi.',
            'city_id.exists' => 'Kota tidak valid.',
            'name.required' => 'Nama wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'phone.required' => 'No Hp wajib diisi.',
            'car_description.required' => 'Deskripsi Mobil wajib diisi.',
            'service_type.required' => 'Jenis Layanan wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Service::create([
                'city_id' => $request->city_id,
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'car_description' => $request->car_description,
                'service_type' => $request->service_type,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan layanan.');
        }

        return redirect()->route('services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $service = Service::findOrFail($id);

            $service->update([
                'status' => 'finished',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah status layanan.');
        }

        return redirect()->route('services.index')->with('success', 'Berhasil mengubah status layanan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Service::destroy($id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus layanan.');
        }

        return redirect()->route('services.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
