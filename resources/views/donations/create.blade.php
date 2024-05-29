@extends('adminlte::page')

@section('title', 'Tambah Data')

@section('content_header')
    <h1>Tambah Data</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('donations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <x-adminlte-input name="title" label="Judul" placeholder="Judul" fgroup-class="col-md-6"
                        enable-old-support value="{{ old('title') }}" />
                    <x-adminlte-input name="subtitle" label="Sub Judul" placeholder="Sub Judul" fgroup-class="col-md-6"
                        enable-old-support value="{{ old('subtitle') }}" />
                </div>

                <div class="row">
                    <x-adminlte-textarea name="description" label="Deskripsi" placeholder="Deskripsi" rows="3"
                        fgroup-class="col-md-12" />

                </div>

                <div class="row">
                    <x-adminlte-input-file id="images" name="images[]" label="Upload Gambar" fgroup-class="col-md-6"
                        placeholder="Choose multiple files..." legend="Choose" multiple>
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-file-upload"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-file>
                    <x-adminlte-input name="video" label="Link Video" placeholder="Link Video" fgroup-class="col-md-6"
                        enable-old-support value="{{ old('video') }}" />
                </div>
            </div>
            <div class="card-footer">
                <x-adminlte-button type="submit" label="Simpan" theme="primary" />
                <a href={{ route('donations.index') }}>
                    <x-adminlte-button label="Batal" />
                </a>
            </div>
        </form>
    </div>
@stop
