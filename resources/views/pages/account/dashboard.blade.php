@extends('pages.account.layout')

@section('account_content')
<h2 class="text-2xl font-bold text-gray-900 mb-6">Hello, {{ explode(' ', $user->name)[0] }}!</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
    <div class="bg-indigo-50 rounded-xl p-6 border border-indigo-100">
        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-indigo-600 mb-4 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        </div>
        <h3 class="text-3xl font-extrabold text-indigo-900">{{ $orderCount }}</h3>
        <p class="text-sm font-medium text-indigo-700">Total Orders</p>
    </div>
    
    <div class="bg-pink-50 rounded-xl p-6 border border-pink-100">
        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-pink-500 mb-4 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
        </div>
        <h3 class="text-3xl font-extrabold text-pink-900">{{ $wishlistCount }}</h3>
        <p class="text-sm font-medium text-pink-700">Wishlist Items</p>
    </div>
</div>

<h3 class="text-lg font-bold text-gray-900 mb-4">Recent Orders</h3>
@if($recentOrders->isEmpty())
    <div class="bg-gray-50 rounded-lg p-6 text-center border border-gray-200">
        <p class="text-gray-500 mb-4">You haven't placed any orders yet.</p>
        <a href="{{ route('shop.index') }}" class="text-indigo-600 font-bold hover:text-indigo-800">Start Shopping →</a>
    </div>
@else
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200 text-sm text-gray-500">
                    <th class="py-3 font-semibold">Order #</th>
                    <th class="py-3 font-semibold">Date</th>
                    <th class="py-3 font-semibold">Total</th>
                    <th class="py-3 font-semibold">Status</th>
                    <th class="py-3 font-semibold text-right">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">
                @foreach($recentOrders as $order)
                <tr>
                    <td class="py-4 font-bold text-gray-900">{{ $order->order_number }}</td>
                    <td class="py-4 text-gray-600">{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="py-4 font-medium text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($order->total) }}</td>
                    <td class="py-4">{!! $order->status_badge !!}</td>
                    <td class="py-4 text-right">
                        <a href="{{ route('customer.order.detail', $order->order_number) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
