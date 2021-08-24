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
        $trashCat = Category::onlyTrashed()->latest()->paginate(3);
        return view('admin.category.index', compact('category', 'trashCat'));
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

    public function softdelete($id)
    {
        $delete = Category::find($id)->delete();
        return Redirect()->back()->with('success', 'Category Move to Trash List Successfully');
    }

    public function restoredel($id)
    {
        $delete = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success', 'Category Restored Successfully');
    }

    public function delete($id)
    {
        $delete = Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('success', 'Category Permanet Deleted Successfully');
    }
}
