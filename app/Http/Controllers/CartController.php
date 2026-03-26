<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService) {}

    public function index()
    {
        $cart = $this->cartService->getCart();
        $summary = $this->cartService->getCartSummary();
        return view('pages.cart', compact('cart', 'summary'));
    }

    public function add(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'integer|min:1']);
        $item = $this->cartService->addItem($request->product_id, $request->get('quantity', 1));

        if ($request->ajax()) {
            $summary = $this->cartService->getCartSummary();
            return response()->json(['success' => true, 'message' => 'Added to cart!', 'cart_count' => $summary['items_count']]);
        }
        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, int $itemId)
    {
        $request->validate(['quantity' => 'required|integer|min:0']);
        $this->cartService->updateItem($itemId, $request->quantity);

        if ($request->ajax()) {
            $summary = $this->cartService->getCartSummary();
            return response()->json(['success' => true, 'summary' => $summary]);
        }
        return back()->with('success', 'Cart updated!');
    }

    public function remove(Request $request, int $itemId)
    {
        $this->cartService->removeItem($itemId);

        if ($request->ajax()) {
            $summary = $this->cartService->getCartSummary();
            return response()->json(['success' => true, 'summary' => $summary]);
        }
        return back()->with('success', 'Item removed from cart!');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string']);
        $result = $this->cartService->applyCoupon($request->coupon_code);

        if ($request->ajax()) {
            return response()->json($result);
        }
        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }
}
