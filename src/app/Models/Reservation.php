<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cafe_id',
        'reservation_time',
        'guest_count',
        'status',
    ];

    protected $attributes = [
        'status' => 'confirmed',
    ];

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function cafe() {
        return $this->belongsTo(Cafe::class);
    }
}
