<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\MenuItem;
use App\Models\ItemReview;

class ReviewController extends Controller
{

    public function pending()
{
    $userId = Auth::id();

    // Pobieramy wszystkie menu_item_id ze WSZYSTKICH zamówień użytkownika
    $orderedItemIds = DB::table('orders')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->where('orders.user_id', $userId)
        ->pluck('order_items.menu_item_id')
        ->unique()
        ->toArray();

    // Filtrujemy te, dla których nie ma jeszcze recenzji od tego usera
    $itemsToReview = MenuItem::with('reviews')
        ->whereIn('id', $orderedItemIds)
        ->whereDoesntHave('reviews', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->get();

    return view('reviews.pending', compact('itemsToReview'));
}



     //Zapis recenzji i aktualizacja średniej oceny + liczby recenzji w MenuItem

    public function store(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'rating'       => 'required|integer|min:0|max:5',
        ]);

        $userId = Auth::id();
        $menuItem = MenuItem::findOrFail($request->menu_item_id);

        // Zabezpieczenie: czy user już nie ocenił?
        if ($menuItem->reviews()->where('user_id', $userId)->exists()) {
            return back()->with('error', 'Ta pozycja została już oceniona.');
        }

        DB::transaction(function() use ($menuItem, $userId, $request) {
            // Tworzymy recenzję
            ItemReview::create([
                'menu_item_id' => $menuItem->id,
                'user_id'      => $userId,
                'rating'       => $request->rating,
            ]);

            $stats = $menuItem->reviews()
                ->selectRaw('COUNT(*) as cnt, AVG(rating) as avg')
                ->first();

            $menuItem->rating = round($stats->avg, 2);
            $menuItem->rating_count = $stats->cnt;
            $menuItem->save();
        });

        return back()->with('success', 'Dziękujemy za ocenę!');
    }
}
