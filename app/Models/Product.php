<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = ['code', 'name', 'price', 'category_id', 'description', 'shop_id'];

    function shop() 
    {
        return $this->belongsTo(Shop::class);
    }

    function category() 
    {
        return $this->belongsTo(Category::class);
    }

    function carts()
    {
        return $this->belongstoMany(Cart::class);
    }
}

