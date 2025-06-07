<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'restaurant_id',
        'category',
        'rating',
        'rating_count',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    public function reviews()
    {
        return $this->hasMany(ItemReview::class);
    }
}
