@extends('pages.account.layout')

@section('account_content')
<h2 class="text-2xl font-bold text-gray-900 mb-6">Order History</h2>

@if($orders->isEmpty())
    <div class="bg-gray-50 rounded-lg p-10 text-center border border-gray-200">
        <p class="text-gray-500 mb-4 text-lg">You haven't placed any orders yet.</p>
        <a href="{{ route('shop.index') }}" class="btn-primary">Browse Products</a>
    </div>
@else
    <div class="space-y-6">
        @foreach($orders as $order)
        <div class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition">
            <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-200">
                <div class="flex gap-8">
                    <div>
                        <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Date Placed</span>
                        <span class="block text-sm font-medium text-gray-900 mt-1">{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</span>
                        <span class="block text-sm font-bold text-gray-900 mt-1">{{ settings('currency_symbol', '₵') }}{{ number_format($order->total) }}</span>
                    </div>
                </div>
                <div class="flex flex-col sm:items-end">
                    <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Order #{{ $order->order_number }}</span>
                    {!! $order->status_badge !!}
                </div>
            </div>
            <div class="p-6 bg-white flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    {{ $order->items->count() }} item(s) in this order.
                </div>
                <div>
                    <a href="{{ route('customer.order.detail', $order->order_number) }}" class="inline-block border border-gray-300 text-gray-700 bg-white px-4 py-2 rounded-lg font-medium hover:bg-gray-50 transition text-sm">View Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-8">
        {{ $orders->links() }}
    </div>
@endif
@endsection
