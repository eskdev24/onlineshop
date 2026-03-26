@extends('layouts.admin')
@section('title', 'Hero Sliders')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-900">Hero Sliders</h1>
    <a href="/admin/hero-sliders/create" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition shadow-sm">
        + Add Slider
    </a>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
            <tr>
                <th class="p-4 font-semibold">Image</th>
                <th class="p-4 font-semibold">Status</th>
                <th class="p-4 font-semibold">Order</th>
                <th class="p-4 font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($sliders as $slider)
            <tr>
                <td class="p-4">
                    <img src="{{ $slider->image_url }}" class="w-40 h-20 object-cover rounded-lg">
                </td>
                <td class="p-4">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $slider->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ $slider->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="p-4 text-gray-600">{{ $slider->sort_order }}</td>
                <td class="p-4">
                    <a href="/admin/hero-sliders/{{ $slider->id }}/edit" class="text-indigo-600 hover:text-indigo-900 font-medium mr-4">Edit</a>
                    <a href="/admin/hero-sliders/{{ $slider->id }}/delete" onclick="return confirm('Delete this slider?');" class="text-red-600 hover:text-red-900">Delete</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="p-8 text-center text-gray-500">
                    No sliders yet. <a href="/admin/hero-sliders/create" class="text-indigo-600 hover:underline">Add your first slider</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($sliders->hasPages())
<div class="mt-4">{{ $sliders->links() }}</div>
@endif
@endsection
