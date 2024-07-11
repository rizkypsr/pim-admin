@extends('adminlte::page')

@section('title', 'Ubah Mobil')

@section('content_header')
    <h1>Ubah Mobil</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('cars.update', $car->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="row">
                    <x-adminlte-input name="car_name" label="Nama Mobil" placeholder="Nama Mobil" fgroup-class="col-md-3"
                        enable-old-support value="{{ $car->car_name }}" />
                    <x-adminlte-input name="brand_name" label="Merk Mobil" placeholder="Merk Mobil" fgroup-class="col-md-3"
                        enable-old-support value="{{ $car->brand_name }}" />
                    <x-adminlte-input type="number" name="year" label="Tahun Mobil" placeholder="Tahun Mobil"
                        fgroup-class="col-md-3" min="1900" max="{{ date('Y') }}" enable-old-support
                        value="{{ $car->year }}" />
                    <x-adminlte-input type="number" name="price" label="Harga Mobil" placeholder="Harga Mobil"
                        fgroup-class="col-md-3" enable-old-support value="{{ $car->price }}" />
                </div>

                <div class="row">
                    <x-adminlte-input type="number" name="whatsapp_number" label="Nomor WA" placeholder="ex. 089884..."
                        fgroup-class="col-md-4" enable-old-support value="{{ $car->whatsapp_number }}" />
                    <x-adminlte-input name="video" label="Link Video" placeholder="Link Video" fgroup-class="col-md-4"
                        enable-old-support value="{{ $car->video }}" />
                    <x-adminlte-select2 name="city_id" label="Kota" fgroup-class="col-md-4" enable-old-support>
                        <option value="" disabled>Pilih Kota</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ $city->id == $car->city_id ? 'selected' : '' }}>
                                {{ $city->city_name }}
                            </option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
                <div class="row">
                    <x-adminlte-textarea label="Deskripsi" name="description" placeholder="Masukan deskripsi..."
                        fgroup-class="col-md-12" enable-old-support>
                        {{ $car->description }}
                    </x-adminlte-textarea>
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
