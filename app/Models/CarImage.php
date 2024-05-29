<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'car_id' => 'integer',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    // public function getFilenameAttribute($value)
    // {
    //     return config('app.url') . '/storage/cars/' . $value;
    // }
}
