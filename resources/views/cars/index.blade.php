@extends('adminlte::page')

@section('title', 'Mobil')

@section('content_header')
    <h1>Mobil</h1>
@stop

@section('content')
    <div class="mb-2">
        <a href="{{ route('cars.create') }}">
            <x-adminlte-button label="Tambah" theme="success" icon="fas fa-plus" />
        </a>
    </div>

    <form class="row d-flex align-items-end" action="{{ route('cars.index') }}" method="GET">
        <div class="col-md-3">
            <x-adminlte-input name="min_price" type="number" label="Harga" placeholder="Harga Minimum" igroup-size="sm"
                value="{{ request('min_price') }}" enable-old-support>
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <span>Rp</span>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <x-adminlte-input name="max_price" type="number" placeholder="Harga Maksimal" igroup-size="sm"
                value="{{ request('max_price') }}" enable-old-support>
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <span>Rp</span>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>
        <div class="col-md-3">
            <x-adminlte-input name="year" type="number" label="Tahun" placeholder="Tahun" igroup-size="sm"
                enable-old-support value="{{ request('year') }}" />
        </div>
        <div class="col-md-3">
            <x-adminlte-input name="brand_name" label="Merk" placeholder="Merk Mobil" igroup-size="sm"
                value="{{ request('brand_name') }}" enable-old-support />
        </div>
        <div class="col-md-3 mb-3">
            <x-adminlte-button type="submit" label="Apply" class="btn-sm" />
            <a href="{{ route('cars.index') }}">
                <x-adminlte-button label="Reset" class="btn-sm" />
            </a>
        </div>
    </form>

    <div class="container-fluid bg-light p-3 border">
        <x-adminlte-datatable id="table2" :heads="$heads" head-theme="dark" :config="$config" striped hoverable
            bordered with-buttons />
    </div>
@stop
