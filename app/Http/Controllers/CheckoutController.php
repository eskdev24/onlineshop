<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use App\Services\PaystackService;
use App\Models\ShippingRate;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected OrderService $orderService,
        protected PaystackService $paystackService
    ) {}

    public function index()
    {
        $cart = $this->cartService->getCart();
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $summary = $this->cartService->getCartSummary();
        $user = auth()->user();

        // Dynamic rates from settings
        $rates = [
            'standard' => (float) settings('shipping_standard', 0),
            'express' => (float) settings('shipping_express', 0),
            'free_threshold' => (float) settings('shipping_free_threshold', 5000),
        ];

        return view('pages.checkout', compact('cart', 'summary', 'user', 'rates'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address_line_1' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'shipping_method' => 'required|string',
        ]);

        try {
            $summary = $this->cartService->getCartSummary();
            $shippingCost = 0;
            $method = $request->shipping_method;

            if ($method === 'Express Delivery') {
                $shippingCost = (float) settings('shipping_express', 0);
            } elseif ($method === 'Standard Delivery') {
                $shippingCost = (float) settings('shipping_standard', 0);
            } elseif ($method === 'Free Shipping') {
                if ($summary['subtotal'] >= (float) settings('shipping_free_threshold', 5000)) {
                    $shippingCost = 0;
                } else {
                    throw new \Exception('Subtotal does not qualify for free shipping.');
                }
            }

            $order = $this->orderService->createOrder(array_merge(
                $request->all(),
                ['shipping_cost' => $shippingCost]
            ));

            $result = $this->paystackService->initializePayment($order);

            if ($result['success']) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'reference' => $order->order_number,
                        'email' => $order->email,
                        'amount' => (int) ($order->total * 100),
                        'public_key' => config('services.paystack.public_key'),
                    ]);
                }
                return redirect($result['authorization_url']);
            }

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $result['message'] ?? 'Payment initialization failed.'], 422);
            }

            return back()->with('error', $result['message'] ?? 'Payment initialization failed.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        $reference = $request->query('reference') ?? $request->query('trxref');

        if (!$reference) {
            return redirect()->route('shop.index')->with('error', 'Invalid payment reference.');
        }

        $result = $this->paystackService->verifyPayment($reference);

        if ($result['success']) {
            $order = \App\Models\Order::where('order_number', $reference)->first();
            return redirect()->route('order.confirmation', $order->order_number)->with('success', 'Payment successful!');
        }

        return redirect()->route('shop.index')->with('error', 'Payment verification failed.');
    }

    public function confirmation(string $orderNumber)
    {
        $order = \App\Models\Order::where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->with('items.product')
            ->firstOrFail();

        return view('pages.order-confirmation', compact('order'));
    }
}
