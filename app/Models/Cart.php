<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['total_price','user_id'];

    function products() {
        return $this->belongsToMany(Product::class)->withPivot('amont','price');
        }
    
    function user(){
        return $this->belongsTo(User::class);
    }

}
