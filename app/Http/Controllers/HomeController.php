<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Question;
use App\Models\Report;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::count();
        $categories = Category::count();
        $tags = Tag::count();
        $questions = Question::count();
        $comments = Comment::count();
        $reports = Report::count();
        $messages = Contact::count();
        $recentQuestions = Question::orderBy('created_at', 'DESC')->limit(5)->get();
        $recentComments = Comment::orderBy('date', 'DESC')->limit(5)->get();

        return view('dashboard', compact('users', 'categories', 'tags', 'questions', 'comments', 'reports', 'recentQuestions', 'recentComments', 'messages'));
    }
}
