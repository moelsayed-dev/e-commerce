@extends('layouts.main')

@section('content')
    <div>
        <header class="text-white px-10 md:px-24 lg:px-52">
            <div class="top-nav flex flex-col md:flex-row justify-between items-center py-7">
                <div class="text-gray-300 font-bold text-2xl mb-5 md:mb-1"><a href="/">E-Commerce</a></div>
                <ul class="flex justify-between w-full sm:w-4/5 md:w-1/2 lg:w-1/3 uppercase font-semibold text-gray-300">
                    <li class="hover:text-gray-400"><a href="/shop">Shop</a></li>
                    <li class="hover:text-gray-400"><a href="#">About</a></li>
                    <li class="hover:text-gray-400"><a href="#">Blog</a></li>
                    <li class="hover:text-gray-400">
                        <a href="{{ route('cart.index') }}">Cart <span class=" bg-yellow-400 rounded-full text-gray-700 font-bold text-sm px-1.5 py-0.5">{{ Cart::instance('default')->count() }}</span></a>
                    </li>
                </ul>
            </div> <!-- end top-nav -->
            <div class="hero grid grid-cols-1 md:grid-cols-2 gap-4 pt-5 pb-20">
                <div class="hero-copy text-center md:text-left">
                    <h1 class="text-4xl mt-12 font-semibold">E-Commerce Website</h1>
                    <p class="text-lg mt-10 mb-14">Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <div class="flex justify-center md:justify-start">
                        <a href="{{ route('products.index') }}" class="w-52 border-2 text-center text-lg border-gray-300 py-3 px-10 hover:bg-gray-300 hover:text-gray-900 transition ease-in-out duration-200 mr-4">Start Shopping</a>
                        <a href="#" class="w-52 border-2 text-center text-lg border-gray-300 py-3 px-10 hover:bg-gray-300 hover:text-gray-900 transition ease-in-out duration-200">Flash Sales</a>
                    </div>
                </div> {{-- end hero-copy --}}
                <div class="md:pl-14 mt-5 md:mt-0">
                    <img class="w-full md:w-auto" src="img/macbook-pro-laravel.png" alt="hero image">
                </div>
            </div> {{-- end hero --}}
        </header>
        <div class="featured-section py-12 px-10 md:px-28 text-gray-800">
            <div class="text-center">
                <h1 class="text-4xl font-bold">Featured Products</h1>
                <p class="text-lg text-gray-800 pt-10 w-4/5 mx-auto">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus aliquid,
                in eum minima magni magnam nobis aspernatur optio sed. Nesciunt,
                eos iure? Esse, nulla ut. Aliquid, temporibus quaerat. Dolor, consequatur!</p>

                <div class="button-container py-16">
                    <a href="#" class="border text-center text-lg border-gray-bg py-3 px-10 hover:bg-gray-bg hover:text-white transition ease-in-out duration-200 mr-3">Featured</a>
                    <a href="#" class="border text-center text-lg border-gray-bg py-3 px-10 hover:bg-gray-bg hover:text-white transition ease-in-out duration-200">On Sale</a>
                </div>
            </div>

            <div class="products grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 text-center w-4/5 mx-auto">
                @foreach ($products as $product)
                    <div class="product mb-4">
                        <a href="{{ route('products.show', $product->slug) }}"><img class="mx-auto mb-4" src="{{ asset('img/products/' . $product->slug . '.jpg') }}" alt="product"></a>
                        <a href="{{ route('products.show', $product->slug) }}"><div class="product-name">{{ $product->name }}</div></a>
                        <div class="product-price">{{ $product->presentPrice() }}</div>
                    </div>
                @endforeach
            </div> {{-- end products --}}

            <div class="text-center py-16">
                <a href="{{ route('products.index') }}"  class="border text-center text-lg border-gray-bg py-3 px-10 hover:bg-gray-bg hover:text-white transition ease-in-out duration-200">View more products</a>
            </div>
        </div> {{-- end featured section --}}

        <div class="blog-section bg-gray-100 border-t border-gray-300 py-12 text-center text-gray-800 px-10 md:px-28">
            <h1 class="text-4xl font-bold mb-10">From Our Blog</h1>
            <p class="section-description text-lg w-4/5 mx-auto">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Fugiat dignissimos quasi asperiores expedita culpa rerum nobis ut libero illum temporibus.
            Quasi aspernatur molestias non placeat tenetur tempora eligendi veritatis maxime?</p>

            <div class="blog-posts grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 py-14 w-4/5 mx-auto">
                <div>
                    <a href="#"><img class="w-full" src="img/blog1.png" alt="blog image"></a>
                    <a href="#"><h2 class="text-2xl font-bold pb-3 pt-2">Blog Post Title</h2></a>
                    <p class="text-lg">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi earum animi.</p>
                </div>

                <div>
                    <a href="#"><img class="w-full" src="img/blog1.png" alt="blog image"></a>
                    <a href="#"><h2 class="text-2xl font-bold pb-3 pt-2">Blog Post Title</h2></a>
                    <p class="text-lg">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi earum animi.</p>
                </div>

                <div>
                    <a href="#"><img class="w-full" src="img/blog1.png" alt="blog image"></a>
                    <a href="#"><h2 class="text-2xl font-bold pb-3 pt-2">Blog Post Title</h2></a>
                    <p class="text-lg">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi earum animi.</p>
                </div>
            </div> {{-- end blog posts --}}
        </div> {{-- end blog section --}}
    </div>
@endsection
