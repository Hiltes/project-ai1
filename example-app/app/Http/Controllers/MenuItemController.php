<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Restaurant;

class MenuItemController extends Controller
{
public function index(Request $request)
{
    $query = MenuItem::with('restaurant');

    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    $items = $query->latest()->paginate(10);

    return view('admin.menu_items.index', compact('items'));
}


    public function create()
    {
        $restaurants = Restaurant::all();
        return view('admin.menu_items.create', compact('restaurants'));
    }


    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'restaurant_id' => 'required|integer',
    ]);


    $restaurantExists = Restaurant::where('id', $data['restaurant_id'])->exists();

    if (!$restaurantExists) {
        return back()->withInput()
                     ->with('error', 'Podana restauracja nie istnieje.');
    }

    try {
        MenuItem::create($data);
        return redirect()->route('admin.menu_items.index')
                       ->with('success', 'Danie zostało pomyślnie dodane.');
    } catch (\Exception $e) {
        return back()->withInput()
                   ->with('error', 'Wystąpił błąd podczas dodawania dania: ' . $e->getMessage());
    }
}

    public function show(MenuItem $menuItem)
    {
        return view('admin.menu_items.show', compact('menuItem'));
    }


    public function edit(MenuItem $menuItem)
    {
        $restaurants = Restaurant::all();
        return view('admin.menu_items.edit', compact('menuItem', 'restaurants'));
    }


    public function update(Request $request, MenuItem $menuItem)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'restaurant_id' => 'required|exists:restaurants,id',
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
}
