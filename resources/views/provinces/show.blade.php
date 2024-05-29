@extends('adminlte::page')

@section('title', 'Detail Provinsi')

@section('content_header')
    <h1>Detail Provinsi</h1>
@stop

@section('content')
    <div class="card p-4">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id">ID</label>
                    <p>{{ $province->id }}</p>
                </div>
                <div class="form-group">
                    <label for="province_name">Nama Provinsi</label>
                    <p>{{ $province->province_name }}</p>
                </div>
                <div class="form-group">
                    <label for="created_at">Dibuat pada</label>
                    <p>{{ $province->created_at }}</p>
                </div>
            </div>
        </div>
    </div>
@stop
