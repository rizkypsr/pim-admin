<?php

namespace App\Http\Controllers;

use App\Charts\MonthlyServicesChart;
use App\Charts\OneMonthServiceChart;

class DashboardController extends Controller
{
    public function index(MonthlyServicesChart $serviceChart, OneMonthServiceChart $oneMonthServiceChart)
    {
        $oneMonthChart = $oneMonthServiceChart->build(request('month'));
        $chart = $serviceChart->build(request('month'));

        return view('dashboard.index', compact('chart', 'oneMonthChart'));
    }
}
