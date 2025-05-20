<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Jan Klient',
            'email' => 'janek@example.com',
            'phone' => '123456789',
            'password' => Hash::make('password'),
            'address' => 'ul. Klienta 1',
            'role' => 'customer',
        ]);

        User::create([
            'name' => 'Anna Właściciel',
            'email' => 'anna@example.com',
            'phone' => '987654321',
            'password' => Hash::make('password'),
            'address' => 'ul. Właścicieli 2',
            'role' => 'admin',
        ]);
    }
}
