<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order_value', 'usage_limit',
        'used_count', 'expires_at', 'is_active',
    ];

    protected $casts = [
        'expires_at' => 'date',
        'is_active' => 'boolean',
        'value' => 'decimal:2',
        'min_order_value' => 'decimal:2',
    ];

    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function getTotalUsedAttribute(): int
    {
        return $this->used_count ?? $this->usages()->count();
    }

    public function isValid(float $orderTotal = 0): bool
    {
        if (!$this->is_active) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        if ($this->min_order_value && $orderTotal < $this->min_order_value) return false;
        return true;
    }

    public function calculateDiscount(float $total): float
    {
        if ($this->type === 'percentage') {
            return round($total * ($this->value / 100), 2);
        }
        return min($this->value, $total);
    }
}
