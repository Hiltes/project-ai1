<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Models\Restaurant;

Route::get('/', function () {

    // Do testów potem zrobi sie razem z baza danych
    // $restaurants = [
    //     ['id' => 1, 'name' => 'Pizzeria Napoli', 'description' => 'Autentyczna pizza neapolitańska.'],
    //     ['id' => 2, 'name' => 'Sushi World', 'description' => 'Świeże sushi i japońskie specjały.'],
    //     ['id' => 3, 'name' => 'Burger House', 'description' => 'Najlepsze burgery w mieście.'],
    //     ['id' => 4, 'name' => 'Tandoori Express', 'description' => 'Pikantne dania kuchni indyjskiej.'],
    //     ['id' => 5, 'name' => 'Green Vegan', 'description' => 'Zdrowe i pyszne roślinne jedzenie.'],
    //     ['id' => 6, 'name' => 'Mediterraneo', 'description' => 'Śródziemnomorskie smaki pełne aromatu.'],
    //     ['id' => 7, 'name' => 'Cafe Paris', 'description' => 'Francuskie desery i aromatyczna kawa.'],
    // ];
    $restaurants = Restaurant::all();

    return view('welcome', compact('restaurants'));
});

Route::get('/restaurant/{id}', function ($id) {
    return "Strona restauracji o ID: " . $id;
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
