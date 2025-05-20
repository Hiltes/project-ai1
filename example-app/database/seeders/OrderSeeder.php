<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        Order::create([
            'user_id' => 1,
            'courier_id' => null,
            'restaurant_id' => 1,
            'order_date' => now(),
            'delivery_address' => 'ul. Klienta 1',
            'status' => 'pending',
        ]);
    }
}
