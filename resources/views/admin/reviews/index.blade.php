@extends('layouts.admin')
@section('title', 'Product Reviews')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Product Reviews</h1>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                    <th class="p-4 font-semibold">Product</th>
                    <th class="p-4 font-semibold">User</th>
                    <th class="p-4 font-semibold">Rating</th>
                    <th class="p-4 font-semibold">Comment</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold">Date</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($reviews as $review)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4">
                        <div class="font-bold text-gray-900">{{ $review->product->name }}</div>
                        <div class="text-xs text-gray-500 italic">{{ $review->product->sku }}</div>
                    </td>
                    <td class="p-4 text-gray-900">{{ $review->user->name }}</td>
                    <td class="p-4">
                        <div class="flex text-yellow-400">
                            @for($i=1; $i<=5; $i++)
                                <svg class="w-4 h-4 fill-current {{ $i <= $review->rating ? '' : 'text-gray-200' }}" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                            @endfor
                        </div>
                    </td>
                    <td class="p-4 text-gray-600 max-w-xs truncate" title="{{ $review->comment }}">
                        {{ $review->comment }}
                    </td>
                    <td class="p-4">
                        @if($review->is_approved)
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Approved</span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Pending</span>
                        @endif
                    </td>
                    <td class="p-4 text-gray-500 italic">{{ $review->created_at->format('M d, Y') }}</td>
                    <td class="p-4 text-right flex justify-end space-x-2">
                        @if(!$review->is_approved)
                        <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-green-600 hover:text-green-900 font-medium">Approve</button>
                        </form>
                        @endif
                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete this review?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="p-8 text-center text-gray-500">No reviews found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($reviews->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50">
        {{ $reviews->links() }}
    </div>
    @endif
</div>
@endsection
