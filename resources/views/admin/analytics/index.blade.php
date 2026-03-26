@extends('layouts.admin')
@section('title', 'Business Analytics')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Analytics Overview</h1>
        <p class="text-sm text-gray-500">Track your store performance, sales trends and customer behavior.</p>
    </div>
    <div class="flex space-x-3" x-data="{ open: false }">
        <div class="relative">
            <button @click="open = !open" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition flex items-center shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export Report
            </button>
            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden" x-cloak>
                <button onclick="exportData('csv')" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 border-b border-gray-50 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z"></path></svg>
                    Download CSV
                </button>
                <button onclick="exportData('excel')" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 border-b border-gray-50 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z"></path></svg>
                    Download Excel
                </button>
                <button onclick="window.print()" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
                    Save as PDF / Print
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Quick Stats --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Revenue</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ settings('currency_symbol', '₵') }}{{ number_format($stats['total_revenue'], 2) }}</p>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">This Month</p>
        <p class="text-2xl font-bold text-indigo-600 mt-1">{{ settings('currency_symbol', '₵') }}{{ number_format($stats['monthly_revenue'], 2) }}</p>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Orders</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_orders']) }}</p>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pending Orders</p>
        <p class="text-2xl font-bold text-orange-500 mt-1">{{ number_format($stats['pending_orders']) }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    {{-- Revenue Line Chart --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Revenue Trend (Last 30 Days)</h3>
        <canvas id="revenueChart" height="300"></canvas>
    </div>

    {{-- Top Products Bar Chart --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Top 5 Selling Products</h3>
        <canvas id="productsChart" height="300"></canvas>
    </div>

    {{-- Payment Methods Pie Chart --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Orders by Payment Method</h3>
        <div class="max-w-[300px] mx-auto">
            <canvas id="paymentChart"></canvas>
        </div>
    </div>

    {{-- Data Table Placeholder --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Recent Performance Summary</h3>
        <div class="space-y-4">
            @foreach($topProducts as $product)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                <span class="text-sm font-medium text-gray-700 truncate pr-4">{{ $product->product_name }}</span>
                <span class="text-sm font-bold text-gray-900 whitespace-nowrap">{{ $product->total_sold }} sold</span>
            </div>
            @endforeach
            @if($topProducts->isEmpty())
                <p class="text-gray-400 text-center py-8">No sales data available yet.</p>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // 1. Revenue Chart
    const revCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueData->pluck('date')) !!},
            datasets: [{
                label: 'Daily Revenue',
                data: {!! json_encode($revenueData->pluck('daily_revenue')) !!},
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // 2. Products Chart
    const prodCtx = document.getElementById('productsChart').getContext('2d');
    new Chart(prodCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topProducts->pluck('product_name')) !!},
            datasets: [{
                label: 'Units Sold',
                data: {!! json_encode($topProducts->pluck('total_sold')) !!},
                backgroundColor: '#10b981'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    // 3. Payment Method Chart
    const payCtx = document.getElementById('paymentChart').getContext('2d');
    new Chart(payCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($paymentMethods->pluck('method')) !!},
            datasets: [{
                data: {!! json_encode($paymentMethods->pluck('count')) !!},
                backgroundColor: ['#4f46e5', '#f59e0b', '#10b981', '#ef4444', '#6366f1']
            }]
        },
        options: {
            responsive: true,
            cutout: '70%'
        }
    });
</script>
@endpush
@endsection
