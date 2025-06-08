<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $restaurantsToReview = Restaurant::whereDoesntHave('reviews', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        $restaurantToReview = $restaurantsToReview->isNotEmpty()
            ? $restaurantsToReview->random()
            : null;

        return view('customer.dashboard', compact('restaurantToReview'));
    }
}
