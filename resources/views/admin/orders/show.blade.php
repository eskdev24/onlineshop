@extends('layouts.admin')
@section('title', 'Order Details #' . $order->order_number)

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Order #{{ $order->order_number }}</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $order->created_at->format('M d, Y h:i A') }}</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">← Back to Orders</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-8">
        {{-- Order Items --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-900">Order Items</h2>
            </div>
            <div class="p-0">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="p-4 font-semibold">Product</th>
                            <th class="p-4 font-semibold text-center">Price</th>
                            <th class="p-4 font-semibold text-center">Qty</th>
                            <th class="p-4 font-semibold text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="p-4 flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gray-100 rounded bg-cover bg-center flex-shrink-0" style="background-image: url('{{ $item->product ? $item->product->image_url : '' }}')"></div>
                                <div>
                                    <p class="font-medium text-gray-900 line-clamp-2">{{ $item->product_name }}</p>
                                    @if($item->product && $item->product->sku)
                                        <p class="text-xs text-gray-500">SKU: {{ $item->product->sku }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4 text-center text-gray-600">{{ settings('currency_symbol', '₵') }}{{ number_format($item->price) }}</td>
                            <td class="p-4 text-center text-gray-900 font-medium">x{{ $item->quantity }}</td>
                            <td class="p-4 text-right font-medium text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($item->price * $item->quantity) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-6 bg-gray-50 border-t border-gray-100">
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center text-gray-600">
                        <span>Subtotal ({{ $order->items->sum('quantity') }} items)</span>
                        <span>{{ settings('currency_symbol', '₵') }}{{ number_format($order->items->sum(function($item) { return $item->price * $item->quantity; })) }}</span>
                    </div>
                    @if($order->discount > 0)
                    <div class="flex justify-between items-center text-green-600">
                        <span>Discount</span>
                        <span>-{{ settings('currency_symbol', '₵') }}{{ number_format($order->discount) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center text-gray-600">
                        <span>Shipping</span>
                        <span>{{ settings('currency_symbol', '₵') }}{{ number_format($order->shipping_cost) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-gray-600">
                        <span>Tax</span>
                        <span>{{ settings('currency_symbol', '₵') }}{{ number_format($order->tax) }}</span>
                    </div>
                    <div class="pt-3 border-t border-gray-200 mt-3 flex justify-between items-center text-lg font-bold text-gray-900">
                        <span>Grand Total</span>
                        <span>{{ settings('currency_symbol', '₵') }}{{ number_format($order->total) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Notes --}}
        @if($order->notes)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Customer Notes</h2>
            <div class="p-4 bg-yellow-50 text-yellow-800 rounded-lg text-sm border border-yellow-100">
                {{ $order->notes }}
            </div>
        </div>
        @endif
    </div>

    <div class="space-y-8">
        {{-- Status Update Form --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Update Order Status</h2>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 border text-sm">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                
                <!-- Display current status badge as reminder -->
                <div class="flex items-center text-sm mt-2">
                    <span class="text-gray-500 mr-2">Current:</span> {!! $order->status_badge !!}
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2.5 rounded-lg text-sm font-bold hover:bg-indigo-700 transition">Update Status</button>
                </div>
            </form>
        </div>

        {{-- Customer & Shipping Info --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Customer Details</h2>
            
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Contact Info</p>
                    <p class="text-sm font-medium text-gray-900">{{ $order->customer_name }}</p>
                    <p class="text-sm text-gray-600"><a href="mailto:{{ $order->email }}" class="text-indigo-600 hover:underline">{{ $order->email }}</a></p>
                    <p class="text-sm text-gray-600">{{ $order->phone }}</p>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Shipping Address</p>
                    <p class="text-sm text-gray-900 leading-relaxed">
                        {{ $order->address }}<br>
                        {{ $order->city }}, {{ $order->state }}<br>
                        {{ $order->country }}<br>
                        {{ $order->postal_code }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Payment Info --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Payment Information</h2>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Method</span>
                    <span class="font-medium text-gray-900 capitalize">{{ $order->payment ? str_replace('_', ' ', $order->payment->method) : 'N/A' }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Status</span>
                    @if($order->payment)
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $order->payment->status === 'success' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($order->payment->status) }}
                        </span>
                    @else
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">No Payment Found</span>
                    @endif
                </div>
                @if($order->payment && $order->payment->reference)
                <div class="flex justify-between">
                    <span class="text-gray-500">Reference</span>
                    <span class="font-mono text-xs text-gray-700 break-all ml-4 text-right">{{ $order->payment->reference }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
