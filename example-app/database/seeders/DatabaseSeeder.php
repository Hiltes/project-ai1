<?php

namespace Database\Seeders;

use App\Models\ItemReview;
use Illuminate\Database\Seeder;
use App\Models\User;

use Database\Seeders\UserSeeder;
use Database\Seeders\RestaurantSeeder;
use Database\Seeders\MenuItemSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\OrderItemSeeder;
use Database\Seeders\ReviewSeeder;
use Database\Seeders\OpeningHourSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RestaurantSeeder::class,
            MenuItemSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            ReviewSeeder::class,
            OpeningHourSeeder::class,
            ItemReviewSeeder::class,
        ]);
    }
}
