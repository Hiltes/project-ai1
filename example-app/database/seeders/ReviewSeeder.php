<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        Review::create([
            'user_id' => 1,
            'restaurant_id' => 1,
            'rating' => 5,
            'comment' => 'Świetne jedzenie!',
            'created_at' => now(),
        ]);
    }
}
