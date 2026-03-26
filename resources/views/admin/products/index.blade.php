@extends('layouts.admin')
@section('title', 'Products')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Products</h1>
    <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition shadow-sm">
        + Add New Product
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-4 border-b border-gray-100">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-800 transition">Search</button>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                    <th class="p-4 font-semibold w-16">Image</th>
                    <th class="p-4 font-semibold">Name</th>
                    <th class="p-4 font-semibold">Category</th>
                    <th class="p-4 font-semibold">Price</th>
                    <th class="p-4 font-semibold">Stock</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4">
                        <div class="w-10 h-10 bg-gray-100 rounded bg-cover bg-center" style="background-image: url('{{ $product->image_url }}')"></div>
                    </td>
                    <td class="p-4">
                        <p class="font-bold text-gray-900">{{ $product->name }}</p>
                        <p class="text-xs text-gray-500">SKU: {{ $product->sku }}</p>
                    </td>
                    <td class="p-4 text-gray-600">{{ $product->category->name ?? '-' }}</td>
                    <td class="p-4 font-medium text-gray-900">
                        {{ settings('currency_symbol', '₵') }}{{ number_format($product->current_price) }}
                        @if($product->discount_price)<br><span class="text-xs text-gray-400 line-through">{{ settings('currency_symbol', '₵') }}{{ number_format($product->price) }}</span>@endif
                    </td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $product->stock_quantity > 10 ? 'bg-green-100 text-green-800' : ($product->stock_quantity > 0 ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800') }}">
                            {{ $product->stock_quantity }}
                        </span>
                    </td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $product->is_active ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="p-4 text-right flex justify-end space-x-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="p-8 text-center text-gray-500">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
