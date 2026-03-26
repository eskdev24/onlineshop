<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'slug', 'excerpt', 'body', 'image', 'is_published', 'published_at'];
    protected $casts = ['is_published' => 'boolean', 'published_at' => 'datetime'];
    public function scopePublished($q) { return $q->where('is_published', true); }
}
