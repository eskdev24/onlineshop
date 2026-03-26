@extends('layouts.app')
@section('title', 'Order Confirmed - ' . $order->order_number)

@section('content')
<div class="bg-gray-50 py-16 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-8">
        <div class="bg-white rounded-2xl shadow-sm p-10 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-green-500"></div>
            
            <div class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 fade-in">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Thank you for your order!</h1>
            <p class="text-gray-600 mb-8">Order <span class="font-bold text-gray-900">#{{ $order->order_number }}</span> has been placed successfully.</p>
            
            <div class="bg-gray-50 rounded-xl p-6 text-left mb-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Shipping Information</h3>
                        <p class="text-sm text-gray-900 font-medium">{{ $order->customer_name }}</p>
                        <p class="text-sm text-gray-600">{{ $order->address }}</p>
                        <p class="text-sm text-gray-600">{{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}</p>
                        <p class="text-sm text-gray-600">{{ $order->country }}</p>
                        <p class="text-sm text-gray-600 mt-2"><strong>Phone:</strong> {{ $order->phone }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Payment Summarry</h3>
                        <div class="space-y-1 text-sm">
                            <div class="flex justify-between"><span class="text-gray-600">Subtotal:</span> <span class="font-medium text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($order->subtotal) }}</span></div>
                            <div class="flex justify-between"><span class="text-gray-600">Shipping:</span> <span class="font-medium text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($order->shipping_cost) }}</span></div>
                            <div class="flex justify-between"><span class="text-gray-600">Tax:</span> <span class="font-medium text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($order->tax) }}</span></div>
                            @if($order->discount > 0)
                                <div class="flex justify-between text-green-600"><span>Discount:</span> <span class="font-medium">-{{ settings('currency_symbol', '₵') }}{{ number_format($order->discount) }}</span></div>
                            @endif
                            <div class="flex justify-between border-t border-gray-200 mt-2 pt-2"><span class="font-bold text-gray-900">Total:</span> <span class="font-bold text-indigo-600 text-lg">{{ settings('currency_symbol', '₵') }}{{ number_format($order->total) }}</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-500 mb-6">We've sent a confirmation email to <strong>{{ $order->email }}</strong> with the order details.</p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('customer.dashboard') }}" class="border border-gray-300 text-gray-700 bg-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">View Order Status</a>
                    <a href="{{ route('shop.index') }}" class="btn-primary">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
