<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackService
{
    protected string $secretKey;
    protected string $paymentUrl;

    public function __construct()
    {
        $this->secretKey = config('services.paystack.secret_key');
        $this->paymentUrl = config('services.paystack.payment_url', 'https://api.paystack.co');
    }

    public function initializePayment(Order $order): array
    {
        $response = Http::withToken($this->secretKey)
            ->post("{$this->paymentUrl}/transaction/initialize", [
                'email' => $order->email,
                'amount' => (int) ($order->total * 100), // Paystack requires amount in kobo
                'reference' => $order->order_number,
                'callback_url' => route('payment.callback'),
                'metadata' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_name' => $order->first_name . ' ' . $order->last_name,
                ],
            ]);

        if ($response->successful() && $response->json('status')) {
            $data = $response->json('data');

            Payment::create([
                'order_id' => $order->id,
                'reference' => $order->order_number,
                'amount' => $order->total,
                'status' => 'pending',
            ]);

            return [
                'success' => true,
                'authorization_url' => $data['authorization_url'],
                'reference' => $data['reference'],
            ];
        }

        Log::error('Paystack initialization failed', ['response' => $response->json()]);

        return [
            'success' => false,
            'message' => $response->json('message') ?? 'Payment initialization failed.',
        ];
    }

    public function verifyPayment(string $reference): array
    {
        $response = Http::withToken($this->secretKey)
            ->get("{$this->paymentUrl}/transaction/verify/{$reference}");

        if ($response->successful() && $response->json('status')) {
            $data = $response->json('data');

            if ($data['status'] === 'success') {
                $payment = Payment::where('reference', $reference)->first();

                if ($payment) {
                    $payment->update([
                        'status' => 'success',
                        'method' => $data['channel'] ?? 'card',
                        'gateway_response' => $data,
                        'paid_at' => now(),
                    ]);

                    $order = $payment->order;
                    $order->update(['status' => 'paid']);

                    // Reduce stock
                    foreach ($order->items as $item) {
                        $item->product->decrement('stock_quantity', $item->quantity);
                    }
                }

                return ['success' => true, 'data' => $data];
            }
        }

        return [
            'success' => false,
            'message' => 'Payment verification failed.',
        ];
    }

    public function handleWebhook(array $payload): void
    {
        $event = $payload['event'] ?? '';
        $data = $payload['data'] ?? [];

        if ($event === 'charge.success') {
            $reference = $data['reference'] ?? '';
            $this->verifyPayment($reference);
        }
    }
}
