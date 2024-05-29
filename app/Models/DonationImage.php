<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'donation_id' => 'integer',
    ];

    // public function getFilenameAttribute($value)
    // {
    //     return config('app.url') . '/storage/donations/' . $value;
    // }
}
