@extends('layouts.main')

@section('links')
    <script defer src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')

    <x-navbar />

<div class="px-10 md:px-24 xl:px-52 pt-10 pb-20">
    <h2 class="text-4xl font-bold mb-10 border-l-2 border-gray-800 pl-2 font-mono">Checkout</h2>
    @if (session()->has('success_message'))
        <div class="bg-green-100 my-6 py-5 px-5 rounded text-green-600">
            {{ session()->get('success_message') }}
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="bg-red-100 my-6 py-5 px-5 rounded text-red-400">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 lg:gap-20">
        <div>
            <form id="payment-form" class="grid grid-cols-1 gap-4" method="POST" action="{{ route('checkout.charge') }}">
                {{ csrf_field() }}
                <h4 class="text-2xl font-semibold font-mono mb-4">Billing Details</h4>
                <label class="block">
                    <span class="text-gray-700">Email Address</span>
                    <input type="email" id="email" name="email" class="mt-1 py-3 block w-full rounded focus:border-gray-bg focus:ring-gray-bg" value="{{ old('email') }}" required>
                </label>
                <label class="block">
                    <span class="text-gray-700">Name</span>
                    <input type="text" id="name" name="name" class="mt-1 py-3 block w-full rounded focus:border-gray-bg focus:ring-gray-bg" value="{{ old('name') }}" required>
                </label>
                <label class="block">
                    <span class="text-gray-700">Address</span>
                    <input type="text" id="address" name="address" class="mt-1 py-3 block w-full rounded focus:border-gray-bg focus:ring-gray-bg" value="{{ old('address') }}" required>
                </label>
                <div class="grid grid-cols-2 gap-8">
                    <label class="inline">
                        <span class="text-gray-700">City</span>
                        <input type="text" id="city" name="city" class="mt-1 py-3 block w-full rounded focus:border-gray-bg focus:ring-gray-bg" value="{{ old('city') }}" required>
                    </label>
                    <label class="inline">
                        <span class="text-gray-700">Province</span>
                        <input type="text" id="province" name="province" class="mt-1 py-3 block w-full rounded focus:border-gray-bg focus:ring-gray-bg" value="{{ old('province') }}" required>
                    </label>
                    <label class="inline">
                        <span class="text-gray-700">Postal Code</span>
                        <input type="text" id="postalcode" name="postalcode" class="mt-1 py-3 block w-full rounded focus:border-gray-bg focus:ring-gray-bg" value="{{ old('postalcode') }}" required>
                    </label>
                    <label class="inline">
                        <span class="text-gray-700">Phone</span>
                        <input type="tel" id="phone" name="phone" class="mt-1 py-3 block w-full rounded focus:border-gray-bg focus:ring-gray-bg" value="{{ old('phone') }}" required>
                    </label>
                </div>

                <h4 class="text-2xl font-semibold font-mono mt-4">Payment Details</h4>
                <label class="block">
                    <span class="text-gray-700">Name on Card</span>
                    <input type="text" id="name_on_card" name="name_on_card" class="mt-1 py-3 block w-full rounded focus:border-gray-bg focus:ring-gray-bg" value="{{ old('name_on_card') }}" required>
                </label>
                <div class="block">
                    <label for="card-element">Credit or Debit Card</label>
                    <div id="card-element"></div>
                </div>

                {{-- display payment errors --}}
                <div id="card-errors" role="alert"></div>

                <button id="complete-order" type="submit" class="disabled:cursor-not-allowed disabled:opacity-50 mt-6 text-center text-lg py-3 px-10 hover:bg-green-400 transition ease-in-out duration-200 bg-green-500 text-white font-bold rounded">Place Order</button>
            </form>
        </div>
        <div>
            <h4 class="text-2xl font-semibold font-mono my-8 lg:mt-0 lg:mb-14">Your Order</h4>
            <div class="cart-items">
                @foreach (Cart::content() as $cartItem)
                    <div>
                        <div class="flex flex-col sm:flex-row justify-between items-center border-t-2 border-b-2 border-gray-300 py-4 px-2">
                            <a href="{{ route('products.show', $cartItem->model->slug) }}" class="mb-4 sm:mb-0"><img src="{{ asset('img/products/' . $cartItem->model->slug . '.jpg') }}" alt="" class="h-20 w-28"></a>
                            <div class="text-center sm:text-left">
                                <a href="{{ route('products.show', $cartItem->model->slug) }}" class="text-lg font-sans font-semibold">{{ $cartItem->name }}</a>
                                <p class="product-details text-gray-500 font-normal w-72">{{ $cartItem->model->details }}</p>
                                <p class="price font-semibold">{{ $cartItem->model->presentPrice() }}</p>
                            </div>
                            <div class="mb-2 sm:mb-0">
                                <p class="border-2 border-gray-300 py-2 px-3">{{ $cartItem->qty }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="grid grid-cols-2 gap-y-3 py-4 border-b-2 border-gray-300">
                <div><p>Subtotal</p></div>  <div class="text-right">{{ $cartItem->model->presentPrice(Cart::subtotal()); }}</div>
                @if (session()->has('coupon'))
                    <div>
                        <span>Discount Coupon ({{ session()->get('coupon')['name'] }}) </span>
                        <form action="{{ route('coupon.destroy') }}" method="POST" class="inline">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button type="submit" class="text-sm text-red-400 font-bold ml-1">Remove</button>
                        </form>
                    </div>
                    <div class="text-right">-{{ presentPrice(session()->get('coupon')['discount']) }}</div>
                @endif
                @if (!session()->has('coupon'))
                    <div><p>Tax ({{ config('cart.tax') }}%)</p></div>  <div class="text-right">{{ presentPrice(Cart::tax()) }}</div>
                    <div class="text-lg font-bold"><p>Total</p></div>  <div class="text-right text-lg font-bold">{{ presentPrice(Cart::total()) }}</div>
                @endif
            </div>
            @if (session()->has('coupon'))
                <div class="grid grid-cols-2 gap-y-3 py-4 border-b-2 border-gray-300">
                    <div><p>New Subtotal</p></div>  <div class="text-right">{{ presentPrice($newSubtotal) }}</div>
                    <div><p>Tax ({{ config('cart.tax') }}%)</p></div>  <div class="text-right">{{ presentPrice($newTax) }}</div>
                    <div class="text-lg font-bold"><p>Total</p></div>  <div class="text-right text-lg font-bold">{{ presentPrice($newTotal) }}</div>
                </div>
            @endif


            @if (!session()->has('coupon'))
                <div class="coupon mt-6 text-center">
                    <p class="text-lg font-normal mb-4">Have a Code?</p>
                    <form action="{{ route('coupon.apply') }}" method="POST"iv class="flex flex-grow border-2 border-gray-400 max-w-min p-4 mx-auto">
                        {{ csrf_field() }}
                        <input type="text" name="coupon_code" class="border-2 border-r-0 border-gray-300 py-2 px-4 focus:border-gray-bg focus:ring-0 w-auto">
                        <button type="submit" class="border-2 border-gray-bg px-10 py-3 font-semibold hover:bg-gray-bg hover:text-white transition ease-in-out duration-150">Apply</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('extra-js')
    <script>
        (function(){
            // Create a Stripe client
            var stripe = Stripe('pk_test_51K2iV3KdekwVAlLGT0r9ZejT0U4dakEUM8zANFzk82hPFkPTalOOvZ2BR9DX6LHtqFV27zwUVJ2rlKyZi8cIDNxH00vESYwdm9');
            // Create an instance of Elements
            var elements = stripe.elements();
            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
              base: {
                color: '#32325d',
                lineHeight: '18px',
                fontFamily: '"Roboto", Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                  color: '#aab7c4'
                }
              },
              invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
              }
            };
            // Create an instance of the card Element
            var card = elements.create('card', {
                style: style,
                hidePostalCode: true
            });
            // Add an instance of the card Element into the `card-element` <div>
            card.mount('#card-element');
            // Handle real-time validation errors from the card Element.
            card.addEventListener('change', function(event) {
              var displayError = document.getElementById('card-errors');
              if (event.error) {
                displayError.textContent = event.error.message;
              } else {
                displayError.textContent = '';
              }
            });
            // Handle form submission
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
              event.preventDefault();

              // Disable the submit button to prevent repeated clicks
              document.getElementById('complete-order').disabled = true;
              var options = {
                name: document.getElementById('name_on_card').value,
                address_line1: document.getElementById('address').value,
                address_city: document.getElementById('city').value,
                address_state: document.getElementById('province').value,
                address_zip: document.getElementById('postalcode').value
              }
              stripe.createToken(card, options).then(function(result) {
                if (result.error) {
                  // Inform the user if there was an error
                  var errorElement = document.getElementById('card-errors');
                  errorElement.textContent = result.error.message;

                  // Enable the submit button
                  document.getElementById('complete-order').disabled = false;
                } else {
                  // Send the token to your server
                  stripeTokenHandler(result.token);
                }
              });
            });
            function stripeTokenHandler(token) {
              // Insert the token ID into the form so it gets submitted to the server
              var form = document.getElementById('payment-form');
              var hiddenInput = document.createElement('input');
              hiddenInput.setAttribute('type', 'hidden');
              hiddenInput.setAttribute('name', 'stripeToken');
              hiddenInput.setAttribute('value', token.id);
              form.appendChild(hiddenInput);
              // Submit the form
              form.submit();
            }
        })();
    </script>
@endsection
