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


// Autoryzacja użytkowników:

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');


    //Routing dla CRUD dań
    Route::view('/admin/menu_items/create', 'admin.menu_items.create')->name('admin.menu_items.create');
    Route::view('/admin/menu_items/edit', 'admin.menu_items.edit')->name('admin.menu_items.edit');
    Route::view('/admin/menu_items/index', 'admin.menu_items.index')->name('admin.menu_items.index');
    Route::view('/admin/menu_items/show', 'admin.menu_items.show')->name('admin.menu_items.show');

    // CRUD userów
    Route::view('/admin/users/create', 'admin.users.create')->name('admin.users.create');
    Route::view('/admin/users/edit', 'admin.users.edit')->name('admin.users.edit');
    Route::view('/admin/users/index', 'admin.users.index')->name('admin.users.index');
    Route::view('/admin/users/show', 'admin.users.show')->name('admin.users.show');


});

    //Podpięcie kontrolera do CRUDA dań
Route::resource('admin/menu_items', MenuItemController::class)
     ->names('admin.menu_items');

// Resource controller
    Route::resource('admin/users', UserController::class)->names('admin.users');

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


// Routing do wyszukiwarki dań
Route::get('/items', [MenuItemController::class, 'index2'])->name('items.index');
Route::get('/items/{menuItem}', [MenuItemController::class, 'show2'])->name('items.show');


// Routing do wyszukiwarki restauracji
Route::get('/restaurant', [RestaurantController::class, 'index'])->name('restaurants.index');
require __DIR__.'/auth.php';


// Routing do rankingu dań

Route::get('/ranking', [MenuItemController::class, 'ranking'])->name('items.ranking');


