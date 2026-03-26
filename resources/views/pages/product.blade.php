@extends('layouts.app')
@section('title', $product->name)
@section('description', $product->short_description)

@section('content')
<div class="bg-white py-8" x-data="{ 
    mainImage: '{{ $product->image_url }}', 
    quantity: 1 
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex text-sm text-gray-500 mb-8 mt-2 space-x-2">
            <a href="{{ route('home') }}" class="hover:text-indigo-600 transition">Home</a>
            <span>/</span>
            <a href="{{ route('shop.index') }}" class="hover:text-indigo-600 transition">Shop</a>
            <span>/</span>
            @if($product->category)
            <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-indigo-600 transition">{{ $product->category->name }}</a>
            <span>/</span>
            @endif
            <span class="text-gray-900 font-medium truncate w-32 md:w-auto">{{ $product->name }}</span>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            {{-- Image Gallery --}}
            <div>
                <div class="bg-gray-100 rounded-2xl overflow-hidden aspect-square mb-4 relative">
                    <template x-if="mainImage">
                        <img :src="mainImage" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!mainImage">
                        <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                    </template>
                    @if($product->discount_price)
                        <span class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full font-bold text-sm shadow-sm">-{{ $product->discount_percent }}% OFF</span>
                    @endif
                </div>
                
                @if($product->images->count() > 0)
                <div class="grid grid-cols-5 gap-3">
                    @if($product->image)
                    <button @click="mainImage = '{{ $product->image_url }}'" 
                            class="border-2 rounded-lg overflow-hidden focus:outline-none" 
                            :class="mainImage === '{{ $product->image_url }}' ? 'border-indigo-600' : 'border-transparent'">
                        <img src="{{ $product->image_url }}" class="w-full aspect-square object-cover">
                    </button>
                    @endif
                    @foreach($product->images as $img)
                    <button @click="mainImage = '{{ $img->image_url }}'" 
                            class="border-2 rounded-lg overflow-hidden focus:outline-none" 
                            :class="mainImage === '{{ $img->image_url }}' ? 'border-indigo-600' : 'border-transparent'">
                        <img src="{{ $img->image_url }}" class="w-full aspect-square object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Product Info --}}
            <div class="flex flex-col">
                @if($product->brand)
                    <span class="text-sm font-bold text-indigo-600 uppercase tracking-widest mb-1">{{ $product->brand->name }}</span>
                @endif
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight mb-2">{{ $product->name }}</h1>
                
                <div class="flex items-center space-x-4 mb-6">
                    <div class="flex text-yellow-400">
                        @for($i=1; $i<=5; $i++)
                            <svg class="w-5 h-5 {{ $i <= round($product->average_rating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-500">({{ $product->approvedReviews->count() }} reviews)</span>
                </div>

                <div class="flex items-end space-x-3 mb-6">
                    <span class="text-4xl font-extrabold text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($product->current_price) }}</span>
                    @if($product->discount_price)
                        <span class="text-xl text-gray-400 line-through mb-1">{{ settings('currency_symbol', '₵') }}{{ number_format($product->price) }}</span>
                    @endif
                </div>

                <div class="prose prose-sm text-gray-600 mb-8 max-w-none">
                    <p>{{ $product->short_description }}</p>
                </div>

                <hr class="border-gray-200 mb-8">

                <div class="flex items-center space-x-6 mb-8">
                    <div>
                        <span class="block text-sm font-bold text-gray-900 mb-2">Quantity</span>
                        <div class="flex items-center border border-gray-300 rounded-lg bg-white">
                            <button @click="if(quantity > 1) quantity--" class="px-4 py-2 text-gray-600 hover:text-indigo-600 hover:bg-gray-50 rounded-l-lg transition">-</button>
                            <input type="number" x-model="quantity" min="1" max="{{ $product->stock_quantity }}" class="w-16 text-center focus:outline-none border-x border-gray-300 py-2 font-medium" readonly>
                            <button @click="if(quantity < {{ $product->stock_quantity }}) quantity++" class="px-4 py-2 text-gray-600 hover:text-indigo-600 hover:bg-gray-50 rounded-r-lg transition">+</button>
                        </div>
                    </div>
                    <div class="flex-1 self-end">
                        @if($product->stock_quantity > 0)
                            <p class="text-sm text-green-600 font-medium mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                In Stock ({{ $product->stock_quantity }} available)
                            </p>
                        @endif
                    </div>
                </div>

                <div class="flex space-x-4">
                    @if($product->stock_quantity > 0)
                        <button @click="addToCartWithQty({{ $product->id }}, quantity)" class="flex-1 bg-indigo-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 flex justify-center items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Add to Cart
                        </button>
                    @else
                        <button disabled class="flex-1 bg-gray-300 text-gray-500 px-8 py-4 rounded-xl font-bold text-lg cursor-not-allowed">
                            Out of Stock
                        </button>
                    @endif
                    @auth
                    <form action="{{ route('customer.wishlist.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="p-4 border border-gray-300 rounded-xl hover:bg-gray-50 hover:text-red-500 transition text-gray-500 focus:outline-none">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>
                    </form>
                    @endauth
                </div>
            </div>
        </div>

        {{-- Description & Details Tabs --}}
        <div class="mt-16" x-data="{ tab: 'description' }">
            <div class="border-b border-gray-200 flex space-x-8">
                <button @click="tab = 'description'" :class="tab === 'description' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-4 font-bold border-b-2 text-lg transition">Description</button>
                <button @click="tab = 'specifications'" :class="tab === 'specifications' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-4 font-bold border-b-2 text-lg transition">Specifications</button>
                <button @click="tab = 'reviews'" :class="tab === 'reviews' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-4 font-bold border-b-2 text-lg transition">Reviews ({{ $product->approvedReviews->count() }})</button>
            </div>
            
            <div class="py-8">
                <div x-show="tab === 'description'" class="prose max-w-none text-gray-600 leading-relaxed">
                    {!! nl2br(e($product->description)) !!}
                </div>

                <div x-show="tab === 'specifications'" x-cloak>
                    @if($product->specifications && is_array($product->specifications) && count($product->specifications) > 0)
                        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 text-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left font-bold">Specification</th>
                                        <th class="px-6 py-3 text-left font-bold">Value</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($product->specifications as $key => $value)
                                    <tr>
                                        <td class="px-6 py-3 font-medium text-gray-900">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                        <td class="px-6 py-3 text-gray-600">{{ $value }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 py-4 text-center">No specifications available for this product.</p>
                    @endif
                </div>

                <div x-show="tab === 'reviews'" x-cloak>
                    @auth
                        <form action="{{ route('review.store', $product) }}" method="POST" class="bg-gray-50 p-6 rounded-xl mb-10 border border-gray-200">
                            @csrf
                            <h3 class="font-bold text-gray-900 mb-4">Write a Review</h3>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                                <select name="rating" class="border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 w-32 border">
                                    <option value="5">5 - Excellent</option><option value="4">4 - Good</option><option value="3">3 - Average</option><option value="2">2 - Poor</option><option value="1">1 - Terrible</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Comment</label>
                                <textarea name="comment" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 border" required placeholder="Share your experience with this product..."></textarea>
                            </div>
                            <button type="submit" class="btn-primary">Submit Review</button>
                        </form>
                    @else
                        <div class="bg-blue-50 text-blue-800 p-4 rounded-lg mb-8">Please <a href="{{ route('login') }}" class="font-bold underline">login</a> to write a review.</div>
                    @endauth

                    <div class="space-y-6">
                        @forelse($product->approvedReviews as $review)
                        <div class="pb-6 border-b border-gray-100 last:border-0 text-sm">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-bold text-gray-900">{{ $review->user->name }}</span>
                                <span class="text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex text-yellow-400 mb-2">
                                @for($i=1; $i<=5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            </div>
                            <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                        </div>
                        @empty
                        <p class="text-gray-500 py-4 text-center">No reviews yet. Be the first to review this product!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->count() > 0)
        <div class="mt-16 pt-16 border-t border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">You May Also Like</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relProduct)
                    @include('partials.product-card', ['product' => $relProduct])
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function addToCartWithQty(productId, qty) {
        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ product_id: productId, quantity: qty })
        }).then(r => r.json()).then(data => {
            if (data.success) {
                document.getElementById('cart-count').textContent = data.cart_count;
                showToast(data.message);
            } else {
                showToast(data.message || 'Error occurred');
            }
        });
    }
</script>
@endpush
