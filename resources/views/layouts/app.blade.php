<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', settings('site_name', 'Buyvia')) - {{ settings('site_tagline', 'Shop Smart, Live Better') }}</title>
    <meta name="description" content="@yield('description', settings('site_name', 'Buyvia') . ' - Your premier online shopping destination.')">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236366f1' stroke-width='2'><circle cx='9' cy='21' r='1'/><circle cx='20' cy='21' r='1'/><path d='M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6'/></svg>">
    <meta property="og:title" content="@yield('title', settings('site_name', 'Buyvia')) - {{ settings('site_tagline', 'Shop Smart, Live Better') }}">
    <meta property="og:description" content="@yield('description', settings('site_name', 'Buyvia') . ' - Your premier online shopping destination.')">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', settings('site_name', 'Buyvia'))">
    <meta name="twitter:description" content="@yield('description', settings('site_name', 'Buyvia') . ' - Your premier online shopping destination.')">
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .gradient-hero { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.15); }
        .btn-primary { @apply bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-all duration-300; }
        .fade-in { animation: fadeIn 0.5s ease-in; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Infinite Scroll Animation */
        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-scroll {
            display: flex;
            width: max-content;
            animation: scroll 30s linear infinite;
        }
        .animate-scroll:hover {
            animation-play-state: paused;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">
    {{-- NAVBAR --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ settings('site_name', 'Buyvia') }}" class="h-16 w-auto">
                </a>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="relative {{ request()->is('/') ? 'text-indigo-600' : 'text-gray-700' }} hover:text-indigo-600 font-medium transition group">
                        Home
                        <span class="absolute -bottom-1 left-0 w-6 h-0.5 bg-indigo-600 transition-all {{ request()->is('/') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }}"></span>
                    </a>
                    <a href="{{ route('shop.index') }}" class="relative {{ request()->is('shop*') ? 'text-indigo-600' : 'text-gray-700' }} hover:text-indigo-600 font-medium transition group">
                        Shop
                        <span class="absolute -bottom-1 left-0 w-6 h-0.5 bg-indigo-600 transition-all {{ request()->is('shop*') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }}"></span>
                    </a>
                    <a href="{{ route('home') }}#hot-deals" class="text-gray-700 hover:text-indigo-600 font-medium transition">Deals</a>
                    <a href="{{ route('about') }}" class="relative {{ request()->is('about*') ? 'text-indigo-600' : 'text-gray-700' }} hover:text-indigo-600 font-medium transition group">
                        About
                        <span class="absolute -bottom-1 left-0 w-6 h-0.5 bg-indigo-600 transition-all {{ request()->is('about*') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }}"></span>
                    </a>
                    <a href="{{ route('contact') }}" class="relative {{ request()->is('contact*') ? 'text-indigo-600' : 'text-gray-700' }} hover:text-indigo-600 font-medium transition group">
                        Contact
                        <span class="absolute -bottom-1 left-0 w-6 h-0.5 bg-indigo-600 transition-all {{ request()->is('contact*') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }}"></span>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    {{-- Search --}}
                    <form action="{{ route('shop.index') }}" method="GET" class="hidden lg:block">
                        <input type="text" name="search" placeholder="Search products..." class="w-48 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </form>

                    {{-- Cart --}}
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-700 hover:text-indigo-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                        <span id="cart-count" class="absolute -top-1 -right-1 bg-indigo-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ app(\App\Services\CartService::class)->getCartSummary()['items_count'] }}</span>
                    </a>

@auth
                        <div class="relative" x-data="{ dropdown: false }">
                            <button @click="dropdown = !dropdown" class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600">
                                @php $user = Auth::user(); @endphp
                                @if($user->avatar)
                                    <img src="{{ $user->avatar_url }}" alt="Profile" class="w-8 h-8 rounded-full object-cover border-2 border-indigo-200">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 border-2 border-indigo-200 flex items-center justify-center">
                                        <span class="text-xs font-bold text-indigo-600">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <span class="hidden sm:block text-sm font-medium">{{ Auth::user()->name }}</span>
                            </button>
                            <div x-show="dropdown" @click.away="dropdown = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Panel</a>
                                @endif
                                <a href="{{ route('customer.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Account</a>
                                <a href="{{ route('customer.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Orders</a>
                                <a href="{{ route('customer.wishlist') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Wishlist</a>
                                <hr class="my-1">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">Login</a>
                        <a href="{{ route('register') }}" class="hidden sm:block text-sm font-medium bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">Register</a>
                    @endauth

                    {{-- Mobile menu --}}
                    <button @click="open = !open" class="md:hidden p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Nav --}}
            <div x-show="open" x-cloak class="md:hidden pb-4 space-y-2">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">Home</a>
                <a href="{{ route('shop.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">Shop</a>
                <a href="{{ route('about') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">About</a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">Contact</a>
                <form action="{{ route('shop.index') }}" method="GET" class="px-3">
                    <input type="text" name="search" placeholder="Search..." class="w-full px-3 py-2 border rounded-lg text-sm">
                </form>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 mt-4">
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex justify-between items-center" x-data="{ show: true }" x-show="show">
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="text-green-500 hover:text-green-700">&times;</button>
        </div>
    </div>
    @endif
    @if(session('error'))
    <div class="max-w-7xl mx-auto px-4 mt-4">
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex justify-between items-center" x-data="{ show: true }" x-show="show">
            <span>{{ session('error') }}</span>
            <button @click="show = false" class="text-red-500 hover:text-red-700">&times;</button>
        </div>
    </div>
    @endif

    {{-- MAIN CONTENT --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gray-900 text-gray-300 mt-12">
        <div class="max-w-7xl mx-auto px-4 pt-4 pb-12 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <a href="/" class="flex items-center gap-2 mb-2">
                    <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="text-2xl font-bold text-white">Buyvia</span>
                </a>
                <p class="text-sm mt-1 mb-4">Shop Smart, Live Better. Discover amazing products at unbeatable prices. Quality guaranteed, fast delivery, and hassle-free returns.</p>
                <div class="flex space-x-4">
                    @if(settings('social_facebook'))
                    <a href="{{ settings('social_facebook') }}" class="text-gray-400 hover:text-white transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    @endif
                    @if(settings('social_instagram'))
                    <a href="{{ settings('social_instagram') }}" class="text-gray-400 hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    </a>
                    @endif
                    @if(settings('social_twitter'))
                    <a href="{{ settings('social_twitter') }}" class="text-gray-400 hover:text-white transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    @endif
                </div>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('shop.index') }}" class="hover:text-white transition">Shop</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white transition">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition">Contact</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-white transition">FAQ</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Customer Service</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('privacy') }}" class="hover:text-white transition">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}" class="hover:text-white transition">Terms of Service</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition">Returns & Refunds</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Newsletter</h4>
                <p class="text-sm mb-3">Get updates on new products and exclusive offers.</p>
                <form class="flex">
                    <input type="email" placeholder="Your email" class="flex-1 px-3 py-2 rounded-l-lg bg-gray-800 border border-gray-700 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500">
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-r-lg text-sm hover:bg-indigo-700 transition">Subscribe</button>
                </form>
            </div>
        </div>
        <div class="border-t border-gray-800 py-4 text-center text-sm">
            <p>&copy; {{ date('Y') }} {{ settings('site_name', 'Buyvia') }}. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // AJAX Add to Cart
        function addToCart(productId) {
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ product_id: productId, quantity: 1 })
            }).then(r => r.json()).then(data => {
                if (data.success) {
                    document.getElementById('cart-count').textContent = data.cart_count;
                    showToast(data.message);
                }
            });
        }

        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 fade-in';
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }
    </script>
    @stack('scripts')
</body>
</html>
