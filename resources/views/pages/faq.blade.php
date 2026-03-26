@extends('layouts.app')
@section('title', 'Frequently Asked Questions')

@section('content')
<div class="bg-gray-50 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-8 text-center">Frequently Asked Questions</h1>
        
        <div class="space-y-4">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-2">How long does shipping take?</h3>
                <p class="text-gray-600">Standard shipping typically takes 3-5 business days. Express shipping is available for 1-2 day delivery.</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-2">What is your return policy?</h3>
                <p class="text-gray-600">We offer a 30-day hassle-free return policy. If you are not satisfied with your purchase, you can return it for a full refund or exchange.</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Do you ship internationally?</h3>
                <p class="text-gray-600">Currently, we only ship within the country. We are looking to expand our shipping options in the near future.</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-2">How can I track my order?</h3>
                <p class="text-gray-600">Once your order is shipped, you will receive an email with a tracking number. You can also view your order status in your account dashboard.</p>
            </div>
        </div>
    </div>
</div>
@endsection
