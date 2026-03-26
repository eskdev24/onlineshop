@extends('layouts.app')
@section('title', 'About Us')

@section('content')
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-4">About Buyvia</h1>
            <p class="text-xl text-gray-500">Shop Smart, Live Better. We are your premier online shopping destination for quality products at unbeatable prices.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-16">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="p-12 md:p-16 flex flex-col justify-center">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Mission</h2>
                    <p class="text-gray-600 text-lg leading-relaxed mb-6">
                        At Buyvia, our mission is to provide an unparalleled shopping experience by offering a curated selection of high-quality products that enhance your daily life. We believe that smart shopping shouldn't mean compromising on quality or service.
                    </p>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Founded in 2026, we've quickly grown to become a trusted destination for electronics, fashion, home goods, and more, serving thousands of satisfied customers nationwide.
                    </p>
                </div>
                <div class="bg-indigo-600 p-12 md:p-16 text-white flex flex-col justify-center">
                     <h2 class="text-3xl font-bold mb-6">Why Choose Us?</h2>
                     <ul class="space-y-4 text-lg">
                         <li class="flex items-start">
                             <svg class="w-6 h-6 mr-3 text-indigo-300 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                             <span>Curated, high-quality products</span>
                         </li>
                         <li class="flex items-start">
                             <svg class="w-6 h-6 mr-3 text-indigo-300 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                             <span>Unbeatable prices and daily deals</span>
                         </li>
                         <li class="flex items-start">
                             <svg class="w-6 h-6 mr-3 text-indigo-300 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                             <span>Fast, reliable shipping</span>
                         </li>
                         <li class="flex items-start">
                             <svg class="w-6 h-6 mr-3 text-indigo-300 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                             <span>24/7 dedicated customer support</span>
                         </li>
                         <li class="flex items-start">
                             <svg class="w-6 h-6 mr-3 text-indigo-300 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                             <span>Secure, hassle-free checkout</span>
                         </li>
                     </ul>
                </div>
            </div>
        </div>

        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Ready to start shopping?</h2>
            <a href="{{ route('shop.index') }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg hover:shadow-xl transition-all duration-200">
                Explore Our Products
            </a>
        </div>
    </div>
</div>
@endsection
