<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id', 'label', 'first_name', 'last_name', 'phone',
        'address_line_1', 'address_line_2', 'city', 'state',
        'postal_code', 'country', 'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address_line_1}, {$this->city}, {$this->state}, {$this->country}";
    }
}
