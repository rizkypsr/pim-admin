<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $faqs = Faq::all();

        $data = $faqs->map(function ($faq) {
            return [
                $faq->id,
                $faq->name,
                $faq->value,
                view('components.action-buttons', [
                    'editRoute' => route('faqs.edit', $faq->id),
                    'deleteRoute' => route('faqs.destroy', $faq->id),
                ])->render()
            ];
        });

        $config = [
            'data' => $data,
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, null],
        ];

        $heads = [
            ['label' => 'ID', 'width' => 3],
            ['label' => 'Nama', 'width' => 40],
            ['label' => 'Data', 'width' => 40],
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];


        return view("faqs.index", compact('heads', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:faqs',
            'value' => 'required|string|max:255',
        ];

        $messages = [
            'name.required' => 'Nama wajib diisi.',
            'value.required' => 'Nilai wajib diisi.',
            'name.unique' => 'Nama sudah ada.',
            'string' => 'Input harus berupa text.',
            'max' => 'Inout maksimal :max karakter.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Faq::create([
            'name' => $request->name,
            'value' => $request->value,
        ]);

        return redirect()->route('faqs.index')->with('success', 'Faq berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $faq = Faq::findOrFail($id);

        return view('faqs.show', compact('faq'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $faq = Faq::findOrFail($id);

        return view('faqs.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ];

        $messages = [
            'name.required' => 'Nama wajib diisi.',
            'value.required' => 'Nilai wajib diisi.',
            'name.unique' => 'Nama sudah ada.',
            'string' => 'Input harus berupa text.',
            'max' => 'Inout maksimal :max karakter.',
        ];

        // check if user dont change the name then it will not check the unique rule
        if (Faq::find($id)->name != $request->name) {
            $rules['name'] = 'required|string|max:255|unique:faqs';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Faq::find($id)->update([
            'name' => $request->name,
            'value' => $request->value,
        ]);

        return redirect()->route('faqs.index')->with('success', 'Faq berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Faq::destroy($id);

        return redirect()->route('faqs.index')->with('success', 'Faq berhasil dihapus.');
    }
}
