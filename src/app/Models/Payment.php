<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'payment_intent_id',
        'amount',
        'status',
        'payment_method',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    public function getAmountAttribute()
    {
        return $this->order->items->sum(fn($item) => $item->product->price * $item->quantity);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
