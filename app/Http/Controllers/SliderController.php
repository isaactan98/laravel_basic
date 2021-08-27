<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\Facades\Image as Image;

class SliderController extends Controller
{
    public function index()
    {
        $slider = Slider::latest()->paginate(5);
        return view('admin.slider.index', compact('slider'));
    }

    public function add()
    {
        return view('admin.slider.add');
    }

    public function store(Request $request)
    {
        $validate = $request->validate(
            [
                'title' => 'required|unique:sliders|min:4',
                'image' => 'required|mimes:jpg,jpeg,png',
            ],
            [
                'title.required' => 'Please Insert a Slider Title!'
            ]
        );

        $slider_image = $request->file('image');

        $name_gen = hexdec(uniqid()) . '.' . $slider_image->getClientOriginalExtension();
        Image::make($slider_image)->resize(1920, 1088)->save('images/slider/' . $name_gen);
        $last_image = 'images/slider/' . $name_gen;

        Slider::insert([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $last_image,
            'created_at' => Carbon::now(),
        ]);

        return Redirect()->route('home.slider')->with('success', 'Slider Inserted Successfully');
    }
}
