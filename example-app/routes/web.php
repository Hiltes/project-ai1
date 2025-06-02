<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Models\Restaurant;

Route::get('/', function () {

    $restaurants = Restaurant::all();

    return view('welcome', compact('restaurants'));
})->name('home');

Route::get('/restaurant/{id}', function ($id) {
    return "Strona restauracji o ID: " . $id;
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

Route::prefix('cart')->group(function () {
    Route::post('/add/{menuItemId}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/remove/{restaurantId}/{menuItemId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/', [CartController::class, 'show'])->name('cart.show');
});

// TESTOWO DO DODAWANIA DO CARTA

use App\Models\MenuItem;
use App\Services\CartService;

Route::get('/test-add-to-cart/{id}/{quantity?}', function ($id, $quantity = 1, CartService $cart) {
    $item = MenuItem::with('restaurant')->find($id);
    
    if (!$item) {
        return "Menu item not found";
    }

    $quantity = max(1, (int)$quantity);
    $cart->add($item, $quantity);
    
    return "Added: {$item->name} (Quantity: {$quantity})";
});

// TESTOWO CART ^^^^

require __DIR__.'/auth.php';
