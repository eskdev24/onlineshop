@extends('layouts.admin')
@section('title', 'Brands')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Brands</h1>
    <a href="{{ route('admin.brands.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition shadow-sm">
        + Add New Brand
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                    <th class="p-4 font-semibold w-16">Logo</th>
                    <th class="p-4 font-semibold">Name</th>
                    <th class="p-4 font-semibold">Slug</th>
                    <th class="p-4 font-semibold">Products</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($brands as $brand)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4">
                        <div class="w-10 h-10 bg-gray-100 rounded bg-contain bg-center bg-no-repeat" style="background-image: url('{{ $brand->logo_url }}')"></div>
                    </td>
                    <td class="p-4 font-bold text-gray-900">{{ $brand->name }}</td>
                    <td class="p-4 text-gray-500">{{ $brand->slug }}</td>
                    <td class="p-4 font-medium text-gray-900">{{ $brand->products_count }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $brand->is_active ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $brand->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="p-4 text-right flex justify-end space-x-2">
                        <a href="{{ route('admin.brands.edit', $brand) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                        <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this brand?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-8 text-center text-gray-500">No brands found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($brands->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50">
        {{ $brands->links() }}
    </div>
    @endif
</div>
@endsection
