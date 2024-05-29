<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'province_id' => 'integer',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
