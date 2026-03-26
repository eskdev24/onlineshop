<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Buyvia Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>* { font-family: 'Inter', sans-serif; } [x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-100 h-screen overflow-hidden" x-data="{ sidebarOpen: true }">
    <div class="flex h-full">
        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-gray-900 text-gray-300 transition-all duration-300 flex-shrink-0 h-full flex flex-col">
            <div class="p-4 flex items-center justify-between border-b border-gray-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center" x-show="sidebarOpen">
                    <img src="{{ asset('images/logo.png') }}" alt="Buyvia Admin" class="h-12 w-auto">
                </a>
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>

            <nav class="mt-4 px-4 space-y-2 flex-1 overflow-y-auto custom-scrollbar">
                @php
                    $navItems = [
                        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                        ['route' => 'admin.analytics.index', 'label' => 'Analytics', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                        ['route' => 'admin.products.index', 'label' => 'Products', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                        ['route' => 'admin.categories.index', 'label' => 'Categories', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                        ['route' => 'admin.brands.index', 'label' => 'Brands', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                        ['route' => 'admin.hot-deals.index', 'label' => 'Hot Deals', 'icon' => 'M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.99 7.99 0 0120 13a7.99 7.99 0 01-2.343 5.657z'],
                        ['route' => 'admin.hero-sliders.index', 'label' => 'Hero Sliders', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        ['route' => 'admin.orders.index', 'label' => 'Orders', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                        ['route' => 'admin.customers.index', 'label' => 'Customers', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                        ['route' => 'admin.coupons.index', 'label' => 'Coupons', 'icon' => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z'],
                        ['route' => 'admin.reviews.index', 'label' => 'Reviews', 'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
                        ['route' => 'admin.settings.index', 'label' => 'Settings', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
                    ]; 
                @endphp

                @foreach($navItems as $link)
                <a href="{{ route($link['route']) }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs($link['route'].'*') ? 'bg-gray-800 text-white' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}"></path></svg>
                    <span x-show="sidebarOpen" class="text-sm">{{ $link['label'] }}</span>
                </a>
                @endforeach

                <hr class="border-gray-800 my-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-gray-800 transition text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    <span x-show="sidebarOpen" class="text-sm">View Store</span>
                </a>
            </nav>
        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white shadow-sm px-6 py-4 flex items-center justify-between sticky top-0 z-10">
                <h1 class="text-lg font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
                <div class="flex items-center space-x-4">
                    @php $admin = Auth::user(); @endphp
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            @if($admin->avatar)
                                <img src="{{ $admin->avatar_url }}" alt="Admin" class="w-10 h-10 rounded-full object-cover border-2 border-indigo-200">
                            @else
                                <div class="w-10 h-10 rounded-full bg-indigo-100 border-2 border-indigo-200 flex items-center justify-center">
                                    <span class="text-sm font-bold text-indigo-600">{{ substr($admin->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <label for="admin-avatar" class="absolute bottom-0 right-0 bg-indigo-600 text-white p-1 rounded-full cursor-pointer hover:bg-indigo-700 transition shadow-md">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </label>
                            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="hidden">
                                @csrf
                                <input type="file" name="avatar" id="admin-avatar" accept="image/*" onchange="this.form.submit()">
                            </form>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ $admin->name }}</p>
                            <p class="text-xs text-gray-500">Admin</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-md hover:shadow-lg">Logout</button></form>
                </div>
            </header>

            <div class="flex-1">
                @if(session('success'))
                <div class="mx-6 mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>
                @endif

                <main class="p-6">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
