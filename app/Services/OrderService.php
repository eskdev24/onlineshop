<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(protected CartService $cartService) {}

    public function createOrder(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $cart = $this->cartService->getCart();
            $summary = $this->cartService->getCartSummary();

            $shippingCost = (float) ($data['shipping_cost'] ?? 0);
            $total = ($summary['subtotal'] - $summary['discount'] + $summary['tax']) + $shippingCost;

            // Save address if requested
            $addressId = null;
            if (! empty($data['save_address']) && Auth::check()) {
                $address = \App\Models\Address::create([
                    'user_id' => Auth::id(),
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'address_line_1' => $data['address_line_1'],
                    'address_line_2' => $data['address_line_2'] ?? null,
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'postal_code' => $data['postal_code'] ?? null,
                    'country' => $data['country'] ?? 'Nigeria',
                    'phone' => $data['phone'] ?? null,
                    'is_default' => Auth::user()->addresses()->count() === 0,
                ]);
                $addressId = $address->id;
            }

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'status' => 'pending',
                'subtotal' => $summary['subtotal'],
                'discount' => $summary['discount'],
                'shipping_cost' => $shippingCost,
                'tax' => $summary['tax'],
                'total' => $total,
                'coupon_code' => $summary['coupon_code'],
                'shipping_method' => $data['shipping_method'] ?? 'Standard Delivery',
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address_line_1'],
                'city' => $data['city'],
                'state' => $data['state'],
                'postal_code' => $data['postal_code'] ?? null,
                'country' => $data['country'] ?? 'Ghana',
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->price * $item->quantity,
                ]);
            }

            // Record coupon usage if a coupon was applied
            if ($summary['coupon_code']) {
                $coupon = Coupon::where('code', $summary['coupon_code'])->first();
                if ($coupon) {
                    CouponUsage::create([
                        'coupon_id' => $coupon->id,
                        'user_id' => Auth::id(),
                        'order_id' => $order->id,
                    ]);
                    $coupon->increment('used_count');
                }
            }

            $this->cartService->clear();

            return $order;
        });
    }
}
