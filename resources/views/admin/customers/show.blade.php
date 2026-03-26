@extends('layouts.admin')
@section('title', 'Customer Details')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Customer: {{ $customer->name }}</h1>
    <a href="{{ route('admin.customers.index') }}" class="text-gray-500 hover:text-gray-900">&larr; Back to Customers</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Customer Info</h3>
            <div class="space-y-3">
                <div>
                    <label class="text-xs text-gray-500 uppercase font-semibold">Email</label>
                    <p class="text-gray-900">{{ $customer->email }}</p>
                </div>
                <div>
                    <label class="text-xs text-gray-500 uppercase font-semibold">Phone</label>
                    <p class="text-gray-900">{{ $customer->phone ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="text-xs text-gray-500 uppercase font-semibold">Joined</label>
                    <p class="text-gray-900">{{ $customer->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Recent Orders</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                            <th class="p-4 font-semibold">Order #</th>
                            <th class="p-4 font-semibold">Date</th>
                            <th class="p-4 font-semibold">Total</th>
                            <th class="p-4 font-semibold">Status</th>
                            <th class="p-4 font-semibold text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($customer->orders as $order)
                        <tr>
                            <td class="p-4 font-bold text-gray-900">{{ $order->order_number }}</td>
                            <td class="p-4 text-gray-600">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="p-4 text-gray-900 font-medium">₵{{ number_format($order->total, 2) }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 uppercase">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="p-8 text-center text-gray-500">No orders found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
