<?php

namespace App\Services;

use App\Models\MenuItem;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected $sessionKey = 'cart';

    public function getCart()
    {
        return Session::get($this->sessionKey, [
            'restaurants' => [],
        ]);
    }

    public function add(MenuItem $item, int $quantity = 1)
    {
        $cart = $this->getCart();
        
        $restaurantId = $item->restaurant_id;
        $menuItemId = $item->id;

        if (!isset($cart['restaurants'][$restaurantId])) {
            $cart['restaurants'][$restaurantId] = [
                'restaurant_name' => $item->restaurant->name,
                'items' => []
            ];
        }

        if (isset($cart['restaurants'][$restaurantId]['items'][$menuItemId])) {
            $cart['restaurants'][$restaurantId]['items'][$menuItemId]['quantity'] += $quantity;
        } else {
            $cart['restaurants'][$restaurantId]['items'][$menuItemId] = [
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $quantity,
            ];
        }

        Session::put($this->sessionKey, $cart);
        return true;
    }

    public function remove($restaurantId, $menuItemId)
    {
        $cart = $this->getCart();
        
        if (isset($cart['restaurants'][$restaurantId]['items'][$menuItemId])) {
            unset($cart['restaurants'][$restaurantId]['items'][$menuItemId]);
            
            if (empty($cart['restaurants'][$restaurantId]['items'])) {
                unset($cart['restaurants'][$restaurantId]);
            }
            
            Session::put($this->sessionKey, $cart);
        }
        
        if (empty($cart['restaurants'])) {
            $this->clear();
        }
    }

    public function updateQuantity($restaurantId, $menuItemId, $quantity)
    {
        $cart = session()->get('cart', []);

        if (isset($cart['restaurants'][$restaurantId]['items'][$menuItemId])) {
            $cart['restaurants'][$restaurantId]['items'][$menuItemId]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }
    }

    public function clear()
    {
        Session::forget($this->sessionKey);
    }

    public function total()
    {
        $cart = $this->getCart();
        $sum = 0;

        foreach ($cart['restaurants'] as $restaurant) {
            foreach ($restaurant['items'] as $item) {
                $sum += $item['price'] * $item['quantity'];
            }
        }

        return $sum;
    }
}
