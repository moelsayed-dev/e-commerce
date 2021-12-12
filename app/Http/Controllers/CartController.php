<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Akaunting\Money\Money;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index() {
        $relatedProducts = Product::inRandomOrder()->take(4)->get();

        return view('cart.cart')->with('relatedProducts', $relatedProducts);
    }

    public function store(Request $request) {
        $duplicates = Cart::search(function($cartItem, $rowId) use ($request) {
            return $cartItem->id === $request->product_id;
        });
        if($duplicates->isNotEmpty()) {
            return redirect(route('cart.index'))->with('success_message', 'This item is already in your cart.');
        }
        Cart::add($request->product_id, $request->product_name, 1, $request->product_price)
            ->associate(Product::class);

        return redirect(route('cart.index'))->with('success_message', 'Product added to your shopping cart.');
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,5'
        ]);

        if($validator->fails()) {
            session()->flash('errors', $validator->errors());
            return response()->json(['success' => false], 400);
        }

        Cart::update($id, $request->quantity);
        session()->flash('success_message', 'Updated quantity.');

        return response()->json(['success' => true], 200);
    }

    public function destroy($id) {
        Cart::remove($id);

        return back()->with('success_message', 'Item removed successfuly.');
    }
    public function saveForLater($rowId) {
        $product = Cart::get($rowId);

        Cart::instance('default')->remove($rowId);

        $duplicates = Cart::instance('saved')->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id === $product->id;
        });
        if ($duplicates->isNotEmpty()) {
            return redirect(route('cart.index'))->with('success_message', 'This item is already saved for later.');
        }

        Cart::instance('saved')->add($product->id, $product->name, 1, $product->price)
            ->associate(Product::class);

        return redirect(route('cart.index'))->with('success_message', 'Item has been saved.');
    }
}
