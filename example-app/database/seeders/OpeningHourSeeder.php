<?php

namespace Database\Seeders;

use App\Models\OpeningHour;
use Illuminate\Database\Seeder;

class OpeningHourSeeder extends Seeder
{
    public function run()
    {
        OpeningHour::create([
            'restaurant_id' => 1,
            'day_of_week' => 'monday',
            'open_time' => '10:00:00',
            'close_time' => '22:00:00',
        ]);
    }
}
