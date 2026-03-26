@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="bg-gray-50 py-6 md:py-12 min-h-screen">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-6 md:mb-8">Checkout</h1>

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            {{-- Checkout Form --}}
            <div class="w-full lg:w-2/3">
                <div class="bg-white rounded-xl md:rounded-2xl shadow-sm p-4 md:p-6 lg:p-8">
                    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                        @csrf
                        
                        {{-- Shipping Address --}}
                        <h2 class="text-lg md:text-xl font-bold text-gray-900 mb-4 md:mb-6">Shipping Address</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-6 md:mb-8">
                            @if(auth()->user()->addresses->count() > 0)
                                <div class="col-span-full mb-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Saved Address</label>
                                    <select name="address_id" id="savedAddress" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 border text-sm">
                                        <option value="">-- Use New Address --</option>
                                        @foreach(auth()->user()->addresses as $address)
                                            <option value="{{ $address->id }}"
                                                data-first_name="{{ $address->first_name ?? '' }}"
                                                data-last_name="{{ $address->last_name ?? '' }}"
                                                data-phone="{{ $address->phone ?? '' }}"
                                                data-address_line_1="{{ $address->address_line_1 }}"
                                                data-address_line_2="{{ $address->address_line_2 ?? '' }}"
                                                data-city="{{ $address->city }}"
                                                data-state="{{ $address->state }}"
                                                data-postal_code="{{ $address->postal_code ?? '' }}"
                                                data-country="{{ $address->country }}">
                                                {{ $address->address_line_1 }}, {{ $address->city }}, {{ $address->state }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-full flex items-center justify-center">
                                    <span class="text-gray-400 font-medium">OR</span>
                                </div>
                            @endif

                            <div>
                                <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                                <input type="text" name="first_name" required value="{{ old('first_name', explode(' ', auth()->user()->name)[0] ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 md:p-3 border text-sm">
                            </div>
                            <div>
                                <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" name="last_name" required value="{{ old('last_name', explode(' ', auth()->user()->name)[1] ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 md:p-3 border text-sm">
                            </div>
                            <div>
                                <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" required value="{{ old('email', auth()->user()->email) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 md:p-3 border text-sm">
                            </div>
                            <div>
                                <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Phone <span class="text-red-500">*</span></label>
                                <input type="text" name="phone" required value="{{ old('phone', auth()->user()->phone) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 md:p-3 border text-sm">
                            </div>
                            <div class="col-span-full">
                                <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Address Line 1 <span class="text-red-500">*</span></label>
                                <input type="text" name="address_line_1" required value="{{ old('address_line_1') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 md:p-3 border text-sm">
                            </div>
                            <div class="col-span-full">
                                <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Address Line 2</label>
                                <input type="text" name="address_line_2" value="{{ old('address_line_2') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 md:p-3 border text-sm">
                            </div>
                            <div>
                                <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                                <input type="text" name="city" required value="{{ old('city') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 md:p-3 border text-sm">
                            </div>
                            <div>
                                <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">State <span class="text-red-500">*</span></label>
                                <input type="text" name="state" required value="{{ old('state') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 md:p-3 border text-sm">
                            </div>
                            <div>
                                <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                <input type="text" name="postal_code" value="{{ old('postal_code') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 md:p-3 border text-sm">
                            </div>
                            <div>
                                <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Country <span class="text-red-500">*</span></label>
                                <input type="text" name="country" required value="{{ old('country', settings('default_country', 'Nigeria')) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 md:p-3 border text-sm">
                            </div>
                            <div class="col-span-full mt-2">
                                <label class="flex items-start">
                                    <input type="checkbox" name="save_address" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4 mt-0.5">
                                    <span class="ml-2 text-xs md:text-sm text-gray-600">Save this address for future orders</span>
                                </label>
                            </div>
                        </div>

                        {{-- Shipping Method --}}
                        <div class="mb-6 md:mb-8 pt-6 md:pt-8 border-t border-gray-100">
                            <h2 class="text-lg md:text-xl font-bold text-gray-900 mb-4 md:mb-6">Shipping Method</h2>
                            <div class="space-y-3">
                                <label class="flex items-center justify-between p-3 md:p-4 border rounded-xl cursor-pointer transition hover:bg-gray-50 border-indigo-500 bg-indigo-50 shipping-option" onclick="updateShippingSelection(this, {{ $rates['standard'] }})">
                                    <div class="flex items-center">
                                        <input type="radio" name="shipping_method" value="Standard Delivery" checked class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <div class="ml-3">
                                            <span class="block text-sm font-medium text-gray-900">Standard Delivery</span>
                                            <span class="block text-xs text-gray-500">3-5 Business Days</span>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($rates['standard']) }}</span>
                                </label>

                                <label class="flex items-center justify-between p-3 md:p-4 border rounded-xl cursor-pointer transition hover:bg-gray-50 border-gray-200 shipping-option" onclick="updateShippingSelection(this, {{ $rates['express'] }})">
                                    <div class="flex items-center">
                                        <input type="radio" name="shipping_method" value="Express Delivery" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <div class="ml-3">
                                            <span class="block text-sm font-medium text-gray-900">Express Delivery</span>
                                            <span class="block text-xs text-gray-500">1-2 Business Days</span>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($rates['express']) }}</span>
                                </label>

                                @if($summary['subtotal'] >= $rates['free_threshold'])
                                <label class="flex items-center justify-between p-3 md:p-4 border rounded-xl cursor-pointer transition hover:bg-gray-50 border-gray-200 shipping-option" onclick="updateShippingSelection(this, 0)">
                                    <div class="flex items-center">
                                        <input type="radio" name="shipping_method" value="Free Shipping" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <div class="ml-3">
                                            <span class="block text-sm font-medium text-gray-900">Free Shipping</span>
                                            <span class="block text-xs text-gray-500">Orders over {{ settings('currency_symbol', '₵') }}{{ number_format($rates['free_threshold']) }}</span>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold text-green-600 italic">FREE</span>
                                </label>
                                @endif
                            </div>
                        </div>

                        {{-- Order Notes --}}
                        <div class="mb-6 md:mb-8 pt-6 md:pt-8 border-t border-gray-100">
                            <h2 class="text-lg md:text-xl font-bold text-gray-900 mb-4 md:mb-6">Order Notes (Optional)</h2>
                            <textarea name="notes" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 border text-sm" placeholder="Notes about your order, e.g. special notes for delivery.">{{ old('notes') }}</textarea>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Desktop Sidebar Summary --}}
            <div class="hidden lg:block w-full lg:w-1/3">
                <div class="bg-white rounded-2xl shadow-sm p-8 sticky top-24 border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b">Order Summary</h3>
                    
                    <div class="space-y-4 mb-6">
                        @foreach($cart->items as $item)
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 relative">
                                <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover">
                                <span class="absolute -top-2 -right-2 bg-gray-900 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">{{ $item->quantity }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 line-clamp-2">{{ $item->product->name }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ settings('currency_symbol', '₵') }}{{ number_format($item->price) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($item->subtotal) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="space-y-3 mb-6 text-sm text-gray-600 border-t pt-6">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-medium text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($summary['subtotal']) }}</span>
                        </div>
                        
                        @if($summary['discount'] > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Discount</span>
                            <span class="font-medium">-{{ settings('currency_symbol', '₵') }}{{ number_format($summary['discount']) }}</span>
                        </div>
                        @endif

                        <div class="flex justify-between">
                            <span>Tax ({{ settings('tax_rate', 0) }}%)</span>
                            <span class="font-medium text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($summary['tax']) }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span class="font-medium text-gray-900" id="summary-shipping">{{ settings('currency_symbol', '₵') }}{{ number_format($rates['standard']) }}</span>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <div class="flex justify-between items-end">
                            <span class="text-gray-900 text-lg font-bold">Total</span>
                            <span class="text-3xl font-extrabold text-indigo-600" id="summary-total">{{ settings('currency_symbol', '₵') }}{{ number_format($summary['total']) }}</span>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t">
                        <button type="submit" form="checkoutForm" class="w-full bg-indigo-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-indigo-700 transition shadow-lg flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Place Order & Pay {{ settings('currency_symbol', '₵') }}<span id="btn-total">{{ number_format($summary['total']) }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile: Order Summary with Button (last element before button) --}}
        <div class="lg:hidden">
            <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                <div class="flex justify-between items-center mb-4" x-data="{ open: false }">
                    <h3 class="font-bold text-gray-900">Order Summary ({{ count($cart->items) }} items)</h3>
                    <button @click="open = !open" class="text-indigo-600 text-sm font-medium">
                        <span x-text="open ? 'Hide' : 'Show'"></span> Details
                    </button>
                </div>
                
                <div x-show="open" x-collapse>
                    <div class="space-y-3 mb-4 max-h-48 overflow-y-auto">
                        @foreach($cart->items as $item)
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 relative">
                                <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover">
                                <span class="absolute -top-1 -right-1 bg-gray-900 text-white text-[10px] w-4 h-4 flex items-center justify-center rounded-full">{{ $item->quantity }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-900 line-clamp-2">{{ $item->product->name }}</p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-xs font-bold text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($item->subtotal) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="border-t pt-3 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($summary['subtotal']) }}</span>
                    </div>
                    @if($summary['discount'] > 0)
                    <div class="flex justify-between text-sm text-green-600">
                        <span>Discount</span>
                        <span class="font-medium">-{{ settings('currency_symbol', '₵') }}{{ number_format($summary['discount']) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax</span>
                        <span class="font-medium text-gray-900">{{ settings('currency_symbol', '₵') }}{{ number_format($summary['tax']) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-medium text-gray-900" id="mobile-summary-shipping">{{ settings('currency_symbol', '₵') }}{{ number_format($rates['standard']) }}</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="font-extrabold text-indigo-600 text-lg" id="mobile-summary-total">{{ settings('currency_symbol', '₵') }}{{ number_format($summary['total']) }}</span>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t">
                    <button type="submit" form="checkoutForm" class="w-full bg-indigo-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-indigo-700 transition shadow-lg">
                        Place Order & Pay
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    const subtotalWithTax = {{ $summary['subtotal'] - $summary['discount'] + $summary['tax'] }};
    const currency = '{{ settings('currency_symbol', '₵') }}';

    document.addEventListener('DOMContentLoaded', function() {
        const savedAddressSelect = document.getElementById('savedAddress');
        if (savedAddressSelect) {
            savedAddressSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (this.value) {
                    document.querySelector('input[name="first_name"]').value = selectedOption.dataset.first_name || '';
                    document.querySelector('input[name="last_name"]').value = selectedOption.dataset.last_name || '';
                    document.querySelector('input[name="phone"]').value = selectedOption.dataset.phone || '';
                    document.querySelector('input[name="address_line_1"]').value = selectedOption.dataset.address_line_1 || '';
                    document.querySelector('input[name="address_line_2"]').value = selectedOption.dataset.address_line_2 || '';
                    document.querySelector('input[name="city"]').value = selectedOption.dataset.city || '';
                    document.querySelector('input[name="state"]').value = selectedOption.dataset.state || '';
                    document.querySelector('input[name="postal_code"]').value = selectedOption.dataset.postal_code || '';
                    document.querySelector('input[name="country"]').value = selectedOption.dataset.country || '';
                } else {
                    document.querySelector('input[name="first_name"]').value = '';
                    document.querySelector('input[name="last_name"]').value = '';
                    document.querySelector('input[name="phone"]').value = '';
                    document.querySelector('input[name="address_line_1"]').value = '';
                    document.querySelector('input[name="address_line_2"]').value = '';
                    document.querySelector('input[name="city"]').value = '';
                    document.querySelector('input[name="state"]').value = '';
                    document.querySelector('input[name="postal_code"]').value = '';
                    document.querySelector('input[name="country"]').value = '';
                }
            });
        }
    });

    function updateShippingSelection(element, cost) {
        document.querySelectorAll('.shipping-option').forEach(el => {
            el.classList.remove('border-indigo-500', 'bg-indigo-50');
            el.classList.add('border-gray-200');
        });
        element.classList.remove('border-gray-200');
        element.classList.add('border-indigo-500', 'bg-indigo-50');
        
        const newTotal = subtotalWithTax + parseFloat(cost);
        const formattedTotal = currency + new Intl.NumberFormat().format(newTotal);
        const formattedShipping = cost === 0 ? 'FREE' : currency + new Intl.NumberFormat().format(cost);
        
        // Update all total displays
        document.getElementById('summary-shipping').innerText = formattedShipping;
        document.getElementById('summary-total').innerText = formattedTotal;
        document.getElementById('btn-total').innerText = new Intl.NumberFormat().format(newTotal);
        document.getElementById('mobile-summary-shipping').innerText = formattedShipping;
        document.getElementById('mobile-summary-total').innerText = formattedTotal;
        document.getElementById('mobile-btn-total').innerText = formattedTotal;
    }

    const checkoutForm = document.getElementById('checkoutForm');
    checkoutForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtns = document.querySelectorAll('button[type="submit"][form="checkoutForm"]');
        submitBtns.forEach(btn => {
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24">...</svg> Processing...';
        });

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const handler = PaystackPop.setup({
                    key: data.public_key,
                    email: data.email,
                    amount: data.amount,
                    currency: 'GHS',
                    ref: data.reference,
                    callback: function(response) {
                        window.location.href = "{{ route('payment.callback') }}?reference=" + response.reference;
                    },
                    onClose: function() {
                        submitBtns.forEach(btn => {
                            btn.disabled = false;
                            btn.innerHTML = 'Place Order & Pay';
                        });
                    }
                });
                handler.openIframe();
            } else {
                alert(data.message || 'Error initializing payment');
                submitBtns.forEach(btn => {
                    btn.disabled = false;
                    btn.innerHTML = 'Place Order & Pay';
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An unexpected error occurred. Please try again.');
            submitBtns.forEach(btn => {
                btn.disabled = false;
                btn.innerHTML = 'Place Order & Pay';
            });
        });
    });
</script>
@endsection
