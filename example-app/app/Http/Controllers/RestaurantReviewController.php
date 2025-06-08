<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
use App\Models\Review;

class RestaurantReviewController extends Controller
{
    // Pokaż restauracje, które użytkownik kupił, ale jeszcze nie ocenił
    public function pending()
    {
        $userId = Auth::id();

        // ID restauracji z których coś zamówił
        $restaurantIds = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->where('orders.user_id', $userId)
            ->pluck('menu_items.restaurant_id')
            ->unique()
            ->toArray();

        // Restauracje bez opinii użytkownika
        $restaurantsToReview = Restaurant::with('reviews')
            ->whereIn('id', $restaurantIds)
            ->whereDoesntHave('reviews', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get();

        return view('reviews.restaurants.pending', compact('restaurantsToReview'));
    }

    // Zapis opinii i aktualizacja średniej + liczby ocen w Restaurant
    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'rating'        => 'required|integer|min:1|max:5',
            'comment'       => 'nullable|string|max:1000',
        ]);

        $userId = Auth::id();
        $restaurant = Restaurant::findOrFail($request->restaurant_id);

        // Sprawdź, czy już oceniono
        if ($restaurant->reviews()->where('user_id', $userId)->exists()) {
            return back()->with('error', 'Już oceniłeś tę restaurację.');
        }

        DB::transaction(function () use ($restaurant, $userId, $request) {
            // Dodaj opinię
            Review::create([
                'restaurant_id' => $restaurant->id,
                'user_id'       => $userId,
                'rating'        => $request->rating,
                'comment'       => $request->comment,
                'created_at'    => now(),
            ]);

            // Odśwież średnią ocenę i liczbę opinii
            $stats = $restaurant->reviews()
                ->selectRaw('COUNT(*) as cnt, AVG(rating) as avg')
                ->first();

            $restaurant->rating = round($stats->avg, 2);
            $restaurant->rating_count = $stats->cnt;
            $restaurant->save();
        });

        return back()->with('success', 'Dziękujemy za ocenę restauracji!');
    }
}
