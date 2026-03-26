<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('products')->latest()->paginate(15);
        return view('admin.brands.index', compact('brands'));
    }

    public function create() { return view('admin.brands.create'); }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:255', 'logo' => 'nullable|image|max:2048']);
        $data['slug'] = Str::slug($data['name']);
        if ($request->hasFile('logo')) $data['logo'] = $request->file('logo')->store('brands', 'public');
        Brand::create($data);
        return redirect()->route('admin.brands.index')->with('success', 'Brand created!');
    }

    public function edit(Brand $brand) { return view('admin.brands.edit', compact('brand')); }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate(['name' => 'required|string|max:255', 'logo' => 'nullable|image|max:2048']);
        $data['slug'] = Str::slug($data['name']);
        if ($request->hasFile('logo')) $data['logo'] = $request->file('logo')->store('brands', 'public');
        $brand->update($data);
        return redirect()->route('admin.brands.index')->with('success', 'Brand updated!');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted!');
    }
}
