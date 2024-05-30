<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use Filterable, HasFactory;

    protected $guarded = [];

    protected $casts = [
        'price' => 'integer',
        'showroom_id' => 'integer',
    ];

    protected $filterFields = [
        'brand_name',
        'year',
        'price',
        'showroom',
        'whatsapp_number',
        'city_id',
    ];

    // protected $filters = ['year', 'brand_name', 'min_price', 'max_price'];

    // public function min_price($query, $value)
    // {
    //     if ($value) {
    //         return $query->where('price', '>=', $value);
    //     }

    //     return $query;
    // }

    // public function max_price($query, $value)
    // {
    //     if ($value) {
    //         return $query->where('price', '<=', $value);
    //     }

    //     return $query;
    // }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function showroom()
    {
        return $this->belongsTo(Showroom::class);
    }

    public function carImages()
    {
        return $this->hasMany(CarImage::class);
    }

    /**
     * @return string
     */
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    /**
     * @return string
     */
    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }
}
