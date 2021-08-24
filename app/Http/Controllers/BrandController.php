<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function index()
    {
        $brand = Brand::latest()->paginate(5);
        return view('admin.brand.index', compact('brand'));
    }

    public function addbrand(Request $request)
    {
        $validate = $request->validate(
            [
                'brand_name' => 'required|unique:brands|min:4',
                'brand_image' => 'required|mimes:jpg,jpeg,png',
            ],
            [
                'brand_name.required' => 'Please Insert a Brand Name!'
            ]
        );

        $brand_image = $request->file('brand_image');
        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $image_name = $name_gen . '.' . $img_ext;
        $up_location = 'images/brand/';
        $last_image = $up_location . $image_name;
        $brand_image->move($up_location, $image_name);

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_image,
            'created_at' => Carbon::now(),
        ]);

        return Redirect()->back()->with('success', 'Brand Inserted Successfully');
    }
}
