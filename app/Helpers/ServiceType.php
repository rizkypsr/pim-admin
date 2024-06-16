<?php

namespace App\Helpers;

class ServiceType
{
    public static function getLabel(string $type)
    {

        switch ($type) {
            case 'find_car':
                return 'Cari Mobil';
            case 'service':
                return 'Service Mobil';
            case 'sale':
                return 'Jual Mobil';
            case 'inspection':
                return 'Inspeksi Mobil';
            case 'consultation':
                return 'Konsultasi Mobil';
            default:
                throw new \Exception('Jenis layanan tidak valid');
        }
    }

    public static function getStatus(string $type)
    {
        switch ($type) {
            case 'pending':
                return '<span class="badge badge-warning text-uppercase">Belum dikerjakan</span>';
            case 'finished':
                return '<span class="badge badge-success text-uppercase">Sudah dikerjekan</span>';
            default:
                throw new \Exception('Jenis layanan tidak valid');
        }
    }
}
