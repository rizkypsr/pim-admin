@extends('adminlte::page')

@section('title', 'Detail Donasi')

@section('content_header')
    <h1>Detail Donasi</h1>
@stop

@section('content')
    <div class="row pb-4">
        <div class="card p-4 col-md-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id">ID</label>
                        <p>{{ $donation->id }}</p>
                    </div>
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <p>{{ $donation->title }}</p>
                    </div>
                    <div class="form-group">
                        <label for="subtitle">Sub Judul</label>
                        <p>{{ $donation->subtitle }}</p>
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <p>{{ $donation->description }}</p>
                    </div>
                    <div class="form-group">
                        <label for="video">Link Video</label>
                        <p>
                            <a href="{{ $donation->video }}" target="_blank">
                                {{ $donation->video }}
                            </a>
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="created_at">Dibuat pada</label>
                        <p>{{ $donation->created_at }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="container-fluid bg-light p-3 border">
                <x-adminlte-datatable id="table2" :heads="$heads" head-theme="dark" :config="$config" striped hoverable
                    bordered />
            </div>
        </div>
    </div>
@stop
