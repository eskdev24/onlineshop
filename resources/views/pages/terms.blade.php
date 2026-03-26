@extends('layouts.app')
@section('title', 'Terms of Service')

@section('content')
<div class="bg-gray-50 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 bg-white p-8 md:p-12 rounded-2xl shadow-sm border border-gray-100">
        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-8">Terms of Service</h1>
        
        <div class="prose prose-indigo max-w-none text-gray-600">
            <p>Last updated: {{ date('F d, Y') }}</p>
            
            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">1. Agreement to Terms</h2>
            <p>By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement.</p>
            
            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">2. Products and Pricing</h2>
            <p>All products are subject to availability. We reserve the right to limit the quantity of products we supply, supply only part of an order or to divide up orders.</p>
            <p>Prices for our products are subject to change without notice. We reserve the right to modify or discontinue any product at any time.</p>
            
            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">3. User Accounts</h2>
            <p>If you create an account, you are responsible for maintaining the confidentiality of your account and password and for restricting access to your computer or device.</p>
            
            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">4. Prohibited Uses</h2>
            <p>You are prohibited from using the site or its content for any unlawful purpose, to solicit others to perform illegal acts, or to violate any international, federal, or state regulations.</p>
        </div>
    </div>
</div>
@endsection
