<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'session_id', 'coupon_code'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_code', 'code');
    }

    public function getSubtotalAttribute()
    {
        return $this->items->sum(fn ($item) => $item->price * $item->quantity);
    }

    public function getTotalItemsAttribute()
    {
        return $this->items->sum('quantity');
    }
}
