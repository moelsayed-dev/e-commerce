@extends('layouts.main')

@section('content')
    <x-navbar/>
    <div class="py-6 px-10 md:px-24 lg:px-52 border-b border-gray-300 bg-gray-100 shadow text-gray-bg font-semibold text-sm capitalize">
        <a class="hover:underline" href="{{ route("landing-page") }}">home</a>
        <i class="fa fa-chevron-right"></i>
        <a class="hover:underline" href="{{ route('products.index') }}">shop</a>
        <i class="fa fa-chevron-right"></i>
        <a class="hover:underline" href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 px-10 md:px-24 lg:px-52 py-20">
        <div class="flex items-center justify-center border-gray-300">
            <img class="mx-auto" src="{{ asset('img/products/' . $product->slug . '.jpg') }}" alt="product">
        </div>
        <div class="product-information">
            <h2 class="text-3xl font-bold mb-8">{{ $product->name }}</h2>
            <div>
                <div class="font-semibold text-gray-500">{{ $product->details }}</div>
                <div class="text-3xl font-bold my-5">{{ $product->presentPrice() }}</div>
                <div class="text-lg">
                    <p>{{ $product->description }}</p>
                </div>
            </div>
            <div class="mt-16">
                <form action="{{ route('cart.store') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="product_name" value="{{ $product->name }}">
                    <input type="hidden" name="product_price" value="{{ $product->price }}">
                    <button type="submit" class="border text-center text-lg border-gray-bg py-3 px-10 hover:bg-gray-bg hover:text-white transition ease-in-out duration-200">
                        Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="bg-gray-100 px-10 md:px-24 lg:px-52 py-10">
        <h3 class="text-xl font-bold">You might also like...</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center mt-10 ">
            @foreach ($relatedProducts as $product)
                <div class="product mb-8 font-normal text-lg border border-gray-300 shadow bg-white py-6 px-8">
                    <a href="{{ route('products.show', $product->slug) }}"><img class="mx-auto" src="{{ asset('img/products/' . $product->slug . '.jpg') }}" alt="product"></a>
                    <a href="{{ route('products.show', $product->slug) }}"><div class="mt-2">{{ $product->name }}</div></a>
                    <div class="text-gray-500 font-normal">{{ $product->presentPrice() }}</div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
