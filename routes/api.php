<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;

Route::prefix('v1')->group(function () {
    Route::get('/products', function (\Illuminate\Http\Request $request) {
        $query = Product::active()->inStock()->with('category', 'brand');
        if ($request->filled('category')) $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        if ($request->filled('search')) $query->where('name', 'like', "%{$request->search}%");
        return response()->json($query->paginate($request->get('per_page', 12)));
    });

    Route::get('/products/{slug}', function (string $slug) {
        $product = Product::where('slug', $slug)->active()->with('images', 'category', 'brand', 'approvedReviews')->firstOrFail();
        return response()->json($product);
    });

    Route::get('/categories', function () {
        return response()->json(\App\Models\Category::active()->parentCategories()->withCount('products')->get());
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function () { return request()->user(); });

        Route::get('/cart', function () {
            $cartService = app(\App\Services\CartService::class);
            return response()->json(['cart' => $cartService->getCart()->load('items.product'), 'summary' => $cartService->getCartSummary()]);
        });

        Route::post('/cart/add', function (\Illuminate\Http\Request $request) {
            $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'integer|min:1']);
            $cartService = app(\App\Services\CartService::class);
            $cartService->addItem($request->product_id, $request->get('quantity', 1));
            return response()->json(['success' => true, 'summary' => $cartService->getCartSummary()]);
        });

        Route::get('/orders', function () {
            return response()->json(auth()->user()->orders()->with('items')->latest()->paginate(10));
        });
    });
});
