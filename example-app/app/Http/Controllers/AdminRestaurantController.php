<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminRestaurantController extends Controller
{
    protected $types = [
        'Pizza', 'Kuchnia Polska', 'Kuchnia Chińska', 'Kuchnia Włoska', 'Kuchnia Indyjska',
        'Sushi', 'Burger', 'Desery', 'Kebab', 'Fast Food', 'Kuchnia Tajska'
    ];

    public function index(Request $request)
    {
        $query = Restaurant::query();

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
        }

        if ($request->filled('type')) {
            $query->whereRaw('LOWER(type) = ?', [strtolower($request->type)]);
        }

        $restaurants = $query->latest()->paginate(10);

        return view('admin.restaurants.index', [
            'restaurants' => $restaurants,
            'types' => $this->types,
            'selectedType' => $request->type,
        ]);
    }

    public function create()
    {
        return view('admin.restaurants.create', [
            'types' => $this->types,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'type' => ['required', 'string', Rule::in($this->types)],
            'is_active' => 'nullable|boolean',
            'delivery_fee' => 'nullable|numeric|min:0',
        ]);

        $data['is_active'] = $request->has('is_active');
        $data['owner_id'] = auth()->id();

        try {
            Restaurant::create($data);
            return redirect()->route('admin.restaurants.index')
                ->with('success', 'Restauracja została dodana pomyślnie.');
        } catch (\Exception $e) {
            \Log::error('Błąd podczas tworzenia restauracji: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Wystąpił błąd podczas tworzenia restauracji. Szczegóły: ' . $e->getMessage());
        }
    }

    public function edit(Restaurant $restaurant)
    {
        return view('admin.restaurants.edit', [
            'restaurant' => $restaurant,
            'types' => $this->types,
        ]);
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'type' => ['required', 'string', Rule::in($this->types)],
            'is_active' => 'nullable|boolean',
            'delivery_fee' => 'nullable|numeric|min:0',
        ]);

        $data['is_active'] = $request->has('is_active');

        try {
            $restaurant->update($data);
            return redirect()->route('admin.restaurants.index')
                ->with('success', 'Restauracja została zaktualizowana pomyślnie.');
        } catch (\Exception $e) {
            \Log::error('Błąd podczas aktualizacji restauracji ID ' . $restaurant->id . ': ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Wystąpił błąd podczas aktualizacji restauracji. Szczegóły: ' . $e->getMessage());
        }
    }

    public function destroy(Restaurant $restaurant)
    {
        try {
            $restaurant->delete();
            return redirect()->route('admin.restaurants.index')
                ->with('success', 'Restauracja została usunięta pomyślnie.');
        } catch (\Exception $e) {
            \Log::error('Błąd podczas usuwania restauracji ID ' . $restaurant->id . ': ' . $e->getMessage());
            return back()->with('error', 'Wystąpił błąd podczas usuwania restauracji. Szczegóły: ' . $e->getMessage());
        }
    }

    public function show(Restaurant $restaurant)
    {
        return view('admin.restaurants.show', [
            'restaurant' => $restaurant,
        ]);
    }
}