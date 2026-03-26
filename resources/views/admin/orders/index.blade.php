@extends('layouts.admin')
@section('title', 'Orders')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Orders</h1>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-4 border-b border-gray-100 flex flex-wrap gap-4 items-center justify-between">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex gap-4 w-full md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Order ID..." class="w-full md:w-64 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            <select name="status" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-800 transition">Filter</button>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                    <th class="p-4 font-semibold">Order ID</th>
                    <th class="p-4 font-semibold">Customer</th>
                    <th class="p-4 font-semibold">Date</th>
                    <th class="p-4 font-semibold">Total</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold">Payment</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 font-bold text-gray-900">
                        <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-indigo-600">#{{ $order->order_number }}</a>
                    </td>
                    <td class="p-4">
                        <p class="font-medium text-gray-900">{{ $order->customer_name ?? ($order->user ? $order->user->name : 'Guest') }}</p>
                        <p class="text-xs text-gray-500">{{ $order->customer_email ?? ($order->user ? $order->user->email : '') }}</p>
                    </td>
                    <td class="p-4 text-gray-600">{{ $order->created_at->format('M d, Y h:i A') }}</td>
                    <td class="p-4 font-medium text-gray-900">₵{{ number_format($order->total, 2) }}</td>
                    <td class="p-4">{!! $order->status_badge !!}</td>
                    <td class="p-4">
                        @if($order->payment)
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $order->payment->status === 'success' ? 'bg-green-100 text-green-800' : ($order->payment->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($order->payment->status) }}
                            </span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                Unpaid
                            </span>
                        @endif
                    </td>
                    <td class="p-4 text-right">
                        <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-medium">
                            View Details 
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="p-8 text-center text-gray-500">No orders found matching your criteria.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($orders instanceof \Illuminate\Pagination\LengthAwarePaginator && $orders->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50">
        {{ $orders->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
