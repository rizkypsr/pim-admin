@extends('adminlte::page')

@section('title', 'Ubah Data')

@section('content_header')
    <h1>Ubah Data</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('donations.update', $donation->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="row">
                    <x-adminlte-input name="title" label="Judul" placeholder="Judul" fgroup-class="col-md-6"
                        enable-old-support value="{{ $donation->title }}" />
                    <x-adminlte-input name="subtitle" label="Sub Judul" placeholder="Sub Judul" fgroup-class="col-md-6"
                        enable-old-support value="{{ $donation->subtitle }}" />
                </div>

                <div class="row">
                    <x-adminlte-textarea name="description" label="Deskripsi" placeholder="Deskripsi" rows="3"
                        fgroup-class="col-md-12">
                        {{ $donation->description }}
                    </x-adminlte-textarea>

                </div>

                <div class="row">
                    <x-adminlte-input name="video" label="Link Video" placeholder="Link Video" fgroup-class="col-md-6"
                        enable-old-support value="{{ $donation->video }}" />
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
