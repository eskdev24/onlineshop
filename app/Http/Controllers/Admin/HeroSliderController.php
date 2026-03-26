<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use Illuminate\Http\Request;

class HeroSliderController extends Controller
{
    public function index()
    {
        $sliders = HeroSlider::orderBy('sort_order')->paginate(15);

        return view('admin.hero-sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.hero-sliders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image|max:5120',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $filename = uniqid().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $filename);
            $data['image'] = $filename;
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['buttons'] = [['text' => 'Shop Now', 'url' => '/shop', 'style' => 'primary']];

        HeroSlider::create($data);

        return redirect()->route('admin.hero-sliders.index')->with('success', 'Slider added!');
    }

    public function edit(HeroSlider $slider)
    {
        return view('admin.hero-sliders.edit', compact('slider'));
    }

    public function update(Request $request, HeroSlider $slider)
    {
        $data = $request->validate([
            'image' => 'nullable|image|max:5120',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $filename = uniqid().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $filename);
            $data['image'] = $filename;
        } else {
            unset($data['image']);
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['buttons'] = [['text' => 'Shop Now', 'url' => '/shop', 'style' => 'primary']];

        $slider->update($data);

        return redirect()->route('admin.hero-sliders.index')->with('success', 'Slider updated!');
    }

    public function delete($id)
    {
        $slider = HeroSlider::findOrFail($id);

        if (file_exists(public_path('images/'.$slider->image))) {
            unlink(public_path('images/'.$slider->image));
        }

        $slider->delete();

        return redirect()->route('admin.hero-sliders.index')->with('success', 'Slider deleted!');
    }
}
