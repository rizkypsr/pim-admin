@extends('adminlte::page')

@section('title', 'Tambah Gambar Donasi')

@section('content_header')
    <h1>Tambah Gambar Donasi</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('donations.storeImage') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="donation_id" value="{{ $id }}">

            <div class="card-body">
                <div class="row">
                    <x-adminlte-input-file id="images" name="images[]" label="Upload Gambar" fgroup-class="col-md-4"
                        placeholder="Choose multiple files..." legend="Choose" multiple>
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-file-upload"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-file>
                </div>
            </div>
            <div class="card-footer">
                <x-adminlte-button type="submit" label="Simpan" theme="primary" />
                <a href={{ route('donations.show', $id) }}>
                    <x-adminlte-button label="Batal" />
                </a>
            </div>
        </form>
    </div>
@stop
