<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->inStock()->with('category', 'brand');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $sortBy = $request->get('sort', 'latest');
        $query = match($sortBy) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc' => $query->orderBy('name', 'asc'),
            'popular' => $query->withCount('approvedReviews')->orderByDesc('approved_reviews_count'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::active()->parentCategories()->withCount('products')->get();
        $brands = Brand::active()->withCount('products')->get();

        return view('pages.shop', compact('products', 'categories', 'brands'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->active()->with(['images', 'category', 'brand', 'approvedReviews.user', 'attributeValues.attribute'])->firstOrFail();
        $relatedProducts = Product::active()->inStock()->where('category_id', $product->category_id)->where('id', '!=', $product->id)->take(4)->get();

        return view('pages.product', compact('product', 'relatedProducts'));
    }
}
