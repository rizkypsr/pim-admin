<?php

namespace App\Http\Controllers;

use App\Charts\MonthlyServicesChart;

class DashboardController extends Controller
{
    public function index(MonthlyServicesChart $serviceChart)
    {

        $chart = $serviceChart->build();

        return view('dashboard.index', compact('chart'));
    }
}
