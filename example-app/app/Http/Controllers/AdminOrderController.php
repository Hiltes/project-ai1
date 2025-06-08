<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\MenuItem;
use App\Models\Restaurant;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('customer', 'restaurant');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $orders = $query->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $users = User::all();
        $restaurants = Restaurant::all();
        return view('admin.orders.create', [
            'users' => User::all(),
            'restaurants' => Restaurant::all(),
            'menuItems' => MenuItem::all(),
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'restaurant_id' => 'required|exists:restaurants,id',
            'delivery_address' => 'required|string|max:255',
            'status' => 'required|in:pending,in_progress,delivered,cancelled',
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'user_id' => $validated['user_id'],
            'restaurant_id' => $validated['restaurant_id'],
            'delivery_address' => $validated['delivery_address'],
            'status' => $validated['status'],
            'order_date' => now(),
        ]);

        foreach ($validated['items'] as $item) {
            $order->items()->create([
                'menu_item_id' => $item['menu_item_id'],
                'quantity' => $item['quantity'],
            ]);
        }

        return redirect()->route('admin.orders.index')->with('success', 'Zamówienie dodane pomyślnie.');
    }

    public function show(Order $order)
    {
        $order->load('customer', 'restaurant', 'items.menuItem');
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $statuses = ['pending', 'in_progress', 'delivered', 'cancelled'];
        return view('admin.orders.edit', [
            'order' => $order,
            'statuses' => $statuses,
            'users' => User::all(),
            'restaurants' => Restaurant::all(),
            'menuItems' => MenuItem::all(),
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,delivered,cancelled',
            'delivery_address' => 'required|string|max:255',
            'items' => 'array',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'deleted_items' => 'array',
            'deleted_items.*' => 'integer|exists:order_items,id',
        ]);

        $order->status = $request->input('status');
        $order->delivery_address = $request->input('delivery_address');
        $order->save();

        if ($request->filled('deleted_items')) {
            $order->items()->whereIn('id', $request->input('deleted_items'))->delete();
        }

        $submittedItems = $request->input('items', []);

        $submittedMenuItemIds = collect($submittedItems)->pluck('menu_item_id')->toArray();

        $order->items()->whereNotIn('menu_item_id', $submittedMenuItemIds)->delete();

        foreach ($submittedItems as $item) {
            $orderItem = $order->items()->where('menu_item_id', $item['menu_item_id'])->first();

            if ($orderItem) {
                $orderItem->quantity = $item['quantity'];
                $orderItem->save();
            } else {
                $order->items()->create([
                    'menu_item_id' => $item['menu_item_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        }

        return redirect()->route('admin.orders.index', $order)->with('success', 'Zamówienie zaktualizowane pomyślnie.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Zamówienie usunięte.');
    }
}
