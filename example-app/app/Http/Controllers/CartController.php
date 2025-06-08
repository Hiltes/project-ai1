<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function add($menuItemId, Request $request)
    {
        $item = MenuItem::findOrFail($menuItemId);
        $quantity = $request->input('quantity', 1);

        $added = $this->cart->add($item, $quantity); 

        return redirect()->route('items.index')->with('success', 'Dodano do koszyka.');
    }

    public function remove($restaurantId, $menuItemId)
    {
        $this->cart->remove($restaurantId, $menuItemId);

        return redirect()->route('cart.show')
            ->with('success', 'Usunięto z koszyka.');
    }


    public function clear()
    {
        $this->cart->clear();

        return redirect()->route('cart.show')
            ->with('success', 'Koszyk wyczyszczony.');
    }

    public function show()
    {
        $cart = $this->cart->getCart();
        $total = $this->cart->total();

        return view('cart.show', compact('cart', 'total'));
    }

    public function update($restaurantId, $menuItemId, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $quantity = $request->input('quantity');

        $this->cart->updateQuantity($restaurantId, $menuItemId, $quantity);

        return redirect()->route('cart.show')->with('success', 'Zaktualizowano ilość w koszyku.');
    }
}