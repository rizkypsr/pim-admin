@extends('adminlte::page')

@section('title', 'Detail Kota')

@section('content_header')
    <h1>Detail Kota</h1>
@stop

@section('content')
    <div class="card p-4">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id">ID</label>
                    <p>{{ $city->id }}</p>
                </div>
                <div class="form-group">
                    <label for="city_name">Nama Kota</label>
                    <p>{{ $city->city_name }}</p>
                </div>
                <div class="form-group">
                    <label for="province_name">Nama Provinsi</label>
                    <p>{{ $city->province->province_name }}</p>
                </div>
                <div class="form-group">
                    <label for="created_at">Dibuat pada</label>
                    <p>{{ $city->created_at }}</p>
                </div>
            </div>
        </div>
    </div>
@stop
