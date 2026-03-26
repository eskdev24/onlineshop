<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'sku', 'category_id', 'brand_id', 'description',
        'short_description', 'price', 'discount_price', 'stock_quantity',
        'image', 'specifications', 'is_active', 'is_featured', 'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'specifications' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function attributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function hotDeals()
    {
        return $this->hasMany(HotDeal::class);
    }

    public function getCurrentHotDealAttribute()
    {
        return $this->hotDeals()
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function getCurrentPriceAttribute()
    {
        $hotDeal = $this->current_hot_deal;
        if ($hotDeal) {
            return $hotDeal->deal_price;
        }

        return $this->discount_price ?? $this->price;
    }

    public function getDiscountPercentAttribute()
    {
        $currentPrice = $this->current_price;
        if ($currentPrice < $this->price && $this->price > 0) {
            return round((($this->price - $currentPrice) / $this->price) * 100);
        }

        return 0;
    }

    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function getImageUrlAttribute()
    {
        if (! $this->image) {
            return asset('images/no-image.png');
        }

        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        return route('storage.products', ['filename' => basename($this->image)]);
    }
}
