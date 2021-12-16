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
        <div>
            <div class="items-center justify-center border py-32 border-gray-300">
                <img id="currentImage" class="mx-auto h-40" src="{{ productImage($product->image) }}" alt="product">
            </div>

            <div class="grid grid-cols-6 mt-4 gap-6">
                <div class="product-thumbnail flex mx-auto border border-gray-300 items-center p-4 lg:p-0.5 xl:p-2 cursor-pointer hover:border-gray-700 border-gray-700 h-24">
                    <img src="{{ productImage($product->image) }}" alt="product">
                </div>
                @foreach (json_decode($product->images, true) as $image)
                    <div class="product-thumbnail flex mx-auto border border-gray-300 items-center p-4 lg:p-0.5 xl:p-2 cursor-pointer hover:border-gray-700 h-24">
                        <img src="{{ productImage($image) }}" alt="product">
                    </div>
                @endforeach

            </div>
        </div>
        <div class="product-information">
            <h2 class="text-3xl font-bold mb-8">{{ $product->name }}</h2>
            <div>
                <div class="font-semibold text-gray-500">{{ $product->details }}</div>
                <div class="text-3xl font-bold my-5">{{ $product->presentPrice() }}</div>
                <div class="text-lg">
                    <p>{!! $product->description !!}</p>
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
    <x-related-products :relatedProducts="$relatedProducts" />
@endsection

@section('extra-js')
    <script>
        (function() {
            const currentImage = document.querySelector('#currentImage');
            const images = document.querySelectorAll('.product-thumbnail');

            images.forEach((element) => element.addEventListener('click', changeCurrentImage));

            function changeCurrentImage(e) {
                currentImage.src = this.querySelector('img').src;

                images.forEach((element) => element.classList.remove('border-gray-700'));
                this.classList.add('border-gray-700');
            }

        })();
    </script>
@endsection
