<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotDeal;
use App\Models\Product;
use Illuminate\Http\Request;

class HotDealController extends Controller
{
    public function index()
    {
        $hotDeals = HotDeal::with('product')->orderBy('sort_order')->paginate(10);
        return view('admin.hot-deals.index', compact('hotDeals'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('admin.hot-deals.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'deal_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $data['is_active'] = $request->has('is_active');

        HotDeal::create($data);

        return redirect()->route('admin.hot-deals.index')->with('success', 'Hot Deal created successfully!');
    }

    public function edit(HotDeal $hotDeal)
    {
        $products = Product::orderBy('name')->get();
        return view('admin.hot-deals.edit', compact('hotDeal', 'products'));
    }

    public function update(Request $request, HotDeal $hotDeal)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'deal_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $data['is_active'] = $request->has('is_active');

        $hotDeal->update($data);

        return redirect()->route('admin.hot-deals.index')->with('success', 'Hot Deal updated successfully!');
    }

    public function destroy(HotDeal $hotDeal)
    {
        $hotDeal->delete();
        return redirect()->route('admin.hot-deals.index')->with('success', 'Hot Deal deleted successfully!');
    }
}
