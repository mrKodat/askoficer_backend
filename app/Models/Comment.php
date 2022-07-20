<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'content',
        'author_id',
        'question_id',
        'answer_id',
        'best',
        'type',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'author_id')->with('badge');
    }

    public function votes()
    {
        return $this->hasMany(QuestionVote::class, 'question_id', 'id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'answer_id', 'id')->where('type', '=', 'Reply')->with('user');
    }

}
