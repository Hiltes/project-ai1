<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Order;

class OrderController extends Controller
{
    public function __construct()
    {
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'delivery_address' => ['required', 'string', 'min:5', 'max:255'],
        ]);

        $cart = session('cart');

        if (empty($cart['restaurants'])) {
            return redirect()->route('cart.show')->with('error', 'Koszyk jest pusty.');
        }

        $user = Auth::user();

        DB::beginTransaction();

        try {
            foreach ($cart['restaurants'] as $restaurantId => $restaurant) {

                $order = Order::create([
                    'user_id' => $user->id,
                    'restaurant_id' => $restaurantId,
                    'courier_id' => null,
                    'order_date' => Carbon::now(),
                    'delivery_address' => $request->input('delivery_address'),
                    'status' => 'pending',
                ]);

                foreach ($restaurant['items'] as $menuItemId => $item) {
                    $order->items()->create([
                        'menu_item_id' => $menuItemId,
                        'quantity' => $item['quantity'],
                    ]);
                }
            }

            session()->forget('cart');

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Zamówienia zostały złożone!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.show')->with('error', 'Błąd podczas składania zamówienia.');
        }
    }

    public function index()
    {
        $user = Auth::user();

        $orders = Order::with('restaurant', 'items.menuItem')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return view('orders.index', compact('orders'));
    }
}
