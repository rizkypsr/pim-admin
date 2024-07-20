<?php

namespace App\Exports;

use App\Models\Car;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ShowroomCarExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Car::with(['showroom'])
            ->whereNotNull('showroom_id')
            ->get();
    }

    public function map($car): array
    {
        return [
            $car->showroom->showroom_name,
            $car->car_name,
            $car->brand_name,
            $car->price,
            $car->year,
            $car->whatsapp_number,
            $car->video,
            $car->description,
        ];
    }

    public function headings(): array
    {
        return [
            'Showroom',
            'Nama Mobil',
            'Merk Mobil',
            'Harga',
            'Tahun',
            'Nomor Whatsapp',
            'Link Video',
            'Deskripsi',
        ];
    }
}
