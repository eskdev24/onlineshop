<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'status', 'subtotal', 'discount',
        'shipping_cost', 'tax', 'total', 'coupon_code', 'shipping_method',
        'first_name', 'last_name', 'email', 'phone', 'address',
        'city', 'state', 'postal_code', 'country', 'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public static function generateOrderNumber(): string
    {
        return 'BV-' . strtoupper(uniqid());
    }

    public function getStatusBadgeAttribute(): string
    {
        $class = match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'paid' => 'bg-blue-100 text-blue-800',
            'processing' => 'bg-indigo-100 text-indigo-800',
            'shipped' => 'bg-purple-100 text-purple-800',
            'delivered' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
        return '<span class="px-2 py-1 rounded-full text-xs font-semibold ' . $class . ' uppercase">' . $this->status . '</span>';
    }

    public function getCustomerNameAttribute(): string
    {
        if ($this->first_name || $this->last_name) {
            return trim($this->first_name . ' ' . $this->last_name);
        }
        return $this->user ? $this->user->name : 'Guest';
    }
}
