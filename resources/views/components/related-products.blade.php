<div class="bg-gray-100 px-10 md:px-24 lg:px-52 py-10">
    <h3 class="text-xl font-bold">You might also like...</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center mt-10 ">
        @foreach ($relatedProducts as $product)
        <div class="product mb-8 font-normal text-lg border border-gray-300 shadow bg-white py-6 px-8">
            <a href="{{ route('products.show', $product->slug) }}"><img class="mx-auto"
                    src="{{ productImage($product->image) }}" alt="product"></a>
            <a href="{{ route('products.show', $product->slug) }}">
                <div class="mt-2">{{ $product->name }}</div>
            </a>
            <div class="text-gray-500 font-normal">{{ $product->presentPrice() }}</div>
        </div>
        @endforeach
    </div>
</div>
