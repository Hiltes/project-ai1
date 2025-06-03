<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Models\Restaurant;
use App\Http\Controllers\RestaurantController;
Route::get('/', function () {


    $restaurants = Restaurant::all();

    return view('welcome', compact('restaurants'));
})->name('home');



Route::get('/restaurant/{id}', function ($id) {
    $restaurant = \App\Models\Restaurant::findOrFail($id);

    $reviews = $restaurant->reviews()->latest()->get();
    return view('restaurant', compact('restaurant', 'reviews'));

});



Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Volt::route('/login', 'auth.login')->middleware('guest')->name('login');
Volt::route('/register', 'auth.register')->middleware('guest')->name('register');
Volt::route('/forgot-password', 'auth.forgot-password')->middleware('guest')->name('password.request');
Volt::route('/reset-password', 'auth.reset-password')->middleware('guest')->name('password.reset');
Volt::route('/verify-email', 'auth.verify-email')->middleware('auth')->name('verification.notice');
Volt::route('/confirm-password', 'auth.confirm-password')->middleware('auth')->name('password.confirm');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
