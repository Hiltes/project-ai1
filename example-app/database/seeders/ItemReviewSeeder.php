<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemReview;

class ItemReviewSeeder extends Seeder
{
    public function run()
    {

        ItemReview::create([
            'menu_item_id' => 1,
            'user_id'      => 1,
            'rating'       => 5,
        ]);
        ItemReview::create([
            'menu_item_id' => 1,
            'user_id'      => 2,
            'rating'       => 4,
        ]);
        ItemReview::create([
            'menu_item_id' => 2,
            'user_id'      => 1,
            'rating'       => 3,
        ]);
        ItemReview::create([
            'menu_item_id' => 2,
            'user_id'      => 2,
            'rating'       => 5,
        ]);

    }
}
