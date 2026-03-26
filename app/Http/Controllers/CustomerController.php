<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $recentOrders = $user->orders()->latest()->take(5)->get();
        $wishlistCount = $user->wishlist()->count();
        $orderCount = $user->orders()->count();

        return view('pages.account.dashboard', compact('user', 'recentOrders', 'wishlistCount', 'orderCount'));
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);

        return view('pages.account.orders', compact('orders'));
    }

    public function orderDetail(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->with('items.product', 'payment')
            ->firstOrFail();

        return view('pages.account.order-detail', compact('order'));
    }

    public function profile()
    {
        return view('pages.account.profile', ['user' => auth()->user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            $request->validate(['avatar' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048']);

            $avatar = $request->file('avatar');
            $filename = uniqid().'_'.$avatar->getClientOriginalName();

            $avatarDir = public_path('images/avatars');
            if (! file_exists($avatarDir)) {
                mkdir($avatarDir, 0755, true);
            }

            if ($user->avatar && file_exists(public_path('images/avatars/'.$user->avatar))) {
                unlink(public_path('images/avatars/'.$user->avatar));
            }

            $avatar->move($avatarDir, $filename);
            $user->update(['avatar' => $filename]);
        }

        $request->validate(['name' => 'required|string|max:255', 'phone' => 'nullable|string']);
        $user->update($request->only('name', 'phone'));

        return back()->with('success', 'Profile updated!');
    }

    public function wishlist()
    {
        $wishlistItems = auth()->user()->wishlist()->with('product')->latest()->paginate(12);

        return view('pages.account.wishlist', compact('wishlistItems'));
    }

    public function addToWishlist(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        Wishlist::firstOrCreate([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Added to wishlist!']);
        }

        return back()->with('success', 'Added to wishlist!');
    }

    public function removeFromWishlist(int $id)
    {
        Wishlist::where('id', $id)->where('user_id', auth()->id())->delete();

        return back()->with('success', 'Removed from wishlist.');
    }

    public function storeAddress(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal_code' => 'nullable|string',
            'country' => 'nullable|string',
        ]);

        $data['user_id'] = auth()->id();
        $data['is_default'] = auth()->user()->addresses()->count() === 0;

        \App\Models\Address::create($data);

        return back()->with('success', 'Address saved!');
    }
}
