@extends('layouts.app')
@section('title', 'Home')

@section('content')
{{-- HERO SLIDER SECTION --}}
@php
$sliders = \App\Models\HeroSlider::where('is_active', true)->orderBy('sort_order')->get();
@endphp

@if($sliders->count() > 0)
<section class="relative h-[250px] sm:h-[350px] md:h-[450px] lg:h-[550px] overflow-hidden bg-gray-900" x-data="{ 
    active: 0, 
    count: {{ $sliders->count() }},
    autoSlide() {
        setInterval(() => {
            this.active = (this.active + 1) % this.count;
        }, 30000);
    }
}" x-init="autoSlide()">
    @foreach($sliders as $index => $slider)
    <div x-show="active === {{ $index }}" 
         x-transition:enter="transition ease-out duration-700" 
         x-transition:enter-start="opacity-0 translate-x-8" 
         x-transition:enter-end="opacity-100 translate-x-0" 
         x-transition:leave="transition ease-in duration-500" 
         x-transition:leave-start="opacity-100 translate-x-0" 
         x-transition:leave-end="opacity-0 -translate-x-8"
         class="absolute inset-0 w-full h-full">
        <img src="{{ $slider->image_url }}" alt="Hero" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-black/20"></div>
        <div class="absolute inset-0 flex items-end pb-8 sm:pb-12 md:pb-20 lg:pb-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-12 w-full">
                <div class="max-w-xl md:max-w-2xl">
                    <div class="flex items-center gap-2 sm:gap-3 mb-2 sm:mb-4">
                        <span class="w-6 sm:w-8 md:w-12 h-1 bg-indigo-500 rounded-full"></span>
                        <span class="text-white/80 text-xs sm:text-sm font-semibold uppercase tracking-wider">
                            @if($index === 0)Featured
                            @elseif($index === 1)Flash Sale
                            @elseif($index === 2)New Arrivals
                            @else Special Offer
                            @endif
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl xl:text-7xl font-black text-white mb-2 sm:mb-3 md:mb-4 leading-tight">
                        {{ $slider->title }}
                    </h1>
                    <p class="text-xs sm:text-sm md:text-base text-white/80 mb-4 sm:mb-6 md:mb-8 max-w-lg leading-relaxed">
                        {{ $slider->subtitle }}
                    </p>
                    <div class="flex flex-wrap gap-2 sm:gap-3 md:gap-4">
                        <a href="/shop" class="inline-flex items-center justify-center gap-1 sm:gap-2 bg-indigo-600 hover:bg-indigo-500 text-white px-5 sm:px-6 md:px-8 py-3 sm:py-3 md:py-4 rounded-sm font-bold text-base sm:text-base md:text-lg transition-all duration-300">
                            Shop Now
                        </a>
                        <a href="/#hot-deals" class="inline-flex items-center justify-center gap-1 sm:gap-2 bg-white/10 hover:bg-white/20 text-white px-5 sm:px-6 md:px-8 py-3 sm:py-3 md:py-4 rounded-sm font-bold text-base sm:text-base md:text-lg border border-white/30 transition-all duration-300">
                            View Deals
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    
    {{-- Navigation dots --}}
    @if($sliders->count() > 1)
    <div class="absolute bottom-4 sm:bottom-6 left-1/2 transform -translate-x-1/2 flex gap-2 sm:gap-3 z-10">
        @foreach($sliders as $index => $slider)
        <button @click="active = {{ $index }}" 
                :class="active === {{ $index }} ? 'bg-white w-6 sm:w-8' : 'bg-white/40 hover:bg-white/60 w-2 sm:w-3'" 
                class="h-2 sm:h-3 rounded-full transition-all duration-300"></button>
        @endforeach
    </div>
    @endif
