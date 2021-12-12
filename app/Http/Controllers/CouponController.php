<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request) {
        $coupon = Coupon::findByCode($request->coupon_code);
        // $coupon = Coupon::where('code', $request->coupon_code)->first();
        if(!$coupon) {
            return redirect(route('checkout.index'))->withErrors('Invalid coupon code, try a different one.');
        }

        session()->put('coupon', [
            'name' => $coupon->code,
            'discount' => $coupon->discount(Cart::subtotal()),
        ]);
        return redirect(route('checkout.index'))->with('success_message', 'Coupon applied!');
    }

    public function destroy() {
        session()->forget('coupon');
        return redirect(route('checkout.index'))->with('success_message', 'Coupon was removed!');
    }

}
