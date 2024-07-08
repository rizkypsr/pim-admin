@extends('adminlte::page')

@section('title', 'Notifikasi')

@section('content_header')
    <h1>Kirim Notifikasi</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('notification.send') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <x-adminlte-input name="title" label="Judul" placeholder="Judul" fgroup-class="col-md-6"
                        enable-old-support value="{{ old('title') }}" />
                    <x-adminlte-input name="description" label="Deskripsi" placeholder="Deskripsi" fgroup-class="col-md-6"
                        enable-old-support value="{{ old('description') }}" />
                </div>
            </div>
            <div class="card-footer">
                <x-adminlte-button type="submit" label="Simpan" theme="primary" />
                <a href={{ route('notification.index') }}>
                    <x-adminlte-button label="Batal" />
                </a>
            </div>
        </form>
    </div>
@stop
