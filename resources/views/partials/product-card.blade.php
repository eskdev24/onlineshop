{{-- Product Card Partial --}}
<div class="card-hover bg-white rounded-xl shadow-sm overflow-hidden group">
    <a href="{{ route('product.show', $product->slug) }}" class="block">
        <div class="relative aspect-square bg-gray-100 overflow-hidden">
            @if($product->image)
                <img src="{{ $product->image_url }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            @endif
            @if($product->discount_price)
                <span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full font-semibold">-{{ $product->discount_percent }}%</span>
            @endif
        </div>
    </a>
    <div class="p-4">
        <p class="text-xs text-indigo-600 font-medium mb-1">{{ $product->category->name ?? '' }}</p>
        <a href="{{ route('product.show', $product->slug) }}" class="block">
            <h3 class="font-semibold text-gray-900 truncate hover:text-indigo-600 transition">{{ $product->name }}</h3>
        </a>
        <div class="flex items-baseline gap-2 mt-2">
            <span class="text-lg font-bold text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($product->current_price) }}</span>
            @if($product->discount_price)
                <span class="text-sm text-gray-400 line-through">{{ settings('currency_symbol', '₵') }}{{ number_format($product->price) }}</span>
            @endif
        </div>
        <button onclick="addToCart({{ $product->id }})" class="mt-3 w-full bg-indigo-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
            Add to Cart
        </button>
    </div>
</div>
