@extends('pages.account.layout')

@section('account_content')
<div class="flex items-center justify-between mb-8">
    <h2 class="text-2xl font-bold text-gray-900">Order #{{ $order->order_number }}</h2>
    {!! $order->status_badge !!}
</div>

<p class="text-sm text-gray-500 mb-8 border-b pb-4">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
        <h3 class="font-bold text-gray-900 mb-4">Shipping Information</h3>
        <p class="text-sm text-gray-900 font-medium">{{ $order->customer_name }}</p>
        <p class="text-sm text-gray-600 mt-1">{{ $order->address }}</p>
        <p class="text-sm text-gray-600">{{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}</p>
        <p class="text-sm text-gray-600">{{ $order->country }}</p>
        <p class="text-sm text-gray-600 mt-3">Phone: {{ $order->phone }}</p>
    </div>
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
        <h3 class="font-bold text-gray-900 mb-4">Order Summary</h3>
        <div class="space-y-2 text-sm text-gray-600">
            <div class="flex justify-between"><span>Subtotal:</span> <span>{{ settings('currency_symbol', '₵') }}{{ number_format($order->subtotal) }}</span></div>
            <div class="flex justify-between"><span>Shipping:</span> <span>{{ settings('currency_symbol', '₵') }}{{ number_format($order->shipping_cost) }}</span></div>
            <div class="flex justify-between"><span>Tax:</span> <span>{{ settings('currency_symbol', '₵') }}{{ number_format($order->tax) }}</span></div>
            @if($order->discount > 0)
                <div class="flex justify-between text-green-600"><span>Discount:</span> <span>-{{ settings('currency_symbol', '₵') }}{{ number_format($order->discount) }}</span></div>
            @endif
            <div class="flex justify-between pt-3 border-t border-gray-200 text-gray-900 font-bold text-lg">
                <span>Total:</span>
                <span class="text-indigo-600">{{ settings('currency_symbol', '₵') }}{{ number_format($order->total) }}</span>
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-200">
                <span class="font-bold text-gray-900">Payment Status:</span>
                @if($order->payment && $order->payment->status === 'success')
                    <span class="text-green-600 font-medium">Paid successfully</span>
                @else
                    <span class="text-amber-600 font-medium">Pending / Failed</span>
                @endif
            </div>
        </div>
    </div>
</div>

<h3 class="font-bold text-gray-900 mb-4 text-lg">Items Ordered</h3>
<div class="border border-gray-200 rounded-xl overflow-hidden">
    <ul class="divide-y divide-gray-100">
        @foreach($order->items as $item)
        <li class="p-4 flex items-center gap-4 bg-white">
            <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                <img src="{{ $item->product ? $item->product->image_url : '' }}" class="w-full h-full object-cover">
            </div>
            <div class="flex-1">
                <a href="{{ $item->product ? route('product.show', $item->product->slug) : '#' }}" class="text-sm font-bold text-gray-900 hover:text-indigo-600 transition">{{ $item->product_name }}</a>
                <p class="text-xs text-gray-500 mt-1">Qty: {{ $item->quantity }} x {{ settings('currency_symbol', '₵') }}{{ number_format($item->price) }}</p>
            </div>
            <div class="text-right">
                <span class="text-sm font-bold text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($item->total) }}</span>
            </div>
        </li>
        @endforeach
    </ul>
</div>

<div class="mt-8 text-center sm:text-left">
    <a href="{{ route('customer.orders') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">← Back to Orders</a>
</div>
@endsection
