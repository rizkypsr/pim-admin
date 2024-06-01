@extends('adminlte::page')

@section('title', 'Layanan')

@section('content_header')
    <h1>Layanan</h1>
@stop

@section('content')
    <div class="mb-2">
        <a href="{{ route('services.create') }}">
            <x-adminlte-button label="Tambah" theme="success" icon="fas fa-plus" />
        </a>
    </div>

    <div class="container-fluid bg-light p-3 border">
        <x-adminlte-datatable id="table2" :heads="$heads" head-theme="dark" :config="$config" striped hoverable bordered
            with-buttons />
    </div>
@stop
