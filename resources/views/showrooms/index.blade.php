@extends('adminlte::page')

@section('title', 'Showroom')

@section('content_header')
    <h1>Showroom</h1>
@stop

@section('content')
    <div class="mb-2">
        <a class="mr-2" href="{{ route('showrooms.create') }}">
            <x-adminlte-button label="Tambah" theme="success" icon="fas fa-plus" />
        </a>
        <a href="{{ route('showrooms.export') }}">
            <x-adminlte-button type="submit" theme="success" icon="fas fa-file-excel" />
        </a>
    </div>

    <div class="container-fluid bg-light p-3 border">
        <x-adminlte-datatable id="table2" :heads="$heads" head-theme="dark" :config="$config" striped hoverable
            bordered />
    </div>
@stop
