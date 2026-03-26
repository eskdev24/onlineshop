<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Payment::where('status', 'success')->sum('amount');
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalProducts = Product::count();
        $pendingOrders = Order::where('status', 'pending')->count();

        $recentOrders = Order::with('user')->latest()->take(10)->get();
        $topProducts = Product::withCount(['reviews as order_count' => function ($q) {
            // Using order_items count as proxy for popularity
        }])->orderByDesc('order_count')->take(5)->get();

        // Monthly revenue for chart (last 6 months)
        $monthlyRevenue = Payment::where('status', 'success')
            ->where('paid_at', '>=', now()->subMonths(6))
            ->select(DB::raw('MONTH(paid_at) as month'), DB::raw('SUM(amount) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        return view('admin.dashboard', compact(
            'totalRevenue', 'totalOrders', 'totalCustomers', 'totalProducts',
            'pendingOrders', 'recentOrders', 'topProducts', 'monthlyRevenue'
        ));
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

        return back()->with('success', 'Profile updated!');
    }
}
