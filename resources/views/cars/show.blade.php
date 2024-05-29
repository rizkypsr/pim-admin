@extends('adminlte::page')

@section('title', 'Detail Mobil')

@section('content_header')
    <h1>Detail Mobil</h1>
@stop

@section('content')
    <div class="row pb-4">
        <div class="card p-4 col-md-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id">ID</label>
                        <p>{{ $car->id }}</p>
                    </div>
                    <div class="form-group">
                        <label for="car_name">Nama Mobil</label>
                        <p>{{ $car->car_name }}</p>
                    </div>
                    <div class="form-group">
                        <label for="brand_name">Merk Mobil</label>
                        <p>{{ $car->brand_name }}</p>
                    </div>
                    <div class="form-group">
                        <label for="brand_name">Deskripsi Mobil</label>
                        <p>{{ $car->description }}</p>
                    </div>
                    <div class="form-group">
                        <label for="price">Harga Mobil</label>
                        <p>@rupiah($car->price)</p>
                    </div>
                    <div class="form-group">
                        <label for="whatsapp_number">Nomor WA</label>
                        <p>{{ $car->whatsapp_number }}</p>
                    </div>
                    <div class="form-group">
                        <label for="city_name">Kota</label>
                        <p>{{ $car->city->city_name ?? '-' }}</p>
                    </div>
                    <div class="form-group">
                        <label for="showroom_name">Showrooom</label>
                        <p>{{ $car->showroom->showroom_name ?? '-' }}</p>
                    </div>
                    <div class="form-group">
                        <label for="video">Link Video</label>
                        <p>
                            <a href="{{ $car->video }}" target="_blank">
                                {{ $car->video }}
                            </a>
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="created_at">Dibuat pada</label>
                        <p>{{ $car->created_at }}</p>
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
