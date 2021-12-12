<div>
    <nav class="text-white px-10 md:px-24 lg:px-52 bg-gray-bg">
        <div class="top-nav flex flex-col md:flex-row justify-between items-center py-7">
            <div class="text-gray-300 font-bold text-2xl mb-5 md:mb-1"><a href="/">E-Commerce</a></div>
            <ul class="flex justify-between w-full sm:w-4/5 md:w-1/2 lg:w-1/3 uppercase font-semibold text-gray-300">
                <li class="hover:text-gray-400"><a href="/shop">Shop</a></li>
                <li class="hover:text-gray-400"><a href="#">About</a></li>
                <li class="hover:text-gray-400"><a href="#">Blog</a></li>
                <li class="hover:text-gray-400">
                    <a href="{{ route('cart.index') }}">Cart <span
                            class=" bg-yellow-500 rounded-full text-white font-bold text-sm px-1.5 py-0.5">{{ Cart::instance('default')->count() }}</span></a>
                </li>
            </ul>
        </div> <!-- end top-nav -->
    </nav>
</div>
