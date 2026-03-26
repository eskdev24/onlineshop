<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')->withCount('orders')->latest()->paginate(15);
        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        $customer->load('orders');
        return view('admin.customers.show', compact('customer'));
    }
}
