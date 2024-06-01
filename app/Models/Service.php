<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'name',
        'address',
        'phone',
        'car_description',
        'service_type',
        'status',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
