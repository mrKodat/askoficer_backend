<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function allcomments()
    {
        $allComments = Comment::all();
        return view('answers.all-comments', ['allComments' => $allComments]);
    }

    public function answers()
    {
        $answers = Comment::where('type', '=', 'Answer')->get();
        return view('answers.answers', ['answers' => $answers]);
    }

    public function replies()
    {
        $replies = Comment::where('type', '=', 'Reply')->get();
        return view('answers.replies', ['replies' => $replies]);
    }
}