</section>
@else
{{-- FALLBACK HERO (when no sliders) --}}
<section class="relative h-[300px] sm:h-[400px] md:h-[500px] lg:h-[600px] overflow-hidden bg-gradient-to-br from-gray-900 via-indigo-900 to-purple-900">
    <div class="absolute inset-0">
        <div class="absolute top-10 sm:top-20 left-10 sm:left-20 w-40 sm:w-72 h-40 sm:h-72 bg-indigo-500/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 sm:bottom-20 right-10 sm:right-20 w-48 sm:w-96 h-48 sm:h-96 bg-purple-500/30 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 md:px-12 h-full flex items-center">
        <div class="max-w-xl sm:max-w-2xl">
            <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-6">
                <span class="w-6 sm:w-12 h-1 bg-indigo-500 rounded-full"></span>
                <span class="text-white/80 text-xs sm:text-sm font-semibold uppercase tracking-wider">Featured</span>
            </div>
            <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-7xl font-black text-white mb-3 sm:mb-6 leading-tight">
                Shop Smart,<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">Live Better.</span>
            </h1>
            <p class="text-sm sm:text-base md:text-xl text-white/70 mb-4 sm:mb-10 max-w-lg leading-relaxed">
                Discover amazing products at unbeatable prices. Quality guaranteed, fast delivery, and hassle-free returns.
            </p>
            <div class="flex flex-wrap gap-3 sm:gap-5">
                <a href="/shop" class="group relative inline-flex items-center gap-1 sm:gap-3 bg-indigo-600 hover:bg-indigo-500 text-white px-4 sm:px-8 md:px-10 py-2 sm:py-4 md:py-5 rounded-sm font-bold text-sm sm:text-lg md:text-xl transition-all duration-300 overflow-hidden shadow-2xl shadow-indigo-500/30">
                    <span class="relative z-10">Shop Now</span>
                    <svg class="relative z-10 w-4 sm:w-6 md:w-7 h-4 sm:h-6 md:h-7 transition-transform group-hover:translate-x-1 sm:group-hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
                <a href="/#hot-deals" class="group relative inline-flex items-center gap-1 sm:gap-3 bg-white/10 hover:bg-white/20 text-white px-4 sm:px-8 md:px-10 py-2 sm:py-4 md:py-5 rounded-sm font-bold text-sm sm:text-lg md:text-xl border border-white/30 transition-all duration-300">
                    <span>View Deals</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endif

{{-- TOP CATEGORIES --}}
<section class="max-w-7xl mx-auto px-4 py-10 md:py-16">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Shop by Category</h2>
            <p class="text-gray-500 mt-1 hidden md:block">Browse our curated collections</p>
        </div>
        <a href="{{ route('shop.index') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm">View All →</a>
    </div>
    
    {{-- Mobile Slider --}}
    <div class="md:hidden overflow-x-auto pb-4 scrollbar-hide" style="-webkit-overflow-scrolling: touch;">
        <div class="flex gap-3">
            @foreach($categories as $category)
            <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="flex-shrink-0">
                <div class="bg-white rounded-xl p-4 text-center shadow-sm w-28">
                    @if($category->image)
                        <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto flex items-center justify-center mb-2 overflow-hidden">
                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-16 h-16 bg-indigo-50 rounded-full mx-auto flex items-center justify-center mb-2">
                            <span class="text-2xl">{{ ['📱','👗','🏠','⚽','📚','💄','🎮','🚗','🛒','✏️'][$loop->index] ?? '📦' }}</span>
                        </div>
                    @endif
                    <h3 class="font-semibold text-gray-900 text-xs leading-tight">{{ Str::limit($category->name, 12) }}</h3>
                    <p class="text-[10px] text-gray-500">{{ $category->products_count }} items</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    
    {{-- Desktop Grid --}}
    <div class="hidden md:grid grid-cols-4 gap-6">
        @foreach($categories as $category)
        <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="group bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-md transition">
            @if($category->image)
                <div class="w-20 h-20 bg-gray-100 rounded-full mx-auto flex items-center justify-center mb-4 overflow-hidden">
                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                </div>
            @else
                <div class="w-20 h-20 bg-indigo-50 rounded-full mx-auto flex items-center justify-center mb-4 group-hover:bg-indigo-100 transition">
                    <span class="text-3xl">{{ ['📱','👗','🏠','⚽','📚','💄','🎮','🚗','🛒','✏️'][$loop->index] ?? '📦' }}</span>
                </div>
            @endif
            <h3 class="font-semibold text-gray-900">{{ $category->name }}</h3>
            <p class="text-sm text-gray-500">{{ $category->products_count }} products</p>
        </a>
        @endforeach
    </div>
</section>

