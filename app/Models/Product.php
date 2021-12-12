<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Akaunting\Money\Currency;
use Akaunting\Money\Money;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;

    public function categories() {
        return $this->belongsToMany('App\Models\Category');
    }

    public function presentPrice($price = null) {
        if($price == null) {
            $price = $this->price;
        }
        return Money::USD($price);
    }
}
