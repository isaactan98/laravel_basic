<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    //
    public function allcat()
    {
        $category = Category::latest()->paginate(5);
        return view('admin.category.index', compact('category'));
    }

    public function addcat(Request $request)
    {
        $validate = $request->validate(
            [
                'category_name' => 'required|unique:categories|max:255',
            ],
            [
                'category_name.required' => 'Please Insert a Category Name!'
            ]
        );
        Category::insert([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        // $category = new Category;
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->save();

        return Redirect()->back()->with('success', 'Category Inserted Successfully');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update($id, Request $request)
    {
        $update = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' =>  Auth::user()->id,
        ]);
        return Redirect()->route('all.category')->with('success', 'Category Update Successfully');
    }
}
