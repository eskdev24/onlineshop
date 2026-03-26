<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image', 'sort_order'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageUrlAttribute()
    {
        if (! $this->image) {
            return asset('images/no-image.png');
        }

        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        if (str_contains($this->image, 'gallery')) {
            return route('storage.gallery', ['filename' => basename($this->image)]);
        }

        return route('storage.products', ['filename' => basename($this->image)]);
    }
}
