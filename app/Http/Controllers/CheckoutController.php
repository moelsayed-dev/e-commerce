<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Gloudemans\Shoppingcart\Facades\Cart;
use Akaunting\Money\Money;
use App\Http\Requests\CheckoutRequest;
use Cartalyst\Stripe\Exception\CardErrorException;

class CheckoutController extends Controller
{
    public function index() {



        return view('cart.checkout')
            ->with('newSubtotal', $this->getNumbers()->get('newSubtotal'))
            ->with('newTax', $this->getNumbers()->get('newTax'))
            ->with('discount', $this->getNumbers()->get('discount'))
            ->with('newTotal', $this->getNumbers()->get('newTotal'));
    }

    public function charge(CheckoutRequest $request) {

        $contents = Cart::content()->map(function($item) {
            return $item->model->slug . ', ' . $item->qty;
        })->values()->toJson();

        try {
            $charge = Stripe::charges()->create([
                'amount' => Money::USD($this->getNumbers()->get('newTotal')),
                'currency' => 'USD',
                'source' => $request->stripeToken,
                'description' => 'order',
                'receipt_email' => $request->email,
                'metadata' => [
                    'contents' => $contents,
                    'quantity' => Cart::instance('default')->count(),
                    'discount' => collect(session()->get('coupon'))->toJson(),
                ],
            ]);

            Cart::instance('default')->destroy();
            session()->forget('coupon');

            return redirect(route('cart.index'))->with('success_message', 'Your payment was successful!');
        } catch (CardErrorException $e) {
            return back()->withErrors($e->getMessage());
        }


        // dd($request->all());
    }

    private function getNumbers() {
        $tax = config('cart.tax') / 100;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $newSubtotal = (intval(Cart::subtotal()) - $discount);
        $newTax = $newSubtotal * $tax;
        $newTotal = $newSubtotal + $newTax;

        return collect([
            'tax' => $tax,
            'discount' => $discount,
            'newSubtotal' => $newSubtotal,
            'newTax' => $newTax,
            'newTotal' => $newTotal,
        ]);
    }
}
