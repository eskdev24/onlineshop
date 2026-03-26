@extends('layouts.app')
@section('title', 'Create Account')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 md:p-12 rounded-2xl shadow-xl shadow-indigo-100/50">
        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-block mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="{{ settings('site_name', 'Buyvia') }}" class="h-24 w-auto mx-auto">
            </a>
            <h2 class="text-3xl font-extrabold text-gray-900">Create an account</h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Already have an account? <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Sign in</a>
            </p>
        </div>
        
        <form class="mt-8 space-y-6" action="{{ route('register.submit') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}" class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="John Doe">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}" class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Email address">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div x-data="{ 
                    show: false,
                    password: '',
                    password_confirmation: '',
                    get strength() {
                        let score = 0;
                        if (this.password.length >= 8) score++;
                        if (/[A-Z]/.test(this.password)) score++;
                        if (/[a-z]/.test(this.password)) score++;
                        if (/[0-9]/.test(this.password)) score++;
                        if (/[^A-Za-z0-9]/.test(this.password)) score++;
                        return score;
                    },
                    get passwordsMatch() {
                        return this.password.length > 0 && this.password === this.password_confirmation;
                    }
                }">
                    <div class="relative mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" name="password" :type="show ? 'text' : 'password'" x-model="password" required class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="At least 8 characters">
                        <button type="button" @click="show = !show" class="absolute right-3 top-9 text-gray-400 hover:text-indigo-600">
                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c3.478 0 6.522 1.891 8.196 4.725a9.003 9.003 0 010 8.55C18.522 21.109 15.478 23 12 23c-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                        </button>

                        {{-- Strength Meter --}}
                        <div class="mt-2 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full transition-all duration-500" 
                                 :class="{
                                    'bg-red-500 w-1/5': strength === 1,
                                    'bg-orange-500 w-2/5': strength === 2,
                                    'bg-yellow-500 w-3/5': strength === 3,
                                    'bg-blue-500 w-4/5': strength === 4,
                                    'bg-green-500 w-full': strength === 5,
                                    'bg-gray-200 w-0': strength === 0
                                 }"></div>
                        </div>

                        {{-- Checklist --}}
                        <div class="mt-3 grid grid-cols-2 gap-2">
                            <div class="flex items-center text-[10px] font-bold uppercase transition" :class="password.length >= 8 ? 'text-green-600' : 'text-gray-400'">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                8+ Characters
                            </div>
                            <div class="flex items-center text-[10px] font-bold uppercase transition" :class="(/[A-Z]/.test(password)) ? 'text-green-600' : 'text-gray-400'">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Uppercase
                            </div>
                            <div class="flex items-center text-[10px] font-bold uppercase transition" :class="(/[a-z]/.test(password)) ? 'text-green-600' : 'text-gray-400'">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Lowercase
                            </div>
                            <div class="flex items-center text-[10px] font-bold uppercase transition" :class="(/[0-9]/.test(password)) ? 'text-green-600' : 'text-gray-400'">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Number
                            </div>
                            <div class="flex items-center text-[10px] font-bold uppercase transition" :class="(/[^A-Za-z0-9]/.test(password)) ? 'text-green-600' : 'text-gray-400'">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Special Char
                            </div>
                            <div class="flex items-center text-[10px] font-bold uppercase transition" :class="passwordsMatch ? 'text-green-600' : 'text-gray-400'">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Passwords Match
                            </div>
                        </div>
                        
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="relative">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" :type="show ? 'text' : 'password'" x-model="password_confirmation" required class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Confirm password">
                    </div>
                </div>
            </div>

            <div>
                <p class="text-xs text-gray-500 mb-4 text-center">By creating an account, you agree to our <a href="{{ route('terms') }}" class="text-indigo-600 underline">Terms</a> and <a href="{{ route('privacy') }}" class="text-indigo-600 underline">Privacy Policy</a>.</p>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-lg shadow-indigo-200">
                    Create Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
