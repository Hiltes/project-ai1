<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Restaurant;

class RestaurantSeeder extends Seeder
{
    public function run()
    {
        $owner = User::where('role', 'admin')->first();

        if (!$owner) {
            throw new \Exception('Brak użytkownika z rolą admin. Upewnij się, że UserSeeder go tworzy.');
        }

        Restaurant::create([
            'owner_id' => $owner->id,
            'name' => 'Pyszna Restauracja',
            'address' => 'ul. Jedzenia 3',
            'phone' => '111222333',
            'description' => 'Najlepsze jedzenie w mieście',
            'is_active' => true,
        ]);

        Restaurant::create([
            'owner_id' => $owner->id,
            'name' => 'Sushi World',
            'address' => 'ul. Ryżowa 7',
            'phone' => '222333444',
            'description' => 'Świeże sushi i japońskie specjały.',
            'is_active' => true,
        ]);

        Restaurant::create([
            'owner_id' => $owner->id,
            'name' => 'Burger House',
            'address' => 'ul. Soczysta 9',
            'phone' => '333444555',
            'description' => 'Najlepsze burgery w mieście.',
            'is_active' => true,
        ]);
    }
}
