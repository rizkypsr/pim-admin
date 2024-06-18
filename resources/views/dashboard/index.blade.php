@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <form id="monthForm" method="GET" action="{{ route('dashboard') }}">
        <x-adminlte-select2 name="month" label="Bulan" fgroup-class="col-md-3" enable-old-support
            onchange="document.getElementById('monthForm').submit();">
            <option value="">Bulan Ini</option>
            <option value="1" {{ request('month') == 1 ? 'selected' : '' }}>Januari</option>
            <option value="2" {{ request('month') == 2 ? 'selected' : '' }}>Februari</option>
            <option value="3" {{ request('month') == 3 ? 'selected' : '' }}>Maret</option>
            <option value="4" {{ request('month') == 4 ? 'selected' : '' }}>April</option>
            <option value="5" {{ request('month') == 5 ? 'selected' : '' }}>Mei</option>
            <option value="6" {{ request('month') == 6 ? 'selected' : '' }}>Juni</option>
            <option value="7" {{ request('month') == 7 ? 'selected' : '' }}>Juli</option>
            <option value="8" {{ request('month') == 8 ? 'selected' : '' }}>Agustus</option>
            <option value="9" {{ request('month') == 9 ? 'selected' : '' }}>September</option>
            <option value="10" {{ request('month') == 10 ? 'selected' : '' }}>Oktober</option>
            <option value="11" {{ request('month') == 11 ? 'selected' : '' }}>November</option>
            <option value="12" {{ request('month') == 12 ? 'selected' : '' }}>Desember</option>
        </x-adminlte-select2>
    </form>
    <div class="container-fluid">
        <div class="row">
            <div class="div col">
                <div class="card">
                    <div class="card-body">
                        {!! $oneMonthChart->container() !!}
                    </div>
                </div>
            </div>
            <div class="div col">
                <div class="card">
                    <div class="card-body">
                        {!! $chart->container() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ $chart->cdn() }}"></script>

    {{ $chart->script() }}
    {{ $oneMonthChart->script() }}
@endsection
