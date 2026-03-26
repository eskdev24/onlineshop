<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, int $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $productId],
            ['rating' => $request->rating, 'comment' => $request->comment, 'is_approved' => false]
        );

        return back()->with('success', 'Review submitted! It will be visible after approval.');
    }
}
