@extends('layouts.app')
@section('title', 'Forgot Password')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 md:p-12 rounded-2xl shadow-xl shadow-indigo-100/50">
        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-block mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="{{ settings('site_name', 'Buyvia') }}" class="h-20 w-auto mx-auto">
            </a>
            <h2 class="text-3xl font-extrabold text-gray-900">Forgot Password?</h2>
            <p class="mt-2 text-sm text-gray-600">Enter your email and we'll send you a link to reset your password.</p>
        </div>

        @if (session('status'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('password.email') }}" method="POST">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="email@example.com">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-lg shadow-indigo-200">
                    Send Reset Link
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition">
                    Back to login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
