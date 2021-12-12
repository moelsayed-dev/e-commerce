<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Models\Product;

class SaveForLaterController extends Controller
{
    public function destroy($id) {
        Cart::instance('saved')->remove($id);

        return back()->with('success_message', 'Item removed successfuly.');
    }

    public function moveToCart($rowId) {
        $product = Cart::instance('saved')->get($rowId);

        Cart::instance('saved')->remove($rowId);

        $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id === $product->id;
        });
        if ($duplicates->isNotEmpty()) {
            return redirect(route('cart.index'))->with('success_message', 'This item is already in your cart.');
        }

        Cart::instance('default')->add($product->id, $product->name, 1, $product->price)
            ->associate(Product::class);

        return redirect(route('cart.index'))->with('success_message', 'Item has been added to your cart.');
    }
}
