<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    public function run()
    {
        OrderItem::create([
            'order_id' => 1,
            'menu_item_id' => 1,
            'quantity' => 1,
        ]);

        OrderItem::create([
            'order_id' => 1,
            'menu_item_id' => 2,
            'quantity' => 2,
        ]);
    }
}
