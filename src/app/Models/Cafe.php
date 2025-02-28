<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cafe extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'description',
        'address',
        'latitude',
        'longitude',
    ];

    public function owner(){
        return $this->belongsTo(Owner::class);
    }

    public function favorites(){
        return $this->hasMany(Favorite::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }
}
