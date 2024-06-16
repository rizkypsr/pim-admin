@extends('adminlte::page')

@section('title', 'Tambah Data')

@section('content_header')
    <h1>Tambah Data</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('services.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <x-adminlte-select2 name="service_type" label="Jenis Layanan" fgroup-class="col-md-3" enable-old-support>
                        <option value="" disabled selected>Pilih Jenis Layanan</option>
                        <option value="find_car">Cari Mobil</option>
                        <option value="service">Service</option>
                        <option value="sale">Jual Mobil</option>
                        <option value="inspection">Inspeksi Mobil</option>
                        <option value="consultation">Konsultasi Mobil</option>
                    </x-adminlte-select2>
                    <x-adminlte-input name="name" label="Nama" placeholder="Nama" fgroup-class="col-md-3"
                        enable-old-support value="{{ old('name') }}" />
                    <x-adminlte-input name="phone" label="No Hp" placeholder="No Hp" fgroup-class="col-md-3"
                        enable-old-support value="{{ old('phone') }}" />
                    <x-adminlte-select2 name="city_id" label="Kota" fgroup-class="col-md-3" enable-old-support>
                        <option value="" disabled selected>Pilih Kota</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                {{ $city->city_name }}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>

                <div class="row">
                    <x-adminlte-textarea label="Alamat" name="address" placeholder="Masukan alamat..."
                        fgroup-class="col-md-12" enable-old-support>
                        {{ old('address') }}
                    </x-adminlte-textarea>
                </div>
                <div class="row">
                    <x-adminlte-textarea label="Deskripsi Mobil" name="car_description"
                        placeholder="Masukan deskripsi mobil..." fgroup-class="col-md-12" enable-old-support>
                        {{ old('description') }}
                    </x-adminlte-textarea>
                </div>
            </div>
            <div class="card-footer">
                <x-adminlte-button type="submit" label="Simpan" theme="primary" />
                <a href={{ route('services.index') }}>
                    <x-adminlte-button label="Batal" />
                </a>
            </div>
        </form>
    </div>
@stop
