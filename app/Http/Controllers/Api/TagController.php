<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\QuestionTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as Validator;


class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(QuestionTag::limit(15)->get(), 200);
    }

}
