<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpeningHour extends Model
{
    protected $fillable = [
        'restaurant_id',
        'day_of_week',
        'open_time',
        'close_time',
    ];

    public $timestamps = false;

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
