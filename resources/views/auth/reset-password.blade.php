@extends('layouts.app')
@section('title', 'Reset Password')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 md:p-12 rounded-2xl shadow-xl shadow-indigo-100/50">
        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-block mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="{{ settings('site_name', 'Buyvia') }}" class="h-20 w-auto mx-auto">
            </a>
            <h2 class="text-3xl font-extrabold text-gray-900">Reset Password</h2>
            <p class="mt-2 text-sm text-gray-600">Please enter your new password below.</p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                <input id="email" name="email" type="email" value="{{ $email ?? old('email') }}" required readonly class="appearance-none relative block w-full px-4 py-3 border border-gray-200 bg-gray-50 text-gray-500 rounded-xl focus:outline-none sm:text-sm">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div x-data="{ show: false }" class="relative">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input id="password" name="password" :type="show ? 'text' : 'password'" required class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Minimum 8 characters">
                <button type="button" @click="show = !show" class="absolute right-3 top-9 text-gray-400 hover:text-indigo-600">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c3.478 0 6.522 1.891 8.196 4.725a9.003 9.003 0 010 8.55C18.522 21.109 15.478 23 12 23c-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                </button>
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div x-data="{ show: false }" class="relative">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                <input id="password_confirmation" name="password_confirmation" :type="show ? 'text' : 'password'" required class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Confirm password">
                <button type="button" @click="show = !show" class="absolute right-3 top-9 text-gray-400 hover:text-indigo-600">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c3.478 0 6.522 1.891 8.196 4.725a9.003 9.003 0 010 8.55C18.522 21.109 15.478 23 12 23c-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                </button>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-lg shadow-indigo-200">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
