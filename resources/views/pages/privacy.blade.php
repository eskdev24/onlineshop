@extends('layouts.app')
@section('title', 'Privacy Policy')

@section('content')
<div class="bg-gray-50 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 bg-white p-8 md:p-12 rounded-2xl shadow-sm border border-gray-100">
        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-8">Privacy Policy</h1>
        
        <div class="prose prose-indigo max-w-none text-gray-600">
            <p>Last updated: {{ date('F d, Y') }}</p>
            
            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">1. Information We Collect</h2>
            <p>We collect information you provide directly to us when you create an account, make a purchase, or contact us for support. This includes your name, email address, phone number, and shipping/billing address.</p>
            
            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">2. How We Use Your Information</h2>
            <p>We use the information we collect to process your orders, communicate with you about your account, and improve our services. We do not sell your personal information to third parties.</p>
            
            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">3. Data Security</h2>
            <p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>
            
            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">4. Cookies</h2>
            <p>We use cookies to enhance your browsing experience, remember your preferences, and analyze site traffic.</p>
        </div>
    </div>
</div>
@endsection
