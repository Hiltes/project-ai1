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
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TotpController;
use App\Http\Middleware\EnsureTotpIsVerified;

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

// Ustawienia
Route::middleware(['auth'])->group(function () {
    Route::get('/settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    //Totp
    Route::get('/settings/totp', [TotpController::class, 'show'])->name('totp.show');
    Route::post('/settings/totp/enable', [TotpController::class, 'enable'])->name('totp.enable');
    Route::delete('/settings/totp/disable', [TotpController::class, 'disable'])->name('totp.disable');

});

Route::middleware(['auth', EnsureTotpIsVerified::class])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
});

Volt::route('/verify-totp', 'auth.verify-totp')
    ->name('totp.verify')
    ->middleware('web');

// Panel admina
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');
});

// Panel klienta
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::view('/customer', 'customer.dashboard')->name('customer.dashboard');
});

// Koszyk
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::post('/add/{menuItemId}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/remove/{restaurantId}/{menuItemId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::patch('/update/{restaurantId}/{menuItemId}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
});

// Zamawianie
Route::middleware(['auth'])->group(function () {
    Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});

// Routing do wyszukiwarki dań
Route::get('/items', [MenuItemController::class, 'index2'])->name('items.index');
Route::get('/items/{item}', [MenuItemController::class, 'show2'])->name('items.show');


require __DIR__.'/auth.php';
