<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'brand');
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        $products = $query->latest()->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        $brands = Brand::active()->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
            'specifications' => 'nullable|array',
            'specifications.*.key' => 'nullable|string|max:255',
            'specifications.*.value' => 'nullable|string|max:255',
        ]);

        $data['slug'] = Str::slug($data['name']).'-'.Str::random(4);
        $data['sku'] = 'BV-'.strtoupper(Str::random(6));
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->has('specifications') && is_array($request->specifications)) {
            $specs = [];
            foreach ($request->specifications as $spec) {
                if (! empty($spec['key']) && ! empty($spec['value'])) {
                    $specs[$spec['key']] = $spec['value'];
                }
            }
            $data['specifications'] = $specs;
        }

        $product = Product::create($data);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $product->images()->create([
                    'image' => $image->store('products/gallery', 'public'),
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created!');
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $brands = Brand::active()->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
            'specifications' => 'nullable|array',
            'specifications.*.key' => 'nullable|string|max:255',
            'specifications.*.value' => 'nullable|string|max:255',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->has('specifications') && is_array($request->specifications)) {
            $specs = [];
            foreach ($request->specifications as $spec) {
                if (! empty($spec['key']) && ! empty($spec['value'])) {
                    $specs[$spec['key']] = $spec['value'];
                }
            }
            $data['specifications'] = $specs;
        } else {
            $data['specifications'] = null;
        }

        $product->update($data);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $product->images()->create([
                    'image' => $image->store('products/gallery', 'public'),
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted!');
    }

    public function deleteImage(\App\Models\ProductImage $image)
    {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image);
        $image->delete();

        return back()->with('success', 'Image removed from gallery!');
    }
}
