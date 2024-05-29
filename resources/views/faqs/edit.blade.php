@extends('adminlte::page')

@section('title', 'Ubah Data')

@section('content_header')
    <h1>Ubah Data</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('faqs.update', $faq->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="row">
                    <x-adminlte-input name="name" label="Nama" placeholder="Nama" fgroup-class="col-md-6"
                        enable-old-support value="{{ $faq->name }}" />
                    <x-adminlte-input name="value" label="Data" placeholder="Data" fgroup-class="col-md-6"
                        enable-old-support value="{{ $faq->value }}" />
                </div>
            </div>
            <div class="card-footer">
                <x-adminlte-button type="submit" label="Simpan" theme="primary" />
                <a href={{ route('faqs.index') }}>
                    <x-adminlte-button label="Batal" />
                </a>
            </div>
        </form>
    </div>
@stop
