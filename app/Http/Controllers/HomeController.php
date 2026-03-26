<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Post;
use App\Models\Setting;
use App\Models\HotDeal;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::active()->featured()->inStock()->with('category')->take(8)->get();
        $newArrivals = Product::active()->inStock()->latest()->take(8)->get();
        $categories = Category::active()->parentCategories()->withCount('products')->take(8)->get();
        $dealProducts = Product::active()->inStock()->whereNotNull('discount_price')->take(4)->get();
        $brands = Brand::active()->take(6)->get();
        $hotDeals = HotDeal::active()->with('product')->get();

        return view('pages.home', compact('featuredProducts', 'newArrivals', 'categories', 'dealProducts', 'brands', 'hotDeals'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactSubmit(\Illuminate\Http\Request $request)
    {
        $request->validate(['name' => 'required', 'email' => 'required|email', 'message' => 'required']);
        \App\Models\ContactMessage::create($request->only('name', 'email', 'subject', 'message'));
        return back()->with('success', 'Message sent successfully!');
    }

    public function faq() { return view('pages.faq'); }
    public function privacy() { return view('pages.privacy'); }
    public function terms() { return view('pages.terms'); }
}
