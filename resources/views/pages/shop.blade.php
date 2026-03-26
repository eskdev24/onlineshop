@extends('layouts.app')
@section('title', 'Shop')

@section('content')
<div class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex text-sm text-gray-500 mb-8 mt-2 space-x-2">
            <a href="{{ route('home') }}" class="hover:text-indigo-600 transition">Home</a>
            <span>/</span>
            <span class="text-gray-900 font-medium">Shop</span>
        </nav>

        <div class="flex flex-col md:flex-row gap-8">
            {{-- Filters Sidebar (Desktop) --}}
            <aside class="w-full md:w-64 flex-shrink-0" x-data="{ open: false }">
                <div class="md:hidden flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">Filters</h2>
                    <button @click="open = !open" class="text-indigo-600 font-medium">Toggle Filters</button>
                </div>

                <div :class="{'hidden': !open, 'block': open}" class="md:block space-y-8 bg-white p-6 rounded-xl shadow-sm">
                    <form action="{{ route('shop.index') }}" method="GET" id="filterForm">
                        @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                        
                        {{-- Categories --}}
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Categories</h3>
                            <div class="space-y-2">
                                @foreach($categories as $category)
                                <label class="flex items-center space-x-3">
                                    <input type="radio" name="category" value="{{ $category->slug }}" onchange="document.getElementById('filterForm').submit();" {{ request('category') == $category->slug ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                    @if($category->image)
                                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-5 h-5 object-cover rounded-full">
                                    @endif
                                    <span class="text-sm text-gray-700">{{ $category->name }} ({{ $category->products_count }})</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Brands --}}
                        <div class="mt-8">
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Brands</h3>
                            <div class="space-y-2">
                                @foreach($brands as $brand)
                                <label class="flex items-center space-x-3">
                                    <input type="radio" name="brand" value="{{ $brand->slug }}" onchange="document.getElementById('filterForm').submit();" {{ request('brand') == $brand->slug ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                    <span class="text-sm text-gray-700">{{ $brand->name }} ({{ $brand->products_count }})</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Sort --}}
                        <div class="mt-8">
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Sort By</h3>
                            <select name="sort" onchange="document.getElementById('filterForm').submit();" class="w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest Arrivals</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            </select>
                        </div>
                        
                        @if(request()->anyFilled(['category', 'brand', 'sort', 'search']))
                        <div class="mt-6">
                            <a href="{{ route('shop.index') }}" class="text-sm text-red-600 hover:text-red-800 font-medium">Clear Filters</a>
                        </div>
                        @endif
                    </form>
                </div>
            </aside>

            {{-- Main Content --}}
            <div class="flex-1">
                @if(request('search'))
                    <h1 class="text-2xl font-bold text-gray-900 mb-6">Search Results for "{{ request('search') }}"</h1>
                @endif
                
                @if($products->isEmpty())
                <div class="bg-white rounded-xl p-12 text-center shadow-sm">
                    <div class="text-6xl mb-4">😞</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-500 mb-6">Try adjusting your filters or search query.</p>
                    <a href="{{ route('shop.index') }}" class="btn-primary">Clear all filters</a>
                </div>
                @else
                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
                
                <div class="mt-10 flex justify-center">
                    {{ $products->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
