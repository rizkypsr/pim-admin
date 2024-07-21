<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showroom extends Model
{
    use Filterable, HasFactory, Sortable;

    protected $guarded = [];

    protected $casts = [
        'city_id' => 'integer',
    ];

    protected $filterFields = [
        'showroom_name',
        'city_id',
    ];

    protected $sortableFields = [
        'created_at',
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
