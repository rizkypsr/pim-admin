@extends('adminlte::page')

@section('title', 'Tambah Mobil')

@section('content_header')
    <h1>Tambah Mobil</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <x-adminlte-input name="car_name" label="Nama Mobil" placeholder="Nama Mobil" fgroup-class="col-md-3"
                        enable-old-support value="{{ old('car_name') }}" />
                    <x-adminlte-input name="brand_name" label="Merk Mobil" placeholder="Merk Mobil" fgroup-class="col-md-3"
                        enable-old-support value="{{ old('brand_name') }}" />
                    <x-adminlte-input type="number" name="year" label="Tahun Mobil" placeholder="Tahun Mobil"
                        fgroup-class="col-md-3" min="1900" max="{{ date('Y') }}" enable-old-support
                        value="{{ old('year') }}" />
                    <x-adminlte-input type="number" name="price" label="Harga Mobil" placeholder="Harga Mobil"
                        fgroup-class="col-md-3" enable-old-support value="{{ old('price') }}" />
                </div>

                <div class="row">
                    <x-adminlte-input-file id="images" name="images[]" label="Upload Gambar" fgroup-class="col-md-4"
                        placeholder="Choose multiple files..." legend="Choose" multiple>
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-file-upload"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-file>
                    <x-adminlte-input type="number" name="whatsapp_number" label="Nomor WA" placeholder="ex. 089884..."
                        fgroup-class="col-md-4" enable-old-support value="{{ old('whatsapp_number') }}" />
                    <x-adminlte-select2 name="city_id" label="Kota" fgroup-class="col-md-4" enable-old-support>
                        <option value="" disabled selected>Pilih Kota</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
                <div class="row">
                    <x-adminlte-input name="video" label="Youtube Video" placeholder="Youtube Video"
                        fgroup-class="col-md-6" enable-old-support value="{{ old('video') }}" />
                    <x-adminlte-input name="general_video" label="General Video" placeholder="General Video"
                        fgroup-class="col-md-6" enable-old-support value="{{ old('general_video') }}" />
                </div>
                <div class="row">
                    <x-adminlte-textarea label="Deskripsi" name="description" placeholder="Masukan deskripsi..."
                        fgroup-class="col-md-12" enable-old-support value="{{ old('description') }}" />
                </div>
            </div>
            <div class="card-footer">
                <x-adminlte-button type="submit" label="Simpan" theme="primary" />
                <a href={{ route('cars.index') }}>
                    <x-adminlte-button label="Batal" />
                </a>
            </div>
        </form>
    </div>
@stop
