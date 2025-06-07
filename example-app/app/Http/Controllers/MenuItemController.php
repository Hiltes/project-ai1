<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\ItemReview;
use Illuminate\Support\Facades\DB;

class MenuItemController extends Controller
{
    // lista kategorii do reużycia
    protected $categories = [
        'Fast Food',
        'Pizza',
        'Kuchnia Azjatycka',
        'Kebab & Gyros',
        'Kuchnia Meksykańska',
        'Desery',
        'Kuchnia Włoska',
        'Kuchnia Indyjska',
        'Śniadania i Brunch',
        'Zdrowe Jedzenie',
        'Kuchnia Polska',
        'Street Food',
        'BBQ & Grill',
        'Kuchnia Tajska',
        'Kuchnia Turecka',
        'Napoje',
        'Pieczywo & Wypieki',
        'Zupy',
        'Makarony',
        'Mięsa i Wędliny',
    ];


    public function index(Request $request)
    {
        $query = MenuItem::with('restaurant');

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
        }

        if ($request->filled('category')) {
            $query->whereRaw('LOWER(category) = ?', [strtolower($request->category)]);
        }

        $items = $query->latest()->paginate(10);

        return view('admin.menu_items.index', [
            'items' => $items,
            'categories' => $this->categories,
            'selectedCategory' => $request->category,
        ]);
    }


    public function index2(Request $request)
    {
        $query = MenuItem::with('restaurant');

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
        }

        if ($request->filled('category')) {
            $query->whereRaw('LOWER(category) = ?', [strtolower($request->category)]);
        }


        $sortOption = $request->get('sort', 'newest');
        switch ($sortOption) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $items = $query->paginate(10);

        return view('items.index', [
            'items' => $items,
            'categories' => $this->categories,
            'selectedCategory' => $request->category,
            'selectedSort' => $sortOption,
        ]);
    }

    public function create()
    {
        $restaurants = Restaurant::all();
        return view('admin.menu_items.create', [
            'restaurants' => $restaurants,
            'categories'  => $this->categories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'restaurant_id' => 'required|integer|exists:restaurants,id',
            'category'      => 'required|string|in:' . implode(',', array_map('addslashes', $this->categories)),
        ]);

        try {
            MenuItem::create($data);
            return redirect()->route('admin.menu_items.index')
                ->with('success', 'Danie zostało pomyślnie dodane.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Wystąpił błąd podczas dodawania dania: ' . $e->getMessage());
        }
    }

    //Wyświetlanie w panelu admina
    public function show(MenuItem $menuItem)
    {
        return view('admin.menu_items.show', compact('menuItem'));
    }


    //Wyświetlanie dla użytkownika niezalogowanego / zalogowanego
    public function show2(MenuItem $menuItem)
    {
        $menuItem->load('restaurant');
        return view('items.show', compact('menuItem'));
    }



    public function edit(MenuItem $menuItem)
    {
        $restaurants = Restaurant::all();
        return view('admin.menu_items.edit', [
            'menuItem'    => $menuItem,
            'restaurants' => $restaurants,
            'categories'  => $this->categories,
        ]);
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'restaurant_id' => 'required|exists:restaurants,id',
            'category'      => 'required|string|in:' . implode(',', array_map('addslashes', $this->categories)),
        ]);

        try {
            $menuItem->update($data);
            return redirect()->route('admin.menu_items.index')
                ->with('success', 'Danie zostało pomyślnie zaktualizowane.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Wystąpił błąd podczas aktualizacji dania: ' . $e->getMessage());
        }
    }

    public function destroy(MenuItem $menuItem)
    {
        try {
            $menuItem->delete();
            return redirect()->route('admin.menu_items.index')
                ->with('success', 'Danie zostało pomyślnie usunięte.');
        } catch (\Exception $e) {
            return back()->with('error', 'Wystąpił błąd podczas usuwania dania: ' . $e->getMessage());
        }
    }



public function ranking()
{
    $thisMonth = now()->startOfMonth();

    $rankingItems = MenuItem::with('restaurant')
        ->withCount([
            'reviews as ratings_count' => function ($query) use ($thisMonth) {
                $query->where('created_at', '>=', $thisMonth);
            },
        ])
        ->withAvg('reviews', 'rating')
        ->whereHas('reviews', function ($query) use ($thisMonth) {
            $query->where('created_at', '>=', $thisMonth);
        })
        ->orderByDesc('reviews_avg_rating')
        ->limit(10)
        ->get();

    return view('items.ranking', compact('rankingItems'));
}




}
