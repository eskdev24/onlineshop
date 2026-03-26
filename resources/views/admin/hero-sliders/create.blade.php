@extends('layouts.admin')
@section('title', 'Add Hero Slider')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-900">Add Hero Slider</h1>
    <a href="/admin/hero-sliders" class="text-sm font-medium text-gray-500 hover:text-gray-700">← Back</a>
</div>

<form action="/admin/hero-sliders/store" method="POST" enctype="multipart/form-data" class="max-w-lg">
    @csrf
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Slider Image *</label>
            <input type="file" name="image" accept="image/*" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            <p class="text-xs text-gray-400 mt-1">Recommended: 1920x600px or similar aspect ratio</p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="0" class="w-full border-gray-300 rounded-lg p-2 border">
            </div>
            <div class="flex items-center pt-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-indigo-600 h-4 w-4">
                    <span class="ml-2 text-sm text-gray-600">Active</span>
                </label>
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-800">
            <p class="font-medium">Default settings will be applied:</p>
            <ul class="mt-2 space-y-1 text-blue-700">
                <li>• Title: Based on image</li>
                <li>• Button: "Shop Now" → /shop</li>
            </ul>
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
            Upload Slider
        </button>
    </div>
</form>
@endsection
