@extends('layouts.admin')
@section('title', 'Hot Deals')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Hot Deals</h1>
    <a href="{{ route('admin.hot-deals.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">Add New Hot Deal</a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="p-4 font-semibold text-gray-600">Product</th>
                    <th class="p-4 font-semibold text-gray-600">Deal Price</th>
                    <th class="p-4 font-semibold text-gray-600">Timeline</th>
                    <th class="p-4 font-semibold text-gray-600">Status</th>
                    <th class="p-4 font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hotDeals as $deal)
                <tr class="hover:bg-gray-50 transition border-b border-gray-50">
                    <td class="p-4">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $deal->product->image_url }}" class="w-10 h-10 rounded object-cover">
                            <span class="font-medium text-gray-900">{{ $deal->product->name }}</span>
                        </div>
                    </td>
                    <td class="p-4 text-indigo-600 font-bold">₵{{ number_format($deal->deal_price, 2) }}</td>
                    <td class="p-4 text-sm">
                        <div><span class="text-gray-400">Start:</span> {{ $deal->start_date->format('M d, Y H:i') }}</div>
                        <div><span class="text-gray-400">End:</span> {{ $deal->end_date->format('M d, Y H:i') }}</div>
                    </td>
                    <td class="p-4">
                        @if($deal->is_expired)
                            <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full font-semibold">Expired</span>
                        @elseif(!$deal->is_active)
                            <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-full font-semibold">Inactive</span>
                        @elseif($deal->start_date->isFuture())
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full font-semibold">Scheduled</span>
                        @else
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-semibold">Live</span>
                        @endif
                    </td>
                    <td class="p-4">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.hot-deals.edit', $deal) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold text-sm">Edit</a>
                            <form action="{{ route('admin.hot-deals.destroy', $deal) }}" method="POST" onsubmit="return confirm('Delete this deal?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:text-red-900 font-semibold text-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-500">No hot deals found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($hotDeals->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50">
        {{ $hotDeals->links() }}
    </div>
    @endif
</div>
@endsection