{{-- FEATURED PRODUCTS --}}
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Featured Products</h2>
                <p class="text-gray-500 mt-1">Handpicked favorites just for you</p>
            </div>
            <a href="{{ route('shop.index') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">View All →</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
            @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

        {{-- HOT DEALS CAROUSEL --}}
@if($hotDeals->isNotEmpty())
<section id="hot-deals" class="bg-gradient-to-br from-rose-600 via-orange-500 to-amber-500 py-8 md:py-16 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-6 md:mb-12">
            <h2 class="text-3xl md:text-5xl font-black text-white tracking-tighter uppercase italic">🔥 Flash Deals</h2>
            <p class="text-rose-100 mt-2 md:mt-4 text-base md:text-lg font-medium">Unbeatable prices, but only until the timer hits zero!</p>
        </div>

        <div x-data="{ 
            activeDeal: 0,
            count: {{ $hotDeals->count() }},
            timers: {},
            init() {
                @foreach($hotDeals as $deal)
                this.timers[{{ $loop->index }}] = {
                    expiry: new Date('{{ $deal->end_date->toIso8601String() }}').getTime(),
                    days: 0, hours: 0, minutes: 0, seconds: 0
                };
                @endforeach
                this.updateTimers();
                setInterval(() => this.next(), 8000);
            },
            updateTimers() {
                Object.keys(this.timers).forEach(i => {
                    let t = this.timers[i];
                    let diff = t.expiry - new Date().getTime();
                    if (diff < 0) return;
                    t.days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    t.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    t.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    t.seconds = Math.floor((diff % (1000 * 60)) / 1000);
                });
            },
            next() { this.activeDeal = (this.activeDeal + 1) % this.count; },
            prev() { this.activeDeal = (this.activeDeal - 1 + this.count) % this.count; }
        }" x-init="setInterval(() => updateTimers(), 1000)" class="relative max-w-5xl mx-auto">
            
            <div class="relative h-[550px] sm:h-[480px] md:h-[420px]">
                @foreach($hotDeals as $index => $deal)
                <div x-show="activeDeal === {{ $index }}" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute inset-0">
                   
                    <div class="bg-white rounded-2xl md:rounded-[2rem] shadow-2xl overflow-hidden h-full flex flex-col md:flex-row border-4 border-white/20">
                        <div class="md:w-1/2 h-44 md:h-full relative bg-gray-50">
                            <img src="{{ $deal->product->image_url }}" alt="{{ $deal->product->name }}" class="w-full h-full object-cover">
                            <div class="absolute top-3 left-3 md:top-6 md:left-6 bg-rose-600 text-white px-3 py-1 md:px-5 md:py-2 rounded-full font-black text-sm md:text-xl shadow-xl animate-pulse">
                                -{{ round((($deal->product->price - $deal->deal_price) / $deal->product->price) * 100) }}%
                            </div>
                        </div>

                        <div class="md:w-1/2 p-5 md:p-10 flex flex-col justify-center">
                            <span class="text-rose-500 font-bold uppercase tracking-wider text-xs md:text-sm mb-1 md:mb-2">{{ $deal->product->category->name ?? 'Special Offer' }}</span>
                            <h3 class="text-xl md:text-3xl font-black text-gray-900 leading-tight mb-2 md:mb-3">{{ $deal->product->name }}</h3>
                            
                            <div class="flex items-center gap-2 md:gap-4 mb-3 md:mb-6">
                                <span class="text-xl md:text-3xl font-black text-rose-600">GH₵{{ number_format($deal->deal_price, 2) }}</span>
                                <span class="text-sm md:text-lg text-gray-400 line-through font-bold">GH₵{{ number_format($deal->product->price, 2) }}</span>
                            </div>

                            <div class="grid grid-cols-4 gap-1 md:gap-2 mb-3 md:mb-5">
                                <div class="bg-gray-900 rounded-lg md:rounded-xl p-1.5 md:p-3 text-center text-white">
                                    <span class="block text-sm md:text-xl font-black" x-text="timers[{{ $index }}]?.days?.toString().padStart(2, '0') || '00'">00</span>
                                    <span class="text-[8px] md:text-[9px] uppercase font-bold text-gray-400">Days</span>
                                </div>
                                <div class="bg-gray-900 rounded-lg md:rounded-xl p-1.5 md:p-3 text-center text-white">
                                    <span class="block text-sm md:text-xl font-black" x-text="timers[{{ $index }}]?.hours?.toString().padStart(2, '0') || '00'">00</span>
                                    <span class="text-[8px] md:text-[9px] uppercase font-bold text-gray-400">Hrs</span>
                                </div>
                                <div class="bg-gray-900 rounded-lg md:rounded-xl p-1.5 md:p-3 text-center text-white">
                                    <span class="block text-sm md:text-xl font-black" x-text="timers[{{ $index }}]?.minutes?.toString().padStart(2, '0') || '00'">00</span>
                                    <span class="text-[8px] md:text-[9px] uppercase font-bold text-gray-400">Min</span>
                                </div>
                                <div class="bg-gray-900 rounded-lg md:rounded-xl p-1.5 md:p-3 text-center text-white">
                                    <span class="block text-sm md:text-xl font-black" x-text="timers[{{ $index }}]?.seconds?.toString().padStart(2, '0') || '00'">00</span>
                                    <span class="text-[8px] md:text-[9px] uppercase font-bold text-gray-400">Sec</span>
                                </div>
                            </div>

                            <button onclick="addToCart({{ $deal->product->id }})" class="w-full bg-rose-600 text-white py-2.5 md:py-4 rounded-xl md:rounded-2xl font-black text-sm md:text-lg hover:bg-rose-700 transition shadow-lg uppercase tracking-wide">
                                CLAIM NOW
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($hotDeals->count() > 1)
            <div class="flex justify-center mt-4 md:mt-6 gap-3 md:gap-4">
                <button @click="prev()" class="p-2 md:p-3 bg-white/20 hover:bg-white/30 rounded-full text-white transition backdrop-blur-sm">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <div class="flex items-center gap-1.5 md:gap-2">
                    @foreach($hotDeals as $index => $deal)
                    <button @click="activeDeal = {{ $index }}" 
                            :class="activeDeal === {{ $index }} ? 'bg-white w-5 md:w-6' : 'bg-white/40 w-2'" 
                            class="h-2 rounded-full transition-all duration-300"></button>
                    @endforeach
                </div>
                <button @click="next()" class="p-2 md:p-3 bg-white/20 hover:bg-white/30 rounded-full text-white transition backdrop-blur-sm">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

