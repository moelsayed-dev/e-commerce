@extends('layouts.main')

@section('content')
    <x-navbar/>

    <div class="breadcrumbs text-gray-800 font-semibold">
        <div class="py-6 px-10 md:px-24 lg:px-52 border-b border-gray-300 bg-gray-100 shadow text-gray-bg font-semibold text-sm capitalize">
        <a class="hover:underline" href="{{ route("landing-page") }}">home</a>
        <i class="fa fa-chevron-right"></i>
        <a class="hover:underline" href="{{ route('products.index') }}">shop</a>
    </div>
        <div class="flex flex-row px-10 md:px-24 lg:px-52 pt-10">
            <div class="w-1/4">
                <div>
                    <h5 class="font-bold mb-3 text-xl">Categories</h5>
                    <ul class="font-normal">
                        @foreach ($categories as $category)
                            <li class="leading-loose {{ setActiveCategory($category->slug) }}"><a href="{{ route('products.index', ['category' => $category->slug]) }}" class="hover:text-gray-500">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

            </div>
            <div class="w-3/4 mb-8">
                <div class="flex flex-row items-center justify-between mb-16">
                    <h2 class="text-5xl font-bold border-l-2 border-gray-800 pl-2 capitalize">{{ $title }}</h2>
                    <div>
                        <div>
                            <span>Sort: </span>
                            <a href="{{ route('products.index', ['category' => request()->category, 'sort' => 'low_high']) }}" class="font-normal hover:text-gray-500">Low to High</a>
                            <span class="font-extrabold"> | </span>
                            <a href="{{ route('products.index', ['category' => request()->category, 'sort' => 'high_low']) }}" class="font-normal hover:text-gray-500">High to Low</a>
                        </div>
                    </div>
                </div>

                <div class="products grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 text-center">
                    @forelse ($products as $product)
                        <div class="product w-full mb-8 font-normal text-lg">
                            <a href="{{ route('products.show', $product->slug) }}"><img class="mx-auto" src="{{ asset('img/products/' . $product->slug . '.jpg') }}" alt="product"></a>
                            <a href="{{ route('products.show', $product->slug) }}"><div class="mt-2">{{ $product->name }}</div></a>
                            <div class="text-gray-500 font-normal">{{ $product->presentPrice() }}</div>
                        </div>
                    @empty
                        <div class="font-normal text-left">No items found.</div>
                    @endforelse

                </div>
                {{ $products->links() }}
            </div>
        </div>

    </div>
@endsection
