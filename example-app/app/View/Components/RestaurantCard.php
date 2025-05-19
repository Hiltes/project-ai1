<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RestaurantCard extends Component
{
    public $restaurant;

    public function __construct($restaurant)
    {
        $this->restaurant = $restaurant;
    }

    public function render()
    {
        return view('components.restaurant-card');
    }
}
