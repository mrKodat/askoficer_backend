<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryFollower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator as Validator;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Category::where('status', '=', '1')->with('followers')->get(), 200);
    }

    public function followCategory(Request $request)
    {
        $userId = $request->input('user_id');
        $categoryId = $request->input('category_id');
        $follower = CategoryFollower::where([['user_id', '=', $userId], ['category_id', '=', $categoryId]])->first();
        if(is_null($follower)){
            $categoryFollower = new CategoryFollower;
            $categoryFollower->user_id =  $request->input('user_id');
            $categoryFollower->category_id =  $request->input('category_id');
            $categoryFollower->save();
        }else {
            $follower->delete();
        }

        return response()->json(['message' => 'success'], 200);
    }

    public function getFollows($id) {
        $followingCategories = CategoryFollower::where('user_id', $id)->get();
        return response()->json(['followingCategories' => $followingCategories], 200);
    }
}
