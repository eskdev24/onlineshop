@extends('layouts.app')
@section('title', 'Shopping Cart')

@section('content')
<div class="bg-gray-50 py-12 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Your Items</h1>

        @if(!$cart || $cart->items->isEmpty())
        <div class="bg-white rounded-2xl p-16 text-center shadow-sm max-w-2xl mx-auto mt-12 card-hover">
            <div class="w-24 h-24 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Your cart is empty</h2>
            <p class="text-gray-500 mb-8">Looks like you haven't added anything to your cart yet.</p>
            <a href="{{ route('shop.index') }}" class="btn-primary inline-flex items-center shadow-md shadow-indigo-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Continue Shopping
            </a>
        </div>
        @else
        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Cart Items --}}
            <div class="w-full lg:w-2/3">
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    <ul class="divide-y divide-gray-100">
                        @foreach($cart->items as $item)
                        <li class="p-6 flex flex-col sm:flex-row items-center gap-6">
                            <div class="w-24 h-24 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                                <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 text-center sm:text-left">
                                <a href="{{ route('product.show', $item->product->slug) }}" class="text-lg font-bold text-gray-900 hover:text-indigo-600 transition">{{ $item->product->name }}</a>
                                <p class="text-indigo-600 font-semibold mt-1">{{ settings('currency_symbol', '₵') }}{{ number_format($item->price) }}</p>
                            </div>
                            <div class="flex items-center space-x-6">
                                <div class="flex items-center border border-gray-200 rounded-lg bg-gray-50">
                                    <form action="{{ route('cart.update', $item) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
                                        <button type="submit" class="px-4 py-2 text-gray-500 hover:text-indigo-600 transition" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                                    </form>
                                    <span class="w-8 text-center font-semibold text-gray-900">{{ $item->quantity }}</span>
                                    <form action="{{ route('cart.update', $item) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                        <button type="submit" class="px-4 py-2 text-gray-500 hover:text-indigo-600 transition">+</button>
                                    </form>
                                </div>
                                <div class="w-24 text-right hidden sm:block">
                                    <span class="font-bold text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($item->subtotal) }}</span>
                                </div>
                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:bg-red-50 hover:text-red-500 rounded-lg transition" title="Remove item">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Summary Sidebar --}}
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-2xl shadow-sm p-8 sticky top-24 border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 border-b pb-4">Order Summary</h3>
                    
                    <div class="space-y-4 mb-6 text-gray-600">
                        <div class="flex justify-between">
                            <span>Subtotal ({{ $cart->total_items }} items)</span>
                            <span class="font-medium text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($summary['subtotal']) }}</span>
                        </div>
                        
                        @if($summary['discount'] > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Discount @if($cart->coupon)({{ $cart->coupon->code }})@endif</span>
                            <span class="font-medium">-{{ settings('currency_symbol', '₵') }}{{ number_format($summary['discount']) }}</span>
                        </div>
                        @endif

                        <div class="flex justify-between">
                            <span>Tax ({{ settings('tax_rate', 0) }}%)</span>
                            <span class="font-medium text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($summary['tax']) }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span class="font-medium text-gray-900">{{ $summary['shipping'] > 0 ? settings('currency_symbol', '₵') . number_format($summary['shipping']) : 'Free' }}</span>
                        </div>
                    </div>

                    <div class="border-t pt-4 mb-8">
                        <div class="flex justify-between items-end">
                            <span class="text-gray-900 font-bold">Total</span>
                            <span class="text-3xl font-extrabold text-indigo-600">{{ settings('currency_symbol', '₵') }}{{ number_format($summary['total']) }}</span>
                        </div>
                        <p class="text-xs text-gray-500 text-right mt-1">Shipping calculated at checkout</p>
                    </div>

                    {{-- Coupon Form --}}
                    <form action="{{ route('cart.coupon') }}" method="POST" class="mb-8">
                        @csrf
                        <div class="flex space-x-2">
                            <input type="text" name="coupon_code" placeholder="Enter promo code" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-sm uppercase">
                            <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-800 transition">Apply</button>
                        </div>
                    </form>

                    <a href="{{ route('checkout.index') }}" class="w-full btn-primary flex justify-center items-center shadow-lg shadow-indigo-200 py-4 text-lg">
                        Proceed to Checkout
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    
                    <div class="mt-6 flex items-center justify-center space-x-2 text-sm text-gray-400 bg-gray-50 p-3 rounded-lg">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span>Secure encrypted checkout</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
