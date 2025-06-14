<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\MenuItem;
use App\Services\CartService;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\AdminRestaurantController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\TotpController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\EnsureTotpIsVerified;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\RestaurantReviewController;
use App\Http\Controllers\ReviewController;

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

// Dashboard
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

// Panel administratora i wszystkie admin-routy
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');

    // Widoki (blade) – CRUD
    Route::view('/admin/menu_items/create', 'admin.menu_items.create')->name('admin.menu_items.create');
    Route::view('/admin/menu_items/edit', 'admin.menu_items.edit')->name('admin.menu_items.edit');
    Route::view('/admin/menu_items/index', 'admin.menu_items.index')->name('admin.menu_items.index');
    Route::view('/admin/menu_items/show', 'admin.menu_items.show')->name('admin.menu_items.show');

    Route::view('/admin/users/create', 'admin.users.create')->name('admin.users.create');
    Route::view('/admin/users/edit', 'admin.users.edit')->name('admin.users.edit');
    Route::view('/admin/users/index', 'admin.users.index')->name('admin.users.index');
    Route::view('/admin/users/show', 'admin.users.show')->name('admin.users.show');

    Route::view('/admin/restaurants/create', 'admin.restaurants.create')->name('admin.restaurants.create');
    Route::view('/admin/restaurants/edit', 'admin.restaurants.edit')->name('admin.restaurants.edit');
    Route::view('/admin/restaurants/index', 'admin.restaurants.index')->name('admin.restaurants.index');
    Route::view('/admin/restaurants/show', 'admin.restaurants.show')->name('admin.restaurants.show');

    Route::view('/admin/orders/create', 'admin.orders.create')->name('admin.orders.create');
    Route::view('/admin/orders/edit', 'admin.orders.edit')->name('admin.orders.edit');
    Route::view('/admin/orders/index', 'admin.orders.index')->name('admin.orders.index');
    Route::view('/admin/orders/show', 'admin.orders.show')->name('admin.orders.show');

    // Kontrolery (resource)
    Route::resource('admin/menu_items', MenuItemController::class)->names('admin.menu_items');
    Route::resource('admin/users', UserController::class)->names('admin.users');
    Route::resource('admin/restaurants', AdminRestaurantController::class)->names('admin.restaurants');
    Route::resource('admin/orders', AdminOrderController::class)->names('admin.orders');

    // Statystyki sprzedaży
    Route::get('sales', [SalesController::class, 'index'])->name('admin.sales.index');
});

// Panel klienta
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::view('/customer', 'customer.dashboard')->name('customer.dashboard');
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.dashboard');
});

// Ustawienia użytkownika
Route::middleware(['auth'])->group(function () {
    Route::get('/settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // TOTP
    Route::get('/settings/totp', [TotpController::class, 'show'])->name('totp.show');
    Route::post('/settings/totp/enable', [TotpController::class, 'enable'])->name('totp.enable');
    Route::delete('/settings/totp/disable', [TotpController::class, 'disable'])->name('totp.disable');
});

// TOTP weryfikacja
Route::middleware(['auth', EnsureTotpIsVerified::class])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
});

Volt::route('/verify-totp', 'auth.verify-totp')->name('totp.verify')->middleware('web');

// Koszyk i zamówienia
Route::middleware(['auth'])->group(function () {
    Route::post('/add/{menuItemId}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/remove/{restaurantId}/{menuItemId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::patch('/update/{restaurantId}/{menuItemId}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');

    Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    // Recenzje
    Route::get('/reviews/pending', [ReviewController::class, 'pending'])->name('reviews.pending');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/reviews/restaurants/to-rate', [RestaurantReviewController::class, 'pending'])->name('reviews.restaurants.to-rate');
    Route::post('/reviews/restaurants', [RestaurantReviewController::class, 'store'])->name('reviews.restaurants.store');
});

// Wyszukiwarka i ranking
Route::get('/items', [MenuItemController::class, 'index2'])->name('items.index');
Route::get('/items/{menuItem}', [MenuItemController::class, 'show2'])->name('items.show');
Route::get('/ranking', [MenuItemController::class, 'ranking'])->name('items.ranking');

// Restauracje publicznie
Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');

// Testowe dodawanie do koszyka
Route::get('/test-add-to-cart/{id}/{quantity?}', function ($id, $quantity = 1, CartService $cart) {
    $item = MenuItem::with('restaurant')->find($id);
    if (!$item) {
        return "Menu item not found";
    }
    $cart->add($item, max(1, (int)$quantity));
    return "Added: {$item->name} (Quantity: {$quantity})";
});

// Laravel Breeze (lub Fortify)
require __DIR__.'/auth.php';
