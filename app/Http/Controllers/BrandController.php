<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\MultiPic;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image as Image;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function logout()
    {
        Auth::logout();
        return Redirect()->route('login')->with('success', 'Logout Success');
    }

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
        // $name_gen = hexdec(uniqid());
        // $img_ext = strtolower($brand_image->getClientOriginalExtension());
        // $image_name = $name_gen . '.' . $img_ext;
        // $up_location = 'images/brand/';
        // $last_image = $up_location . $image_name;
        // $brand_image->move($up_location, $image_name);

        $name_gen = hexdec(uniqid()) . '.' . $brand_image->getClientOriginalExtension();
        Image::make($brand_image)->resize(300, 200)->save('images/brand/' . $name_gen);
        $last_image = 'images/brand/' . $name_gen;

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_image,
            'created_at' => Carbon::now(),
        ]);

        return Redirect()->back()->with('success', 'Brand Inserted Successfully');
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('admin.brand.edit', compact('brand'));
    }

    public function update($id, Request $request)
    {
        $validate = $request->validate(
            [
                'brand_name' => 'required|min:4',
            ],
            [
                'brand_name.required' => 'Please Insert a Brand Name!'
            ]
        );

        $old_image = $request->old_image;

        $brand_image = $request->file('brand_image');
        if ($brand_image) {
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($brand_image->getClientOriginalExtension());
            $image_name = $name_gen . '.' . $img_ext;
            $up_location = 'images/brand/';
            $last_image = $up_location . $image_name;
            $brand_image->move($up_location, $image_name);

            unlink($old_image);

            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'brand_image' => $last_image,
                'created_at' => Carbon::now(),
            ]);

            return Redirect()->route('all.brand')->with('success', 'Brand Update Successfully');
        } else {
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'created_at' => Carbon::now(),
            ]);

            return Redirect()->route('all.brand')->with('success', 'Brand Name Update Successfully');
        }
    }

    public function delete($id)
    {
        $image = Brand::find($id);
        $old_image = $image->brand_image;
        //delete image unlink
        unlink($old_image);

        Brand::find($id)->delete();
        return Redirect()->route('all.brand')->with('success', 'Brand Deleted Successfully');
    }

    //multiple image uplooad 
    public function multiIMG()
    {
        $images = MultiPic::all();
        return view('admin.multipic.index', compact('images'));
    }

    public function multiADD(Request $request)
    {
        $image = $request->file('image');

        foreach ($image as $multi) {
            $name_gen = hexdec(uniqid()) . '.' . $multi->getClientOriginalExtension();
            Image::make($multi)->resize(300, 300)->save('images/multi/' . $name_gen);
            $last_image = 'images/multi/' . $name_gen;

            MultiPic::insert([
                'image' => $last_image,
                'created_at' => Carbon::now(),
            ]);
        }
        return Redirect()->back()->with('success', 'Multiple Images Inserted');
    }
}
