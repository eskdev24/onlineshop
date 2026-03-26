@extends('layouts.admin')
@section('title', 'Edit Hot Deal')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.hot-deals.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">← Back to List</a>
    <h1 class="text-2xl font-bold text-gray-900 mt-2">Edit Hot Deal</h1>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl">
    <form action="{{ route('admin.hot-deals.update', $hotDeal) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Select Product</label>
                <select name="product_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id', $hotDeal->product_id) == $product->id ? 'selected' : '' }}>
                        {{ $product->name }} (Current Price: ₵{{ number_format($product->price, 2) }})
                    </option>
                    @endforeach
                </select>
                @error('product_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deal Price (GH₵)</label>
                <input type="number" step="0.01" name="deal_price" value="{{ old('deal_price', $hotDeal->deal_price) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="0.00">
                @error('deal_price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Start Date & Time</label>
                    <input type="datetime-local" name="start_date" value="{{ old('start_date', $hotDeal->start_date->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    @error('start_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">End Date & Time</label>
                    <input type="datetime-local" name="end_date" value="{{ old('end_date', $hotDeal->end_date->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    @error('end_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $hotDeal->sort_order) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div class="flex items-center pt-8">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $hotDeal->is_active) ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="ml-2 text-sm font-medium text-gray-700">Is Active</span>
                    </label>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">Update Hot Deal</button>
            </div>
        </div>
    </form>
</div>
@endsection
