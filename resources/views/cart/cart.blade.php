@extends('layouts.main')

@section('content')
    <x-navbar />

    <div class="breadcrumbs text-gray-800 font-semibold">
        <div class="py-6 px-10 md:px-24 lg:px-52 border-b border-gray-300 bg-gray-100 shadow text-gray-bg font-semibold text-sm capitalize">
            <a class="hover:underline" href="{{ route("landing-page") }}">home</a>
            <i class="fa fa-chevron-right"></i>
            <a class="hover:underline" href="{{ route('cart.index') }}">shopping cart</a>
        </div>
    </div>

    <div class="cart px-10 md:px-24 lg:px-52 py-16 xl:w-4/5">
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

        @if (Cart::count() > 0)
            <h2 class="text-2xl font-bold mb-8">{{ Cart::count() }} item(s) in your shopping cart</h2>
            <div class="cart-items">
                @foreach (Cart::content() as $cartItem)
                    <div x-data="{ open: true }">
                        <div x-show="open" class="flex flex-col sm:flex-row justify-between items-center border-t-2 border-b-2 border-gray-300 py-4 px-2">
                            <a href="{{ route('products.show', $cartItem->model->slug) }}" class="mb-4 sm:mb-0"><img src="{{ asset('img/products/' . $cartItem->model->slug . '.jpg') }}" alt="" class="h-20 w-28"></a>
                            <div class="text-center sm:text-left">
                                <a href="{{ route('products.show', $cartItem->model->slug) }}" class="text-lg font-sans">{{ $cartItem->name }}</a>
                                <p class="product-details text-gray-500 font-normal w-72">{{ $cartItem->model->details }}</p>
                            </div>
                            <div class="flex flex-col text-center sm:text-left my-2 sm:my-0">
                                <form action="{{ route('cart.destroy', $cartItem->rowId) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" x-on:click="open = false" class="text-sm text-red-400 font-bold">Remove</button>
                                </form>

                                <form action="{{ route('cart.saveForLater', $cartItem->rowId) }}" method="POST">
                                    {{ csrf_field() }}

                                    <button type="submit" class="text-sm text-gray-500 font-bold">Save for later</button>
                                </form>
                            </div>
                            <div class="mb-2 sm:mb-0">
                                <input type="number" min="1" max="5" value="{{ $cartItem->qty }}" data-id="{{ $cartItem->rowId }}" class="quantity w-14 border border-gray-300 rounded p-2">
                            </div>
                            <div class="price font-semibold">{{ $cartItem->model->presentPrice($cartItem->subtotal) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="total flex justify-between bg-gray-100 mt-10 py-6 px-4 font-normal">
                <div class="mr-10">
                    <p>Shipping is free because we're awesome like that. Also i'm too lazy to figure it out :D.</p>
                </div>
                <div>
                    <div class="flex"><p>Subtotal:</p> <span class="ml-4">{{ $cartItem->model->presentPrice(Cart::subtotal()); }}</span></div>
                    <div class="flex"><p>Tax:</p> <span class="ml-3">{{ $cartItem->model->presentPrice(Cart::tax()); }}</span></div>
                    <div class="flex text-lg font-bold"><p>Total:</p> <span class="ml-3">{{ $cartItem->model->presentPrice(Cart::total()); }}</span></div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between mt-10">
                <a href="{{ route('products.index') }}" class="border text-center text-lg border-gray-bg py-3 px-10 hover:bg-gray-bg hover:text-white transition ease-in-out duration-200 mb-4 sm:mb-0">Continue Shopping</a>
                <a href="{{ route('checkout.index') }}" class="border text-center text-lg border-green-500 py-3 px-10 hover:bg-green-400 transition ease-in-out duration-200 bg-green-500 text-white">Proceeed to Checkout</a>
            </div>
            @else
                <h2 class="text-lg font-semibold mb-8">Your shopping cart is empty.</h2>
                <a href="{{ route('products.index') }}" class="border text-center text-lg border-gray-bg py-3 px-10 hover:bg-gray-bg hover:text-white transition ease-in-out duration-200 mb-4 sm:mb-0">Continue Shopping</a>
        @endif

        @if (Cart::instance('saved')->count() > 0)
            <h2 class="text-2xl font-bold my-8">{{ Cart::instance('saved')->count() }} item(s) saved for later</h2>
            <div class="cart-items">
                @foreach (Cart::instance('saved')->content() as $cartItem)
                    <div x-data="{ open: true }">
                        <div x-show="open" class="flex flex-col sm:flex-row justify-between items-center border-t-2 border-b-2 border-gray-300 py-4 px-2">
                            <a href="{{ route('products.show', $cartItem->model->slug) }}" class="mb-4 sm:mb-0"><img src="{{ asset('img/products/' . $cartItem->model->slug . '.jpg') }}" alt="" class="h-20 w-30"></a>
                            <div class="text-center sm:text-left">
                                <a href="{{ route('products.show', $cartItem->model->slug) }}" class="text-lg font-sans">{{ $cartItem->name }}</a>
                                <p class="product-details text-gray-500 font-normal">{{ $cartItem->model->details }}</p>
                            </div>
                            <div class="flex flex-col text-center sm:text-left my-2 sm:my-0">
                                <form action="{{ route('saveForLater.destroy', $cartItem->rowId) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" x-on:click="open = false" class="text-sm text-red-400 font-bold">Remove</button>
                                </form>

                                <form action="{{ route('saveForLater.moveToCart', $cartItem->rowId) }}" method="POST">
                                    {{ csrf_field() }}

                                    <button type="submit" x-on:click="open = false" class="text-sm text-gray-500 font-bold">Move to Cart</button>
                                </form>
                            </div>
                            <div class="mb-2 sm:mb-0">
                                <input type="number" min="1" value="1" class="w-12 border border-gray-300 rounded pl-1">
                            </div>
                            <div class="price">{{ $cartItem->model->presentPrice() }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
                <h2 class="text-lg font-semibold my-8">You have no saved items.</h2>
        @endif
    </div>

    <div class="bg-gray-100 px-10 md:px-24 lg:px-52 py-10">
        <h3 class="text-xl font-bold">You might also like...</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center mt-20 ">
            @foreach ($relatedProducts as $product)
                <div class="product mb-8 font-normal text-lg border border-gray-300 shadow bg-white py-6 px-8">
                    <a href="{{ route('products.show', $product->slug) }}"><img class="mx-auto" src="{{ asset('img/products/' . $product->slug . '.jpg') }}" alt="product"></a>
                    <a href="{{ route('products.show', $product->slug) }}"><div class="mt-2 text-lg font-semibold font-sans">{{ $product->name }}</div></a>
                    <div class="text-gray-500 font-normal">{{ $product->presentPrice() }}</div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

@section('extra-js')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        (function() {
            const items = document.querySelectorAll('.quantity')
            Array.from(items).forEach(function(element) {
                element.addEventListener('change', function() {
                    document.querySelectorAll('.quantity').disabled = true;
                    const id = element.getAttribute('data-id')
                    axios.patch(`/cart/${id}`, {
                            quantity: this.value
                        })
                        .then(function (response) {
                            window.location.reload();
                        })
                        .catch(function (error) {
                            window.location.reload();
                        });
                })
            })
        })();
    </script>
@endsection
