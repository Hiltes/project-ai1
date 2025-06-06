<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\MenuItem;
use App\Services\CartService;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;


// Testowe strony błędów
Route::view('/test-403', 'errors.403');
Route::view('/test-404', 'errors.404');
Route::view('/test-419', 'errors.419');
Route::view('/test-500', 'errors.500');

// Strona główna
Route::get('/', function () {
    $restaurants = Restaurant::all();
    return view('welcome', compact('restaurants'));
})->name('home');

// Szczegóły restauracji
Route::get('/restaurant/{id}', function ($id) {
    $restaurant = Restaurant::findOrFail($id);
    $reviews = $restaurant->reviews()->latest()->get();
    return view('restaurant', compact('restaurant', 'reviews'));
});

// Panel użytkownika – przekierowanie na podstawie roli
Route::get('/panel', function (Request $request) {
    return match ($request->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'customer' => redirect()->route('customer.dashboard'),
        default => abort(403),
    };
})->middleware('auth')->name('user.panel');

// Dashboard (Volt)
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Autoryzacja (Volt)
Volt::route('/login', 'auth.login')->middleware('guest')->name('login');
Volt::route('/register', 'auth.register')->middleware('guest')->name('register');
Volt::route('/forgot-password', 'auth.forgot-password')->middleware('guest')->name('password.request');
Volt::route('/reset-password', 'auth.reset-password')->middleware('guest')->name('password.reset');
Volt::route('/verify-email', 'auth.verify-email')->middleware('auth')->name('verification.notice');
Volt::route('/confirm-password', 'auth.confirm-password')->middleware('auth')->name('password.confirm');

// Ustawienia (Livewire + Volt)
Route::middleware(['auth'])->group(function () {
    Route::get('/settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// Panel admina
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');
});

// Panel klienta
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::view('/customer', 'customer.dashboard')->name('customer.dashboard');
});

// Koszyk
Route::prefix('cart')->group(function () {
    Route::post('/add/{menuItemId}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/remove/{restaurantId}/{menuItemId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/', [CartController::class, 'show'])->name('cart.show');
});

// Testowe dodawanie do koszyka
Route::get('/test-add-to-cart/{id}/{quantity?}', function ($id, $quantity = 1, CartService $cart) {
    $item = MenuItem::with('restaurant')->find($id);
    if (!$item) {
        return "Menu item not found";
    }

    $cart->add($item, max(1, (int)$quantity));
    return "Added: {$item->name} (Quantity: {$quantity})";
});

require __DIR__.'/auth.php';
