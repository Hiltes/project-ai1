<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    protected $types = [
        'Pizza', 'Kuchnia Polska', 'Kuchnia Chińska', 'Kuchnia Włoska', 'Kuchnia Indyjska', 'Sushi', 'Burger', 'Desery', 'Kebab'
    ];

    public function index(Request $request)
    {
        $query = Restaurant::withAvg('reviews', 'rating')->withCount('reviews');



        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
        }

        if ($request->filled('type')) {
            $query->whereRaw('LOWER(type) = ?', [strtolower($request->type)]);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'rating':
                    $query->orderBy('rating', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $restaurants = $query->paginate(10);


        return view('restaurant.index', [

        return view('restaurants.index', [

            'restaurants' => $restaurants,
            'types' => $this->types,
            'selectedType' => $request->type,
            'selectedSort' => $request->sort,
        ]);
    }
}
