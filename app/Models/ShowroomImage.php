<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowroomImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'showroom_id' => 'integer',
    ];

    // public function getFilenameAttribute($value)
    // {
    //     return config('app.url') . '/storage/showroom/' . $value;
    // }
}
