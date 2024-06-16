@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {!! $chart->container() !!}
        </div>
    </div>
@stop

@section('js')
    <script src="{{ $chart->cdn() }}"></script>

    {{ $chart->script() }}
@endsection
