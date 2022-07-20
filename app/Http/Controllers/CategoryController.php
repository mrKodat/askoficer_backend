<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index(Category $categories)
    {
        return view('categories.categories-index', ['categories' => $categories->get()]);
    }

    public function categoryedit(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        return view('categories.category-edit')->with('category', $category);
    }

    public function categoryupdate(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();
        return redirect('/categories')->with('status', 'Category updated successfully');
    }

    public function categorydelete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect('/categories')->with('status', 'Category deleted successfully');
    }

    public function categoryadd(Request $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();
        return redirect('/categories')->with('status', 'Category added successfully');
    }
}
