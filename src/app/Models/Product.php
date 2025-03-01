<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
    ];

    public function favorites(){
        return $this->hasMany(Favorite::class);
    }

    public function productImages(){
        return $this->hasMany(ProductImage::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function carts() {
        return $this->hasMany(Cart::class);
    }
}
