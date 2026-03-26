@extends('layouts.admin')
@section('title', isset($product) ? 'Edit Product' : 'Add New Product')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-900">{{ isset($product) ? 'Edit Product' : 'Add New Product' }}</h1>
    <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">← Back to list</a>
</div>

<form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($product)) @method('PUT') @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Info --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Basic Information</h2>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Barcode</label>
                        <input type="text" name="barcode" value="{{ old('barcode', $product->barcode ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
                    <textarea name="short_description" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">{{ old('short_description', $product->short_description ?? '') }}</textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Description</label>
                    <textarea name="description" rows="5" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">{{ old('description', $product->description ?? '') }}</textarea>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Pricing & Inventory</h2>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Regular Price ({{ settings('currency_symbol', '₵') }}) *</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', isset($product) ? $product->getRawOriginal('price') : '') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Discount Price ({{ settings('currency_symbol', '₵') }})</label>
                        <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price', isset($product) ? $product->getRawOriginal('discount_price') : '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cost Price ({{ settings('currency_symbol', '₵') }})</label>
                        <input type="number" step="0.01" name="cost_price" value="{{ old('cost_price', isset($product) ? $product->getRawOriginal('cost_price') : '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity *</label>
                        <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4" x-data="{ specs: {{ isset($product) && $product->specifications ? json_encode($product->specifications) : '[]' }}, addSpec() { this.specs.push({ key: '', value: '' }); }, removeSpec(index) { this.specs.splice(index, 1); } }">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Specifications</h2>
                
                <div class="space-y-2">
                    <template x-for="(spec, index) in specs" :key="index">
                        <div class="flex items-center gap-2">
                            <input type="text" x-model="spec.key" :name="'specifications[' + index + '][key]'" placeholder="e.g. Weight, Color" class="flex-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border text-sm">
                            <input type="text" x-model="spec.value" :name="'specifications[' + index + '][value]'" placeholder="e.g. 500g, Black" class="flex-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border text-sm">
                            <button type="button" @click="removeSpec(index)" class="text-red-500 hover:text-red-700 p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </template>
                </div>
                
                <button type="button" @click="addSpec()" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Specification
                </button>
            </div>
        </div>

        {{-- Sidebar Info --}}
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Organization</h2>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                        <option value="">None</option>
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                    <select name="brand_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                        <option value="">None</option>
                        @foreach(\App\Models\Brand::all() as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm font-medium text-gray-700">Feature on homepage</span>
                    </label>
                </div>
                <div>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm font-medium text-gray-700">Active (Visible in store)</span>
                    </label>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Product Image</h2>
                @if(isset($product) && $product->image)
                    <div class="relative group">
                        <div class="w-full aspect-square bg-gray-100 rounded-lg overflow-hidden mb-4">
                            <img src="{{ $product->image_url }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif
                <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="text-xs text-gray-400 mt-2">Main featured image. Recommended size: 800x800px.</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Product Gallery</h2>
                
                @if(isset($product) && $product->images->count() > 0)
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        @foreach($product->images as $img)
                            <div class="relative group">
                                <div class="aspect-square bg-gray-50 rounded-lg overflow-hidden border border-gray-100">
                                    <img src="{{ $img->image_url }}" class="w-full h-full object-cover">
                                </div>
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-lg">
                                    <button type="button" 
                                            onclick="if(confirm('Delete this gallery image?')) { document.getElementById('delete-image-{{ $img->id }}').submit(); }"
                                            class="bg-white/90 hover:bg-white text-red-600 p-2 rounded-full shadow-sm transform hover:scale-110 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div x-data="{ count: 1 }">
                    <template x-for="i in count" :key="i">
                        <div class="mb-2">
                            <input type="file" name="gallery[]" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
                        </div>
                    </template>
                    <button type="button" @click="if(count < 4) count++" x-show="count < 4" class="text-xs font-medium text-indigo-600 hover:text-indigo-700">+ Add another image</button>
                </div>
                <p class="text-xs text-gray-400 mt-2">Up to 4 additional images for the gallery.</p>
            </div>
            
            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
                {{ isset($product) ? 'Update Product' : 'Create Product' }}
            </button>
        </div>
    </div>
</form>

@if(isset($product))
    @foreach($product->images as $img)
        <form id="delete-image-{{ $img->id }}" action="{{ route('admin.products.images.destroy', $img->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
@endif
@endsection