{{-- NEW ARRIVALS --}}
<section class="max-w-7xl mx-auto px-4 py-10 md:py-16">
    <div class="flex justify-between items-center mb-8 md:mb-10">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">New Arrivals</h2>
            <p class="text-gray-500 mt-1">Fresh products just added</p>
        </div>
        <a href="{{ route('shop.index', ['sort' => 'latest']) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">View All →</a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($newArrivals as $product)
        @include('partials.product-card', ['product' => $product])
        @endforeach
    </div>
</section>

{{-- NEWSLETTER --}}
<section class="bg-indigo-600 py-10 md:py-16">
    <div class="max-w-3xl mx-auto px-4 text-center text-white">
        <h2 class="text-2xl md:text-3xl font-bold mb-2 md:mb-4">Get Updates</h2>
        <p class="text-indigo-100 mb-6 md:mb-8 text-sm md:text-base">Subscribe to get latest offers, new arrivals, and more.</p>
        <form class="flex max-w-md mx-auto">
            <input type="email" placeholder="Enter your email" class="flex-1 px-3 md:px-4 py-2.5 md:py-3 rounded-l-lg text-gray-900 focus:outline-none text-sm md:text-base">
            <button class="bg-gray-900 px-4 md:px-6 py-2.5 md:py-3 rounded-r-lg font-semibold hover:bg-gray-800 transition text-sm md:text-base">Subscribe</button>
        </form>
    </div>
</section>

{{-- BRAND LOGOS --}}
@if($brands->isNotEmpty())
<section class="py-12 bg-white border-y border-gray-100 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 mb-8 text-center">
        <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Trusted by Top Brands</h2>
    </div>
    <div class="relative flex overflow-x-hidden">
        <div class="animate-scroll whitespace-nowrap flex items-center">
            @foreach($brands->concat($brands) as $brand) {{-- Duplicate for seamless loop --}}
            <div class="mx-12 flex-shrink-0">
                <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" class="h-20 w-auto grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition duration-300">
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
