@extends('adminlte::page')

@section('title', 'Tambah Provinsi')

@section('content_header')
    <h1>Tambah Provinsi</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('provinces.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <x-adminlte-input name="province_name" label="Nama Provinsi" placeholder="Nama Provinsi"
                        fgroup-class="col-md-6" enable-old-support value="{{ old('province_name') }}" />
                </div>
            </div>
            <div class="card-footer">
                <x-adminlte-button type="submit" label="Simpan" theme="primary" />
                <a href={{ route('provinces.index') }}>
                    <x-adminlte-button label="Batal" />
                </a>
            </div>
        </form>
    </div>
@stop
