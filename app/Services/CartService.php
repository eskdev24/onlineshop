<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart(): Cart
    {
        if (Auth::check()) {
            $cart = Cart::with('items.product')->firstOrCreate(['user_id' => Auth::id()]);
        } else {
            $sessionId = Session::getId();
            $cart = Cart::with('items.product')->firstOrCreate(['session_id' => $sessionId]);
        }
        return $cart;
    }

    public function addItem(int $productId, int $quantity = 1): CartItem
    {
        $cart = $this->getCart();
        $product = Product::findOrFail($productId);
        $price = $product->current_price;

        $item = $cart->items()->where('product_id', $productId)->first();

        if ($item) {
            $item->update(['quantity' => $item->quantity + $quantity, 'price' => $price]);
        } else {
            $item = $cart->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
            ]);
        }

        return $item->load('product');
    }

    public function updateItem(int $itemId, int $quantity): void
    {
        $cart = $this->getCart();
        $item = $cart->items()->findOrFail($itemId);

        if ($quantity <= 0) {
            $item->delete();
        } else {
            $item->update(['quantity' => $quantity]);
        }
    }

    public function removeItem(int $itemId): void
    {
        $cart = $this->getCart();
        $cart->items()->where('id', $itemId)->delete();
    }

    public function clear(): void
    {
        $cart = $this->getCart();
        $cart->items()->delete();
        $cart->update(['coupon_code' => null]);
    }

    public function applyCoupon(string $code): array
    {
        $coupon = Coupon::where('code', $code)->first();
        $cart = $this->getCart();

        if (!$coupon) {
            return ['success' => false, 'message' => 'Invalid coupon code.'];
        }

        if (!$coupon->isValid($cart->subtotal)) {
            return ['success' => false, 'message' => 'This coupon is not valid or has expired.'];
        }

        $cart->update(['coupon_code' => $code]);
        return ['success' => true, 'message' => 'Coupon applied successfully!'];
    }

    public function getCartSummary(): array
    {
        $cart = $this->getCart();
        $subtotal = $cart->subtotal;
        $discount = 0;

        if ($cart->coupon_code) {
            $coupon = Coupon::where('code', $cart->coupon_code)->first();
            if ($coupon && $coupon->isValid($subtotal)) {
                $discount = $coupon->calculateDiscount($subtotal);
            }
        }

        $taxRate = (float) settings('tax_rate', 0);
        $shippingCost = (float) settings('shipping_cost', 0);
        
        $tax = round(($subtotal - $discount) * ($taxRate / 100), 2);
        $total = $subtotal - $discount + $tax + $shippingCost;

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'shipping' => $shippingCost,
            'total' => $total,
            'coupon_code' => $cart->coupon_code,
            'items_count' => $cart->total_items,
        ];
    }

    public function mergeGuestCart(): void
    {
        if (!Auth::check()) return;

        $sessionId = Session::getId();
        $guestCart = Cart::where('session_id', $sessionId)->with('items')->first();

        if (!$guestCart || $guestCart->items->isEmpty()) return;

        $userCart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        foreach ($guestCart->items as $item) {
            $existing = $userCart->items()->where('product_id', $item->product_id)->first();
            if ($existing) {
                $existing->update(['quantity' => $existing->quantity + $item->quantity]);
            } else {
                $userCart->items()->create($item->only(['product_id', 'quantity', 'price']));
            }
        }

        $guestCart->items()->delete();
        $guestCart->delete();
    }
}
