@extends('pages.account.layout')

@section('account_content')
<h2 class="text-2xl font-bold text-gray-900 mb-6">My Wishlist</h2>

@if($wishlistItems->isEmpty())
    <div class="bg-gray-50 rounded-lg p-10 text-center border border-gray-200">
        <p class="text-gray-500 mb-4 text-lg">Your wishlist is empty.</p>
        <a href="{{ route('shop.index') }}" class="btn-primary">Browse Products</a>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($wishlistItems as $item)
            @if($item->product)
            <div class="card-hover bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden flex flex-col relative">
                <form action="{{ route('customer.wishlist.remove', $item->id) }}" method="POST" class="absolute top-2 right-2 z-10">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-white/80 hover:bg-white text-red-500 p-2 rounded-full shadow-sm transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                    </button>
                </form>
                
                <a href="{{ route('product.show', $item->product->slug) }}" class="block p-4 flex-1">
                    <div class="aspect-square bg-gray-50 rounded-lg mb-4 overflow-hidden">
                        <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-gray-900 truncate mb-1">{{ $item->product->name }}</h3>
                    <p class="text-lg font-bold text-indigo-600">{{ settings('currency_symbol', '₵') }}{{ number_format($item->product->current_price) }}</p>
                </a>
                
                <div class="px-4 pb-4">
                    <button onclick="addToCart({{ $item->product_id }})" class="w-full bg-indigo-600 text-white font-semibold py-2 rounded-lg hover:bg-indigo-700 transition">
                        Add to Cart
                    </button>
                </div>
            </div>
            @endif
        @endforeach
    </div>
    
    <div class="mt-8">
        {{ $wishlistItems->links() }}
    </div>
@endif
@endsection
