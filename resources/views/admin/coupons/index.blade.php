@extends('layouts.admin')
@section('title', 'Coupons')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Coupons</h1>
    <a href="{{ route('admin.coupons.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition shadow-sm">
        + Add New Coupon
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                    <th class="p-4 font-semibold">Code</th>
                    <th class="p-4 font-semibold">Type</th>
                    <th class="p-4 font-semibold">Value</th>
                    <th class="p-4 font-semibold">Min. Order</th>
                    <th class="p-4 font-semibold">Usage</th>
                    <th class="p-4 font-semibold">Expires</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($coupons as $coupon)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 font-bold text-gray-900">{{ $coupon->code }}</td>
                    <td class="p-4 text-gray-600 capitalize">{{ $coupon->type }}</td>
                    <td class="p-4 font-medium text-gray-900">
                        {{ $coupon->type === 'percentage' ? $coupon->value . '%' : '₵' . number_format($coupon->value, 2) }}
                    </td>
                    <td class="p-4 text-gray-600">₵{{ number_format($coupon->min_order_value ?? 0, 2) }}</td>
                    <td class="p-4 text-gray-600">{{ $coupon->total_used }} / {{ $coupon->usage_limit ?? '∞' }}</td>
                    <td class="p-4">
                        @if($coupon->expires_at)
                            <span class="{{ $coupon->expires_at->isPast() ? 'text-red-500' : 'text-gray-600' }}">
                                {{ $coupon->expires_at->format('M d, Y') }}
                            </span>
                        @else
                            <span class="text-gray-400">Never</span>
                        @endif
                    </td>
                    <td class="p-4 text-right flex justify-end space-x-2">
                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('Delete this coupon?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="p-8 text-center text-gray-500">No coupons found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($coupons->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50">
        {{ $coupons->links() }}
    </div>
    @endif
</div>
@endsection
