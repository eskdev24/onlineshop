<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotDeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 
        'deal_price', 
        'start_date', 
        'end_date', 
        'is_active', 
        'sort_order'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('start_date', '<=', now())
                     ->where('end_date', '>=', now())
                     ->orderBy('sort_order', 'asc');
    }

    public function getIsExpiredAttribute()
    {
        return $this->end_date->isPast();
    }
}
