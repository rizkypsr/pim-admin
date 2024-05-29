<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showroom extends Model
{
    use HasFactory, Filterable;

    protected $guarded = [];

    protected $casts = [
        'city_id' => 'integer',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function showroomImages()
    {
        return $this->hasMany(ShowroomImage::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    // public function getWhatsappNumberAttribute()
    // {
    //     return 'https://wa.me/' . '62' . substr($this->attributes['whatsapp_number'], 1);
    // }

    /**
     * @return string
     */
    public function getCreatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    /**
     * @return string
     */
    public function getUpdatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }
}
