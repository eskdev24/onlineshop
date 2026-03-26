<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'logo', 'is_active'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getLogoUrlAttribute()
    {
        if (! $this->logo) {
            return asset('images/no-brand.png');
        }

        if (str_starts_with($this->logo, 'http')) {
            return $this->logo;
        }

        return route('storage.brands', ['filename' => basename($this->logo)]);
    }
}
