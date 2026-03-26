@extends('pages.account.layout')

@section('account_content')
<h2 class="text-2xl font-bold text-gray-900 mb-6">Profile Settings</h2>

<form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" class="max-w-xl">
    @csrf
    @method('PUT')
    
    <div class="space-y-5">
        <div class="flex items-center space-x-6">
            <div class="relative">
                @if($user->avatar)
                    <img src="{{ $user->avatar_url }}" alt="Profile" class="w-24 h-24 rounded-full object-cover border-4 border-indigo-100">
                @else
                    <div class="w-24 h-24 rounded-full bg-indigo-100 border-4 border-indigo-200 flex items-center justify-center">
                        <span class="text-3xl font-bold text-indigo-600">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                @endif
                <label for="avatar" class="absolute bottom-0 right-0 bg-indigo-600 text-white p-2 rounded-full cursor-pointer hover:bg-indigo-700 transition shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden" onchange="this.form.submit()">
                </label>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900">Profile Picture</p>
                <p class="text-xs text-gray-500">Click icon to upload</p>
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 border">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-xs font-normal text-gray-400">(Cannot be changed)</span></label>
            <input type="email" value="{{ $user->email }}" disabled class="w-full bg-gray-50 border-gray-200 rounded-lg shadow-sm p-3 border text-gray-500 cursor-not-allowed">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 border">
            @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        
        <div class="pt-4">
            <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-indigo-700 transition-all duration-300 shadow-lg shadow-indigo-200 hover:shadow-indigo-300">Save Changes</button>
        </div>
    </div>
</form>

<div class="max-w-xl mt-12 pt-8 border-t border-gray-200">
    <h3 class="text-xl font-bold text-gray-900 mb-4">Saved Addresses</h3>
    
    @if($user->addresses->isEmpty())
        <p class="text-gray-500 text-sm mb-4">You haven't saved any addresses yet.</p>
    @else
        <div class="space-y-4 mb-6">
            @foreach($user->addresses as $address)
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 flex justify-between items-start">
                <div>
                    <p class="font-medium text-gray-900 text-sm">{{ $address->first_name }} {{ $address->last_name }}</p>
                    <p class="font-medium text-gray-900 text-sm">{{ $address->address_line_1 }}</p>
                    @if($address->address_line_2)<p class="text-sm text-gray-600">{{ $address->address_line_2 }}</p>@endif
                    <p class="text-sm text-gray-600">{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                    <p class="text-sm text-gray-600">{{ $address->country }}</p>
                </div>
            </div>
            @endforeach
        </div>
    @endif
    
    <button type="button" onclick="document.getElementById('addAddressForm').classList.toggle('hidden')" class="btn-primary">+ Add New Address</button>
    
    <form id="addAddressForm" action="{{ route('customer.address.store') }}" method="POST" class="hidden mt-4 bg-white border border-gray-200 rounded-lg p-4">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                <input type="text" name="first_name" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                <input type="text" name="last_name" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
            </div>
            <div class="col-span-full">
                <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 1</label>
                <input type="text" name="address_line_1" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
            </div>
            <div class="col-span-full">
                <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 2</label>
                <input type="text" name="address_line_2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                <input type="text" name="city" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                <input type="text" name="state" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                <input type="text" name="postal_code" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                <input type="text" name="country" value="Nigeria" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
            </div>
        </div>
        <button type="submit" class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition">Save Address</button>
    </form>
</div>
@endsection
