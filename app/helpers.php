<?php

use Akaunting\Money\Money;

function setActiveCategory($category) {
    return request()->category == $category ? 'font-semibold' : '';
}

function presentPrice($price) {
    return Money::USD($price);
}
