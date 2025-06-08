<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemReview;
use App\Models\MenuItem;


class ItemReviewSeeder extends Seeder
{
    public function run()
    {

        $users = [1, 2];
        $ratings = [3, 4, 5];

        $menuItems = MenuItem::all();

        foreach ($menuItems as $item) {
            foreach ($users as $userId) {
                ItemReview::create([
                    'menu_item_id' => $item->id,
                    'user_id'      => $userId,
                    'rating'       => $ratings[array_rand($ratings)],
                ]);
            }
        }

    }
}
