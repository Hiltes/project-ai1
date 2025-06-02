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

        $added = $this->cart->add($item, $request->input('quantity', 1));

        if (!$added) {
            return redirect()->back()->with('error', 'Koszyk zawiera dania z innej restauracji. Wyczyść go, aby dodać nowe.');
        }

        return redirect()->back()->with('success', 'Dodano do koszyka.');
    }

    public function remove($restaurantId, $menuItemId)
    {
        $this->cart->remove($restaurantId, $menuItemId);
        return redirect()->route('cart.show')->with('success', 'Usunięto z koszyka.');
    }

    public function clear()
    {
        $this->cart->clear();
        return redirect()->route('cart.show')->with('success', 'Koszyk wyczyszczony.');
    }

    public function show()
    {
        $cart = $this->cart->getCart();
        $total = $this->cart->total();

        return view('cart.show', compact('cart', 'total'));
    }
}
