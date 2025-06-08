<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        // 1. Suma sprzedanych sztuk dań
        $totalItemsSold = OrderItem::sum('quantity');

        // 2. Łączna wartość sprzedaży (zakładam, że MenuItem ma pole price)
        $totalSalesValue = OrderItem::join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->select(DB::raw('SUM(order_items.quantity * menu_items.price) as total'))
            ->value('total');

        // 3. Najpopularniejsze dania (top 5)
        $topItems = OrderItem::join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->select('menu_items.name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('menu_items.id', 'menu_items.name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        // 4. Sprzedaż dzienna (ostatnie 7 dni)
        $salesByDay = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->select(
                DB::raw('DATE(orders.order_date) as date'),
                DB::raw('SUM(order_items.quantity * menu_items.price) as total_sales')
            )
            ->where('orders.order_date', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $salesByRestaurant = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('restaurants', 'orders.restaurant_id', '=', 'restaurants.id')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->select(
                'restaurants.name as restaurant_name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.quantity * menu_items.price) as total_value')
            )
            ->groupBy('restaurants.id', 'restaurants.name')
            ->orderByDesc('total_value')
            ->get();

        return view('admin.sales.index', compact('totalItemsSold', 'totalSalesValue', 'topItems', 'salesByDay', 'salesByRestaurant'));
    }
}
