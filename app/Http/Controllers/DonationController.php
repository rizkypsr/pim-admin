<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donations = Donation::all();

        $data = $donations->map(function ($donation) {
            return [
                $donation->id,
                $donation->title,
                $donation->subtitle,
                $donation->description,
                '<a href="' . $donation->video . '">' . $donation->video . '</a>',
                view('components.action-buttons', [
                    'editRoute' => route('donations.edit', $donation->id),
                    'deleteRoute' => route('donations.destroy', $donation->id),
                    'showRoute' => route('donations.show', $donation->id),
                ])->render()
            ];
        });

        $config = [
            'data' => $data,
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, null, null, ['orderable' => false]],
        ];

        $heads = [
            ['label' => 'ID', 'width' => 3],
            ['label' => 'Judul', 'width' => 40],
            ['label' => 'Sub Judul', 'width' => 20],
            ['label' => 'Deskripsi', 'width' => 40],
            ['label' => 'Link Video', 'width' => 20],
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        return view('donations.index', compact('heads', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('donations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'video' => 'nullable|string|max:255',
            'images' => 'max:2048'
        ];

        $messages = [
            'string' => 'Input harus berupa string.',
            'title.required' => 'Judul harus diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'subtitle.required' => 'Sub judul harus diisi.',
            'subtitle.max' => 'Sub judul maksimal 255 karakter.',
            'description.required' => 'Deskripsi harus diisi.',
            'description.max' => 'Deskripsi maksimal 255 karakter.',
            'video.max' => 'Link video maksimal 255 karakter.',
            'images.max' => 'Ukuran gambar maksimal 2MB.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $donation = Donation::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'video' => $request->video,
        ]);

        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('donations', $imageName, 'public');

                DonationImage::create([
                    'donation_id' => $donation->id,
                    'filename' => $imageName,
                ]);
            }
        }

        return redirect()->route('donations.index')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $donation = Donation::with('images')->findOrFail($id);

        $data = $donation->images->map(function ($image) {
            $path = Storage::url('donations/' . $image->filename);

            return [
                $image->id,
                '<img src="' . $path . '" alt="Donation Image" class="img-thumbnail" style="width: 100px;">',
                view('components.only-delete-button', [
                    'deleteRoute' => route('donations.destroyImage', $image->id),
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

        return view('donations.show', compact('donation', 'heads', 'config'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $donation = Donation::findOrFail($id);

        return view('donations.edit', compact('donation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'video' => 'nullable|string|max:255',
        ];

        $messages = [
            'string' => 'Input harus berupa string.',
            'title.required' => 'Judul harus diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'subtitle.required' => 'Sub judul harus diisi.',
            'subtitle.max' => 'Sub judul maksimal 255 karakter.',
            'description.required' => 'Deskripsi harus diisi.',
            'description.max' => 'Deskripsi maksimal 255 karakter.',
            'video.max' => 'Link video maksimal 255 karakter.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $donation = Donation::findOrFail($id);
        $donation->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'video' => $request->video,
        ]);

        return redirect()->route('donations.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $donation = Donation::with('images')->findOrFail($id);

        foreach ($donation->images as $donationImage) {
            $path = 'donations/' . $donationImage->filename;

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $donation->delete();

        return redirect()->route('donations.index')->with('success', 'Data berhasil dihapus.');
    }

    public function destroyImage(string $id)
    {
        $donationImage = DonationImage::findOrFail($id);
        $path = 'donations/' . $donationImage->filename;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);

            $donationImage->delete();

            return redirect()->back()->with('success', 'Gambar Donasi berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Gambar Donasi gagal dihapus.');
    }
}
