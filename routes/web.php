<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\HotDealController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaystackWebhookController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

// ─── PUBLIC ASSET ROUTES ─────────────────────────────────────
Route::get('/storage/avatars/{filename}', function ($filename) {
    $path = public_path('storage/avatars/'.$filename);
    if (! file_exists($path)) {
        $path = storage_path('app/public/avatars/'.$filename);
    }
    if (! file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('storage.avatar');

Route::get('/storage/products/{filename}', function ($filename) {
    $path = public_path('storage/products/'.$filename);
    if (! file_exists($path)) {
        $path = storage_path('app/public/products/'.$filename);
    }
    if (! file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('storage.products');

Route::get('/storage/products/gallery/{filename}', function ($filename) {
    $path = public_path('storage/products/gallery/'.$filename);
    if (! file_exists($path)) {
        $path = storage_path('app/public/products/gallery/'.$filename);
    }
    if (! file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('storage.gallery');

Route::get('/storage/brands/{filename}', function ($filename) {
    $path = public_path('storage/brands/'.$filename);
    if (! file_exists($path)) {
        $path = storage_path('app/public/brands/'.$filename);
    }
    if (! file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('storage.brands');

Route::get('/storage/categories/{filename}', function ($filename) {
    $path = public_path('storage/categories/'.$filename);
    if (! file_exists($path)) {
        $path = storage_path('app/public/categories/'.$filename);
    }
    if (! file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('storage.categories');

Route::get('/storage/hero/{filename}', function ($filename) {
    $path = public_path('storage/hero/'.$filename);
    if (! file_exists($path)) {
        $path = storage_path('app/public/hero/'.$filename);
    }
    if (! file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('storage.hero');

// ─── PUBLIC ROUTES ─────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('product.show');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');

// ─── CART ROUTES ─────────────────────────────────────────
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');

// ─── PAYSTACK WEBHOOK ────────────────────────────────────
Route::post('/paystack/webhook', [PaystackWebhookController::class, 'handle'])->name('paystack.webhook');

// ─── PAYMENT CALLBACK ────────────────────────────────────
Route::get('/payment/callback', [CheckoutController::class, 'callback'])->name('payment.callback');

// ─── AUTH ROUTES ─────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/login', function (\Illuminate\Http\Request $request) {
        $credentials = $request->validate(['email' => 'required|email', 'password' => 'required']);
        if (auth()->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            app(\App\Services\CartService::class)->mergeGuestCart();
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended(route('customer.dashboard'));
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->onlyInput('email');
    })->name('login.submit');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    Route::post('/register', function (\Illuminate\Http\Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                \Illuminate\Validation\Rules\Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);
        $user = \App\Models\User::create(['name' => $data['name'], 'email' => $data['email'], 'password' => bcrypt($data['password']), 'role' => 'customer']);
        auth()->login($user);
        app(\App\Services\CartService::class)->mergeGuestCart();

        return redirect()->route('customer.dashboard');
    })->name('register.submit');

    // Password Reset Routes
    Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout');

// ─── CUSTOMER ROUTES (AUTH REQUIRED) ─────────────────────
Route::middleware('auth')->prefix('account')->name('customer.')->group(function () {
    Route::get('/', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
    Route::get('/orders/{orderNumber}', [CustomerController::class, 'orderDetail'])->name('order.detail');
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::put('/profile', [CustomerController::class, 'updateProfile'])->name('profile.update');
    Route::get('/wishlist', [CustomerController::class, 'wishlist'])->name('wishlist');
    Route::post('/wishlist', [CustomerController::class, 'addToWishlist'])->name('wishlist.add');
    Route::delete('/wishlist/{id}', [CustomerController::class, 'removeFromWishlist'])->name('wishlist.remove');
    Route::post('/address', [CustomerController::class, 'storeAddress'])->name('address.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/order/confirmation/{orderNumber}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');
    Route::post('/review/{product}', [ReviewController::class, 'store'])->name('review.store');
});

// ─── ADMIN ROUTES ────────────────────────────────────────
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/profile', [Admin\DashboardController::class, 'updateProfile'])->name('profile.update');

    Route::resource('products', Admin\ProductController::class);
    Route::delete('products/images/{image}', [Admin\ProductController::class, 'deleteImage'])->name('products.images.destroy');
    Route::resource('categories', Admin\CategoryController::class);
    Route::resource('brands', Admin\BrandController::class);
    Route::resource('coupons', Admin\CouponController::class);
    Route::resource('hot-deals', HotDealController::class);
    Route::get('/hero-sliders', [Admin\HeroSliderController::class, 'index'])->name('hero-sliders.index');
    Route::get('/hero-sliders/create', [Admin\HeroSliderController::class, 'create'])->name('hero-sliders.create');
    Route::post('/hero-sliders/store', [Admin\HeroSliderController::class, 'store'])->name('hero-sliders.store');
    Route::get('/hero-sliders/{hero_slider}/edit', [Admin\HeroSliderController::class, 'edit'])->name('hero-sliders.edit');
    Route::post('/hero-sliders/{hero_slider}/update', [Admin\HeroSliderController::class, 'update'])->name('hero-sliders.update');
    Route::get('/hero-sliders/{hero_slider}/delete', [Admin\HeroSliderController::class, 'delete'])->name('hero-sliders.delete');

    Route::get('/orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('orders.status');

    Route::get('/customers', [Admin\CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{customer}', [Admin\CustomerController::class, 'show'])->name('customers.show');

    Route::get('/reviews', [Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::patch('/reviews/{review}/approve', [Admin\ReviewController::class, 'approve'])->name('reviews.approve');
    Route::delete('/reviews/{review}', [Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/settings', [Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');

    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
});
