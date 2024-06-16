<?php

namespace App\Charts;

use App\Models\Service;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class MonthlyServicesChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {

        $currentYear = Carbon::now()->year;

        $allMonths = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December',
        ];

        $findCar = Service::selectRaw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->where('service_type', 'find_car')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $findCarData = collect($allMonths)->map(function ($month) use ($findCar) {
            $serviceCount = $findCar->where('month', $month)->first();

            return $serviceCount ? $serviceCount->total : 0;
        });

        $sale = Service::selectRaw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->where('service_type', 'sale')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $saleData = collect($allMonths)->map(function ($month) use ($sale) {
            $serviceCount = $sale->where('month', $month)->first();

            return $serviceCount ? $serviceCount->total : 0;
        });

        $service = Service::selectRaw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->where('service_type', 'service')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $serviceData = collect($allMonths)->map(function ($month) use ($service) {
            $serviceCount = $service->where('month', $month)->first();

            return $serviceCount ? $serviceCount->total : 0;
        });

        $inspection = Service::selectRaw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->where('service_type', 'inspection')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $inspectionData = collect($allMonths)->map(function ($month) use ($inspection) {
            $serviceCount = $inspection->where('month', $month)->first();

            return $serviceCount ? $serviceCount->total : 0;
        });

        $consultation = Service::selectRaw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->where('service_type', 'consultation')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $consultationData = collect($allMonths)->map(function ($month) use ($consultation) {
            $serviceCount = $consultation->where('month', $month)->first();

            return $serviceCount ? $serviceCount->total : 0;
        });

        return $this->chart->barChart()
            ->setTitle('Layanan')
            ->setSubtitle('Tahun '.$currentYear)
            ->addData('Layanan Cari Mobil', $findCarData->toArray())
            ->addData('Layanan Jual Mobil', $saleData->toArray())
            ->addData('Layanan Service Mobil', $serviceData->toArray())
            ->addData('Layanan Inspeksi Mobil', $inspectionData->toArray())
            ->addData('Layanan Konsultasi Mobil', $consultationData->toArray())
            ->setLabels(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
    }
}
