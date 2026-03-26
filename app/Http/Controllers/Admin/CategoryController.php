<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->withCount('products')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = Category::parentCategories()->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string', 'parent_id' => 'nullable|exists:categories,id', 'image' => 'nullable|image|max:2048']);
        $data['slug'] = Str::slug($data['name']);
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('categories', 'public');
        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category created!');
    }

    public function edit(Category $category)
    {
        $parentCategories = Category::parentCategories()->where('id', '!=', $category->id)->get();
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string', 'parent_id' => 'nullable|exists:categories,id', 'image' => 'nullable|image|max:2048']);
        $data['slug'] = Str::slug($data['name']);
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('categories', 'public');
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted!');
    }
}
