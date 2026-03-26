<?php

namespace App\Http\Controllers;

use App\Services\PaystackService;
use Illuminate\Http\Request;

class PaystackWebhookController extends Controller
{
    public function handle(Request $request, PaystackService $paystackService)
    {
        // Verify webhook signature
        $paystackSignature = $request->header('x-paystack-signature');
        $computedSignature = hash_hmac('sha512', $request->getContent(), config('services.paystack.secret_key'));

        if ($paystackSignature !== $computedSignature) {
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        $paystackService->handleWebhook($request->all());

        return response()->json(['message' => 'Webhook handled'], 200);
    }
}
