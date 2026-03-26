<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlider extends Model
{
    protected $fillable = ['image', 'title', 'subtitle', 'link', 'link_text', 'buttons', 'is_active', 'sort_order'];

    public function getRouteKeyName()
    {
        return 'id';
    }

    protected $casts = [
        'is_active' => 'boolean',
        'buttons' => 'array',
    ];

    public function getImageUrlAttribute()
    {
        if (! $this->image) {
            return null;
        }

        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        return '/images/'.$this->image;
    }
}
