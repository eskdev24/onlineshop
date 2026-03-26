@extends('layouts.admin')
@section('title', 'Customers')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Customers</h1>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-4 border-b border-gray-100">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email or phone..." class="w-full md:w-96 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-800 transition">Search</button>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                    <th class="p-4 font-semibold w-12"></th>
                    <th class="p-4 font-semibold">Customer</th>
                    <th class="p-4 font-semibold">Contact</th>
                    <th class="p-4 font-semibold">Registered Date</th>
                    <th class="p-4 font-semibold text-center">Total Orders</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($customers as $customer)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-sm">
                            {{ substr($customer->name, 0, 1) }}
                        </div>
                    </td>
                    <td class="p-4">
                        <p class="font-bold text-gray-900">{{ $customer->name }}</p>
                    </td>
                    <td class="p-4">
                        <p class="text-gray-900"><a href="mailto:{{ $customer->email }}" class="hover:text-indigo-600">{{ $customer->email }}</a></p>
                        @if($customer->phone)
                            <p class="text-xs text-gray-500 mt-1">{{ $customer->phone }}</p>
                        @endif
                    </td>
                    <td class="p-4 text-gray-600">{{ $customer->created_at->format('M d, Y') }}</td>
                    <td class="p-4 text-center">
                        <span class="inline-flex items-center justify-center px-2 py-1 rounded bg-gray-100 text-gray-800 font-medium text-xs min-w-[2rem]">
                            {{ $customer->orders_count ?? $customer->orders()->count() }}
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        {{-- Future implementation: view customer details/history --}}
                        <a href="{{ route('admin.customers.show', $customer) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">View History</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-8 text-center text-gray-500">No customers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($customers instanceof \Illuminate\Pagination\LengthAwarePaginator && $customers->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50">
        {{ $customers->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
