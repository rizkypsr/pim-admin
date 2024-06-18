<?php

namespace App\Charts;

use App\Models\Service;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class OneMonthServiceChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($month): \ArielMejiaDev\LarapexCharts\BarChart
    {

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // If $month is provided, use it; otherwise, use the current month
        $selectedMonth = $month ?? $currentMonth;
        $selectedMonthName = Carbon::create()->month($selectedMonth)->format('F'); // Convert month number to month name

        $findCar = Service::selectRaw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $selectedMonth)
            ->where('service_type', 'find_car')
            ->groupBy('month')
            ->orderBy('month')
            ->first();

        $findCarData = $findCar ? $findCar->total : 0;

        $sale = Service::selectRaw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $selectedMonth)
            ->where('service_type', 'sale')
            ->groupBy('month')
            ->orderBy('month')
            ->first();

        $saleData = $sale ? $sale->total : 0;

        $service = Service::selectRaw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $selectedMonth)
            ->where('service_type', 'service')
            ->groupBy('month')
            ->orderBy('month')
            ->first();

        $serviceData = $service ? $service->total : 0;

        $inspection = Service::selectRaw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $selectedMonth)
            ->where('service_type', 'inspection')
            ->groupBy('month')
            ->orderBy('month')
            ->first();

        $inspectionData = $inspection ? $inspection->total : 0;

        $consultation = Service::selectRaw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $selectedMonth)
            ->where('service_type', 'consultation')
            ->groupBy('month')
            ->orderBy('month')
            ->first();

        $consultationData = $consultation ? $consultation->total : 0;

        return $this->chart->barChart()
            ->setTitle('Total Layanan Bulan '.$selectedMonthName)
            ->setSubtitle('Tahun '.$currentYear)
            ->addData('Layanan Cari Mobil', [$findCarData])
            ->addData('Layanan Jual Mobil', [$saleData])
            ->addData('Layanan Servis Mobil', [$serviceData])
            ->addData('Layanan Inspeksi Mobil', [$inspectionData])
            ->addData('Layanan Konsultasi Mobil', [$consultationData])
            ->setXAxis([$selectedMonthName]);
    }
}
