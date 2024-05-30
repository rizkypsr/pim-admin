@extends('adminlte::page')

@section('title', 'Ubah Showroom')

@section('content_header')
    <h1>Ubah Showroom</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('showrooms.update', $showroom->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <x-adminlte-input name="showroom_name" label="Nama Showroom" placeholder="Nama Showroom"
                        fgroup-class="col-md-6" enable-old-support value="{{ $showroom->showroom_name }}" />
                    <x-adminlte-input type="number" name="whatsapp_number" label="Nomor WA" placeholder="Nomor WA"
                        fgroup-class="col-md-6" enable-old-support value="{{ $showroom->whatsapp_number }}" />
                </div>
                <div class="row">
                    <x-adminlte-select2 name="city_id" label="Kota" fgroup-class="col-md-6" enable-old-support>
                        <option value="" disabled>Pilih Kota</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ $city->id == $showroom->city_id ? 'selected' : '' }}>
                                {{ $city->city_name }}
                            </option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-input name="video" label="Link Video" placeholder="Link Video" fgroup-class="col-md-6"
                        enable-old-support value="{{ $showroom->video }}" />
                </div>
            </div>
            <div class="card-footer">
                <x-adminlte-button type="submit" label="Simpan" theme="primary" />
                <a href={{ route('showrooms.index') }}>
                    <x-adminlte-button label="Batal" />
                </a>
            </div>
        </form>
    </div>
@stop
