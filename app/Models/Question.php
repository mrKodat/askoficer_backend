<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'titlePlain',
        'content',
        'excerpt',
        'date',
        'modified',
        'category_id',
        'author_id',
        'attachment_id',
        'views',
        'answers',
        'bestAnswer',
        'commentStatus',
        'share',
        'polled',
        'imagePolled',
        'type',
        'status',
        'custom_field_id'
    ];
    

    protected $casts = [
        'votes'=> 'integer',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'author_id')->with('badge')->withCount('questions as questions')->withCount('answers as answers');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function tags()
    {
        return $this->hasMany(QuestionTag::class, 'question_id');
    }

    public function answers()
    {
        return $this->hasMany(Comment::class, 'question_id', 'id')->where('type', '=', 'Answer')->with('user')->with('replies');
    }

    public function votes()
    {
        return $this->hasMany(QuestionVote::class, 'question_id', 'id');
    }

    // public function votes(){
    //     return QuestionVote::where('id_buyer', Auth::user()->id)->get();
    //   }

    public function options()
    {
        return $this->hasMany(Option::class, 'question_id', 'id');
    }

    public function userOptions()
    {
        return $this->hasMany(QuestionUserOptions::class, 'question_id', 'id');
    }

    public function favorite()
    {
        return $this->hasOne(QuestionFavorite::class, 'question_id', 'id');
    }
}
