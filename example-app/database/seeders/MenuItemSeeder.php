<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run()
    {
        MenuItem::create([
            'name' => 'Pizza Margherita',
            'description' => 'Klasyczna pizza z mozzarellą',
            'price' => 24.99,
            'restaurant_id' => 1,
            'category' => 'Pizza',
            'rating' => 4.5,
            'rating_count' => 120,
        ]);

        MenuItem::create([
            'name' => 'Burger Wołowy',
            'description' => 'Wołowina, sałata, sos',
            'price' => 29.50,
            'restaurant_id' => 1,
            'category' => 'Fast Food',
            'rating' => 4.2,
            'rating_count' => 85,
        ]);
    }
}
