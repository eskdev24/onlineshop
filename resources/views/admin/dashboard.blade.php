@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-indigo-50 rounded-xl p-6 border border-indigo-100 flex items-center shadow-sm">
        <div class="p-3 bg-indigo-500 rounded-lg text-white mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Revenue</p>
            <p class="text-2xl font-bold text-gray-900">₵{{ number_format($totalRevenue, 2) }}</p>
        </div>
    </div>
    
    <div class="bg-blue-50 rounded-xl p-6 border border-blue-100 flex items-center shadow-sm">
        <div class="p-3 bg-blue-500 rounded-lg text-white mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Orders</p>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalOrders) }}</p>
        </div>
    </div>

    <div class="bg-green-50 rounded-xl p-6 border border-green-100 flex items-center shadow-sm">
        <div class="p-3 bg-green-500 rounded-lg text-white mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Customers</p>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalCustomers) }}</p>
        </div>
    </div>

    <div class="bg-orange-50 rounded-xl p-6 border border-orange-100 flex items-center shadow-sm">
        <div class="p-3 bg-orange-500 rounded-lg text-white mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Products</p>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalProducts) }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Recent Orders --}}
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-900">Recent Orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                        <th class="p-4 font-semibold">Order ID</th>
                        <th class="p-4 font-semibold">Customer</th>
                        <th class="p-4 font-semibold">Date</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-bold text-gray-900"><a href="{{ route('admin.orders.show', $order) }}" class="hover:text-indigo-600">#{{ $order->order_number }}</a></td>
                        <td class="p-4 text-gray-600">{{ $order->customer_name }}</td>
                        <td class="p-4 text-gray-600">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="p-4">{!! $order->status_badge !!}</td>
                        <td class="p-4 text-right font-medium text-gray-900">₵{{ number_format($order->total, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-4 text-center text-gray-500">No orders found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Top Selling Products --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-900">Low Stock Alert</h2>
        </div>
        <div class="p-4">
            <div class="space-y-4">
                @php
                    $lowStock = \App\Models\Product::where('stock_quantity', '<=', 10)->orderBy('stock_quantity')->take(5)->get();
                @endphp
                @forelse($lowStock as $product)
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-100 rounded flex-shrink-0">
                            <img src="{{ $product->image_url }}" class="w-full h-full object-cover rounded">
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 line-clamp-1" title="{{ $product->name }}">{{ $product->name }}</p>
                            <p class="text-xs {{ $product->stock_quantity == 0 ? 'text-red-600 font-bold' : 'text-orange-500' }}">Stock: {{ $product->stock_quantity }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:bg-indigo-50 p-2 rounded text-xs font-semibold transition">Edit</a>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">All products are well stocked.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
