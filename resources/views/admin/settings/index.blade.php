@extends('layouts.admin')
@section('title', 'Platform Settings')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Platform Settings</h1>
    <p class="text-sm text-gray-500">Manage your application-wide configuration here.</p>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: General & Contact --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- General Settings --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    General Configuration
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Buyvia' }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Site Tagline</label>
                        <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? 'Advanced E-Commerce Platform' }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Currency Symbol</label>
                    <input type="text" name="currency_symbol" value="{{ $settings['currency_symbol'] ?? '₵' }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    <p class="text-xs text-gray-400 mt-1">Symbol to display (e.g., ₵, $, £)</p>
                </div>
            </div>

            {{-- Tax & Shipping --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Store Rates & Shipping
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-full">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sales Tax (%)</label>
                        <input type="number" step="0.01" name="tax_rate" value="{{ $settings['tax_rate'] ?? '0' }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Standard Delivery Cost (GH₵)</label>
                        <input type="number" step="0.01" name="shipping_standard" value="{{ $settings['shipping_standard'] ?? '0' }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Express Delivery Cost (GH₵)</label>
                        <input type="number" step="0.01" name="shipping_express" value="{{ $settings['shipping_express'] ?? '0' }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    </div>

                    <div class="col-span-full">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Free Shipping Threshold (GH₵)</label>
                        <input type="number" step="0.01" name="shipping_free_threshold" value="{{ $settings['shipping_free_threshold'] ?? '5000' }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                        <p class="text-xs text-gray-400 mt-1">Orders above this subtotal will have free shipping option.</p>
                    </div>
                </div>
            </div>

            {{-- Paystack Settings --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Paystack API Settings
                </h2>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Public Key</label>
                    <input type="text" name="paystack_public_key" value="{{ $settings['paystack_public_key'] ?? '' }}" placeholder="pk_test_..." class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border font-mono text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Secret Key</label>
                    <input type="password" name="paystack_secret_key" value="{{ $settings['paystack_secret_key'] ?? '' }}" placeholder="sk_test_..." class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border font-mono text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment URL</label>
                    <input type="url" name="paystack_payment_url" value="{{ $settings['paystack_payment_url'] ?? 'https://api.paystack.co' }}" placeholder="https://api.paystack.co" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                </div>
            </div>

            {{-- Mail Settings --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Mail Settings
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">SMTP Host</label>
                        <input type="text" name="mail_host" value="{{ $settings['mail_host'] ?? '127.0.0.1' }}" placeholder="smtp.example.com" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">SMTP Port</label>
                        <input type="number" name="mail_port" value="{{ $settings['mail_port'] ?? '2525' }}" placeholder="2525" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" name="mail_username" value="{{ $settings['mail_username'] ?? '' }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="mail_password" value="{{ $settings['mail_password'] ?? '' }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">From Address</label>
                    <input type="email" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? 'noreply@buyvia.com' }}" placeholder="noreply@example.com" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                </div>
            </div>

            {{-- Contact Information --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Contact Info
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Support Email</label>
                        <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? 'support@buyvia.com' }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '+233 00 000 0000' }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Store Address</label>
                    <textarea name="contact_address" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">{{ $settings['contact_address'] ?? 'Accra, Ghana' }}</textarea>
                </div>
            </div>
        </div>

        {{-- Right Column: Social & Appearance --}}
        <div class="space-y-6">
            {{-- Social Media --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.828a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    Social Links
                </h2>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Facebook URL</label>
                    <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" placeholder="https://facebook.com/..." class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instagram URL</label>
                    <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" placeholder="https://instagram.com/..." class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Twitter URL</label>
                    <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}" placeholder="https://twitter.com/..." class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 border">
                </div>
            </div>

            {{-- Platform Status --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Maintenance
                </h2>
                
                <div class="flex items-center space-x-3">
                    <input type="checkbox" name="maintenance_mode" value="1" {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm font-medium text-gray-700">Enable Maintenance Mode</span>
                </div>
                <p class="text-xs text-gray-400">If enabled, public storefront will be inaccessible.</p>
            </div>
            
            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
                Save All Settings
            </button>
        </div>
    </div>
</form>
@endsection
