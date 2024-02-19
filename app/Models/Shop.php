<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'latitude','longitude','address','user_id'];

    function products() 
    {
        return $this->HasMany(Product::class);
    }
    function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
