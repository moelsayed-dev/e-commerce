<?php

use Akaunting\Money\Money;

function setActiveCategory($category) {
    return request()->category == $category ? 'font-semibold' : '';
}

function presentPrice($price) {
    return Money::USD($price);
}

function productImage($path) {
    return $path && file_exists('storage/'.$path) ? asset('storage/' . $path) : asset('img/image-not-found.jpg');
}
