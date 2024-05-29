@extends('adminlte::page')

@section('title', 'Tambah Showroom')

@section('content_header')
    <h1>Tambah Showroom</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('showrooms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <x-adminlte-input name="showroom_name" label="Nama Showroom" placeholder="Nama Showroom"
                        fgroup-class="col-md-6" enable-old-support value="{{ old('showroom_name') }}" />
                    <x-adminlte-input type="number" name="whatsapp_number" label="Nomor WA" placeholder="ex. 089884..."
                        fgroup-class="col-md-6" enable-old-support value="{{ old('whatsapp_number') }}" />
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
                    <x-adminlte-select2 name="city_id" label="Kota" fgroup-class="col-md-4" enable-old-support>
                        <option value="" disabled selected>Pilih Kota</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-input name="video" label="Link Video" placeholder="Link Video" fgroup-class="col-md-4"
                        enable-old-support value="{{ old('video') }}" />
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
