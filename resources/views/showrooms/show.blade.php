@extends('adminlte::page')

@section('title', 'Detail Showroom')

@section('content_header')
    <h1>Detail Showroom</h1>
@stop

@section('content')
    <div class="p-4">
        <div class="mb-3">
            <a href="{{ route('showrooms.createCar', $showroom->id) }}">
                <x-adminlte-button label="Tambah Mobil" theme="success" icon="fas fa-plus" />
            </a>
        </div>

        <div class="card p-4">

            <div class="col-md-6">
                <div class="form-group">
                    <label for="id">ID</label>
                    <p>{{ $showroom->id }}</p>
                </div>
                <div class="form-group">
                    <label for="showroom_name">Nama Showroom</label>
                    <p>{{ $showroom->showroom_name }}</p>
                </div>
                <div class="form-group">
                    <label for="city_name">Kota</label>
                    <p>{{ $showroom->city->city_name }}</p>
                </div>
                <div class="form-group">
                    <label for="whatsapp_number">Nomor Whatsapp</label>
                    <p>
                        <a href="@toWhatsapp($showroom->whatsapp_number)">
                            {{ $showroom->whatsapp_number }}
                        </a>
                    </p>
                </div>
                <div class="form-group">
                    <label for="video">Link Video</label>
                    <p>
                        <a href="{{ $showroom->video }}">{{ $showroom->video }}</a>
                    </p>
                </div>
                <div class="form-group">
                    <label for="created_at">Dibuat pada</label>
                    <p>{{ $showroom->created_at }}</p>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-7">
                <h2>Daftar Mobil pada Showroom {{ $showroom->showroom_name }}</h2>

                <div class="container-fluid bg-light p-3 border">
                    <x-adminlte-datatable id="carTable" :heads="$heads" head-theme="dark" :config="$config" striped
                        hoverable bordered />
                </div>
            </div>
            <div class="bg-light p-3 border col-md-5">
                <x-adminlte-datatable id="table2" :heads="$headsImage" head-theme="dark" :config="$configImage" striped hoverable
                    bordered />
            </div>
        </div>
    </div>
@stop
