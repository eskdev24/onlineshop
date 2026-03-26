@extends('layouts.app')
@section('title', 'Contact Us')

@section('content')
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-4">Contact Us</h1>
            <p class="text-xl text-gray-500">We're here to help. Reach out to our team with any questions or concerns.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden max-w-4xl mx-auto">
            <div class="p-8 md:p-12">
                @if(session('success'))
                    <div class="bg-green-50 text-green-800 p-4 rounded-lg mb-6 font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" name="name" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 border">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 border">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <input type="text" name="subject" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea name="message" rows="5" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 border"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-xl shadow-lg hover:bg-indigo-700 transition">
                        Send Message
                    </button>
                </form>
            </div>
            <div class="bg-gray-50 p-8 border-t border-gray-100 flex flex-col md:flex-row justify-around text-center md:text-left gap-6">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">Email Us</h3>
                    <p class="text-gray-600">{{ settings('contact_email', 'support@buyvia.com') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">Call Us</h3>
                    <p class="text-gray-600">{{ settings('contact_phone', '+233 20 123 4567') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">Headquarters</h3>
                    <p class="text-gray-600">{!! nl2br(e(settings('contact_address', "123 Commerce St,\nAccra, Ghana"))) !!}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
