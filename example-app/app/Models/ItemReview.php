<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_item_id',
        'user_id',
        'rating',
    ];

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
