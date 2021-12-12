<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index() {
        $categories = Category::all();
        if(request()->category) {
            $products = Product::with('categories')->whereHas('categories', function($query) {
                $query->where('slug', request()->category);
            });
            $title = optional($categories->where('slug', request()->category)->first())->name;
        } else {
            $products = Product::where('featured', true);
            $title = "Featured";
        }

        if(request()->sort == "low_high") {
            $products = $products->orderBy('price')->paginate(12)->withQueryString();
        } elseif(request()->sort == "high_low") {
            $products = $products->orderBy('price', 'desc')->paginate(12)->withQueryString();
        } else {
            $products = $products->paginate(12)->withQueryString();
        }

        return view('products.index')->with('products', $products)
            ->with('categories', $categories)
            ->with('title', $title);
    }

    public function show($slug) {
        $product = Product::where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('slug', '!=', $slug)->inRandomOrder()->take(4)->get();
        $pages = ['home', 'shop'];
        $pages[] = $product->slug;

        return view('products.show')->with([
            'product' => $product,
            'pages' => $pages,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
