<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use Filterable, HasFactory, Sortable;

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

    protected $sortableFields = [
        'created_at',
    ];

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
