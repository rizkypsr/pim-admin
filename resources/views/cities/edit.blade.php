@extends('adminlte::page')

@section('title', 'Ubah Kota')

@section('content_header')
    <h1>Ubah Kota</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('cities.update', $city->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="row">
                    <x-adminlte-input name="city_name" label="Nama Kota" placeholder="Nama Kota" fgroup-class="col-md-6"
                        enable-old-support value="{{ $city->city_name }}" />
                    <x-adminlte-select2 name="province_id" label="Nama Provinsi" fgroup-class="col-md-6" enable-old-support>
                        <option value="" disabled>Pilih Provinsi</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}" {{ $province->id == $city->province_id ? 'selected' : '' }}>
                                {{ $province->province_name }}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
            </div>
            <div class="card-footer">
                <x-adminlte-button type="submit" label="Simpan" theme="primary" />
                <a href={{ route('cities.index') }}>
                    <x-adminlte-button label="Batal" />
                </a>
            </div>
        </form>
    </div>
@stop
