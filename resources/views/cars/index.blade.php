@extends('adminlte::page')

@section('title', 'Mobil')

@section('content_header')
    <h1>Mobil</h1>
@stop

@section('css')
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-switch@3.4.0/dist/css/bootstrap3/bootstrap-switch.min.css">
@stop


@section('content')
    <div class="mb-2">
        <a href="{{ route('cars.create', ['param1' => 'add', 'param2' => 'da']) }}" class="mr-3">
            <x-adminlte-button label="Tambah" theme="success" icon="fas fa-plus" />
        </a>
        <a href="{{ route('share.encrypt', request()->query()) }}" target="_blank">
            <x-adminlte-button label="Share" theme="info" icon="fas fa-share" />
        </a>

    </div>

    <form action="{{ route('cars.index') }}" method="GET">
        <div class="row d-flex align-items-end">
            <div class="col-md-3">
                <x-adminlte-input name="min_price" type="number" label="Harga" placeholder="Harga Minimum"
                    igroup-size="sm">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <span>Rp</span>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="max_price" type="number" placeholder="Harga Maksimal" igroup-size="sm">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <span>Rp</span>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="col-md-3">
                <x-adminlte-input name="year" type="number" label="Tahun" placeholder="Tahun" igroup-size="sm"
                    value="{{ request('year') }}" />
            </div>
            <div class="col-md-3">
                <x-adminlte-input name="brand_name" label="Merk" placeholder="Merk Mobil" igroup-size="sm"
                    value="{{ request('brand_name') }}" />
            </div>
            <div class="col-md-3 mb-3">
                <x-adminlte-button type="submit" label="Apply" class="btn-sm" />
                <a href="{{ route('cars.index') }}">
                    <x-adminlte-button label="Reset" class="btn-sm" />
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <x-adminlte-input name="car_name" label="Nama" placeholder="Nama Mobil" igroup-size="sm" />
            </div>

            <div class="col-md-3">
                <x-adminlte-select name="city_id" label="Kota" igroup-size="sm">
                    <option value="">Pilih Kota</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                            {{ $city->city_name }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>
        </div>
    </form>

    <div class="container-fluid bg-light p-3 border">
        <x-adminlte-datatable id="table2" :heads="$heads" head-theme="dark" :config="$config" striped hoverable
            bordered with-buttons />
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-switch@3.4.0/dist/js/bootstrap-switch.min.js"></script>
@stop
